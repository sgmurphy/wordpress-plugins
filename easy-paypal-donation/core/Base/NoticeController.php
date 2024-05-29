<?php

namespace WPEasyDonation\Base;

use WPEasyDonation\Helpers\Template;

class NoticeController
{
	/**
	 * init services
	 */
	public function register() {
		add_action('admin_notices', array($this, 'activation_notice'));
		add_action('admin_notices', array($this, 'stripe_connect_error_notice'));
		add_action('admin_notices', array($this, 'stripe_connect_notice'));
		add_action('admin_notices',  array($this, 'ppcp_notice'));
		add_action('admin_init', array($this, 'stripe_connect_notice_dismiss'));
		add_action('admin_init', array($this, 'ppcp_notice_dismiss'));
	}

	/**
	 * Show admin activation notice
	 */
	function activation_notice() {
		$options = \WPEasyDonation\Helpers\Option::get();
		if (empty($options['activation_notice_shown'])) {
			Template::getTemplate('notice/activation_notice.php');
			$options['activation_notice_shown'] = 1;
			\WPEasyDonation\Helpers\Option::update($options);
		}
	}

	/**
	 * Stripe Connect error notice.
	 */
	function stripe_connect_error_notice() {
		if (empty($_GET['wpedon_error']) || $_GET['wpedon_error'] != 'stripe-connect-handler') {
			return;
		}
		Template::getTemplate('notice/stripe_connect_error.php');
	}

	/**
	 * Show admin notice for Stripe Connect.
	 */
	function stripe_connect_notice() {
		$options = \WPEasyDonation\Helpers\Option::get();
		$mode = intval( $options['mode_stripe'] ) === 2 ? 'live' : 'sandbox';
		$acct_id_key = 'acct_id_' . $mode;
		if ( !empty( $options[$acct_id_key] ) || !empty( $options['stripe_connect_notice_dismissed'] )  ||
			( isset( $_GET['page'] ) && $_GET['page'] == 'wpedon_settings' && isset( $_GET['tab'] ) && $_GET['tab'] == 4 ) ) return;
		Template::getTemplate('notice/stripe_connect_notice.php');
	}

	/**
	 * Show admin notice for PayPal Commerce Platform.
	 */
	function ppcp_notice() {
		$options = \WPEasyDonation\Helpers\Option::get();
		$env = intval( $options['mode'] ) === 2 ? 'live' : 'sandbox';
		$connected = !empty( $options['ppcp_onboarding'][$env] ) && !empty( $options['ppcp_onboarding'][$env]['seller_id'] );
		if ( $connected || !empty( $options['ppcp_notice_dismissed'] ) ||
			( isset( $_GET['page'] ) && $_GET['page'] == 'wpedon_settings' && isset( $_GET['tab'] ) && $_GET['tab'] == 3 ) ) return;
		Template::getTemplate('notice/ppcp_notice.php');
	}







	/**
	 * Dismiss admin notice for Stripe Connect.
	 */
	function stripe_connect_notice_dismiss() {
		if (empty($_GET['wpedon_admin_stripe_connect_notice_dismiss'])) {
			return;
		}

		$options = \WPEasyDonation\Helpers\Option::get();
		$options['stripe_connect_notice_dismissed'] = 1;
		\WPEasyDonation\Helpers\Option::update($options);
		die();
	}



	/**
	 * Dismiss admin notice for PayPal Commerce Platform.
	 */
	function ppcp_notice_dismiss() {
		if (empty($_GET['wpedon_admin_ppcp_notice_dismiss'])) {
			return;
		}

		$options = \WPEasyDonation\Helpers\Option::get();
		$options['ppcp_notice_dismissed'] = 1;
		\WPEasyDonation\Helpers\Option::update($options);
		die();
	}
}