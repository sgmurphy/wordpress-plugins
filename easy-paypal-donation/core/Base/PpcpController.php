<?php

namespace WPEasyDonation\Base;

use WPEasyDonation\API\Order;
use WPEasyDonation\Helpers\Option;
use WPEasyDonation\Helpers\Func;
use WPEasyDonation\Helpers\Template;

class PpcpController extends BaseController
{
	/**
	 * init services
	 */
	public function register() {
		add_action( 'wp_ajax_wpedon-ppcp-onboarding-start', array($this, 'onboarding_start_ajax') );
		add_action( 'wp_ajax_wpedon-ppcp-disconnect', array($this, 'ppcp_disconnect_ajax') );
		add_action( 'wp_ajax_wpedon-ppcp-payment-capture', array($this, 'payment_capture_ajax') );

		add_action( 'wp_ajax_wpedon-ppcp-order-create', array($this, 'order_create_ajax'));
		add_action( 'wp_ajax_nopriv_wpedon-ppcp-order-create', array($this, 'order_create_ajax'));

		add_action( 'wp_ajax_wpedon-ppcp-order-finalize', array($this, 'order_finalize_ajax') );
		add_action( 'wp_ajax_nopriv_wpedon-ppcp-order-finalize', array($this, 'order_finalize_ajax') );

		add_action( 'init', array($this, 'maybe_refund_payment') );
		add_action( 'wp_ajax_wpedon-free-ppcp-order-refund', array($this, 'order_refund') );
	}

	/**
	 * ppcp status
	 * @param $button_id
	 * @param bool $return_general
	 * @return false
	 */
	public function status( $button_id, $return_general = true ) {
		global $wpedonPpcpStatus;

		if ( !is_array( $wpedonPpcpStatus ) ) {
			$wpedonPpcpStatus = [];
		}

		$button_id = intval( $button_id );
		$button_id = !empty( $button_id ) ? $button_id : 'general';
		$key = $button_id . '_' . ( $return_general ? '1' : '0' );
		if ( !isset( $wpedonPpcpStatus[$key] ) ) {
			$wpedonPpcpStatus[$key] = false;

			$options = Option::get();
			$default_mode = intval( $options['mode'] );
			if ( $button_id === 'general' ) {
				$mode = $default_mode;
				$env = $mode === 1 ? 'sandbox' : 'live';
				$onboarding = isset( $options['ppcp_onboarding'][$env] ) ? $options['ppcp_onboarding'][$env] : [];
			} else {
				$ppcp_onboarding = get_post_meta( $button_id, '_wpedon_ppcp_onboarding', true );
				$button_mode = (int) get_post_meta( $button_id, '_wpedon_paypal_mode', true );
				$mode = in_array( $button_mode, [1, 2] ) ? $button_mode : $default_mode;
				$env = $mode === 1 ? 'sandbox' : 'live';
				$onboarding = isset( $ppcp_onboarding[$env] ) ? $ppcp_onboarding[$env] : ( $return_general && isset( $options['ppcp_onboarding'][$env] ) ? $options['ppcp_onboarding'][$env] : [] );
			}

			if ( !empty( $onboarding['seller_id'] ) ) {
				$args = [
					'env' => $env,
					'onboarding' => $onboarding
				];
				$transient = md5( json_encode( $args ) );
				$wpedonPpcpStatus[$key] = get_transient( $transient );
				if ( $wpedonPpcpStatus[$key] === false ) {
					$response = wp_remote_get( $this->ppcp_api . 'get-status?' . http_build_query( $args ) );
					$body = wp_remote_retrieve_body( $response );
					$data = json_decode( $body, true );
					if ( is_array( $data ) && !empty( $data['mode'] ) ) {
						set_transient( $transient, $data, HOUR_IN_SECONDS );
						$wpedonPpcpStatus[$key] = $data;
					}
				}
			} elseif ( !empty( $onboarding ) ) {
				$response = wp_remote_get( $this->ppcp_api . 'find-seller-id?' . http_build_query( [
						'env' => $env,
						'onboarding' => $onboarding
					] ) );
				$body = wp_remote_retrieve_body( $response );
				$data = json_decode( $body, true );
				if ( is_array( $data ) && !empty( $data['mode'] ) ) {
					$this->save( sanitize_text_field( $data['env'] ), sanitize_text_field( $data['seller_id'] ), $button_id );
					$wpedonPpcpStatus[$key] = $data;
				} elseif ( $onboarding['timestamp'] + 3600 < time() ) {
					if ( $button_id === 'general' ) {
						unset( $options['ppcp_onboarding'][$env] );
						Option::update($options);
					} else {
						if ( is_array( $ppcp_onboarding ) && isset( $ppcp_onboarding[$env] ) ) {
							unset( $ppcp_onboarding[$env] );
							update_post_meta( $button_id, '_wpedon_ppcp_onboarding', $ppcp_onboarding );
						}
					}
				}
			}
		}
		return $wpedonPpcpStatus[$key];
	}

	/**
	 * save
	 * @param $env
	 * @param $seller_id
	 * @param $button_id
	 */
	public function save($env, $seller_id, $button_id)
	{
		if ( $button_id === 'general' ) {
			$options = Option::get();

			if ( $env === 'sandbox' && isset( $options['sandboxaccount'] ) ) {
				unset( $options['sandboxaccount'] );
			} elseif ( $env === 'live' && isset( $options['liveaccount'] ) ) {
				unset( $options['liveaccount'] );
			}

			$options['ppcp_onboarding'][$env]['seller_id'] = $seller_id;
			Option::update($options);
		} else {
			delete_post_meta( $button_id, 'wpedon_button_account' );

			$ppcp_onboarding = get_post_meta( $button_id, '_wpedon_ppcp_onboarding', true );
			$ppcp_onboarding[$env]['seller_id'] = $seller_id;
			update_post_meta( $button_id, '_wpedon_ppcp_onboarding', $ppcp_onboarding );
		}
	}

	/**
	 * onboarding start ajax
	 */
	function onboarding_start_ajax() {
		if ( !wp_verify_nonce( $_GET['nonce'], 'wpedon-ppcp-onboarding-start' ) ) {
			echo '<script>window.close();</script>';
			die();
		}

		$env = !empty( $_GET['sandbox'] ) ? 'sandbox' : 'live';
		$country = sanitize_text_field( $_GET['country'] );
		$accept_cards = !empty( $_GET['accept-cards'] ) ? 1 : 0;
		$button_id = intval( $_GET['button-id'] );
		$button_id = !empty( $button_id ) ? $button_id : 'general';

		$response = wp_remote_post(
			$this->ppcp_api . 'signup',
			[
				'timeout' => 60,
				'body' => [
					'env' => $env,
					'return_url' => $this->connect_tab_url( $button_id ),
					'email' => get_bloginfo( 'admin_email' ),
					'country' => $country,
					'accept_cards' => $accept_cards
				]
			]
		);

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( empty( $data['action_url'] ) || empty( $data['tracking_id'] ) ) {
			echo '<script>window.close();</script>';
			die();
		}

		$onboarding = [
			'timestamp' => time(),
			'tracking_id' => $data['tracking_id'],
			'country' => $country,
			'accept_cards' => $accept_cards,
			'seller_id' => ''
		];

		$mode = $env === 'sandbox' ? 1 : 2;

		if ( $button_id === 'general' ) {
			$options = Option::get();
			$options['ppcp_onboarding'][$env] = $onboarding;

			$options['mode'] = $mode;

			Option::update($options);
		} else {
			$ppcp_onboarding = get_post_meta( $button_id, '_wpedon_ppcp_onboarding', true );
			if ( !is_array( $ppcp_onboarding ) ) {
				$ppcp_onboarding = [];
			}
			$ppcp_onboarding[$env] = $onboarding;
			update_post_meta( $button_id, '_wpedon_ppcp_onboarding', $ppcp_onboarding );

			update_post_meta( $button_id, '_wpedon_paypal_mode', $mode );
		}

		header( "Location: {$data['action_url']}" );
		die();
	}

	/**
	 * connect tab url
	 * @param $button_id
	 * @return string
	 */
	function connect_tab_url( $button_id ) {
		if ( $button_id === 'general' ) {
			$args = [
				'page' => 'wpedon_settings',
				'tab' => '3'
			];
		} else {
			$args = [
				'page' => 'wpedon_buttons',
				'action' => 'edit',
				'product' => $button_id,
				'_wpnonce' => wp_create_nonce( 'edit_' . $button_id ),
			];
		}

		return add_query_arg(
			$args,
			admin_url('admin.php')
		);
	}

	/**
	 * ppcp disconnect ajax
	 */
	function ppcp_disconnect_ajax() {
		if ( !wp_verify_nonce( $_POST['nonce'], 'wpedon-request' ) ) {
			wp_send_json_error( [
				'message' => __( 'The request has not been authenticated. Please reload the page and try again.' )
			] );
		}

		$button_id = intval( $_POST['button_id'] );
		$button_id = !empty( $button_id ) ? $button_id : 'general';

		$options = Option::get();
		$default_mode = intval( $options['mode'] );
		if ( $button_id === 'general' ) {
			$mode = $default_mode;
			$env = $mode === 1 ? 'sandbox' : 'live';
			$onboarding = isset( $options['ppcp_onboarding'][$env] ) ? $options['ppcp_onboarding'][$env] : [];
		} else {
			$ppcp_onboarding = get_post_meta( $button_id, '_wpedon_ppcp_onboarding', true );
			$button_mode = (int) get_post_meta( $button_id, '_wpedon_paypal_mode', true );
			$mode = in_array( $button_mode, [1, 2] ) ? $button_mode : $default_mode;
			$env = $mode === 1 ? 'sandbox' : 'live';
			$onboarding = isset( $ppcp_onboarding[$env] ) ? $ppcp_onboarding[$env] : [];
		}

		if ( empty( $onboarding ) ) {
			wp_send_json_error( [
				'message' => __( 'An error occurred while processing your account disconnection request. Please contact our support service.' )
			] );
		}

		$args = [
			'env' => $env,
			'onboarding' => $onboarding
		];

		$response = wp_remote_post(
			$this->ppcp_api . 'disconnect',
			[
				'timeout' => 60,
				'body' => $args
			]
		);

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( empty( $data['success'] ) ) {
			wp_send_json_error( [
				'message' => __( 'An error occurred while processing your account disconnection request. Please contact our support service.' )
			] );
		}

		if ( $button_id === 'general' ) {
			unset( $options['ppcp_onboarding'][$env] );
			Option::update($options);
		} else {
			unset( $ppcp_onboarding[$env] );
			update_post_meta( $button_id, '_wpedon_ppcp_onboarding', $ppcp_onboarding );
		}

		$transient = md5( json_encode( $args ) );
		delete_transient( $transient );

		$html = $this->status_markup_html($button_id);

		wp_send_json_success( [
			'statusHtml' => $html
		] );
	}

	/**
	 * payment capture ajax
	 */
	function payment_capture_ajax() {
		global $wpdb;

		if ( !wp_verify_nonce( $_POST['nonce'], 'wpedon-request' ) ) {
			wp_send_json_error( [
				'message' => __( 'The request has not been authenticated. Please reload the page and try again.' )
			] );
		}

		$order_id = intval( $_POST['order_id'] );
		$button_id = get_post_meta( $order_id, 'wpedon_button_id', true );

		$ppcp_connection_data = $this->paypal_connection_data( $button_id );

		if ( !$ppcp_connection_data || $ppcp_connection_data['connection_type'] !== 'ppcp' ) {
			wp_send_json_error( [
				'message' => __( 'An error occurred.' )
			] );
		}

		$authorization = get_post_meta( $order_id, 'wpedon_button_authorization', true );

		$response = wp_remote_post(
			$this->ppcp_api . 'payment-capture',
			[
				'timeout' => 60,
				'body' => [
					'env' => $ppcp_connection_data['env'],
					'seller_id' => $ppcp_connection_data['seller_id'],
					'authorization' => $authorization
				]
			]
		);

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( empty( $data['success'] ) ) {
			wp_send_json_error();
		}

		$order_id = (int) $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='wpedon_button_authorization' AND meta_value=%s", $authorization ) );
		if ( empty( $order_id ) ) {
			wp_send_json_error();
		}

		$order = new Order();
		$order->update($order_id, ['payment_status' => 'completed']);

		wp_send_json_success( [
			'redirect_url' => admin_url( "admin.php?page=wpedon_button_settings&action=view&order={$order_id}&captured=1" )
		] );
	}

	/**
	 * paypal connection data
	 * @param $button_id
	 * @param array $atts
	 * @return array|false
	 */
	public function paypal_connection_data( $button_id, $atts = [] ) {
		$options = Option::get();

		$disable_paypal = get_post_meta( $button_id, 'wpedon_button_disable_paypal', true );
		if ( $disable_paypal == '1' ) {
			$disable_paypal = false;
		} elseif ( $disable_paypal == '2' ) {
			$disable_paypal = true;
		} else {
			$disable_paypal = isset( $options['disable_paypal'] ) && $options['disable_paypal'] == '2';
		}
		if ( $disable_paypal ) return false;

		$connection_data = false;

		// currency
		if ( !empty( $atts['currency'] ) ) {
			$currency_code = $atts['currency'];
		} else {
			$currency_code = get_post_meta( $button_id,'wpedon_button_currency',true );
			if ( empty( $currency_code ) ) {
				$currency_code = $options['currency'];
			}
		}
		$currency = Func::currency_code_to_iso( $currency_code );

		// locale
		if ( !empty( $atts['language'] ) ) {
			$language_code = $atts['language'];
		} else {
			$language_code = get_post_meta( $button_id,'wpedon_button_language',true );
			if ( empty( $language_code ) ) {
				$language_code = $options['language'];
			}
		}
		//
		$locale = Func::language_to_locale( $language_code );

		$ppcp_status = $this->status( $button_id );
		$paypal_account = get_post_meta( $button_id, 'wpedon_button_account', true );
		if ( !empty( $ppcp_status['client_id'] ) && empty( $ppcp_status['errors'] ) && empty($paypal_account) ) {
			$connection_data = $ppcp_status;
			$connection_data['connection_type'] = 'ppcp';
			$connection_data['button_id'] = $button_id;
			$connection_data['currency'] = $currency;
			$connection_data['locale'] = $locale['locale'];
			$connection_data['intent'] = 'capture';
			$connection_data['address'] = intval( $options['no_shipping'] );

			$connection_data['enable-funding'] = [];
			$funding = [
				'paypal' => ['paypal'],
				'paylater' => ['paylater'],
				'venmo' => ['venmo'],
				'alternative' => ['credit','bancontact','blik','eps','giropay','ideal','mercadopago','mybank','p24','sepa','sofort'],
				'cards' => ['card']
			];
			if ( $connection_data['mode'] === 'advanced' ) {
				$funding['advanced_cards'] = ['advanced_cards'];
			}
			foreach ( $funding as $k => $v ) {
				$funding_enabled = get_post_meta( $button_id, "ppcp_funding_{$k}", true );
				if ( $button_id && $funding_enabled == '1' ) {
					$funding_enabled = true;
				} elseif ( $button_id && $funding_enabled == '0' ) {
					$funding_enabled = false;
				} else {
					$funding_enabled = !empty( $options["ppcp_funding_{$k}"] );
				}
				if ( $funding_enabled ) {
					if ( $k === 'advanced_cards' ) {
						$connection_data['advanced_cards'] = true;
					} else {
						$connection_data['enable-funding'] = array_merge( $connection_data['enable-funding'], $v );
					}
				}
			}

			$ppcp_layout = get_post_meta( $button_id, 'ppcp_layout', true );
			if ( empty( $ppcp_layout ) ) {
				$ppcp_layout = $options['ppcp_layout'];
			}

			$connection_data['layout'] = in_array( $ppcp_layout, ['horizontal', 'vertical'] ) ? $ppcp_layout : 'vertical';

			$ppcp_color = get_post_meta( $button_id, 'ppcp_color', true );
			if ( empty( $ppcp_color ) ) {
				$ppcp_color = $options['ppcp_color'];
			}
			$connection_data['color'] = in_array( $ppcp_color, ['gold', 'blue', 'black', 'silver', 'white'] ) ? $ppcp_color : 'gold';

			$ppcp_shape = get_post_meta( $button_id, 'ppcp_shape', true );
			if ( empty( $ppcp_shape ) ) {
				$ppcp_shape = $options['ppcp_shape'];
			}
			$connection_data['shape'] = in_array( $ppcp_shape, ['rect', 'pill'] ) ? $ppcp_shape : 'rect';

			$connection_data['label'] = 'donation';

			$ppcp_height = (int) get_post_meta( $button_id, 'ppcp_height', true );
			if ( empty( $ppcp_height ) ) {
				$ppcp_height = (int) $options['ppcp_height'];
			}
			if ( $ppcp_height < 25 || $ppcp_height > 55 ) {
				$ppcp_height = 40;
			}
			$connection_data['height'] = $ppcp_height;

			$ppcp_width = (int) get_post_meta( $button_id, 'wpedon_button_ppcp_width', true );
			if ( empty( $ppcp_width ) ) {
				$ppcp_width = (int) $options['ppcp_width'];
			}
			if ( $ppcp_width < 160 ) {
				$ppcp_width = 160;
			}
			$connection_data['width'] = $ppcp_width;

			$acdc_button_text = get_post_meta( $button_id, 'wpedon_button_ppcp_acdc_button_text', true );
			if ( empty( $acdc_button_text ) ) {
				$acdc_button_text = $options['ppcp_acdc_button_text'];
			}
			$connection_data['acdc_button_text'] = $acdc_button_text;
			
			
			
				// return url
				if ( !empty( $atts['return'] ) ) {
					$return = $atts['return'];
				} else {
					$return = get_post_meta( $button_id,'wpedon_button_return',true );
					if ( empty( $return ) ) {
						$return = $options['return'];
					}
				}
			
			$connection_data['return'] = $return;
			
			
			
		} else {
			// live or test mode
			$default_mode = intval( $options['mode'] );
			if ( empty( $button_id ) ) {
				$mode = $default_mode;
			} else {
				$button_mode = intval( get_post_meta( $button_id, '_wpedon_paypal_mode', true ) );
				$mode = in_array( $button_mode, [1, 2] ) ? $button_mode : $default_mode;
			}

			$paypal_account = get_post_meta( $button_id, 'wpedon_button_account', true );
			if ( $mode === 1 ) {
				$paypal_account = empty( $paypal_account ) && isset( $options['sandboxaccount'] ) ? $options['sandboxaccount'] : $paypal_account;
				$paypal_path = 'sandbox.paypal';
			} else {
				$paypal_account = empty( $paypal_account ) && isset( $options['liveaccount'] ) ? $options['liveaccount'] : $paypal_account;
				$paypal_path = 'paypal';
			}

			if ( !empty( $paypal_account ) ) {
				// payment action
				$paymentaction = 'sale';

				// button size and image
				if ( !empty( $atts['size'] ) ) {
					$size = $atts['size'];
				} else {
					$size = get_post_meta( $button_id,'wpedon_button_buttonsize',true );
					if ( empty( $size ) ) {
						$size = $options['size'];
					}
				}
				switch ($size) {
					case '1':
						$img = $locale['imagea']; $button_width = "86px"; $button_height = "21px";
						break;
					case '2':
						$img = $locale['imageb']; $button_width = "107px"; $button_height = "26px";;
						break;
					case '3':
						$img = $locale['imagec']; $button_width = "171px"; $button_height = "47px";
						break;
					case '4':
						$img = $locale['imaged']; $button_width = "86px"; $button_height = "21px";
						break;
					case '5':
						$img = $locale['imagee']; $button_width = "107px"; $button_height = "26px";
						break;
					case '6':
						$img = $locale['imagef']; $button_width = "144px"; $button_height = "47px";
						break;
					case '7':
						$img = $locale['imageg']; $button_width = "170px"; $button_height = "32px";
						break;
					default:
						if ( !empty( $options['image_1'] ) ) {
							list( $button_width_custom, $button_height_custom, $button_type_custom, $button_attr_custom ) = getimagesize( $options['image_1'] );
							$img = $options['image_1']; $button_width = $button_width_custom . "px"; $button_height = $button_height_custom."px";
						} else {
							$img = $locale['imageg']; $button_width = "170px"; $button_height = "32px";
						}
				}

				// window action
				$target = intval( $options['opens'] ) === 2 ? '_blank' : '';

				// return url
				if ( !empty( $atts['return'] ) ) {
					$return = $atts['return'];
				} else {
					$return = get_post_meta( $button_id,'wpedon_button_return',true );
					if ( empty( $return ) ) {
						$return = $options['return'];
					}
				}

				$connection_data = [
					'connection_type' => 'manual',
					'target' => $target,
					'path' => $paypal_path,
					'account' => $paypal_account,
					'currency' => $currency,
					'locale' => $locale['locale'] === 'default' ? 'en_US' : $locale['locale'],
					'paymentaction' => $paymentaction,
					'return' => $return,
					'cancel' => $options['cancel'],
					'img' => $img,
					'width' => $button_width,
					'height' => $button_height
				];
			}
		}
		

		return $connection_data;
	}

	/**
	 * status markup
	 * @param string $button_id
	 */
	public function status_markup($button_id = 'general') {
		$options = Option::get();
		$status = $this->status($button_id, false);
		$default_mode = intval( $options['mode'] );
		$default_env = $default_mode === 1 ? 'sandbox' : 'live';
		if ( $button_id === 'general' ) {
			$mode = $default_mode;
		} else {
			$button_mode = (int) get_post_meta( $button_id, '_wpedon_paypal_mode', true );
			$mode = in_array( $button_mode, [1, 2] ) ? $button_mode : $default_mode;
		}
		$env = $mode === 1 ? 'sandbox' : 'live';
		if($status) {
			if ( in_array( $status['mode'], ['advanced', 'express'] ) ) {
				if ( empty( $status['warnings'] ) ) {
					$notice_type = 'success';
					$show_links = false;
				} else {
					$notice_type = 'warning';
					$show_links = true;
				}
				$show_settings = true;
			} else {
				$notice_type = 'error';
				$show_links = true;
				$show_settings = false;
			}
			Template::getTemplate('ppcp/ppcp_status_table.php', true,
				['button_id'=>$button_id, 'notice_type'=>$notice_type, 'status'=>$status, 'show_links'=>$show_links, 'show_settings'=>$show_settings, 'options'=>$options]);
		} else {
			Template::getTemplate('ppcp/ppcp_false_status_table.php', true,
				['button_id'=>$button_id, 'url'=>$this->plugin_url, 'default_env'=>$default_env, 'env'=>$env]);
		}
		if ( !wp_doing_ajax() ) {
			add_thickbox();
			Template::getTemplate('ppcp/setup-account-modal.php', true, ['url'=>$this->plugin_url, 'button_id'=>$button_id, 'env'=>$env]);
		}
	}

	/**
	 * status markup html
	 * @param string $button_id
	 * @return false|string
	 */
	public function status_markup_html($button_id = 'general') {
		ob_start();
		$this->status_markup($button_id);
		return ob_get_clean();
	}

	/**
	 * order create ajax
	 */
	public function order_create_ajax() {
		if ( !wp_verify_nonce( $_POST['nonce'], 'wpedon-frontend-request' ) ) {
			wp_send_json_error( [
				'message' => __( 'The request has not been authenticated. Please reload the page and try again.' )
			] );
		}

		$data = $this->get_checkout_data($_POST);
		

		if ( empty( $data['item_price'] ) ) {
			wp_send_json_error( [
				'message' => __( 'The value cannot be zero.' )
			] );
		}

		$ppcp_connection_data = $this->paypal_connection_data($data['button_id']);
		if ( !$ppcp_connection_data || $ppcp_connection_data['connection_type'] !== 'ppcp' ) {
			wp_send_json_error( [
				'message' => __( 'An error occurred.' )
			] );
		}
		
		
		$response = wp_remote_post(
			$this->ppcp_api . 'create-order',
			[
				'timeout' => 60,
				'body' => [
					'env' => $ppcp_connection_data['env'],
					'seller_id' => $ppcp_connection_data['seller_id'],
					'items' => [
						[
							'name' => sanitize_text_field( $_POST['name'] ),
							'price' => floatval( $_POST['price'] )
						]
					],
					'currency' => $data['currency'],
					'intent' => $ppcp_connection_data['intent'],
					'referer' => wp_get_referer()
				]
			]
		);

		$body = wp_remote_retrieve_body( $response );
		$response = json_decode( $body, true );


		if ( empty( $response['success'] ) ) {
			wp_send_json_error( [
				'message' => !empty( $response['message'] ) ? $response['message'] : __( "Can't create an order." )
			] );
		}

		$order = new Order();

		$order_id = $order->create(array_merge($data, ['payment_status' => 'pending', 'payment_method' => 'paypal', 'mode' => $ppcp_connection_data['env'], 'mc_currency' => $data['currency'], 'paypal_connection_type' => $ppcp_connection_data['connection_type']]));

		$order->update($order_id, [
			'txn_id' => $response['order_id'],
			'payment_amount' => $response['payment_amount'],
			'metadata' => $data['metadata']
		]);

		wp_send_json_success( [
			'order_id' => $response['order_id']
		] );
	}

	/**
	 * order finalize ajax
	 */
	public function order_finalize_ajax() {
		global $wpdb;

		if ( !wp_verify_nonce( $_POST['nonce'], 'wpedon-frontend-request' ) ) {
			wp_send_json_error( [
				'message' => __( 'The request has not been authenticated. Please reload the page and try again.' )
			] );
		}

		$data = $this->get_checkout_data($_POST);

		$ppcp_connection_data = $this->paypal_connection_data($data['button_id']);

		if ( !$ppcp_connection_data || $ppcp_connection_data['connection_type'] !== 'ppcp' ) {
			wp_send_json_error( [
				'message' => __( 'An error occurred.' )
			] );
		}

		$paypal_order_id = sanitize_text_field( $_POST['order_id'] );

		$response = wp_remote_post(
			$this->ppcp_api . 'finalize-order',
			[
				'timeout' => 60,
				'body' => [
					'env' => $ppcp_connection_data['env'],
					'seller_id' => $ppcp_connection_data['seller_id'],
					'order_id' => $paypal_order_id,
					'intent' => $ppcp_connection_data['intent'],
					'acdc' => !empty( $_POST['acdc'] )
				]
			]
		);

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		$order_id = (int) $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='wpedon_button_txn_id' AND meta_value=%s", $paypal_order_id ) );
		if ( !empty( $order_id ) ) {
			$order_data = [
				'payer_email' => !empty( $data['payer_email'] ) ? $data['payer_email'] : '',
				'txn_id' => $paypal_order_id,
				'order_key' => $data['order_key'],
				'payment_date' => date( "F j, Y, g:i a", strtotime( $data['date'] ) ),
				'capture_id' => $data['capture_id']
			];

			if ( isset( $data['amount'] ) ) {
				$order_data['payment_amount'] = $data['amount'];
				$order_data['mc_gross'] = $data['amount'];
			}

			if ( empty( $data['success'] ) ) {
				$order_data['payment_status'] = 'failed';
			} elseif ( $data['intent'] === 'authorize' ) {
				$order_data['payment_status'] = 'authorized';
				$order_data['authorization'] = $data['authorization'];
			} else {
				$order_data['payment_status'] = 'completed';
			}

			if ( !empty( $data['shipping'] ) ) {
				$order_data['shipping'] = $data['shipping'];
			}

			$order = new Order();
			$order->update($order_id, $order_data);
		}

		if ( empty( $data['success'] ) ) {
			wp_send_json_error( $data );
		} else {
			wp_send_json_success( $data );
		}
	}

	/**
	 * Maybe refund local order
	 *
	 * @return false|void
	 */
	public function maybe_refund_payment() {
		global $wpdb;

		if ( !isset( $_POST['wpedon-action'] ) || $_POST['wpedon-action'] !== 'refund-payment' || empty( $_POST['token'] ) ) {
			return false;
		}

		$options = Option::get();

		$response = wp_remote_post(
			$this->ppcp_api . 'order-get-refund-data',
			[
				'timeout' => 30,
				'body' => [
					'env' => intval( $options['mode'] ) === 1 ? 'sandbox' : 'live',
					'token' => $_POST['token']
				]
			]
		);

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		if ( empty( $data['order_id'] ) ) {
			return false;
		}

		$order_id = (int) $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='wpedon_button_txn_id' AND meta_value=%s", $data['order_id'] ) );
		if ( empty( $order_id ) ) {
			return false;
		}

		$order = new Order();
		$order->update( $order_id, ['payment_status' => 'refunded'] );

		die('success');
	}

	/**
	 * Refund order via admin ajax
	 *
	 * @return void
	 */
	public function order_refund() {
		if ( !wp_verify_nonce( $_POST['nonce'], 'wpedon-request' ) || !current_user_can( 'administrator' ) ) {
			wp_send_json_error( [
				'message' => __( 'The request has not been authenticated. Please reload the page and try again.' )
			] );
		}

		$order_id = intval( $_POST['order_id'] );
		if ( get_post_type( $order_id ) !== 'wpplugin_don_order' ) {
			wp_send_json_error( [
				'message' => __( 'Donation error.' )
			] );
		}

		$order_meta = Order::getOrderMeta( $order_id );

		$response = wp_remote_post(
			$this->ppcp_api . 'refund-order',
			[
				'timeout' => 60,
				'body' => [
					'env' => isset( $order_meta['wpedon_button_mode'] ) && in_array( $order_meta['wpedon_button_mode'], ['sandbox', 'live'] ) ? $order_meta['wpedon_button_mode'] : 'live',
					'order_id' => isset( $order_meta['wpedon_button_txn_id'] ) ? $order_meta['wpedon_button_txn_id'] : '',
					'order_key' => isset( $order_meta['wpedon_button_order_key'] ) ? $order_meta['wpedon_button_order_key'] : ''
				]
			]
		);

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		if ( isset( $data['status'] ) && $data['status'] === 'success' ) {
			$order = new Order();
			$order->update( $order_id, ['payment_status' => 'refunded'] );
			$message = __( 'The donation was refunded.' );

			wp_send_json_success( [
				'message' => $message
			] );
		} else {
			wp_send_json_error( [
				'message' => __( 'Can\'t refund the donation.' )
			] );
		}
	}
}