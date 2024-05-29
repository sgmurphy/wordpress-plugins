<?php

namespace WPEasyDonation\Base;

class Enqueue extends BaseController
{
	/**
	 * init services
	 */
	public function register() {
		add_action('admin_enqueue_scripts',array($this, 'admin_enqueue'));
		add_action('wp_enqueue_scripts',array($this, 'client_enqueue'));
	}

	/**
	 * Admin dashboard styles/scripts
	 */
	function admin_enqueue() {
		wp_enqueue_style('wpedon-admin-css', $this->plugin_url . '/assets/css/wpedon-admin.css', [], $this->plugin_version);
		wp_enqueue_script('wpedon-admin-js', $this->plugin_url . '/assets/js/wpedon-admin.js', ['jquery'],$this->plugin_version, true);

		$args = [
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('wpedon-request')
		];
		if ( !empty( $_REQUEST['order'] ) ) {
			$args['order_id'] = intval( $_REQUEST['order'] );
		}
		wp_localize_script( 'wpedon-admin-js', 'wpedon', $args );
	}

	/**
	 * client styles/scripts
	 */
	function client_enqueue() {
		$options = \WPEasyDonation\Helpers\Option::get();
		wp_enqueue_style( 'wpedon', $this->plugin_url . '/assets/css/wpedon.css', [],$this->plugin_version );
		wp_enqueue_script( 'stripe-js', 'https://js.stripe.com/v3/', [], null,true );
		wp_enqueue_script( 'wpedon', $this->plugin_url . '/assets/js/wpedon.js', ['jquery', 'stripe-js'], $this->plugin_version,true );
		wp_localize_script( 'wpedon', 'wpedon', [
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'wpedon-frontend-request' ),
			'opens' => $options['opens'],
			'cancel' => $options['cancel'],
			'return' => $options['return']
		] );
	}
}