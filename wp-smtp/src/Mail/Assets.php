<?php

namespace SolidWP\Mail;

use SolidWP\Mail\Admin\SettingsScreen;
use SolidWP\Mail\Contracts\Service_Provider;
use SolidWP\Mail\Repository\ProvidersRepository;
use SolidWP\Mail\StellarWP\Assets\Asset;

/**
 * Class Assets
 *
 * Service provider for managing asset registration within SolidWP Mail.
 *
 * @package SolidWP\Mail
 */
class Assets extends Service_Provider {

	/**
	 * Registers the service provider.
	 *
	 * @inheritDoc
	 */
	public function register(): void {
		$this->register_actions();
	}

	/**
	 * Registers WordPress actions for asset management.
	 *
	 * Adds the 'admin_init' action to trigger the asset registration.
	 *
	 * @return void
	 */
	public function register_actions(): void {
		add_action( 'admin_init', [ $this, 'register_assets' ] );
	}

	/**
	 * Registers assets used in the SolidWP Mail admin interface.
	 *
	 * Registers CSS and JavaScript files with optional dependencies.
	 *
	 * @return void
	 */
	public function register_assets() {

		Asset::add( 'solidwp-mail-admin-css', 'css/styles.css' )
		     ->set_condition(
			     static function () {
				     //phpcs:ignore.
				     $page = $_GET['page'] ?? '';

				     return is_admin() && in_array( $page, [
						     'solidwp-mail',
						     'solidwp-mail-logs',
						     'solidwp-mail-settings'
					     ], true );
			     }
		     )
		     ->add_dependency( 'wp-components' )
		     ->in_footer()
		     ->enqueue_on( 'admin_enqueue_scripts' )
		     ->register();

		$index_asset_data = require WPSMTP_ASSETS_PATH . 'js/index.asset.php';
		Asset::add( 'solidwp-mail-admin', 'js/index.js', $index_asset_data['version'] )
		     ->in_footer()
		     ->set_dependencies( function () use ( $index_asset_data ) {
			     return $index_asset_data['dependencies'];
		     } )
		     ->enqueue_on( 'admin_enqueue_scripts' )
		     ->set_condition(
			     static function () {
				     //phpcs:ignore.
				     $page = $_GET['page'] ?? '';

				     return is_admin() && $page === 'solidwp-mail';
			     }
		     )
		     ->add_localize_script(
			     'SolidWPMail',
			     [
				     'providers' => $this->container->get( ProvidersRepository::class )->get_all_providers_as_array(),
				     'nonces'    => [
					     'save_connection'        => wp_create_nonce( 'save_connection' ),
					     'send_test_email'        => wp_create_nonce( 'send_test_email' ),
					     'delete_connection'      => wp_create_nonce( 'delete_connection' ),
					     'make_connection_active' => wp_create_nonce( 'make_connection_active' ),
				     ],
			     ]
		     )
		     ->register();

		$logs_asset_data = require WPSMTP_ASSETS_PATH . 'js/logs.asset.php';
		Asset::add( 'solidwp-mail-logs', 'js/logs.js', $logs_asset_data['version'] )
		     ->in_footer()
		     ->set_dependencies( function () use ( $logs_asset_data ) {
			     return $logs_asset_data['dependencies'];
		     } )
		     ->enqueue_on( 'admin_enqueue_scripts' )
		     ->set_condition(
				 static function () {
					 //phpcs:ignore.
					 $page = $_GET['page'] ?? '';

					 return is_admin() && 'solidwp-mail-logs' === $page;
				 }
		     )
		     ->register();

		// todo should create a loop for this.
		$settings_asset_data = require WPSMTP_ASSETS_PATH . 'js/settings.asset.php';
		Asset::add( 'solidwp-mail-settings', 'js/settings.js', $settings_asset_data['version'] )
		     ->in_footer()
		     ->set_dependencies( function () use ( $settings_asset_data ) {
			     return $settings_asset_data['dependencies'];
		     } )
		     ->enqueue_on( 'admin_enqueue_scripts' )
		     ->add_localize_script( 'solidMailSettings', $this->container->callback( SettingsScreen::class, 'get_settings' ) )
		     ->set_condition(
			     static function () {
				     //phpcs:ignore.
				     $page = $_GET['page'] ?? '';

				     return is_admin() && 'solidwp-mail-settings' === $page;
			     }
		     )
		     ->register();
	}
}
