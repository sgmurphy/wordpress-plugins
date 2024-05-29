<?php

#[AllowDynamicProperties]
class WFACP_Compatibility_WPML_WCML {
	public function __construct() {
		add_action( 'woocommerce_before_calculate_totals', [ $this, 'woocommerce_calculate_totals' ], 200 );
		add_filter( 'wfacp_product_raw_data', [ $this, 'change_raw_data' ], 10, 2 );

		add_action( 'wfacp_internal_css', [ $this, 'js' ] );
		add_action( 'woocommerce_checkout_update_order_review', [ $this, 'get_data' ], 5 );
		add_filter( 'woocommerce_update_order_review_fragments', [ $this, 'unset_fragments' ], 900 );
	}

	public function woocommerce_calculate_totals( $cart ) {
		if ( ! class_exists( 'SitePress' ) || ! class_exists( 'woocommerce_wpml' ) || ! class_exists( 'WCML_Cart' ) ) {
			return $cart;
		}
		$new_cart = [];
		foreach ( $cart->cart_contents as $key => $cart_item ) {
			if ( isset( $cart_item['key'] ) && isset( $cart_item['_wfacp_options'] ) ) {
				$key = $cart_item['key'];
			}
			$new_cart[ $key ] = $cart_item;
		}
		if ( count( $new_cart ) > 0 ) {
			$cart->cart_contents = $new_cart;
		}

		return $cart->cart_contents;
	}

	public function change_raw_data( $raw_data, $product ) {

		if ( ! class_exists( 'SitePress' ) || ! class_exists( 'woocommerce_wpml' ) || ! $product instanceof WC_Product ) {
			return $raw_data;
		}
		/**
		 * @var $product WC_Product;
		 */

		$product_id = $product->get_id();
		global $wpdb;
		$result = $wpdb->get_results( "select element_id  from {$wpdb->prefix}icl_translations where trid=(select trid from {$wpdb->prefix}icl_translations where element_id='{$product_id}' and element_type='post_product' and source_language_code IS NOT NULL) and source_language_code IS NULL", ARRAY_A );
		if ( empty( $result ) ) {
			return $raw_data;
		}

		$element_id       = $result[0]['element_id'];
		$custom_prices_on = get_post_meta( $element_id, '_wcml_custom_prices_status', true );
		if ( empty( $custom_prices_on ) || 1 != $custom_prices_on ) {
			return $raw_data;
		}

		global $woocommerce_wpml;
		$currency = $woocommerce_wpml->get_multi_currency()->get_client_currency();
		// For variation type of product
		$regular_price = get_post_meta( $element_id, '_regular_price_' . $currency, true );
		$sale_price    = get_post_meta( $element_id, '_sale_price_' . $currency, true );
		$price         = get_post_meta( $element_id, '_price' . $currency, true );

		if ( ! empty( $regular_price ) ) {
			$raw_data['regular_price'] = $regular_price;
			$raw_data['price']         = $price;
		}
		if ( ! is_null( $sale_price ) && $sale_price > 0 ) {
			$raw_data['sale_price'] = $sale_price;
			$raw_data['price']      = $sale_price;
		}

		return $raw_data;
	}

	public function get_data( $data ) {

		if ( empty( $data ) ) {
			return;
		}
		parse_str( $data, $post_data );
		if ( empty( $post_data ) || ! isset( $post_data['wfacp_input_hidden_data'] ) || empty( $post_data['wfacp_input_hidden_data'] ) ) {
			return;
		}

		$bump_action_data = json_decode( $post_data['wfacp_input_hidden_data'], true );

		if ( empty( $bump_action_data ) ) {
			return;
		}
		if ( isset( $bump_action_data['unset_fragments'] ) ) {
			$this->process = true;
		}
	}

	public function unset_fragments( $fragments ) {

		if ( false == $this->process ) {
			return $fragments;
		}
		foreach ( $fragments as $k => $fragment ) {

			if ( false !== strpos( $k, 'wfacp' ) && true == apply_filters( 'wfacp_unset_our_fragments_by_yith_discount', true, $k ) ) {
				unset( $fragments[ $k ] );
			}
		}

		unset( $fragments['cart_total'] );

		return $fragments;
	}

	public function js() {
		?>
		<script>
            window.addEventListener('load', function () {
                (function ($) {
                    wfacp_frontend.hooks.addFilter('wfacp_before_ajax_data_update_product_qty', set_custom_data);
                    wfacp_frontend.hooks.addFilter('wfacp_before_ajax_data_update_cart_item_quantity', set_custom_data);
                    wfacp_frontend.hooks.addFilter('wfacp_before_ajax_data_wfacp_restore_cart_item', set_custom_data);
                    wfacp_frontend.hooks.addAction('wfacp_ajax_response', trigger_checkout);

                    function set_custom_data(data) {
                        data['unset_fragments'] = 'yes';
                        return data;
                    }

                    function trigger_checkout() {
                        setTimeout(() => {
                            $('body').addClass('wfacp_anim_active');
                            $(document.body).trigger('update_checkout');
                        });

                    }

                })(jQuery);
            });
		</script>
		<?php
	}
}


if ( ! class_exists( 'SitePress' ) || ! class_exists( 'woocommerce_wpml' ) || ! class_exists( 'WCML_Cart' ) ) {
	return;
}
WFACP_Plugin_Compatibilities::register( new WFACP_Compatibility_WPML_WCML(), 'wpml_wcml' );


