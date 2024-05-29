<?php
/**
 * Omnisend Cart Class
 *
 * @package OmnisendPlugin
 */

defined( 'ABSPATH' ) || exit;

class Omnisend_Cart {
	public $email;
	public $currency;
	public $products = array();

	// phpcs:disable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
	public $cartID;
	public $contactID;
	public $attributionID;
	public $cartSum;
	public $cartRecoveryUrl;
	// phpcs:enable

	/**
	 * @return Omnisend_Cart|null
	 */
	public static function create() {
		try {
			return new Omnisend_Cart();
		} catch ( Omnisend_Empty_Required_Fields_Exception $exception ) {
			return null;
		}
	}

	/**
	 * @throws Omnisend_Empty_Required_Fields_Exception
	 */
	private function __construct() {
		global $woocommerce;

		$wc_cart = $woocommerce->cart->get_cart();

		$this->set_cart_id();

		$email = wp_get_current_user()->user_email;
		if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$this->email = $email;
		} elseif ( Omnisend_User_Storage::get_contact_id() ) {
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$this->contactID = Omnisend_User_Storage::get_contact_id();
		} else {
			throw new Omnisend_Empty_Required_Fields_Exception();
		}

		if ( Omnisend_User_Storage::get_attribution_id() ) {
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$this->attributionID = Omnisend_User_Storage::get_attribution_id();
		}

		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$this->cartRecoveryUrl = home_url( '?action=restoreCart&cartID=' . $this->cartID );

		$this->currency = get_woocommerce_currency();
		if ( $wc_cart ) {
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$this->cartSum = Omnisend_Helper::price_to_cents( WC()->cart->total );
			foreach ( $wc_cart as $cart_item_key => $wc_product ) {

				$product = array();

				$product['cartProductID'] = $cart_item_key;
				$product['productID']     = '' . $wc_product['product_id'];
				$product['variantID']     = '' . $wc_product['variation_id'];
				if ( empty( $product['variantID'] ) ) {
					$product['variantID'] = $product['productID'];
				}
				$product['quantity']   = intval( $wc_product['quantity'] );
				$product['productUrl'] = get_permalink( $wc_product['product_id'] );

				$wc_product_details = wc_get_product( $wc_product['product_id'] );
				if ( $wc_product_details ) {
					$product['sku']         = '' . $wc_product_details->get_sku();
					$product['title']       = $wc_product_details->get_name();
					$product['description'] = implode( ' ', array_slice( explode( ' ', preg_replace( '#\[[^\]]+\]#', '', $wc_product_details->get_description() ) ), 0, 30 ) );
					$product['price']       = Omnisend_Helper::price_to_cents( $wc_product_details->get_price() );
					if ( $wc_product_details->is_on_sale() && $wc_product_details->get_regular_price() != $wc_product_details->get_price() && is_numeric( $wc_product_details->get_regular_price() ) ) {
						$discount = Omnisend_Helper::price_to_cents( $wc_product_details->get_regular_price() - $wc_product_details->get_price() );
						if ( $discount > 0 ) {
							$product['discount'] = $discount;
						}
					}
					$image_url = wp_get_attachment_url( $wc_product_details->get_image_id() );
					if ( filter_var( $image_url, FILTER_VALIDATE_URL ) ) {
						$product['imageUrl'] = $image_url;
					}
				}

				if ( ! empty( $product['cartProductID'] ) && ! empty( $product['productID'] ) && ! empty( $product['title'] )
					&& ! empty( $product['quantity'] ) && isset( $product['price'] ) ) {
					array_push( $this->products, $product );
				}
			}
		} else {
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$this->cartSum = 0;
		}
		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		if ( empty( $this->cartID ) || ( empty( $this->email ) && empty( $this->contactID ) ) || empty( $this->currency ) || ! isset( $this->cartSum ) ) {
			throw new Omnisend_Empty_Required_Fields_Exception();
		}
	}

	private function set_cart_id() {

		$omnisend_cart_id = null === WC()->session ? '' : WC()->session->get( 'omnisend_cartID' );
		if ( $omnisend_cart_id == '' ) {
			$user_id = get_current_user_id();
			if ( $user_id > 0 ) {
				$omnisend_cart_id = get_user_meta( $user_id, 'omnisend_cartID', true );
			}
			if ( $omnisend_cart_id == '' ) {
				$omnisend_cart_id = 'wc_cart_' . get_current_user_id() . '_' . time() . '_' . wp_rand( 1000, 9999 );
				if ( $user_id > 0 ) {
					update_user_meta( $user_id, 'omnisend_cartID', $omnisend_cart_id );
				}
			}
			if ( null !== WC()->session ) {
				WC()->session->set( 'omnisend_cartID', $omnisend_cart_id );
			}
		}
		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$this->cartID = $omnisend_cart_id;
	}
}
