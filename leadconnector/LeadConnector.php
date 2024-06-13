<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           LeadConnector
 *
 * @wordpress-plugin
 * Plugin Name:       LeadConnector
 * Plugin URI:        https://www.leadconnectorhq.com/wp_plugin
 * Description:       This plugin helps you to add the lead connector widgets to your website.
 * Version:           1.9
 * Author:            LeadConnector
 * Author URI:        https://www.leadconnectorhq.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       LeadConnector
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
define('LEAD_CONNECTOR_VERSION', '1.7');
define('LEAD_CONNECTOR_PLUGIN_NAME', 'LeadConnector');
define('LEAD_CONNECTOR_BASE_URL', 'https://rest.leadconnectorhq.com/');
define('LEAD_CONNECTOR_OPTION_NAME', 'lead_connector_plugin_options');
define('LEAD_CONNECTOR_CDN_BASE_URL', 'https://widgets.leadconnectorhq.com/');
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lc-activator.php
 */
function activate_lead_connector()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-lc-activator.php';
    LeadConnector_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lc-deactivator.php
 */
function deactivate_lead_connector()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-lc-deactivator.php';
    LeadConnector_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_lead_connector');
register_deactivation_hook(__FILE__, 'deactivate_lead_connector');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-lc.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lead_connector()
{

    $plugin = new LeadConnector();
    $plugin->run();

}
run_lead_connector();
