<?php

namespace Templately\Core;

class Maintenance {
	/**
	 * Init Maintenance
	 *
	 * @since 2.0.1
	 * @return void
	 */
	public static function init(){
		register_activation_hook( TEMPLATELY_PLUGIN_BASENAME, [ __CLASS__, 'activation' ] );
		register_uninstall_hook( TEMPLATELY_PLUGIN_BASENAME, [ __CLASS__, 'uninstall' ] );
		register_deactivation_hook( TEMPLATELY_PLUGIN_BASENAME, [ __CLASS__, 'deactivation' ] );
		add_action( 'admin_init', [ __CLASS__, 'maybe_redirect_templately' ] );
	}

	/**
	 * Runs on activation
	 *
	 * @since 2.0.1
	 */
	public static function activation( $network_wide ) {
		if ( wp_doing_ajax() ) {
			return;
		}

		if ( is_multisite() && $network_wide ) {
			return;
		}

		set_transient( 'templately_activation_redirect', true, MINUTE_IN_SECONDS );
	}

	public static function deactivation() {
	}

	/**
	 * Runs on uninstallation.
	 *
	 * @since 2.0.1
	 * @return void
	 */
	public static function uninstall(){

	}

	/**
	 * Redirect on Active
	 */
	public static function maybe_redirect_templately() {
		if ( ! get_transient( 'templately_activation_redirect' ) ) {
			return;
		}
		if ( wp_doing_ajax() ) {
			return;
		}

		delete_transient( 'templately_activation_redirect' );
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}
		// Safe Redirect to Templately Page
		wp_safe_redirect( admin_url( 'admin.php?page=templately&path=elementor/packs' ) );
		exit;
	}
}
