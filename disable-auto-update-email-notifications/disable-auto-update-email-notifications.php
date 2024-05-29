<?php
/**
* Plugin Name: Disable auto-update Email Notifications 
* Plugin URI: https://joltmailer.com
* Description: This plugin performs a simple task of disabling email notifications that are sent by WordPress when a plugin or theme auto-updates.
* Version: 1.4.1
* Author: Joltmailer
* Author URI: https://joltmailer.com
**/

// Disable plugins auto-update email notifications .
add_filter( 'auto_plugin_update_send_email', '__return_false' );
 
// Disable themes auto-update email notifications.
add_filter( 'auto_theme_update_send_email', '__return_false' );