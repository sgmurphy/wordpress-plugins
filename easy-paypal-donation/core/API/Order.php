<?php

namespace WPEasyDonation\API;

use WPEasyDonation\Base\BaseController;

class Order extends BaseController
{
	/**
	 * create order
	 * @param $data
	 * @return int|\WP_Error
	 */
	public function create($data)
	{
		$post_id_author = get_post_field('post_author', $data['button_id']);
		$item_name = sanitize_text_field($data['name'] . $data['item_name']);
		$item_number = intval($data['sku']);
		if (!$item_number) {
			$item_number = "";
		}
		$payment_status = sanitize_text_field($data['payment_status']);
		$payment_amount = sanitize_text_field($data['mc_gross']);
		$payment_currency = sanitize_text_field($data['mc_currency']);
		$payer_email = sanitize_email($data['payer_email']);
		$payment_method = sanitize_text_field($data['payment_method']);
		$mode = sanitize_text_field($data['mode']);
		$paypal_connection_type = sanitize_text_field($data['paypal_connection_type']);

		$ipn_post = array(
			'post_title' => $item_name,
			'post_status' => 'publish',
			'post_author' => $post_id_author,
			'post_type' => 'wpplugin_don_order'
		);

		$post_id = wp_insert_post($ipn_post);
		update_post_meta($post_id, 'wpedon_button_item_number', $item_number);
		update_post_meta($post_id, 'wpedon_button_payment_status', $payment_status);
		update_post_meta($post_id, 'wpedon_button_payment_amount', $payment_amount);
		update_post_meta($post_id, 'wpedon_button_payment_currency', $payment_currency);
		update_post_meta($post_id, 'wpedon_button_payment_method', $payment_method);
		update_post_meta($post_id, 'wpedon_button_mode', $mode);
		update_post_meta($post_id, 'wpedon_button_paypal_connection_type', $paypal_connection_type);
		if ($data['txn_id']) {
			update_post_meta($post_id, 'wpedon_button_txn_id', $data['txn_id']);
		}
		update_post_meta($post_id, 'wpedon_button_payer_email', $payer_email);

		return $post_id;
	}

	public function update($order_id, $data)
	{
		$allowed_meta = ['session_id', 'payment_amount', 'txn_id', 'payer_email', 'payment_status', 'authorization', 'metadata', 'shipping', 'payment_currency', 'order_key', 'capture_id', 'payment_date'];

		foreach ($data as $key => $value) {
			if (!in_array($key, $allowed_meta)) {
				continue;
			}

			if (in_array($key, ['metadata', 'shipping'])) {
				foreach ($value as $k => $item) {
					$value[$k]['key'] = sanitize_text_field($item['key']);
					$value[$k]['value'] = sanitize_text_field($item['value']);
				}
			} else {
				$value = sanitize_text_field($value);
			}

			update_post_meta($order_id, 'wpedon_button_' . $key, $value);
		}
	}

	public static function getOrderMeta($order_id)
	{
		$meta = [];
		$meta_raw = get_post_meta( $order_id );
		foreach ( $meta_raw as $k => $v ) {
			if ( $k === 'wpedon_order_data' ) {
				foreach ( maybe_unserialize( $v[0] ) as $kk => $vv ) {
					$kk = str_replace(
						['mc_currency', 'button_id'],
						['payment_currency', 'id'],
						$kk
					);
					$meta["wpedon_button_{$kk}"] = $vv;
				}
			} else {
				$meta[$k] = maybe_unserialize( $v[0] );
			}
		}

		if ( !isset( $meta['wpedon_button_payment_method'] ) ) {
			$meta['wpedon_button_payment_method'] = '';
		}

		if ( !isset( $meta['wpedon_button_payment_amount'] ) ) {
			if ( !empty( $meta['wpedon_button_payment_gross'] ) ) {
				$meta['wpedon_button_payment_amount'] = $meta['wpedon_button_payment_gross'];
			} elseif ( !empty( $meta['wpedon_button_mc_gross'] ) ) {
				$meta['wpedon_button_payment_amount'] = $meta['wpedon_button_mc_gross'];
			}
		}

		return $meta;
	}
}