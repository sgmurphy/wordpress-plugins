<?php
/**
 * Omnisend Cart Restore Functions
 *
 * @package OmnisendPlugin
 */

defined( 'ABSPATH' ) || exit;

function omnisend_restore_cart() {
	global $woocommerce;
	// Nonce verification is not required here.
	// phpcs:disable WordPress.Security.NonceVerification
	if ( ! empty( $_GET['cartID'] ) ) {

		$cart_id     = sanitize_key( $_GET['cartID'] );
		$link        = OMNISEND_API_URL . '/v3/carts/' . $cart_id;
		$curl_result = Omnisend_Helper::omnisend_api( $link, 'GET' );

		if ( $curl_result['code'] === 200 ) {
			Omnisend_Logger::log( 'info', 'carts', $link, 'Cart with ID ' . $cart_id . ' was successfully restored!' );
			$resp_data = json_decode( $curl_result['response'] );
			if ( null !== WC()->session ) {
				// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				WC()->session->set( 'omnisend_cartID', $resp_data->cartID );
				WC()->session->set( 'omnisend_cart_synced', 1 );
			}
			if ( count( $resp_data->products ) > 0 ) {
				// Clean the cart before restoring it.
				$woocommerce->cart->empty_cart();
			}

			foreach ( $resp_data->products as $product ) {
				// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				if ( $product->variantID !== $product->productID ) {
					$woocommerce->cart->add_to_cart( $product->productID, $product->quantity, $product->variantID );
				} else {
					$woocommerce->cart->add_to_cart( $product->productID, $product->quantity );
				}
				// phpcs:enable
			}
			// Set restored cartID to the current cart.
			$user_id = get_current_user_id();
			if ( $user_id > 0 ) {
				// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				update_user_meta( $user_id, 'omnisend_cartID', $resp_data->cartID );
			}

			$redirect_url = wc_get_cart_url();

			if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
				$redirect_url = add_query_arg( sanitize_text_field( wp_unslash( $_SERVER['QUERY_STRING'] ) ), '', $redirect_url );
			}

			$redirect_url = remove_query_arg( array( 'action' ), $redirect_url );
			wp_safe_redirect( esc_url( $redirect_url ) );

			exit;
		}
	}
	wp_safe_redirect( '/' );
	exit;
	// phpcs:enable
}

/**
 * Restore cart URL
 */
function omnisend_restore_cart_page() {
	// Nonce verification is not required here.
	// phpcs:ignore WordPress.Security.NonceVerification
	if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'restoreCart' ) {
		Omnisend_Logger::hook();
		omnisend_restore_cart();
	}
}

add_action( 'wp', 'omnisend_restore_cart_page' );
