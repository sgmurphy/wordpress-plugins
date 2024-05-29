<?php

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

/*
Plugin Name: Accept Donations with PayPal & Stripe
Plugin URI: https://wordpress.org/plugins/easy-paypal-donation/
Description: A simple and easy way to accept PayPal donations on your website.
Tags: donation, donate, donations, charity, paypal, paypal donation, ecommerce, gateway, payment, paypal button, paypal donation, paypal donate, paypal payment, paypal plugin
Author: Scott Paterson
Author URI: https://wpplugin.org
License: GPL2
Version: 1.4.2
*/

/*  Copyright 2014-2024 Scott Paterson

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//// variables
// plugin function 	  = wpedon
// shortcode 		  = wpedon

if (file_exists(dirname(__FILE__).'/vendor/autoload.php')) {
	require_once dirname(__FILE__).'/vendor/autoload.php';
}

define('WPEDON_FREE_DIR_PATH', plugin_dir_path(__FILE__));
define('WPEDON_FREE_VERSION_NUM', '1.4.2');
define( 'WPEDON_FREE_PPCP_API', 'https://wpplugin.org/ppcp-wpedon/');
define( 'WPEDON_FREE_STRIPE_CONNECT_ENDPOINT', 'https://wpplugin.org/stripe-wpedon/connect.php');

define( 'WPEDON_FREE_URL', plugin_dir_url( __FILE__ ) );
define( 'WPEDON_FREE_BASENAME', plugin_basename(__FILE__) );

include_once('helpers/Option.php');
include_once('helpers/Template.php');
include_once('helpers/Func.php');

register_activation_hook(__FILE__, function () {
	$pro_plugin = 'paypal-donation-pro/easy-paypal-donation-pro.php';
	if (is_plugin_active($pro_plugin)) {
		deactivate_plugins($pro_plugin);
	}
	\WPEasyDonation\Helpers\Option::init();
});

register_deactivation_hook(__FILE__, function () {});
if ( !empty( get_option( 'wpedon_settingsoptions' ) ) ) {
	\WPEasyDonation\Helpers\Option::oldOptions();
}

// public shortcode
include_once('includes/public_shortcode.php');

if (class_exists('WPEasyDonation\Init')) {
	WPEasyDonation\Init::registerServices();
}
