<?php

namespace WPEasyDonation\Base;

class BaseController
{
	/**
	 * plugin path
	 * @var string
	 */
	public $plugin_path;

	/**
	 * plugin url
	 * @var string
	 */
	public $plugin_url;

	/** ppcp api url
	 * @var string
	 */
	public $ppcp_api;

	/**
	 * stripe api url
	 * @var string
	 */
	public $stripe_api;

	/**
	 * plugin version
	 * @var string
	 */
	public $plugin_version;

	/**
	 * plugin basename
	 * @var string
	 */
	public $plugin_basename;

	/**
	 * init vars
	 */
	public function __construct()
	{
		$this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
		$this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
		$this->plugin_version = WPEDON_FREE_VERSION_NUM;
		$this->plugin_basename = WPEDON_FREE_BASENAME;
		$this->ppcp_api = WPEDON_FREE_PPCP_API;
		$this->stripe_api = WPEDON_FREE_STRIPE_CONNECT_ENDPOINT;
	}

	/**
	 * get checkout data
	 * @param $data
	 * @return array
	 */
	protected function get_checkout_data( $data ): array
	{
		$result = [];

		$result['button_id'] = !empty( $data['custom'] ) ? intval( $data['custom'] ) : 0;
		$result['name'] = !empty( $data['item_name'] ) ? sanitize_text_field( $data['item_name'] ) : '';
		$result['currency'] = !empty( $data['currency_code'] ) ? sanitize_text_field( $data['currency_code'] ) : 'USD';

		$result['item_price'] = !empty( $data['amount'] ) ? floatval( $data['amount'] ) : 0;
		if ( isset( $data['os0'] ) ) {
			for ( $i = 0; $i <= 9; $i++ ) {
				if ( isset( $data['option_select' . $i] ) && isset( $data['option_amount' . $i] ) && $data['option_select' . $i] == $data['os0'] ) {
					$result['item_price'] = floatval( $data['option_amount' . $i] );
					break;
				}
			}
		}
		$result['item_full_price'] = $result['item_price'];

		$result['sku'] = !empty( $data['item_number'] ) ? sanitize_text_field( $data['item_number'] ) : '';

		// count discounts
		$result['discount_rate'] = 0;
		$result['discount_amount'] = 0;
		if ( !empty( $data['discount_rate'] ) ) {
			$discount_rate = floatval( $data['discount_rate'] );
			$discount = $result['item_price'] * $discount_rate / 100;
			$result['item_price'] -= $discount;
			$result['discount'] = $discount . '%';
			$result['discount_rate'] = $discount_rate;
		} elseif ( !empty( $data['discount_amount'] ) ) {
			$discount = floatval( $data['discount_amount'] );
			$result['item_price'] -= $discount;
			$result['discount'] = $discount . $result['currency'];
			$result['discount_amount'] = $discount;
		}

		$result['metadata'] = [];

		// Text Dropdown Menu
		if ( !empty( $data['on1'] ) && !empty( $data['os1'] ) ) {
			$result['metadata'][] = [
				'key' => sanitize_text_field( $data['on1'] ),
				'value' => sanitize_text_field( $data['os1'] )
			];
		}

		// Text Field 1
		if ( !empty( $data['on2'] ) && !empty( $data['os2'] ) ) {
			$result['metadata'][] = [
				'key' => sanitize_text_field( $data['on2'] ),
				'value' => sanitize_text_field( $data['os2'] )
			];
		}

		// Text Field 2
		if ( !empty( $data['on3'] ) && !empty( $data['os3'] ) ) {
			$result['metadata'][] = [
				'key' => sanitize_text_field( $data['on3'] ),
				'value' => sanitize_text_field( $data['os3'] )
			];
		}

		$result['item_price'] = max( 0, $result['item_price'] );

		$result['quantity'] = !empty( $result['quantity'] ) ? intval( $data['quantity'] ) : 1;

		$result['tax_rate'] = !empty( $data['tax_rate'] ) ? floatval( $data['tax_rate'] ) : 0;
		$result['tax'] = !empty( $data['tax'] ) ? floatval( $data['tax'] ) : 0;

		$result['shipping'] = !empty( $data['shipping'] ) ? floatval( $data['shipping'] ) : 0;

		$result['no_shipping'] = !empty( $data['no_shipping'] ) ? intval( $data['no_shipping'] ) : 0;

		return $result;
	}
}