<?php 
/*
Plugin Name: Meks Easy Ads Widget
Plugin URI: http://mekshq.com
Description: Display unlimited number of ads inside your WordPress widget. Specify custom ads size, randomize, rotate, enjoy!
Author: Meks
Version: 2.0.9
Author URI: https://mekshq.com
Text Domain: meks-easy-ads-widget
Domain Path: /languages
License: GPL3
*/

define ('MKS_ADS_WIDGET_URL', trailingslashit(plugin_dir_url(__FILE__)));
define ('MKS_ADS_WIDGET_DIR', trailingslashit(plugin_dir_path(__FILE__)));
define ('MKS_ADS_WIDGET_VER', '2.0.9');

/* Initialize Widget */
if(!function_exists('mks_ads_widget_init')):
	function mks_ads_widget_init() {
		require_once(MKS_ADS_WIDGET_DIR.'inc/class-ads-widget.php');
		require_once(MKS_ADS_WIDGET_DIR.'inc/class-ads-blocker-widget.php');
		register_widget('MKS_Ads_Widget');
		register_widget('MKS_AdsBlocker_Widget');
		require_once(MKS_ADS_WIDGET_DIR.'inc/template-functions.php');
	}
endif;

add_action('widgets_init','mks_ads_widget_init');
