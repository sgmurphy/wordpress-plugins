<?php

namespace WPEasyDonation\Pages;

use WPEasyDonation\Helpers\Template;

class SettingPage
{
	/**
	 * render page
	 */
	public function render() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page. Please sign in as an administrator.' ) );
		}
		$options = \WPEasyDonation\Helpers\Option::get();
		$active_tab = isset( $_REQUEST['tab'] ) ? intval( $_REQUEST['tab'] ) : 1;
		if ( !empty( $_POST['update'] ) ) {
			$this->update($options, $_POST);
			$options = \WPEasyDonation\Helpers\Option::get();
		}
		$ppcp = new \WPEasyDonation\Base\PpcpController();
		$ppcp_markup = $ppcp->status_markup_html();
		$stripe = new \WPEasyDonation\Base\Stripe();
		$stripe_status_html = $stripe->connection_status_html();
		Template::getTemplate('page/admin_settings.php', true, ['options'=>$options, 'active_tab'=>$active_tab, 'ppcp_markup'=>$ppcp_markup, 'stripe_status_html'=>$stripe_status_html]);
	}

	/**
	 * update page
	 * @param $options
	 * @param $post
	 */
	public function update($options, $post) {
		foreach ( array_keys( $options ) as $key ) {
			if ( isset( $post[$key] ) ) {
				$options[$key] = sanitize_text_field( $post[$key] );
			}
		}
		\WPEasyDonation\Helpers\Option::update($options);
	}
}