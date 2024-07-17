<?php

#[AllowDynamicProperties]
class BWF_Compatibility_With_YayCurrency {

	public function is_enable() {
		return class_exists( 'Yay_Currency\Helpers\YayCurrencyHelper' );
	}

	/**
	 * Modifies the amount for the fixed discount given by the admin in the currency selected.
	 *
	 * @param integer|float $price
	 *
	 * @return float
	 */
	public function alter_fixed_amount( $price, $currency = null ) {
		if ( ! $this->is_enable() ) {
			return $price;
		}

		$currency = $this->get_formatted_currency( $currency );
		if ( empty( $currency ) ) {
			return $price;
		}

		return Yay_Currency\Helpers\YayCurrencyHelper::calculate_price_by_currency( $price, false, $currency );
	}


	function get_fixed_currency_price_reverse( $price, $from = null, $base = null ) {
		if ( ! $this->is_enable() ) {
			return $price;
		}

		$currency = $this->get_formatted_currency( $from );
		if ( empty( $currency ) ) {
			return $price;
		}

		return Yay_Currency\Helpers\YayCurrencyHelper::reverse_calculate_price_by_currency( $price, $currency );
	}

	public function get_formatted_currency( $from ) {
		if ( ! $this->is_enable() ) {
			return [];
		}

		$currencies     = Yay_Currency\Helpers\Helper::get_currencies_post_type();
		$apply_currency = [];
		foreach ( $currencies as $currency ) {
			if ( ! $currency instanceof WP_Post || $currency->post_title !== $from ) {
				continue;
			}

			$apply_currency = Yay_Currency\Helpers\YayCurrencyHelper::get_currency_by_ID( $currency->ID );
		}

		return $apply_currency;
	}
}

BWF_Plugin_Compatibilities::register( new BWF_Compatibility_With_YayCurrency(), 'yaycurrency' );
