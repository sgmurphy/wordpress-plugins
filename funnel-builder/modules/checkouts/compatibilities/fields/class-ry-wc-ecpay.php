<?php

/**
 * RY WooCommerce ECPay Invoice v.1.6.5 and RY WooCommerce Tools v.3.1.0 by Yang
 * Plugin URI: https://richer.tw/ry-woocommerce-ecpay-invoice/
 */
#[AllowDynamicProperties]
class WFACP_RY_WC_Ecpay {
	public $instance = null;

	public function __construct() {
		/* Register Add field */
		add_filter( 'wfacp_advanced_fields', [ $this, 'add_field' ], 20 );
		add_filter( 'wfacp_html_fields_rc_wc_ecpay', '__return_false' );
		add_action( 'process_wfacp_html', [ $this, 'display_field' ], 999, 2 );
		/* Assign Object */
		add_action( 'wfacp_after_checkout_page_found', [ $this, 'action' ] );
		/* internal css for plugin */
		add_action( 'wfacp_internal_css', [ $this, 'internal_css' ] );


	}

	public function add_field( $fields ) {
		$fields['rc_wc_ecpay'] = [
			'type'       => 'wfacp_html',
			'class'      => [ 'wfacp-col-full', 'wfacp-form-control-wrapper', 'rc_wc_ecpay' ],
			'id'         => 'rc_wc_ecpay',
			'field_type' => 'rc_wc_ecpay',
			'label'      => __( 'RC WC Ecpay', 'woofunnels-aero-checkout' ),
		];

		return $fields;
	}

	public function action() {


		if ( class_exists( 'RY_WEI_Invoice_Basic' ) ) {
			wp_enqueue_script( 'ry-wei-checkout', RY_WEI_PLUGIN_URL . 'style/ry_wei_checkout.js', [ 'jquery' ], RY_WEI_VERSION, true );

		}
		add_action( 'woocommerce_checkout_fields', [ $this, 'checkout_fields' ], 99999 );
		/* default classes */
		add_filter( 'woocommerce_form_field_args', [ $this, 'add_default_wfacp_styling' ], 10, 2 );
	}


	public function checkout_fields( $fields ) {

		if ( ! is_array( $fields ) || count( $fields ) == 0 ) {
			return $fields;
		}

		$aero_fields = WFACP_Common::get_aero_registered_checkout_fields();

		$instance = wfacp_template();
		if ( is_null( $instance ) ) {
			return '';
		}

		$data = $instance->get_checkout_fields();


		foreach ( $fields as $index => $field ) {

			if ( $index !== 'invoice' && $index !== 'billing' && $index !== 'shipping' && $index !== 'advanced' ) {

				continue;
			}


			foreach ( $fields[ $index ] as $key => $field_val ) {

				if ( in_array( $key, $aero_fields ) || $key == 'billing_wfacp_vat_fields' || ! isset( $fields[ $index ][ $key ] ) ) {
					continue;
				}
				if ( isset( $data[ $index ][ $key ] ) ) {
					continue;
				}


				$this->new_fields[ $index ][ $key ] = $fields[ $index ][ $key ];
				$this->new_field_keys[]             = $key;
			}


		}


		return $fields;
	}

	public function is_enable() {
		if ( ! class_exists( 'RY_WEI_Invoice' ) ) {

			return false;
		}

		return true;
	}

	public function display_field( $field, $key ) {
		if ( empty( $key ) || 'rc_wc_ecpay' !== $key ) {
			return '';
		}


		echo ' <div class="wfacp_rc_wc_ecpay" id="wfacp_rc_wc_ecpay">';
		foreach ( $this->new_fields as $k_index => $index_value ) {


			foreach ( $index_value as $field_key => $field_val ) {

				woocommerce_form_field( $field_key, $field_val );
			}
		}
		echo "</div>";

	}

	public function add_default_wfacp_styling( $args, $key ) {
		if ( isset( $args['class'] ) && is_array( $args['class'] ) && ! in_array( 'wfacp-col-full', $args['class'] ) ) {
			$args['class'] = array_merge( [ 'wfacp-form-control-wrapper', 'wfacp-col-full' ], $args['class'] );

			if ( false !== strpos( $args['type'], 'hidden' ) ) {
				$args['class'][] = 'wfacp_type_hidden_field';
			}
		}

		if ( isset( $args['cssready'] ) && is_array( $args['cssready'] ) && ! in_array( 'wfacp-col-full', $args['cssready'] ) ) {
			$args['cssready'] = [ 'wfacp-col-full' ];
		}


		if ( isset( $args['type'] ) && 'checkbox' !== $args['type'] ) {

			if ( isset( $args['input_class'] ) && is_array( $args['input_class'] ) && ! in_array( 'wfacp-form-control', $args['input_class'] ) ) {
				$args['input_class'] = array_merge( [ 'wfacp-form-control' ], $args['input_class'] );
			}

			if ( isset( $args['label_class'] ) && is_array( $args['label_class'] ) && ! in_array( 'wfacp-form-control-label', $args['label_class'] ) ) {
				$args['label_class'] = array_merge( [ 'wfacp-form-control-label' ], $args['label_class'] );;
			}

		}

		if ( ( isset( $args['placeholder'] ) || empty( $args['placeholder'] ) ) && isset( $args['label'] ) ) {
			$args['placeholder'] = $args['label'];
		}

		return $args;
	}

	public function internal_css() {
		$instance = wfacp_template();
		if ( ! $instance instanceof WFACP_Template_Common ) {
			return;
		}


		$bodyClass = "body #wfacp-sec-wrapper ";
		$cssHtml   = "<style>";
		$cssHtml   .= $bodyClass . "#wfacp_rc_wc_ecpay {clear:both;}";
		$cssHtml   .= $bodyClass . "p.form-row.wfacp_type_hidden_field{display:none;}";
		$cssHtml   .= "</style>";
		echo $cssHtml;
	}
}

WFACP_Plugin_Compatibilities::register( new WFACP_RY_WC_Ecpay(), 'wfacp-ecpay' );