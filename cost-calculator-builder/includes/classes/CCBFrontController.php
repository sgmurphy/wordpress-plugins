<?php

namespace cBuilder\Classes;

use cBuilder\Classes\Appearance\CCBAppearanceHelper;
use cBuilder\Helpers\CCBFieldsHelper;
use function Clue\StreamFilter\fun;

$template_variables = array();

class CCBFrontController {

	private static $settings;
	private static $general_settings;
	private static $calc_id;
	private static $sticky;

	public static function init() {
		add_action(
			'wp_enqueue_scripts',
			function () {
				wp_enqueue_script( 'jquery' );
			}
		);
		add_shortcode( 'stm-calc', array( self::class, 'render_calculator' ) );
		add_shortcode( 'stm-thank-you-page', array( self::class, 'render_thank_you_page' ) );
		add_shortcode( 'stm-sticky-calc', array( self::class, 'ccb_render_sticky_calc' ) );
		add_filter( 'ccb_order_data_by_id', array( self::class, 'get_order_data_by_id' ) );
		add_filter( 'wp_footer', array( self::class, 'ccb_render_sticky_calc' ) );
	}

	public static function ccb_render_sticky_calc() {
		echo self::ccb_sticky_calc_handler(); // phpcs:ignore
	}

	public static function ccb_sticky_calc_handler( $content = '' ) {
		$calculators = CCBUpdatesCallbacks::get_calculators();

		$has_sticky    = false;
		$calc_sticky   = '';
		$sticky_banner = '';

		$positions = array(
			'top_left'      => 0,
			'center_left'   => 0,
			'bottom_left'   => 0,
			'top_center'    => 0,
			'bottom_center' => 0,
			'top_right'     => 0,
			'center_right'  => 0,
			'bottom_right'  => 0,
		);

		foreach ( array_reverse( $calculators ) as $calculator ) {
			$calc_settings = CCBSettingsData::get_calc_single_settings( $calculator->ID );
			if ( isset( $calc_settings['sticky_calc'] ) && ! empty( $calc_settings['sticky_calc']['enable'] ) && ccb_pro_active() ) {
				if ( ! $has_sticky ) {
					$has_sticky  = true;
					$calc_sticky = '<div id="ccb-sticky-floating-wrapper">';

					wp_enqueue_style( 'ccb-sticky-css', CALC_URL . '/frontend/dist/css/sticky.css', array(), CALC_VERSION );
					wp_enqueue_style( 'ccb-bootstrap-css', CALC_URL . '/frontend/dist/css/modal.bootstrap.css', array(), CALC_VERSION );
					wp_enqueue_script( 'ccb-velocity-ui-js', CALC_URL . '/frontend/dist/libs/velocity.ui.min.js', array(), CALC_VERSION, true );
					wp_enqueue_script( 'ccb-velocity-ui-js', CALC_URL . '/frontend/dist/libs/velocity.ui.min.js', array(), CALC_VERSION, true );
					wp_enqueue_script( 'ccb-sticky-js', CALC_URL . '/frontend/dist/sticky.js', array(), CALC_VERSION, true );
				}

				$page_id           = get_the_ID();
				$not_allowed_pages = array();

				$position_type = '';
				if ( 'btn' === $calc_settings['sticky_calc']['display_type'] ) {
					$position_type = $calc_settings['sticky_calc']['btn_position'];
				}

				if ( ( isset( $positions[ $position_type ] ) && $positions[ $position_type ] < 2 ) || empty( $position_type ) ) {

					foreach ( $calc_settings['sticky_calc']['pages'] as $page ) {
						$not_allowed_pages[] = intval( $page['id'] );
					}

					if ( ! in_array( intval( $page_id ), $not_allowed_pages, true ) ) {
						$title = get_post_meta( $calculator->ID, 'stm-name', true );
						wp_localize_script(
							'ccb-sticky-js',
							'ccb_sticky_data',
							array(
								'title'        => $title,
								'the_id'       => get_the_ID(),
								'calc_id'      => $calculator->ID,
								'sticky_calc'  => $calc_settings['sticky_calc'],
								'translations' => CCBTranslations::get_frontend_translations(),
								'currency'     => ccb_parse_settings( $calc_settings ),
							)
						);

						$calc_settings['sticky_calc']['calc_title'] = $title;

						$sticky_content = \cBuilder\Classes\CCBTemplate::load(
							'/frontend/sticky',
							array(
								'calc_id'      => $calculator->ID,
								'the_id'       => get_the_ID(),
								'translations' => CCBTranslations::get_frontend_translations(),
								'sticky_calc'  => $calc_settings['sticky_calc'],
								'position'     => $positions[ $position_type ] ?? '',
							)
						);

						$calc_content = '';
						if ( 'open_modal' === $calc_settings['sticky_calc']['one_click_action'] ) {
							$calc_content = \cBuilder\Classes\CCBTemplate::load(
								'/frontend/partials/sticky-modal',
								array(
									'calc_id' => $calculator->ID,
									'the_id'  => get_the_ID(),
								)
							);
						}

						if ( 'banner' === $calc_settings['sticky_calc']['display_type'] ) {
							$sticky_banner  = $sticky_content;
							$sticky_content = '';
						}

						$calc_sticky = $calc_sticky . $sticky_content;
						$content     = $content . $calc_content;
					}

					if ( isset( $positions[ $position_type ] ) ) {
						$positions[ $position_type ]++;
					}
				}
			}
		}

		$close_tag = '';
		if ( $has_sticky ) {
			$close_tag = '</div>';
		}
		$calc_sticky .= $sticky_banner . $close_tag;

		return $content . $calc_sticky;
	}

	/**
	 * todo all template params must be here in controller
	 */
	public static function render_calculator( $attr ) {
		$data   = array( 'id' => null, 'sticky' => null ); //phpcs:ignore
		$params = shortcode_atts( $data, $attr );
		return self::render_calculator_handler( $params['id'], $params['sticky'] );
	}

	/**
	 * todo all template params must be here in controller
	 */
	public static function render_calculator_handler( $calc_id, $sticky = null ) {
		wp_enqueue_script( 'cbb-phone-js', CALC_URL . '/frontend/dist/libs/vue/phone/vue-phone-number-input.umd.js', array(), CALC_VERSION, true );
		wp_enqueue_script( 'cbb-resize-sensor-js', CALC_URL . '/frontend/dist/sticky/ResizeSensor.js', array(), CALC_VERSION, true );
		wp_enqueue_script( 'cbb-sticky-sidebar-js', CALC_URL . '/frontend/dist/sticky/sticky-sidebar.js', array( 'cbb-resize-sensor-js' ), CALC_VERSION, true );

		wp_enqueue_style( 'ccb-icons-list', CALC_URL . '/frontend/dist/css/icon/style.css', array(), CALC_VERSION );
		wp_enqueue_style( 'calc-builder-app', CALC_URL . '/frontend/dist/css/style.css', array(), CALC_VERSION );

		if ( ! empty( $calc_id ) && get_post( $calc_id ) ) {
			$id            = apply_filters( 'wpml_object_id', $calc_id, 'cost-calc', true );
			$calc_settings = CCBSettingsData::get_calculator_settings( $calc_id );
			$fields        = self::getCalculatorFields( $calc_id, $calc_settings );
			$settings      = $calc_settings['settings'];
			$language      = substr( get_bloginfo( 'language' ), 0, 2 );

			$sticky_calc_actions = array( 'open_modal' );
			if ( ccb_pro_active() && ! empty( $settings['sticky_calc']['enable'] ) && in_array( $settings['sticky_calc']['one_click_action'], $sticky_calc_actions, true ) && is_null( $sticky ) ) {
				return '';
			}

			$ccb_sync         = ccb_sync_settings_from_general_settings( $settings, $calc_settings['general_settings'], true );
			$settings         = $ccb_sync['settings'];
			$general_settings = $ccb_sync['general_settings'];

			self::ccb_add_custom_data( $calc_id, $sticky, $settings, $general_settings );

			$templates = \cBuilder\Helpers\CCBFieldsHelper::get_fields_templates( $settings, $general_settings );
			wp_enqueue_script( 'calc-builder-main-js', CALC_URL . '/frontend/dist/bundle.js', array( 'cbb-sticky-sidebar-js' ), CALC_VERSION, true );
			wp_localize_script(
				'calc-builder-main-js',
				'ajax_window',
				array(
					'ajax_url'   => admin_url( 'admin-ajax.php' ),
					'language'   => $language,
					'templates'  => $templates,
					'pro_active' => ccb_pro_active(),
					'the_id'     => get_the_ID(),
				)
			);

			return \cBuilder\Classes\CCBTemplate::load(
				'/frontend/render',
				array(
					'sticky'           => $sticky,
					'calc_id'          => $id,
					'language'         => $language,
					'translations'     => CCBTranslations::get_frontend_translations(),
					'settings'         => $settings,
					'general_settings' => $calc_settings['general_settings'],
					'fields'           => $fields,
				)
			);
		}

		return '<p style="text-align: center">' . __( 'No selected calculator', 'cost-calculator-builder' ) . '</p>';
	}

	private static function getCalculatorFields( $calc_id, $calc_settings ) {
		$fields = get_post_meta( $calc_id, 'stm-fields', true ) ?? array();

		if ( ! empty( $fields ) ) {
			array_walk(
				$fields,
				function ( &$field_value, $k ) use ( $calc_settings ) {

					/** set wc prooduct meta type */
					$field_value['wc_product_meta_link'] = '';
					if ( $calc_settings['settings']['woo_products']['enable'] && array_key_exists( 'alias', $field_value ) ) {
						$key = array_search( $field_value['alias'], array_column( $calc_settings['settings']['woo_products']['meta_links'], 'calc_field' ), true );
						if ( false !== $key ) {
							$field_value['wc_product_meta_link'] = $calc_settings['settings']['woo_products']['meta_links'][ $key ]['woo_meta'];
						}
					}
					/** set wc prooduct meta type |end */

					if ( array_key_exists( 'required', $field_value ) ) {
						$field_value['required'] = $field_value['required'] ? 'true' : 'false';
					}
				}
			);
		}
		return $fields;
	}

	public static function render_thank_you_page( $attr ) {

		wp_enqueue_script( 'cbb-resize-sensor-js', CALC_URL . '/frontend/dist/sticky/ResizeSensor.js', array(), CALC_VERSION, true );
		wp_enqueue_script( 'cbb-sticky-sidebar-js', CALC_URL . '/frontend/dist/sticky/sticky-sidebar.js', array( 'cbb-resize-sensor-js' ), CALC_VERSION, true );

		wp_enqueue_style( 'ccb-icons-list', CALC_URL . '/frontend/dist/css/icon/style.css', array(), CALC_VERSION );
		wp_enqueue_style( 'calc-builder-app', CALC_URL . '/frontend/dist/css/style.css', array(), CALC_VERSION );
		wp_enqueue_script( 'ccb-lodash-js', 'https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js', array(), CALC_VERSION, true );
		wp_add_inline_script( 'ccb-lodash-js', 'window.ccb_lodash = window.ccb_lodash ? window.ccb_lodash : _.noConflict();' );

		$params   = shortcode_atts( array( 'id' => null ), $attr );
		$language = substr( get_bloginfo( 'language' ), 0, 2 );

		wp_enqueue_script( 'calc-builder-main-js', CALC_URL . '/frontend/dist/bundle.js', array( 'ccb-lodash-js', 'cbb-sticky-sidebar-js' ), CALC_VERSION, true );
		wp_localize_script(
			'calc-builder-main-js',
			'ajax_window',
			array(
				'ajax_url'   => admin_url( 'admin-ajax.php' ),
				'language'   => $language,
				'templates'  => CCBFieldsHelper::get_fields_templates( array(), array() ),
				'pro_active' => ccb_pro_active(),
			)
		);

		if ( isset( $params['id'] ) && get_post( $params['id'] ) ) {
			$order_data = array();
			$order_id   = isset( $_GET['order_id'] ) ? (int) $_GET['order_id'] : null;
			$calc_id    = null;
			if ( ! is_null( $order_id ) ) {
				$order_data = apply_filters( 'ccb_order_data_by_id', $order_id );
				if ( isset( $order_data['calc_id'] ) ) {
					$calc_id = $order_data['calc_id'];
				}
			}

			$id = apply_filters( 'wpml_object_id', $calc_id, 'cost-calc', true );

			if ( defined( 'CCB_PRO' ) ) {
				return \cBuilder\Classes\CCBProTemplate::load(
					'/frontend/partials/custom-thank-you-page',
					array(
						'calc_id'      => $id,
						'order_id'     => $order_id,
						'language'     => $language,
						'order_data'   => $order_data,
						'translations' => CCBTranslations::get_frontend_translations(),
					)
				);
			}
		}

		return '';
	}

	public static function get_order_data_by_id( $id ) {
		if ( $id ) {
			$meta_data = get_option( 'calc_meta_data_order_' . $id, array() );
			$ccb_order = CCBOrderController::get_orders_by_id( $id );
			return array(
				'id'            => $ccb_order['id'],
				'calc_id'       => $ccb_order['calc_id'],
				'orderDetails'  => $ccb_order['order_details'],
				'formDetails'   => $ccb_order['form_details'],
				'paymentMethod' => $ccb_order['paymentMethod'],
				'orderDate'     => $ccb_order['date_formatted'],
				'converted'     => $meta_data['converted'],
				'totals'        => json_decode( $meta_data['totals'] ),
			);
		}

		return array();
	}

	public static function ccb_add_custom_data( $calc_id, $sticky, $settings, $general_settings ) {
		$preset_key = get_post_meta( $calc_id, 'ccb_calc_preset_idx', true );
		$preset_key = empty( $preset_key ) ? 0 : $preset_key;
		$appearance = CCBAppearanceHelper::get_appearance_data( $preset_key );
		$loader_idx = 0;

		if ( ! empty( $appearance ) ) {
			$appearance = $appearance['data'];

			if ( isset( $appearance['desktop']['others']['data']['calc_preloader']['value'] ) ) {
				$loader_idx = $appearance['desktop']['others']['data']['calc_preloader']['value'];
			}
		}

		$settings['calc_id'] = $calc_id;
		$settings['title']   = get_post_meta( $calc_id, 'stm-name', true );

		$template_params = array(
			'calc_id'          => $calc_id,
			'loader_idx'       => $loader_idx,
			'settings'         => $settings,
			'general_settings' => $general_settings,
		);

		$template_variables[ 'template' ] = \cBuilder\Classes\CCBTemplate::load( 'frontend/partials/calc-builder', $template_params ); // phpcs:ignore

		if ( ! empty( $sticky ) ) {
			echo '<script type="text/javascript">window["ccb_front_template_' . $calc_id . '"] = ' . json_encode( $template_variables ) . ';</script>'; // phpcs:ignore
		} else {
			add_action( 'wp_footer', function () use ( $calc_id, $template_params, $template_variables ) { // phpcs:ignore
				echo ( '<script type="text/javascript">window["ccb_front_template_' . $calc_id . '"] = ' . json_encode( $template_variables ) . ';</script>' ); //phpcs:ignore
			}); // phpcs:ignore
		}
	}
}
