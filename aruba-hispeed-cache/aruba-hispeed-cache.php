<?php
/**
 * Aruba HiSpeed Cache
 * php version 5.6
 *
 * @category Wordpress-plugin
 *
 * @author   Aruba Developer <hispeedcache.developer@aruba.it>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GPLv3
 *
 * @see     Null
 * @since    1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Aruba HiSpeed Cache
 * Version:           2.0.14
 * Plugin URI:        https://hosting.aruba.it/wordpress.aspx
 *
 * @phpcs:ignore Generic.Files.LineLength.TooLong
 * Description:       Aruba HiSpeed Cache interfaces directly with the Aruba HiSpeed Cache service of the Aruba hosting platform and automates its management.
 * Author:            Aruba.it
 * Author URI:        https://www.aruba.it/
 * Text Domain:       aruba-hispeed-cache
 * Domain Path:       languages
 * License:           GPL v3
 * Tested up to:      6.6
 * Requires PHP:      5.6
 * Requires at least: 5.4
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package ArubaHispeedCache
 */

/** constant configuration*/
include_once "src/AHSC_Config.php";
/** Debug Manager*/
if(AHSC_CORE['debug']) {
	if ( file_exists( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . "Debug/Enable.php" ) ) {
		include_once "Debug/Enable.php";
	}
}
/** control plugin version*/
include_once "src/AHSC_Version.php";
/** Static cache htaccess*/
include_once "src/AHSC_Static.php";
/** plugin general functions*/
include_once "src/AHSC_Functions.php";
/** plugin controllo per check services*/
include_once "src/AHSC_Check.php";
/** class for function purger*/
include_once "src/Purger/AbstractPurger.php";
include_once "src/Purger/WpPurger.php";
/** ADMIN inclusion */
include_once "admin/AHSC_Admin_Menu.php";
include_once "admin/AHSC_Admin_Bar.php";
/** Warmer Manager*/
include_once "src/AHSC_Warmer.php";
/** event for clearcache*/
include_once "src/Events/AHSC_Comments.php";
include_once "src/Events/AHSC_Deferer.php";
include_once "src/Events/AHSC_Plugins.php";
include_once "src/Events/AHSC_PostType.php";
include_once "src/Events/AHSC_Terms.php";
include_once "src/Events/AHSC_Themes.php";


/** check WordPress and php version */
AHSC_check_requirement();

/**
 * Adding methods to "activate" hooks
 */
\register_activation_hook(__FILE__,	'AHSC_activation' );

/**
 * Adding methods to "deactivate" hooks
 */
\register_deactivation_hook(__FILE__,'AHSC_deactivation');

\add_action( 'activated_plugin',  'check_hispeed_cache_services' , 20, 1 );
/**
 * Adding methods for link in plugins page
 */
if ( \is_multisite() ) {
	\add_filter( 'network_admin_plugin_action_links_'.AHSC_CONSTANT['ARUBA_HISPEED_CACHE_BASENAME'], 'AHSC_plugin_action_links'  );
} else {
	\add_filter( 'plugin_action_links_' .AHSC_CONSTANT['ARUBA_HISPEED_CACHE_BASENAME'],'AHSC_plugin_action_links'  );
}

if ( AHSC_REQUIREMENTS['is_legacy_post_61'] ) {
	\add_filter( 'site_status_page_cache_supported_cache_headers','add_supported_cache_headers', 100, 1 );
}


/**
 * Add new header to the existing list of cache headers supported by core.
 * @param  array $cache_headers The list of supported cache headers.
 * @return array
*/
 function add_supported_cache_headers( $cache_headers ) {
	// Add new header to the existing list.
	$cache_headers['x-aruba-cache'] = static function ( $header_value ) {
		return str_contains( strtolower( $header_value ), 'hit' );
	};
	return $cache_headers;
}


/** Load Multi languages*/
add_action( 'init','AHSC_load_plugin_textdomain'  );
//add_action( 'admin_bar_init','AHSC_load_plugin_textdomain'  );
//add_action( 'wp_before_admin_bar_render','AHSC_load_plugin_textdomain'  );

function AHSC_load_plugin_textdomain() {
	\load_plugin_textdomain(
		'aruba-hispeed-cache',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}

add_action('init','AHSC_script_nit');
function AHSC_script_nit() {
	if ( current_user_can( 'manage_options' ) ) {
        if ( is_admin_bar_showing() ) {
            \add_action( 'wp_after_admin_bar_render',  'ahsc_adminbar_inline_style' , 100 );
            \add_action( 'wp_enqueue_scripts',  'ahsc_enqueue_toolbar_js'  );
            \add_action( 'wp_enqueue_scripts',  'AHSC_localize_toolbar_js'  );
            if(is_admin()){
                \add_action( 'admin_enqueue_scripts',  'ahsc_enqueue_toolbar_js'  );
                \add_action( 'admin_enqueue_scripts', 'AHSC_localize_toolbar_js'  );
            }
        }
	}
}

function AHSC_gutemberg_scripts() {
	if( is_admin() ){

        $js_param = array(
            'ahsc_ajax_url' => \admin_url( 'admin-ajax.php' ),
            'ahsc_topurge'  => 'all',
            'ahsc_nonce'    => \wp_create_nonce( 'ahsc-purge-cache' ),
        );
        \wp_add_inline_script( 'AHSC-gutenberg-editor-js-purge', 'const AHSC_TOOLBAR = ' . \wp_json_encode( $js_param ), 'before' );

        wp_enqueue_script(
            'AHSC-gutenberg-editor-js-purge',
            plugins_url( "admin/assets/js/editor.js", __FILE__ ),
            array( 'wp-plugins', 'wp-edit-post', 'react' ),
            filemtime( plugin_dir_path( __FILE__ ) . "admin/assets/js/editor.js" ),
            array(
                'in_footer' => true,
                'strategy'  => 'defer',
            )
        );
    }
}
add_action( 'enqueue_block_assets', 'AHSC_gutemberg_scripts' );

/**
 * Css inclusion for adminbar menu icon and loader
* @return void
 */
function ahsc_adminbar_inline_style() {
	$icon = "#wp-admin-bar-ahsc-purge-link .ahsc-ab-icon:before {
				content: '\\f17e';
				top: 4px;
			}";

	$loader = "#ahsc-loader-toolbar{
				display: none;
				background: rgba(255, 255, 255, .7) url('data:image/gif;base64,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') no-repeat center;
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				z-index: 9998;
			}";

	\printf(
		'<style type="text/css">
				%1$s
				%2$s
				</style>',
		$icon, //@phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$loader //@phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

/**
 * This method adds and localizes the toolbar.js on both the frontend and backend.
 *
 * @return void
 */
 function ahsc_enqueue_toolbar_js() {

	\wp_enqueue_script(
		'ahcs-toolbar',
		AHSC_CONSTANT['ARUBA_HISPEED_CACHE_BASEURL'] . '/assets/js/toolbar.js',
		array(),
		time(),
        array(
            'in_footer' => true,
            'strategy'  => 'defer',
        )
	);
}

add_action( 'wp_ajax_ahcs_clear_cache',  'ahsc_tool_bar_purge' , 100 );

/**
 * Medoto connected to WP's ajax handler to handle calls to cleaning APIs.
 *
 * @return void
 *
 * @SuppressWarnings(PHPMD.ElseExpression)
 */
function ahsc_tool_bar_purge() {
if(is_user_logged_in() && current_user_can( 'manage_options' ) && isset( $_POST['ahsc_nonce'] )){

	if ( ! \wp_verify_nonce( \sanitize_text_field( \wp_unslash( $_POST['ahsc_nonce'] ) ), 'ahsc-purge-cache' ) ) {
		wp_die( wp_json_encode( AHSC_AJAX['security_error'] ) );
	}else{

	$cleaner= new \ArubaSPA\HiSpeedCache\Purger\WpPurger() ;
	$cleaner->setPurger( AHSC_PURGER );

	if ( isset( $_POST['ahsc_to_purge'] ) ) {
		$to_purge = \urldecode( \wp_unslash( $_POST['ahsc_to_purge'] ) ); // @phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		if ( 'all' === $to_purge ) {
			$cleaner->purgeAll();
		} else {
			$cleaner->purgeUrl( \esc_url_raw( $to_purge ) );
		}
		// Don't forget to stop execution afterward.
		wp_die( wp_json_encode( AHSC_AJAX['success']) );
	}
	// Don't forget to stop execution afterward.
	wp_die( wp_json_encode(  AHSC_AJAX['warning'] ) );
    }
}else{
    wp_die( wp_json_encode( AHSC_AJAX['security_error'] ) );
}
}

if(is_multisite()){
	add_action('network_admin_notices', 'AHSC_check_hispeed_cache_notices');
}else{
	add_action( 'admin_notices',  'AHSC_check_hispeed_cache_notices'  );
}
/**
 * Render della notifica in base alla logica presente in ahsc_get_check_notice.
 *
 * @return void
 */
 function AHSC_check_hispeed_cache_notices() {
	$check = ahsc_get_check_notice( ahsc_has_notice() );
	if ( ! \is_null( $check ) ) {
		echo $check; //@phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}