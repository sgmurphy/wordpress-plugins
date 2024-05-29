<?php

namespace WPEasyDonation\Helpers;

class Option
{
	/**
	 * Default options
	 * @return array
	 */
	public static function defaultOptions(): array
	{
		return [
			'liveaccount' => '',
			'sandboxaccount' => '',
			'size' => '2',
			'no_note' => '1',
			'no_shipping' => '1',
			'note' => '1',
			'upload_image' => '',
			'image_1' => '',

			//new
			'currency' => '25',
			'language' => 'default',
			'disable_paypal' => '1',
			'mode' => '2',
			'disable_stripe' => '1',
			'mode_stripe' => '2',
			'acct_id_live' => '',
			'stripe_connect_token_live' => '',
			'acct_id_sandbox' => '',
			'stripe_connect_token_sandbox' => '',
			'opens' => '1',
			'cancel' => '',
			'return' => '',
			'activation_notice_shown' => 0,
			'stripe_connect_notice_dismissed' => 0,
			'ppcp_onboarding' => [
				'live' => [],
				'sandbox' => []
			],
			'ppcp_funding_paypal' => 1,
			'ppcp_funding_paylater' => 0,
			'ppcp_funding_venmo' => 0,
			'ppcp_funding_alternative' => 0,
			'ppcp_funding_cards' => 0,
			'ppcp_funding_advanced_cards' => 0,
			'ppcp_layout' => 'vertical',
			'ppcp_color' => 'gold',
			'ppcp_shape' => 'rect',
			'ppcp_label' => 'buynow',
			'ppcp_height' => 40,
			'ppcp_notice_dismissed' => 0,
			'updated_time' => 0,
			'ppcp_width' => 300,
			'stripe_width' => 300,
			'ppcp_acdc_button_text' => 'PLACE ORDER'
		];
	}

	/**
	 * get options
	 * @return array
	 */
	public static function get():array {
		$default = self::defaultOptions();
		$options = (array) get_option( 'wpedon_settings' );

		return array_merge( $default, $options );
	}

	/**
	 * update options
	 * @param $options
	 * @return bool
	 */
	public static function update($options):bool {
		$options['updated_time'] = time();
		return update_option( 'wpedon_settings', $options );
	}

	/**
	 * Init
	 */
	public static function init()
	{
		$options = self::get();
		self::update($options);
		self::oldOptions();
	}

	/**
	 * support old options
	 */
	public static function oldOptions() {
		$old_free_options = get_option( 'wpedon_settingsoptions' );
		if ( !empty( $old_free_options ) ) {
			$options = self::get();
			$old_free_options = (array) $old_free_options;
			$search_options = array_merge(
				array_keys( $options ),
				[
					'liveaccount',
					'sandboxaccount',
					'size',
					'paymentaction'
				]
			);
			foreach ( $search_options as $option ) {
				if ( isset( $old_free_options[$option] ) ) {
					$options[$option] = $old_free_options[$option];
				}
			}
			delete_option( 'wpedon_settingsoptions' );
			delete_option("wpedon_notice_shown");
			self::update($options);
		}
	}
}