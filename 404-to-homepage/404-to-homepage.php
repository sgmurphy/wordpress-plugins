<?php if (!defined('ABSPATH')) die;
/*
Plugin Name: Redirect 404 to Homepage
Plugin URI: https://wordpress.org/plugins/404-to-homepage/
Description: Redirect 404 missing pages to the homepage.
Author: pipdig
Author URI: https://www.pipdig.co/
Version: 1.0
License: GPLv2 or later
*/

add_action('template_redirect', function() {
	
	if ( (defined('DOING_CRON') && DOING_CRON) || (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) || (defined('DOING_AJAX') && DOING_AJAX) ) return;
	
	if (is_admin()) return;
	
	if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'sitemap.xml') !== false) return;
	
	global $wp_query;
	if ($wp_query->is_404 === false) return;
	
	if (wp_redirect(home_url('/'), 301)) die;
	
}, PHP_INT_MAX);