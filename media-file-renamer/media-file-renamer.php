<?php
/*
Plugin Name: Media File Renamer: Rename for better SEO (AI-Powered)
Plugin URI: https://meowapps.com
Description: Rename filenames and media metadata for SEO and tidyness. Using AI, manually, in bulk, or in so many other ways!
Version: 5.9.2
Author: Jordy Meow
Author URI: https://meowapps.com
Text Domain: media-file-renamer
Domain Path: /languages

Originally developed for two of my websites:
- Jordy Meow (https://offbeatjapan.org)
- Haikyo (https://haikyo.org)
*/

if ( !defined( 'MFRH_VERSION' ) ) {
  define( 'MFRH_VERSION', '5.9.2' );
  define( 'MFRH_PREFIX', 'mfrh' );
  define( 'MFRH_DOMAIN', 'media-file-renamer' );
  define( 'MFRH_ENTRY', __FILE__ );
  define( 'MFRH_PATH', dirname( __FILE__ ) );
  define( 'MFRH_URL', plugin_dir_url( __FILE__ ) );
  define( 'MFRH_ITEM_ID', 2188 );
}

require_once( 'classes/init.php');

?>