<?php

namespace WPEasyDonation\Base;

class Filter extends BaseController
{
	/**
	 * init services
	 */
	public function register() {
		add_filter( 'plugin_action_links_' . $this->plugin_basename, [$this, 'links']);
		add_filter( 'gettext', [$this, 'change_button_text'], 10, 3 );
		add_filter( 'sanitize_post_meta_currency_wpedon', [$this, 'sanitize_currency_meta']);
	}

	/**
	 * plugin links
	 * @param $links
	 * @return mixed
	 */
	public function links($links) {
		if ( isset( $links['edit'] ) ) {
			unset( $links['edit'] );
		}
		$links[] = '<a href="https://wordpress.org/support/plugin/easy-paypal-donation" target="_blank">' . __( 'Support' ) . '</a>';
		$links[] = '<a target="_blank" href="https://wpplugin.org/downloads/paypal-donation-pro/">' . __( 'Pro Version' ) . '</a>';
		$links[] = '<a href="admin.php?page=wpedon_settings">' . __( 'Settings' ) . '</a>';
		return $links;
	}

	/**
	 * change button text
	 * @param $translation
	 * @param $text
	 * @param $domain
	 * @return string
	 */
	public function change_button_text( $translation, $text, $domain )
	{
		if ( 'default' == $domain and 'Insert into Post' == $text )
		{
			remove_filter( 'gettext', 'wpedon_change_button_text' );
			return 'Use this image';
		}
		return $translation;
	}

	/**
	 * sanitize currency meta
	 * @param $value
	 * @return string|null
	 */
	function sanitize_currency_meta( $value ) {
		if (!empty($value)) {
			$value = (float) preg_replace('/[^0-9.]*/','',$value);
			return number_format((float)$value, 2, '.', '');
		}
		return null;
	}
}