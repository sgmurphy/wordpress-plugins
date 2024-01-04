<?php
namespace Mediavine\Grow;

use WP_Screen;

/**
 * Tools to help manage admin notices.
 */
class Admin_Notices {

	/** @var null  */
	private static $instance = null;

	/**
	 *
	 *
	 * @return Admin_Notices
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function init() {
		add_action( 'admin_notices', [ $this, 'dpsp_admin_notices' ] );
		add_action( 'admin_notices', [ $this, 'dpsp_admin_notice_initial_setup_nag' ] );
		add_action( 'admin_notices', [ $this, 'dpsp_admin_notice_facebook_access_token_expired' ] );
		add_action( 'admin_notices', [ $this, 'dpsp_admin_notice_grow_name_change_hubbub' ] );
		add_action( 'admin_notices', [ $this, 'notify_license_status' ] );

		/*
			Only run this action if needed
		*/
		if ( filter_input( INPUT_GET, 'dpsp_admin_notice_dismiss' ) != null ) {
			add_action( 'admin_init', [ $this, 'dpsp_admin_notice_dismiss' ] );
		}

		add_action( 'dpsp_first_activation', [ $this, 'dpsp_setup_activation_notices' ] );
		add_filter( 'removable_query_args', [ $this, 'dpsp_removable_query_args' ] );

		if ( ! \Social_Pug::is_free() ) {
			add_action( 'admin_notices', [ $this, 'dpsp_serial_admin_notification' ] );
		}
	}

	/**
	 * Determines if first activation was before or after a specific date
	 *
	 * @param string $date Date in format: 'h:i m d Y'
	 * @return boolean
	 */
	public function was_first_activation_after( $date ) {
		$first_activation = Settings::get_setting( 'dpsp_first_activation', '' );
		if ( empty( $first_activation ) ) {
			return true;
		}

		$date = strtotime( $date );
		if ( ! empty( $date ) && $first_activation > $date ) {
			return true;
		}

		return false;
	}

	/**
	 * Display admin notices for our pages.
	 */
	function dpsp_admin_notices() {
		// Exit if settings updated is not present
		if ( empty( filter_input( INPUT_GET, 'settings-updated' ) ) ) {
			return;
		}

		$admin_page = ( ! empty( filter_input( INPUT_GET, 'page' ) ) ? filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING ) : '' );

		// Show these notices only on dpsp pages
		if ( false === strpos( $admin_page, 'dpsp' ) || 'dpsp-register-version' === $admin_page ) {
			return;
		}

		// Get messages
		$message_id = ( ! empty( filter_input( INPUT_GET, 'dpsp_message_id' ) ) ? filter_input( INPUT_GET, 'dpsp_message_id', FILTER_SANITIZE_NUMBER_INT ) : 0 );
		$message    = $this->dpsp_get_admin_notice_message( $message_id );

		$class = ( ! empty( filter_input( INPUT_GET, 'dpsp_message_class' ) ) ? filter_input( INPUT_GET, 'dpsp_message_class', FILTER_SANITIZE_STRING ) : 'updated' );

		if ( isset( $message ) ) {
			echo '<div class="dpsp-admin-notice notice is-dismissible ' . esc_attr( $class ) . '">';
			echo '<p>' . esc_attr( $message ) . '</p>';
			echo '</div>';
		}
	}

	/**
	 * Returns a human readable message given a message id.
	 *
	 * @param int $message_id
	 * @return mixed
	 */
	function dpsp_get_admin_notice_message( $message_id ) {
		$messages = apply_filters(
			'dpsp_get_admin_notice_message',
			[
				__( 'Settings saved.', 'social-pug' ),
				__( 'Settings imported.', 'social-pug' ),
				__( 'Please select an import file.', 'social-pug' ),
				__( 'Import file is not valid.', 'social-pug' ),
				__( 'Hubbub App authorized successfully.', 'social-pug' ),
			]
		);

		return $messages[ $message_id ];
	}

	/**
	 * Adds admin notifications for entering the license serial key.
	 */
	function dpsp_serial_admin_notification() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$dpsp_settings = Settings::get_setting( 'dpsp_settings' );

		$serial  = ( ! empty( $dpsp_settings['product_serial'] ) ? $dpsp_settings['product_serial'] : '' );
		$license = ( ! empty( $dpsp_settings['mv_grow_license'] ) ? $dpsp_settings['mv_grow_license'] : '' );
		// Check to see if serial is saved in the database
		if ( empty( $serial ) && empty( $license ) ) {

			$notice_classes = 'dpsp-serial-missing';
			// translators: %1$s is replaced by admin url, %2$s is replaced by store url
			$message = sprintf( __( 'Your <strong>Hubbub Pro</strong> license key is empty. Please <a href="%1$s">register your copy</a> to receive automatic updates and support. <br /><br /> Need a license key? <a class="dpsp-get-license button button-primary" target="_blank" href="%2$s">Get your license here</a> and enter it on the Settings page', 'social-pug' ), admin_url( 'admin.php?page=dpsp-settings' ), 'https://morehubbub.com/' );

			// Display the notice if notice classes have been added
			echo '<div class="dpsp-admin-notice notice ' . esc_attr( $notice_classes ) . '">';
			echo '<p>' . wp_kses( $message, View_Loader::get_allowed_tags() ) . '</p>';

			echo '</div>';
		}
	}

	/**
	 * Add admin notice to let you know the Facebook access token has expired.
	 */
	function dpsp_admin_notice_facebook_access_token_expired() {
		// Do not display this notice if user cannot activate plugins
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$facebook_access_token = Settings::get_setting( 'dpsp_facebook_access_token' );

		// Do not display the notice if the access token is missing
		if ( empty( $facebook_access_token['access_token'] ) || empty( $facebook_access_token['expires_in'] ) ) {
			return;
		}

		// Do not display the notice if the token isn't expired
		if ( time() < absint( $facebook_access_token['expires_in'] ) ) {
			return;
		}

		$settings = Settings::get_setting( 'dpsp_settings', [] );

		// Do not display the notice if the Facebook share count provider isn't set to Hubbub's Facebook app
		if ( ! empty( $settings['facebook_share_counts_provider'] ) && 'authorized_app' !== $settings['facebook_share_counts_provider'] ) {
			return;
		}

		$branding = \Social_Pug::get_branding_name();

		// Echo the admin notice
		echo '<div class="dpsp-admin-notice notice notice-error">';
		// translators: %s Branding name, free or pro version
		echo '<h4>' . sprintf( esc_html__( '%s Important Notification', 'social-pug' ), esc_html( $branding ) ) . '</h4>';
		// translators: %s Branding name, free or pro version
		echo '<p>' . sprintf( esc_html__( 'Your %s Facebook app authorization has expired. Please reauthorize the app for continued Facebook share counts functionality.', 'social-pug' ), esc_html( $branding ) ) . '</p>';
		echo '<p><a class="dpsp-button-primary" href="' . esc_url( add_query_arg( [ 'page' => 'dpsp-settings' ], admin_url( 'admin.php' ) ) ) . '#dpsp-card-misc">' . esc_html__( 'Reauthorize App', 'social-pug' ) . '</a></p>';
		echo '</div>';
	}

	/**
	 * Add admin notice to announce the name change.
	 */
	function dpsp_admin_notice_grow_name_change_hubbub() {
		// Do not display this notice if user cannot activate plugins
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		// Don't show this if the plugin has been activated after December 7, 2023
		if ( $this->was_first_activation_after( '2023-12-12 00:00:00' ) ) {
			return;
		}

		// Do not display this notice for users that have dismissed it
		if ( '' !== get_user_meta( get_current_user_id(), 'dpsp_admin_notice_grow_name_change_hubbub', true ) ) {
			return;
		}

		// Echo the admin notice
		echo '<div class="dpsp-admin-notice dpsp-admin-grow-notice notice notice-info" style="min-height: 300px">';
		echo '<div class="notice-img-wrap">';
		echo '<img width="250" height="250" style="float: left;" src="' . esc_url( DPSP_PLUGIN_DIR_URL . 'assets/dist/hubbub-notice-name-image.png?' . DPSP_VERSION ) . '" />';
		echo '</div>';
		echo '<div class="notice-text-wrap">';
		echo '<h4>' . esc_html__( 'Grow Social is now Hubbub! 🎉', 'social-pug' ) . '</h4>';
		echo '<p>' . esc_html__( 'If you updated your Grow Social plugin within the last few days you may have noticed a few things have changed. NerdPress has acquired the plugin from Mediavine, and we\'ve changed the name to Hubbub. We\'ll be making lots of improvements in order to make Hubbub even better for you and your site!', 'social-pug' ) . '</p>';
		echo '<p><a href="https://www.nerdpress.net/announcing-hubbub/" target="_blank">' . esc_html__( 'Check out our blog post', 'social-pug' ) . '</a>' . esc_html__( ' for more information and answers to frequently asked questions.', 'social-pug' ) . '</p>';
		echo '<p class="notice-subtext">' . esc_html__( 'At NerdPress, our motto is "WordPress support that feels like family." Our acquisition of Hubbub is one more step towards fulfilling our mission of helping people do what they love, so they can lead richer, more fulfilling lives.', 'social-pug' ) . '</p>';
		echo '<p><a href="' . $this->dpsp_create_dimiss_notice_admin_url( 'dpsp_admin_notice_grow_name_change_hubbub' ) . '">' . esc_html__( 'Awesome - Click to dismiss this notice.', 'social-pug' ) . '</a></p>';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Create a secure cruft free Admin URL to the current page for dismissing Hubbub notices
	 * List of known dismissable notices:
	 * - dpsp_admin_notice_grow_name_change_hubbub
	 * - dpsp_admin_notice_initial_setup_nag (works differently, see dpsp_admin_notice_dismiss() )
	 * - deprecated: dpsp_admin_notice_twitter_counts
	 * - deprecated: dpsp_admin_notice_renew_1
	 * - deprecated: dpsp_admin_notice_recovery_system
	 * - deprecated: dpsp_admin_notice_major_update_2_6_0
	 * - deprecated: dpsp_admin_notice_google_plus_removal
	 * - deprecated: dpsp_admin_notice_grow_name_change
	 * - deprecated: dpsp_admin_notice_jquery_deprecation
	 * TODO: Possibly clear deprecated values from user's database?
	 */

	function dpsp_create_dimiss_notice_admin_url( $action ) {
		return esc_attr( add_query_arg( [ '_wpnonce' => wp_create_nonce( 'dpsp_admin_notice_dismiss_' . $action ), 'dpsp_admin_notice_dismiss' => $action ] ), remove_query_arg( ['_wpnonce', 'dpsp_admin_notice_dismiss' ], $_SERVER['REQUEST_URI'] ) );
	}

	/**
	 * Add admin notice for initial setup help documentation
	 */
	function dpsp_admin_notice_initial_setup_nag() {
		// Do not display this notice if user cannot activate plugins
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		// Do not display this notice after it has been dismissed
		if ( 'yes' !== Settings::get_setting( 'dpsp_run_setup_info_nag', 'no' ) ) {
			return;
		}

		// Echo the admin notice
		echo '<div class="dpsp-admin-notice notice notice-info">';
		echo '<a class="notice-dismiss" href="' . $this->dpsp_create_dimiss_notice_admin_url( 'dpsp_admin_notice_initial_setup_nag' ) . '"></a>';
		echo '<h4>' . esc_html__( 'Hubbub Notification', 'social-pug' ) . '</h4>';
		echo '<p>' . esc_html__( 'Would you like help getting started with Hubbub? Click the button below for a step-by-step guide to setting everything up!', 'social-pug' ) . '</p>';
		echo '<p><a class="dpsp-button-primary" target="_blank" href="https://morehubbub.com/docs/getting-started-with-social-pro/">' . esc_html__( 'Learn how to set up Hubbub', 'social-pug' ) . '</a></p>';
		echo '</div>';
	}

	/**
	 * Adds an option on first install so initial admin notice is displayed.
	 */
	function dpsp_setup_activation_notices() {
		update_option( 'dpsp_run_setup_info_nag', 'yes' );
	}

	/**
	 * Handle admin notices dismissals.
	 */
	function dpsp_admin_notice_dismiss() {
		if ( ! wp_verify_nonce( filter_input( INPUT_GET, '_wpnonce' ), 'dpsp_admin_notice_dismiss_' . filter_input( INPUT_GET, 'dpsp_admin_notice_dismiss') ) ) {
			wp_die( 'Sorry, the security token on this URL is invalid. If you believe you have gotten this message in error, please reach out to Hubbub Pro support.' );
		}

		$notice_to_dismiss = filter_input( INPUT_GET, 'dpsp_admin_notice_dismiss' );

		if ( $notice_to_dismiss == 'dpsp_admin_notice_initial_setup_nag' ) {
			update_option( 'dpsp_run_setup_info_nag', 'no' );
		} else {
			add_user_meta( get_current_user_id(), $notice_to_dismiss, 1, true );
		}
	}

	/**
	 * Remove dpsp query args from the URL.
	 *
	 * @param array $removable_query_args The args that WP will remove
	 * @return array
	 */
	function dpsp_removable_query_args( $removable_query_args ) {
		$new_args = [ 'dpsp_message_id', 'dpsp_message_class', 'dpsp_admin_notice_dismiss_button_icon_animation', 'dpsp_admin_notice_activate_button_icon_animation', 'dpsp_admin_notice_activate_button_icon_animation_done' ];

		return array_merge( $new_args, $removable_query_args );
	}

	/**
	 * Notify users of their current license status, if available, while on the Grow Social settings page.
	 */
	public function notify_license_status() : void {
		$screen = get_current_screen();
		if ( ! ( $screen instanceof WP_Screen ) || 'grow_page_dpsp-settings' !== $screen->id ) {
			return;
		}

		$license_status      = get_option( Activation::OPTION_LICENSE_STATUS );
		$license_status_date = get_option( Activation::OPTION_LICENSE_STATUS_DATE );

		if ( ! $license_status ) {
			return;
		}

		switch ( $license_status ) {
			case Activation::LICENSE_STATUS_VALID:
				$notice_type    = Admin_Messages::MESSAGE_TYPE_SUCCESS;
				$license_notice = __( 'The Grow Social Pro license is valid.', 'mediavine' );
				break;
			case Activation::LICENSE_STATUS_INVALID:
				$notice_type    = Admin_Messages::MESSAGE_TYPE_ERROR;
				$license_notice = __( 'The Grow Social Pro license is not valid.', 'mediavine' );
				break;
			case Activation::LICENSE_STATUS_EXPIRED:
				$notice_type    = Admin_Messages::MESSAGE_TYPE_WARNING;
				$license_notice = __( 'The Grow Social Pro license has expired.', 'mediavine' );
				break;
			default:
				return;
		}

		if ( $license_status_date && filter_var( $license_status_date, FILTER_VALIDATE_INT ) ) {
			$date_format                   = get_option( 'date_format', 'F j, Y' );
			$license_status_date_formatted = gmdate( $date_format, $license_status_date );
			$license_notice                = sprintf(
				// translators: %1$s is the license status message, %2$s is the last-checked date.
				__( '%1$s Last checked %2$s.', 'mediavine' ),
				$license_notice,
				$license_status_date_formatted
			);
		}

		mv_grow_admin_error_notice( $license_notice, $notice_type );
	}
}
