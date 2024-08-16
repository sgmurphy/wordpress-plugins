<?php
/**
 * Plugin Name: Hide Shipping Methods for WooCommerce
 * Plugin URI: https://wordpress.org/plugins/wc-hide-shipping-methods/
 * Documentation URI: https://woocommerce.com/document/hide-shipping-methods/
 * Description: Hides other shipping methods when "Free shipping" is available.
 * Author: Rynaldo Stoltz
 * Author URI: https://profiles.wordpress.org/rynald0s/
 * Version: 1.7
 * Text Domain: wc-hide-shipping-methods
 * Domain Path: /languages
 * License: GPLv3 or later License
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * WC requires at least: 3.9.4
 * WC tested up to: 8.1
 * Requires at least: 6.5
 * Requires PHP: 7.4
 *
 * @package WC_Hide_Shipping_Methods
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Check if WooCommerce is active
 */
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
	return;
}

/**
 * Add settings for hiding shipping methods.
 *
 * @param array $settings WooCommerce shipping settings.
 * @return array Updated WooCommerce shipping settings.
 */
function wchfsm_add_settings( $settings ) {

	$settings[] = array(
		'title' => __( 'Shipping Method Visibility', 'wc-hide-shipping-methods' ),
		'type'  => 'title',
		'id'    => 'wc_hide_shipping',
	);

	$settings[] = array(
		'title'    => __( 'Free Shipping: ', 'wc-hide-shipping-methods' ),
		'desc'     => '',
		'id'       => 'wc_hide_shipping_options',
		'type'     => 'radio',
		'desc_tip' => true,
		'options'  => array(
			'hide_all'          => __( 'Show "Free Shipping" only. Hide all the other methods', 'wc-hide-shipping-methods' ),
			'hide_except_local' => __( 'Show "Free Shipping" and "Local Pickup" only (if available). Hide all the other methods.', 'wc-hide-shipping-methods' ),
		),
	);

	$settings[] = array(
		'type' => 'sectionend',
		'id'   => 'wc_hide_shipping',
	);
	return $settings;
}
add_filter( 'woocommerce_get_settings_shipping', 'wchfsm_add_settings', 10, 2 );

// Handle hiding shipping methods based on the selected option.
$hide_shipping_option = get_option( 'wc_hide_shipping_options' );

if ( 'hide_all' === $hide_shipping_option ) {

	/**
	 * Hide all other shipping methods when free shipping is available.
	 *
	 * @param array $rates Array of available shipping rates.
	 * @return array Filtered array of shipping rates.
	 */
	function wchfsm_hide_all_methods( $rates ) {
		$free = array_filter(
			$rates,
			function ( $rate ) {
				return 'free_shipping' === $rate->method_id;
			}
		);

		return ! empty( $free ) ? $free : $rates;
	}
	add_filter( 'woocommerce_package_rates', 'wchfsm_hide_all_methods', 10, 2 );

} elseif ( 'hide_except_local' === $hide_shipping_option ) {

	/**
	 * Hide all other shipping methods except Local Pickup when free shipping is available.
	 *
	 * @param array $rates Array of available shipping rates.
	 * @param array $package The package array being shipped.
	 * @return array Filtered array of shipping rates.
	 */
	function wchfsm_hide_except_local( $rates, $package ) { // phpcs:ignore -- The $package parameter is retained for potential future use.
		$new_rates = array_filter(
			$rates,
			function ( $rate ) {
				return 'free_shipping' === $rate->method_id || 'local_pickup' === $rate->method_id;
			}
		);

		return ! empty( $new_rates ) ? $new_rates : $rates;
	}
	add_filter( 'woocommerce_package_rates', 'wchfsm_hide_except_local', 10, 2 );
}

/**
 * Update the default option when the plugin is activated.
 */
function wchfsm_set_default_option() {
	update_option( 'wc_hide_shipping_options', 'hide_all' );
}
register_activation_hook( __FILE__, 'wchfsm_set_default_option' );

/**
 * Declare plugin compatibility with WooCommerce HPOS.
 */
function wchfsm_declare_woocommerce_hpos_compatibility() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
}
add_action( 'before_woocommerce_init', 'wchfsm_declare_woocommerce_hpos_compatibility' );

/**
 * Declare plugin compatibility with WooCommerce Cart & Checkout Blocks.
 */
function wchfsm_declare_woocommerce_block_compatibility() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, true );
	}
}
add_action( 'before_woocommerce_init', 'wchfsm_declare_woocommerce_block_compatibility' );
