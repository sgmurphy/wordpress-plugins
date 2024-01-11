<?php
/*
Plugin Name:  Conditional Menus
Plugin URI:   https://themify.me/conditional-menus
Version:      1.2.4 
Author:       Themify
Author URI:   https://themify.me/
Description:  This plugin enables you to set conditional menus per posts, pages, categories, archive pages, etc.
Text Domain:  themify-cm
Domain Path:  /languages
Requires PHP: 7.2
License:      GNU General Public License v2.0
License URI:  http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( !defined( 'ABSPATH' ) ) exit;

class Themify_Conditional_Menus {

    public static function get_dir() : string {
        return trailingslashit( plugin_dir_path( __FILE__ ) );
    }

    public static function get_url() : string {
        return trailingslashit( plugin_dir_url( __FILE__ ) );
    }

	public static function get_version() : string {
        return '1.2.4';
    }

    public static function init() {
		$dir=self::get_dir();
        include $dir . 'includes/utils.php';
        include $dir . 'includes/data.php';
        if ( is_admin() ) {
            include $dir . 'includes/admin.php';
            Themify_Conditional_Menus_Admin::init();
        } else {
            /* cache data before it's filtered in Themify_Conditional_Menus_Frontend */
            Themify_Conditional_Menus_Data::get_data();

            include $dir . 'includes/frontend.php';
            Themify_Conditional_Menus_Frontend::init();
        }
    }
}
add_action( 'init', [ 'Themify_Conditional_Menus', 'init' ] );
