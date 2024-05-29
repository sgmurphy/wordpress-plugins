<?php

namespace WPEasyDonation\Pages;

use WPEasyDonation\Helpers\Template;
use WPEasyDonation\Table\ButtonTable;

class ButtonPage
{
	/**
	 * render page
	 */
	public function render()
	{
		if (!isset($_GET['action']) || $_GET['action'] == "delete" || !empty($_GET['action2']) == "delete") {
			$this->get();
		}

		if (isset($_GET['action']) && $_GET['action'] == "delete" || isset($_GET['action2']) && $_GET['action2'] == "delete")
		{
			$this->delete();
		}

		if (isset($_GET['action']) && $_GET['action'] == "new") {
			$this->create();
		}

		if (isset($_GET['action']) && $_GET['action'] == "edit") {
			$this->edit();
		}
	}

	/**
	 * Get all buttons
	 */
	public function get()
	{
		$table = new ButtonTable();
		$table->prepare_items();
		ob_start();
		$table->display();
		$tableHtml = ob_get_clean();
		Template::getTemplate('page/admin_buttons.php', true, ['table'=>$tableHtml]);
	}

	/**
	 * Create new button
	 */
	public function create()
	{
		global $current_user;

		$message = "";
		$error = null;
		if (isset($_POST['update'])) {
			// check nonce for security
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'new_wpedon_button')) {
				echo "Nonce verification failed.";
				exit;
			}
			// price is Required for stripe
			if (empty($_POST['wpedon_button_price'])) {
				$message = "Price Required.";
				$error = "1";
			}

			if (!isset($error)) {
				$my_post = array(
					'post_title' => sanitize_text_field($_POST['wpedon_button_name']),
					'post_status' => 'publish',
					'post_author' => $current_user->ID,
					'post_type' => 'wpplugin_don_button'
				);

				// Insert the post and meta data into the database
				$post_id = wp_insert_post($my_post);

				$wpedon_button_price_type = sanitize_text_field( $_POST['wpedon_button_price_type'] );
				update_post_meta($post_id, 'wpedon_button_price_type', $wpedon_button_price_type);

				$wpedon_button_price = sanitize_meta('currency', $_POST['wpedon_button_price'], 'post');
				update_post_meta($post_id, 'wpedon_button_price', $wpedon_button_price);

				update_post_meta($post_id, 'wpedon_button_id', sanitize_text_field($_POST['wpedon_button_id']));

				$wpedon_button_enable_name = !empty($_POST['wpedon_button_enable_name']) ? sanitize_text_field($_POST['wpedon_button_enable_name']) : 0;
				update_post_meta($post_id, 'wpedon_button_enable_name', $wpedon_button_enable_name);

				$wpedon_button_enable_price = !empty($_POST['wpedon_button_enable_price']) ? sanitize_text_field($_POST['wpedon_button_enable_price']) : 0;
				update_post_meta($post_id, 'wpedon_button_enable_price', $wpedon_button_enable_price);

				if (!empty($_POST['wpedon_button_enable_currency'])) {
					$wpedon_button_enable_currency = intval($_POST['wpedon_button_enable_currency']);
					if (!$wpedon_button_enable_currency) {
						$wpedon_button_enable_currency = "";
					}
				} else {
					$wpedon_button_enable_currency = 0;
				}
				update_post_meta($post_id, 'wpedon_button_enable_currency', $wpedon_button_enable_currency);


				$wpedon_button_currency = intval($_POST['wpedon_button_currency']);
				if (!$wpedon_button_currency) {
					$wpedon_button_currency = "";
				}
				update_post_meta($post_id, 'wpedon_button_currency', $wpedon_button_currency);

				$wpedon_button_language = intval($_POST['wpedon_button_language']);
				if (!$wpedon_button_language) {
					$wpedon_button_language = "";
				}
				update_post_meta($post_id, 'wpedon_button_language', $wpedon_button_language);

				update_post_meta($post_id, 'wpedon_button_buttonsize', "");

				update_post_meta($post_id, 'wpedon_button_return', sanitize_text_field($_POST['wpedon_button_return']));

				update_post_meta($post_id, 'wpedon_button_scpriceprice', sanitize_text_field($_POST['wpedon_button_scpriceprice']));
				update_post_meta($post_id, 'wpedon_button_scpriceaname', sanitize_text_field($_POST['wpedon_button_scpriceaname']));
				update_post_meta($post_id, 'wpedon_button_scpricebname', sanitize_text_field($_POST['wpedon_button_scpricebname']));
				update_post_meta($post_id, 'wpedon_button_scpricecname', sanitize_text_field($_POST['wpedon_button_scpricecname']));
				update_post_meta($post_id, 'wpedon_button_scpricedname', sanitize_text_field($_POST['wpedon_button_scpricedname']));
				update_post_meta($post_id, 'wpedon_button_scpriceename', sanitize_text_field($_POST['wpedon_button_scpriceename']));
				update_post_meta($post_id, 'wpedon_button_scpricefname', sanitize_text_field($_POST['wpedon_button_scpricefname']));
				update_post_meta($post_id, 'wpedon_button_scpricegname', sanitize_text_field($_POST['wpedon_button_scpricegname']));
				update_post_meta($post_id, 'wpedon_button_scpricehname', sanitize_text_field($_POST['wpedon_button_scpricehname']));
				update_post_meta($post_id, 'wpedon_button_scpriceiname', sanitize_text_field($_POST['wpedon_button_scpriceiname']));
				update_post_meta($post_id, 'wpedon_button_scpricejname', sanitize_text_field($_POST['wpedon_button_scpricejname']));

				$wpedon_button_scpricea = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricea'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricea', $wpedon_button_scpricea);
				$wpedon_button_scpriceb = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpriceb'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpriceb', $wpedon_button_scpriceb);
				$wpedon_button_scpricec = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricec'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricec', $wpedon_button_scpricec);
				$wpedon_button_scpriced = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpriced'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpriced', $wpedon_button_scpriced);
				$wpedon_button_scpricee = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricee'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricee', $wpedon_button_scpricee);
				$wpedon_button_scpricef = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricef'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricef', $wpedon_button_scpricef);
				$wpedon_button_scpriceg = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpriceg'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpriceg', $wpedon_button_scpriceg);
				$wpedon_button_scpriceh = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpriceh'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpriceh', $wpedon_button_scpriceh);
				$wpedon_button_scpricei = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricei'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricei', $wpedon_button_scpricei);
				$wpedon_button_scpricej = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricej'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricej', $wpedon_button_scpricej);

				echo '<script>window.location="'.$this->generateMessageUrl('created').'"; </script>';
				exit;
			}
		}
		Template::getTemplate('page/admin_button_new.php', true, ['error'=>$error, 'message'=>$message]);
	}

	/**
	 * Edit button
	 */
	public function edit()
	{
		$post_id = $_GET['product'];
		check_admin_referer('edit_'.$post_id);
		$message = "";
		$error = null;

		// check nonce for security
		$nonce = $_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($nonce, 'edit_' . $post_id)) {
			echo "Nonce verification failed.";
			exit;
		}

		if (isset($_POST['update'])) {
			$post_id = intval($_GET['product']);

			// check nonce for security
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'edit_' . $post_id)) {
				echo "Nonce verification failed.";
				exit;
			}

			if (!$post_id) {
				echo '<script>window.location="'.$this->generateMessageUrl().'"; </script>';
				exit;
			}

			// price is Required for stripe
			if (empty($_POST['wpedon_button_price'])) {
				$message = "Price Required.";
				$error = "1";
			}

			// Update data
			if (!isset($error)) {
				$my_post = array(
					'ID' => $post_id,
					'post_title' => sanitize_text_field($_POST['wpedon_button_name'])
				);
				wp_update_post($my_post);

				$wpedon_button_price_type = sanitize_text_field( $_POST['wpedon_button_price_type'] );
				update_post_meta($post_id, 'wpedon_button_price_type', $wpedon_button_price_type);

				$wpedon_button_price = sanitize_meta('currency_wpedon', $_POST['wpedon_button_price'], 'post');
				update_post_meta($post_id, 'wpedon_button_price', $wpedon_button_price);

				update_post_meta($post_id, 'wpedon_button_id', sanitize_text_field($_POST['wpedon_button_id']));

				$wpedon_button_enable_name = !empty($_POST['wpedon_button_enable_name']) ? sanitize_text_field($_POST['wpedon_button_enable_name']) : 0;
				update_post_meta($post_id, 'wpedon_button_enable_name', $wpedon_button_enable_name);

				$wpedon_button_enable_price = !empty($_POST['wpedon_button_enable_price']) ? sanitize_text_field($_POST['wpedon_button_enable_price']) : 0;
				update_post_meta($post_id, 'wpedon_button_enable_price', $wpedon_button_enable_price);

				$wpedon_button_enable_currency = !empty($_POST['wpedon_button_enable_currency']) ? intval($_POST['wpedon_button_enable_currency']) : 0;
				update_post_meta($post_id, 'wpedon_button_enable_currency', $wpedon_button_enable_currency);

				$wpedon_button_currency = intval($_POST['wpedon_button_currency']);
				if (!$wpedon_button_currency) {
					$wpedon_button_currency = "";
				}
				update_post_meta($post_id, 'wpedon_button_currency', $wpedon_button_currency);

				$wpedon_button_language = intval($_POST['wpedon_button_language']);
				if (!$wpedon_button_language) {
					$wpedon_button_language = "";
				}
				update_post_meta($post_id, 'wpedon_button_language', $wpedon_button_language);

				$wpedon_button_buttonsize = "";
				if (isset($_POST['wpedon_button_buttonsize'])) {
					$wpedon_button_buttonsize = intval($_POST['wpedon_button_buttonsize']);
				}
				update_post_meta($post_id, 'wpedon_button_buttonsize', $wpedon_button_buttonsize);

				if (isset($_POST['wpedon_button_account'])) {
					update_post_meta($post_id, 'wpedon_button_account', sanitize_text_field($_POST['wpedon_button_account']));
				}
				update_post_meta($post_id, 'wpedon_button_return', sanitize_text_field($_POST['wpedon_button_return']));

				update_post_meta($post_id, 'wpedon_button_scpriceprice', sanitize_text_field($_POST['wpedon_button_scpriceprice']));
				update_post_meta($post_id, 'wpedon_button_scpriceaname', sanitize_text_field($_POST['wpedon_button_scpriceaname']));
				update_post_meta($post_id, 'wpedon_button_scpricebname', sanitize_text_field($_POST['wpedon_button_scpricebname']));
				update_post_meta($post_id, 'wpedon_button_scpricecname', sanitize_text_field($_POST['wpedon_button_scpricecname']));
				update_post_meta($post_id, 'wpedon_button_scpricedname', sanitize_text_field($_POST['wpedon_button_scpricedname']));
				update_post_meta($post_id, 'wpedon_button_scpriceename', sanitize_text_field($_POST['wpedon_button_scpriceename']));
				update_post_meta($post_id, 'wpedon_button_scpricefname', sanitize_text_field($_POST['wpedon_button_scpricefname']));
				update_post_meta($post_id, 'wpedon_button_scpricegname', sanitize_text_field($_POST['wpedon_button_scpricegname']));
				update_post_meta($post_id, 'wpedon_button_scpricehname', sanitize_text_field($_POST['wpedon_button_scpricehname']));
				update_post_meta($post_id, 'wpedon_button_scpriceiname', sanitize_text_field($_POST['wpedon_button_scpriceiname']));
				update_post_meta($post_id, 'wpedon_button_scpricejname', sanitize_text_field($_POST['wpedon_button_scpricejname']));
				
				
				update_post_meta($post_id, '_wpedon_paypal_mode', sanitize_text_field($_POST['mode']));
				
				
				$wpedon_button_scpricea = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricea'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricea', $wpedon_button_scpricea);
				$wpedon_button_scpriceb = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpriceb'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpriceb', $wpedon_button_scpriceb);
				$wpedon_button_scpricec = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricec'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricec', $wpedon_button_scpricec);
				$wpedon_button_scpriced = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpriced'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpriced', $wpedon_button_scpriced);
				$wpedon_button_scpricee = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricee'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricee', $wpedon_button_scpricee);
				$wpedon_button_scpricef = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricef'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricef', $wpedon_button_scpricef);
				$wpedon_button_scpriceg = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpriceg'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpriceg', $wpedon_button_scpriceg);
				$wpedon_button_scpriceh = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpriceh'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpriceh', $wpedon_button_scpriceh);
				$wpedon_button_scpricei = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricei'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricei', $wpedon_button_scpricei);
				$wpedon_button_scpricej = sanitize_meta('currency_wpedon', $_POST['wpedon_button_scpricej'], 'post');
				update_post_meta($post_id, 'wpedon_button_scpricej', $wpedon_button_scpricej);

				update_post_meta( $post_id, 'ppcp_funding_paypal', sanitize_text_field( $_POST['ppcp_funding_paypal'] ) );
				update_post_meta( $post_id, 'wpedon_button_ppcp_width', sanitize_text_field( $_POST['wpedon_button_ppcp_width'] ) );
				update_post_meta( $post_id, 'wpedon_button_ppcp_acdc_button_text', sanitize_text_field( $_POST['wpedon_button_ppcp_acdc_button_text'] ) );
				update_post_meta( $post_id, 'ppcp_funding_paylater', sanitize_text_field( $_POST['ppcp_funding_paylater'] ) );
				update_post_meta( $post_id, 'ppcp_funding_venmo', sanitize_text_field( $_POST['ppcp_funding_venmo'] ) );
				update_post_meta( $post_id, 'ppcp_funding_alternative', sanitize_text_field( $_POST['ppcp_funding_alternative'] ) );
				update_post_meta( $post_id, 'ppcp_funding_cards', sanitize_text_field( $_POST['ppcp_funding_cards'] ) );
				update_post_meta( $post_id, 'ppcp_funding_advanced_cards', sanitize_text_field( $_POST['ppcp_funding_advanced_cards'] ) );

				update_post_meta( $post_id, 'ppcp_layout', sanitize_text_field( $_POST['ppcp_layout'] ) );
				update_post_meta( $post_id, 'ppcp_color', sanitize_text_field( $_POST['ppcp_color'] ) );
				update_post_meta( $post_id, 'ppcp_shape', sanitize_text_field( $_POST['ppcp_shape'] ) );
				//update_post_meta( $post_id, 'ppcp_label', sanitize_text_field( $_POST['ppcp_label'] ) );
				update_post_meta( $post_id, 'ppcp_height', sanitize_text_field( $_POST['ppcp_height'] ) );
				update_post_meta($post_id, 'wpedon_button_disable_stripe', sanitize_text_field($_POST['wpedon_button_disable_stripe']));
				update_post_meta($post_id, 'wpedon_button_stripe_width', sanitize_text_field($_POST['wpedon_button_stripe_width']));

				$message = "Saved";
			}
		}

		Template::getTemplate('page/admin_button_edit.php', true, ['error'=>$error, 'message'=>$message]);
	}

	/**
	 * No action taken
	 */
	public function no_action()
	{
		echo '<script>window.location="'.$this->generateMessageUrl('nothing').'"; </script>';
	}

	/**
	 * Delete button
	 */
	public function delete()
	{
		// check nonce for security
		$nonce = $_REQUEST['_wpnonce'];
		$action = 'bulk-products';

		if ( ! wp_verify_nonce( $nonce, $action ) ) {
			wp_die('Security check fail');
		}

		$post_id = null;
		if (isset($_GET['inline']) && $_GET['inline'] == "true") {
			$post_id = array(intval($_GET['product']));
		} else {
			if (isset($_GET['order']) && is_array($_GET['product'])) {
				$post_id = array_map('intval', $_GET['order']);
			}
		}

		if (empty($post_id)) {
			echo '<script>window.location="'.$this->generateMessageUrl('nothing_deleted').'"; </script>';
			exit;
		}

		foreach ($post_id as $to_delete) {
			$to_delete = intval($to_delete);

			if (get_post_type($to_delete) != 'wpplugin_don_button') {
				$to_delete = false;
			}

			if (!$to_delete) {
				echo '<script>window.location="'.$this->generateMessageUrl('error').'"; </script>';
				exit;
			}

			wp_delete_post($to_delete,1);
			delete_post_meta($to_delete,'wpedon_button_price');
			delete_post_meta($to_delete,'wpedon_button_id');
			delete_post_meta($to_delete,'wpedon_button_enable_name');
			delete_post_meta($to_delete,'wpedon_button_enable_price');
			delete_post_meta($to_delete,'wpedon_button_enable_currency');
			delete_post_meta($to_delete,'wpedon_button_currency');
			delete_post_meta($to_delete,'wpedon_button_language');
			delete_post_meta($to_delete,'wpedon_button_account');
			delete_post_meta($to_delete,'wpedon_button_return');
			delete_post_meta($to_delete,'wpedon_button_buttonsize');
			delete_post_meta($to_delete,'wpedon_button_scpriceprice');
			delete_post_meta($to_delete,'wpedon_button_scpriceaname');
			delete_post_meta($to_delete,'wpedon_button_scpricebname');
			delete_post_meta($to_delete,'wpedon_button_scpricecname');
			delete_post_meta($to_delete,'wpedon_button_scpricedname');
			delete_post_meta($to_delete,'wpedon_button_scpriceename');
			delete_post_meta($to_delete,'wpedon_button_scpricefname');
			delete_post_meta($to_delete,'wpedon_button_scpricegname');
			delete_post_meta($to_delete,'wpedon_button_scpricehname');
			delete_post_meta($to_delete,'wpedon_button_scpriceiname');
			delete_post_meta($to_delete,'wpedon_button_scpricejname');
			delete_post_meta($to_delete,'wpedon_button_scpricea');
			delete_post_meta($to_delete,'wpedon_button_scpriceb');
			delete_post_meta($to_delete,'wpedon_button_scpricec');
			delete_post_meta($to_delete,'wpedon_button_scpriced');
			delete_post_meta($to_delete,'wpedon_button_scpricee');
			delete_post_meta($to_delete,'wpedon_button_scpricef');
			delete_post_meta($to_delete,'wpedon_button_scpriceg');
			delete_post_meta($to_delete,'wpedon_button_scpriceh');
			delete_post_meta($to_delete,'wpedon_button_scpricei');
			delete_post_meta($to_delete,'wpedon_button_scpricej');
		}

		echo '<script>window.location="'.$this->generateMessageUrl('deleted').'"; </script>';
		exit;
	}

	/**
	 * generate admin url
	 * @param $message
	 * @return string
	 */
	private function generateMessageUrl($message = null): string
	{
		if ($message) {
			$message = 'admin.php?page=wpedon_buttons&message='.$message;
			return get_admin_url(null, $message);
		} else {
			$message = 'admin.php?page=wpedon_buttons'.$message;
			return get_admin_url(null, $message);
		}
	}
}