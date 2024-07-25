<?php
/*
  Plugin Name: Twenty20 Image Before-After
  Plugin URI: https://wordpress.org/plugins/twenty20/
  Description: Need to highlight the differences between two images? Makes it easy with Twenty20 plugin.
  Version: 1.7.3
  Author: Zayed Baloch
  Author URI: https://www.zayedbaloch.com/
  License: GPL2
*/

defined('ABSPATH') or die("No script kiddies please!");

define('ZB_T20_VER', '1.7.2');
define('ZB_T20_URL', plugins_url('', __FILE__));
define('ZB_T20_DOMAIN', 'zb_twenty20');

// INITIALIZE PLUGIN
function twenty20_dir_init() {
  load_plugin_textdomain(ZB_T20_DOMAIN);
}
add_action('init', 'twenty20_dir_init');

$files_to_include = [
  'inc/enqueue.php',
  'inc/twenty20-shortcode.php',
  'inc/widget-twenty20.php'
];

foreach ($files_to_include as $file) {
  include_once($file);
}

if (class_exists('WPBakeryShortCode')) {
  require_once('inc/twenty20-shortcode-vc.php');
}

// Check if the function add_ux_builder_shortcode exists
if (!function_exists('add_ux_builder_shortcode')) {
  include_once('inc/for-flatsome-ux-builder.php');
} 


function twenty20_ux_builder_thumbnails($name) {
  return ZB_T20_URL . '/assets/images/' . $name . '.png';
}

function twenty20_ux_builder_template($path) {
  ob_start();
  include 'inc/templates/' . $path;
  return ob_get_clean();
}
