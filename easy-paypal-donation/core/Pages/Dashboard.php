<?php

namespace WPEasyDonation\Pages;

class Dashboard
{
	/**
	 * init services
	 */
	public function register()
	{
		add_action("admin_menu", array($this, 'menu'));
	}

	/**
	 * admin menu
	 */
	function menu() {
		add_menu_page("Easy Donations", "Donations with PayPal & Stripe", "manage_options", "wpedon_menu", array(new OrderPage(), 'render'),'dashicons-cart','28.5');

		add_submenu_page("wpedon_menu", "Donations", "Donations", "manage_options", "wpedon_menu", array(new OrderPage(), 'render'));

		add_submenu_page("wpedon_menu", "Buttons", "Buttons", "manage_options", "wpedon_buttons", [new ButtonPage(), 'render']);

		add_submenu_page("wpedon_menu", "Settings", "Settings", "manage_options", "wpedon_settings", array(new SettingPage(), 'render'));
	}
}