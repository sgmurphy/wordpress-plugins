<?php
/**
 * Plugin Name: LightPress Lightbox
 * Plugin URI: http://wordpress.org/extend/plugins/wp-jquery-lightbox/
 * Description: Simple and lightweight lightbox for galleries and images. Formerly WP Jquery Lightbox.
 * Version: 2.0.0
 * Text Domain: wp-jquery-lightbox
 * Author: LightPress
 * Author URI: https://lightpress.io
 * License: GPLv2 or later
 *
 * @package LightPress Lighbox
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define constants.
 */
define( 'LIGHTPRESS_VERSION', '2.0.0' );
define( 'LIGHTPRESS_PLUGIN_BASE', plugin_basename( __FILE__ ) );
define( 'LIGHTPRESS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); // Includes ending slash.
define( 'LIGHTPRESS_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); // Includes ending slash.

if ( defined( 'JQLB_LEGACY' ) && true === JQLB_LEGACY ) {
	require_once LIGHTPRESS_PLUGIN_DIR . 'wp-jquery-lightbox-legacy.php';
} else {
	require_once LIGHTPRESS_PLUGIN_DIR . 'class-lightpress.php';
	new LightPress();
}
