<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ays-pro.com/
 * @since             1.0.0
 * @package           Secure_Copy_Content_Protection
 *
 * @wordpress-plugin
 * Plugin Name:       Secure Copy Content Protection
 * Plugin URI:        https://ays-pro.com/wordpress/secure-copy-content-protection/
 * Description:       Copy Protection plugin is activated it disables the right click, copy paste, content selection and copy shortcut keys
 * Version:           4.2.5
 * Author:            Copy Content Protection Team
 * Author URI:        https://ays-pro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       secure-copy-content-protection
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SCCP_NAME_VERSION', '4.2.5');
define('SCCP_NAME', 'secure-copy-content-protection');
if (!defined('SCCP_ADMIN_URL')) {
	define('SCCP_ADMIN_URL', plugin_dir_url(__FILE__) . 'admin');
}

if (!defined('SCCP_PUBLIC_URL')) {
	define('SCCP_PUBLIC_URL', plugin_dir_url(__FILE__) . 'public');
}

if( ! defined( 'SCCP_DIR' ) )
    define( 'SCCP_DIR', plugin_dir_path( __FILE__ ) );

if( ! defined( 'SCCP_BASENAME' ) )
    define( 'SCCP_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-secure-copy-content-protection-activator.php
 */
function activate_secure_copy_content_protection() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-secure-copy-content-protection-activator.php';
	Secure_Copy_Content_Protection_Activator::ays_sccp_update_db_check();
}

/**
 * The code that runs after plugin activation.
 * This action is documented in includes/class-simple-google-maps-activator.php
 */
function ays_sccp_activation_redirect_method( $plugin ) {
	if ($plugin == plugin_basename(__FILE__)) {
		exit(wp_redirect(admin_url('admin.php?page=secure-copy-content-protection')));
	}
}

// add_action('activated_plugin', 'ays_sccp_activation_redirect_method');
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-secure-copy-content-protection-deactivator.php
 */
function deactivate_secure_copy_content_protection() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-secure-copy-content-protection-deactivator.php';
	Secure_Copy_Content_Protection_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_secure_copy_content_protection');
register_deactivation_hook(__FILE__, 'deactivate_secure_copy_content_protection');
add_action('plugins_loaded', 'activate_secure_copy_content_protection');
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-secure-copy-content-protection.php';

/**
 * Defining DB content
 */
require plugin_dir_path(__FILE__) . 'db.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function sccp_admin_notice() {
	if (isset($_GET['page']) && strpos($_GET['page'], SCCP_NAME) !== false) {
		?>
        <div class="ays-notice-banner">
            <div class="navigation-bar">
                <div id="navigation-container">                   
                    <div class="ays-logo-container-upgrade">
                        <div class="logo-container">
                            <a href="https://ays-pro.com/wordpress/secure-copy-content-protection" target="_blank" style="box-shadow: none;">
                                <img  class="sccp-logo" src="<?php echo esc_attr(SCCP_ADMIN_URL) . '/images/sccp.png'; ?>" alt="<?php echo __( "Secure Copy Content Protection", SCCP_NAME ); ?>" title="<?php echo __( "Secure Copy Content Protection", SCCP_NAME ); ?>"/>
                            </a>
                        </div>
                        <div class="ays-upgrade-container">
                            <a href="https://ays-pro.com/wordpress/secure-copy-content-protection?utm_source=dashboard-sccp&utm_medium=free-sccp&utm_campaign=top-menu-sccp" target="_blank">
                                <img src="<?php echo esc_attr(SCCP_ADMIN_URL) . '/images/icons/lightning-hover.svg'; ?>">
                                <span><?php echo __( "Upgrade", SCCP_NAME ); ?></span>
                            </a>
                            <span class="ays-sccp-logo-container-one-time-text"><?php echo __( "One-time payment", 'secure-copy-content-protection' ); ?></span>
                        </div>
                    </div>
                    <ul id="menu">
                        <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://ays-demo.com/secure-copy-content-protection-free-demo/" target="_blank">Demo</a></li>
                        <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://wordpress.org/support/plugin/secure-copy-content-protection/" target="_blank">Free Support</a></li>
                        <li class="modile-ddmenu-xs make_a_suggestion"><a class="ays-btn" href="https://ays-demo.com/copy-protection-plugin-survey/" target="_blank">Make a Suggestion</a></li>
                        <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://wordpress.org/support/plugin/secure-copy-content-protection/" target="_blank">Contact us</a></li>
                        <li class="modile-ddmenu-md">
                            <a class="toggle_ddmenu" href="javascript:void(0);"><i class="ays_fa ays_fa_ellipsis_h"></i></a>
                            <ul class="ddmenu" data-expanded="false">                                
                                <li><a class="ays-btn" href="https://ays-demo.com/secure-copy-content-protection-free-demo/" target="_blank">Demo</a></li>
                                <li><a class="ays-btn" href="https://wordpress.org/support/plugin/secure-copy-content-protection/" target="_blank">Contact us</a></li>
                            </ul>
                        </li>
                        <li class="modile-ddmenu-sm">
                            <a class="toggle_ddmenu" href="javascript:void(0);"><i class="ays_fa ays_fa_ellipsis_h"></i></a>
                            <ul class="ddmenu" data-expanded="false">
                                <li><a class="ays-btn" href="https://ays-demo.com/secure-copy-content-protection-free-demo/" target="_blank">Demo</a></li>
                                <li><a class="ays-btn" href="https://wordpress.org/support/plugin/secure-copy-content-protection/" target="_blank">Free Support</a></li>
                                <li class="make_a_suggestion"><a class="ays-btn" href="https://ays-demo.com/copy-protection-plugin-survey/" target="_blank">Make a Suggestion</a></li>
                                <li><a class="ays-btn" href="https://wordpress.org/support/plugin/secure-copy-content-protection/" target="_blank">Contact us</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="ays_ask_question_content">
			<div id="ays_ask_question_content_inner">				
                <a href="https://wordpress.org/support/plugin/secure-copy-content-protection/" class="ays_sccp_question_link" target="_blank">
                    <span class="ays-sccp-ask-question-mark-text">?</span>
                    <span class="ays-sccp-ask-question-hidden-text">Ask a question</span>
                </a>
			</div>
		</div>
        <?php

	}
}

function run_secure_copy_content_protection() {
    add_action('admin_notices', 'sccp_admin_notice');
	$plugin = new Secure_Copy_Content_Protection();
	$plugin->run();
}

run_secure_copy_content_protection();
