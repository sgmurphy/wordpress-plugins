<?php

namespace WPEasyDonation\Pages;

use WPEasyDonation\API\Order;
use WPEasyDonation\Helpers\Template;
use WPEasyDonation\Table\OrderTable;

class OrderPage
{
	/**
	 * Render page
	 */
	public function render()
	{
		if (!isset($_GET['action']) || $_GET['action'] == "delete" || (isset($_GET['action2']) && $_GET['action2'] == "delete")) {
			$this->get();
		}

		if (isset($_GET['action']) && $_GET['action'] == "delete" || isset($_GET['action2']) && $_GET['action2'] == "delete") {
			$this->delete();
		}

		if (isset($_GET['action']) && $_GET['action'] == "-1") {
			$this->no_action();
		}

		if (isset($_GET['action']) && $_GET['action'] == "view") {
			$this->getOneOrder();
		}
	}

	/**
	 * View all orders
	 */
	public function get()
	{
		$table = new OrderTable();
		$table->prepare_items();
		ob_start();
		$table->display();
		$tableHtml = ob_get_clean();
		Template::getTemplate('page/admin_orders.php', true, ['table'=>$tableHtml]);
	}

	/**
	 * Delete order
	 */
	public function delete()
	{
		$nonce = $_REQUEST['_wpnonce'];
		$action = 'bulk-orders';

		if ( ! wp_verify_nonce( $nonce, $action ) ) {
			wp_die('Security check fail');
		}
		$post_id = null;
		if (isset($_GET['inline']) && $_GET['inline'] == "true") {
			$post_id = array(intval($_GET['order']));
		} else {
			if (isset($_GET['order']) && is_array($_GET['order'])) {
				$post_id = array_map('intval', $_GET['order']);
			}
		}
		if (empty($post_id)) {
			echo '<script>window.location="'.$this->generateMessageUrl('nothing_deleted').'"; </script>';
			return;
		}
		foreach ($post_id as $to_delete) {
			$to_delete = intval($to_delete);
			if (get_post_type($to_delete) != 'wpplugin_don_order') {
				$to_delete = false;
			}
			if (!$to_delete) {
				echo '<script>window.location="'.$this->generateMessageUrl('error').'"; </script>';
				exit;
			}
			wp_delete_post($to_delete,1);
			delete_post_meta($to_delete,'wpedon_button_item_number');
			delete_post_meta($to_delete,'wpedon_button_payment_status');
			delete_post_meta($to_delete,'wpedon_button_payment_amount');
			delete_post_meta($to_delete,'wpedon_button_txn_id');
			delete_post_meta($to_delete,'wpedon_button_payer_email');
		}
		echo '<script>window.location="'.$this->generateMessageUrl('deleted').'"; </script>';
	}

	/**
	 * No action taken
	 */
	public function no_action() {
		echo '<script>window.location="'.$this->generateMessageUrl('nothing').'"; </script>';
	}


	/**
	 * View order
	 */
	public function getOneOrder() {
		$post_id = intval($_GET['order']);
		if (!$post_id) {
			echo'<script>window.location="'.$this->generateMessageUrl('not_found').'"; </script>';
			exit;
		}

		check_admin_referer('view_'.$post_id);
		$post_data = get_post($post_id);
		$title = $post_data->post_title;
		$date = $post_data->post_date;
		$date = wp_date( get_option( 'date_format' ), strtotime($date));

		$order_meta = Order::getOrderMeta($post_id);

		$title = empty( $title ) && isset( $order_meta['wpedon_button_name'] ) ? $order_meta['wpedon_button_name'] : $title;
		$txn_id = isset( $order_meta['wpedon_button_txn_id'] ) ? $order_meta['wpedon_button_txn_id'] : '';
		$payment_method = isset( $order_meta['wpedon_button_payment_method'] ) ? $order_meta['wpedon_button_payment_method'] : '';
		$amount = isset( $order_meta['wpedon_button_payment_amount'] ) ? $order_meta['wpedon_button_payment_amount'] : '';
		$recurring = isset( $order_meta['wpedon_button_txn_type'] ) && $order_meta['wpedon_button_txn_type'] === 'subscr_signup' ? 'Yes' : 'No';
		$donation_id = isset( $order_meta['wpedon_button_item_number'] ) ? $order_meta['wpedon_button_item_number'] : '';
		$payer_email = isset( $order_meta['wpedon_button_payer_email'] ) ? $order_meta['wpedon_button_payer_email'] : '';
		$payer_currency = isset( $order_meta['wpedon_button_payment_currency'] ) ? $order_meta['wpedon_button_payment_currency'] : '';
		$capture_id = isset( $order_meta['wpedon_button_capture_id'] ) ? $order_meta['wpedon_button_capture_id'] : '';
		$mode = isset( $order_meta['wpedon_button_mode'] ) ? $order_meta['wpedon_button_mode'] : '';
		$payment_status = isset( $order_meta['wpedon_button_payment_status'] ) ? $order_meta['wpedon_button_payment_status'] : '';
		$paypal_connection_type = isset( $order_meta['wpedon_button_paypal_connection_type'] ) ? $order_meta['wpedon_button_paypal_connection_type'] : '';

		Template::getTemplate('page/admin_view_order.php', true, [
			'post_id'=>$post_id, 'payment_method'=>$payment_method, 'txn_id'=>$txn_id,
			'date'=>$date, 'title'=>$title, 'amount'=>$amount, 'recurring'=>$recurring,
			'donation_id'=>$donation_id, 'payer_email'=>$payer_email, 'payer_currency'=>$payer_currency,
			'capture_id' => $capture_id, 'mode' => $mode, 'payment_status' => $payment_status,
			'paypal_connection_type' => $paypal_connection_type
		]);
	}

	/**
	 * generate admin url
	 * @param $message
	 * @return string
	 */
	private function generateMessageUrl($message): string
	{
		$message = 'admin.php?page=wpedon_menu&message='.$message;
		return get_admin_url(null, $message);
	}
}

