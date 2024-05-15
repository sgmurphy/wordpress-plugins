<?php
/**
 * Plugin Name: ThumbPress
 * Description: A complete image and thumbnail management solution for WordPress.
 * Plugin URI: https://thumbpress.co
 * Author: ThumbPress
 * Author URI: https://thumbpress.co
 * Version: 5.1.1
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Text Domain: image-sizes
 * Domain Path: /languages
 *
 * ThumbPress is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * ThumbPress is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

namespace Codexpert\ThumbPress;
use Codexpert\Plugin\Notice;
use Pluggable\Marketing\Survey;
use Pluggable\Marketing\Feature;
use Pluggable\Marketing\Deactivator;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class for the plugin
 * @package Plugin
 * @author Codexpert <hi@codexpert.io>
 */
final class Plugin {
		
	/**
	 * The Plugin
	 * 
	 * @access private
	 */
	private $plugin;
	
	/**
	 * Plugin instance
	 * 
	 * @access private
	 * 
	 * @var Plugin
	 */
	private static $_instance;

	/**
	 * The constructor method
	 * 
	 * @access private
	 * 
	 * @since 0.9
	 */
	private function __construct() {
		
		/**
		 * Check for action scheduler tables
		 */
		register_activation_hook( __FILE__, [ $this, 'check_action_scheduler_tables' ] );

		/**
		 * Includes required files
		 */
		$this->include();

		/**
		 * Defines contants
		 */
		$this->define();

		/**
		 * Runs actual hooks
		 */
		$this->hook();
	}

	/**
	 * Check for action scheduler tables before activation
	 */
	public function check_action_scheduler_tables() {

		$table_report = thumbpress_check_action_tables();

		// check for missing tables
		if( in_array( true, $table_report ) ) :

			// check store table
			if( $table_report['store_table_missing'] ) :
				delete_option( 'schema-ActionScheduler_StoreSchema' );

				$action_store_db 	= new \ActionScheduler_DBStore();
				$action_store_db->init();
			endif;

			// check log table
			if( $table_report['log_table_missing'] ) :
				delete_option( 'schema-ActionScheduler_LoggerSchema' );

				$action_log_db 		= new \ActionScheduler_DBLogger();
				$action_log_db->init();
			endif;

		endif;
	}

	/**
	 * Includes files
	 * 
	 * @access private
	 * 
	 * @uses composer
	 * @uses psr-4
	 */
	private function include() {
		require_once( dirname( __FILE__ ) . '/inc/functions.php' );
		require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
		require_once( dirname( __FILE__ ) . '/libraries/action-scheduler/action-scheduler.php' );
	}

	/**
	 * Define variables and constants
	 * 
	 * @access private
	 * 
	 * @uses get_plugin_data
	 * @uses plugin_basename
	 */
	private function define() {

		/**
		 * Define some constants
		 * 
		 * @since 0.9
		 */
		define( 'THUMBPRESS', __FILE__ );
		define( 'THUMBPRESS_DIR', dirname( THUMBPRESS ) );
		define( 'THUMBPRESS_ASSET', plugins_url( 'assets', THUMBPRESS ) );
		define( 'THUMBPRESS_DEBUG', apply_filters( 'image-sizes_debug', Helper::get_option( 'image-sizes_tools', 'enable_debug', true ) ) );

		/**
		 * The plugin data
		 * 
		 * @since 0.9
		 * @var $plugin
		 */
		$this->plugin					= get_plugin_data( THUMBPRESS );
		$this->plugin['basename']		= plugin_basename( THUMBPRESS );
		$this->plugin['file']			= THUMBPRESS;
		$this->plugin['server']			= apply_filters( 'image-sizes_server', 'https://codexpert.io/dashboard' );
		$this->plugin['icon']			= THUMBPRESS_ASSET . '/img/icon.png';
		$this->plugin['depends']		= [];
	}

	/**
	 * Hooks
	 * 
	 * @access private
	 * 
	 * Executes main plugin features
	 *
	 * To add an action, use $instance->action()
	 * To apply a filter, use $instance->filter()
	 * To register a shortcode, use $instance->register()
	 * To add a hook for logged in users, use $instance->priv()
	 * To add a hook for non-logged in users, use $instance->nopriv()
	 * 
	 * @return void
	 */
	private function hook() {

		if( is_admin() ) :

			/**
			 * Admin facing hooks
			 */
			$admin = new App\Admin( $this->plugin );
			$admin->action( 'admin_footer', 'modal' );
			$admin->action( 'admin_footer', 'upgrade' );
			$admin->action( 'plugins_loaded', 'i18n' );
			$admin->action( 'admin_enqueue_scripts', 'enqueue_scripts' );
			$admin->filter( "plugin_action_links_{$this->plugin['basename']}", 'action_links' );
			$admin->filter( 'plugin_row_meta', 'plugin_row_meta', 10, 2 );
			$admin->action( 'admin_footer_text', 'footer_text' );
			$admin->action( 'admin_notices', 'admin_notices' );
			
			/**
			 * The setup wizard
			 */
			$wizard = new App\Wizard( $this->plugin );
			$wizard->action( 'plugins_loaded', 'render' );
			$wizard->filter( "plugin_action_links_{$this->plugin['basename']}", 'action_links' );

			/**
			 * Settings related hooks
			 */
			$settings = new App\Settings( $this->plugin );
			$settings->action( 'plugins_loaded', 'init_menu', 11 );
			$settings->filter( 'cx-settings-reset', 'reset' );
			$settings->action( 'admin_menu', 'admin_menu' );


			/**
			 * Renders different notices
			 * 
			 * @package Codexpert\Plugin
			 * 
			 * @author Codexpert <hi@codexpert.io>
			 */
			$notice = new Notice( $this->plugin );

			/**
			 * Asks to participate in a survey
			 * 
			 * @package Pluggable\Marketing
			 * 
			 * @author Pluggable <hi@pluggable.io>
			 */
			$survey = new Survey( THUMBPRESS );

			/**
			 * Shows a popup window asking why a user is deactivating the plugin
			 * 
			 * @package Pluggable\Marketing
			 * 
			 * @author Pluggable <hi@pluggable.io>
			 */
			$deactivator = new Deactivator( THUMBPRESS );

			/**
			 * Alters featured plugins
			 * 
			 * @package Pluggable\Marketing
			 * 
			 * @author Pluggable <hi@pluggable.io>
			 */
			$feature = new Feature( THUMBPRESS );

		else : // !is_admin() ?

		endif;

		/**
		 * Modules related hooks
		 */
		$modules = new App\Modules( $this->plugin );
		$modules->action( 'plugins_loaded', 'init' );

		/**
		 * Cron facing hooks
		 */
		$cron = new App\Cron( $this->plugin );
		$cron->activate( 'install' );
		$cron->deactivate( 'uninstall' );

		/**
		 * AJAX related hooks
		 */
		$ajax = new App\AJAX( $this->plugin );
		$ajax->priv( 'image_sizes-notice-dismiss', 'dismiss_notice' );
		$ajax->priv( 'image_sizes-pointer-dismiss', 'dismiss_pointer' );
		$ajax->priv( 'image_sizes-dismiss', 'image_sizes_dismiss' );

	}

	/**
	 * Cloning is forbidden.
	 * 
	 * @access public
	 */
	public function __clone() { }

	/**
	 * Unserializing instances of this class is forbidden.
	 * 
	 * @access public
	 */
	public function __wakeup() { }

	/**
	 * Instantiate the plugin
	 * 
	 * @access public
	 * 
	 * @return $_instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

Plugin::instance();