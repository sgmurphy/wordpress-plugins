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

		/*
			Only run this action if needed
		*/
		if ( filter_input( INPUT_GET, 'dpsp_admin_notice_dismiss' ) != null ) {
			add_action( 'admin_init', [ $this, 'dpsp_admin_notice_dismiss' ] );
		}

		if ( filter_input( INPUT_GET, 'dpsp_check_license' ) != null ) {
			add_action( 'admin_init', [ $this, 'dpsp_check_license' ] );
		}

		add_action( 'dpsp_first_activation', [ $this, 'dpsp_setup_activation_notices' ] );
		add_filter( 'removable_query_args', [ $this, 'dpsp_removable_query_args' ] );

		if ( ! \Social_Pug::is_free() ) {
			add_action( 'admin_notices', [ $this, 'dpsp_license_admin_notification' ] );
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
	 * Determines if the current screen being viewed is
	 * Hubbub or not.
	 * 
	 * @return boolean
	 */
	function dpsp_is_hubbub_screen() {
		$current_screen = get_current_screen();
		
		if ( strpos( $current_screen->id, 'hubbub_page' ) === false ) :
			return false;
		endif;

		return true;
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

		if ( get_transient('hubbub_license_activated_on_this_website') ) :
			$message_id = 5;
		endif;
		
		$message    = $this->dpsp_get_admin_notice_message( $message_id );

		$class = ( ! empty( filter_input( INPUT_GET, 'dpsp_message_class' ) ) ? filter_input( INPUT_GET, 'dpsp_message_class', FILTER_SANITIZE_STRING ) : 'updated' );

		if ( $message_id == 5 && isset( $message ) ) : // The user just activated Hubbub Pro on this domain name for the first time
			echo '<div class="dpsp-admin-notice notice is-dismissible ' . esc_attr( $class ) . '">';
			echo '<h4>Woohoo! Thanks for registering Hubbub Pro! 🎉</h4>';
			echo $message;
			echo '</div>';
		endif;

		if ( $message_id != 5 && isset( $message ) ) {
			echo '<div class="dpsp-admin-notice notice is-dismissible ' . esc_attr( $class ) . '">';
			echo '<p>' . esc_html( $message ) . '</p>';
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

		// Message ID 5 purposely not wrapped __() due to HTML use

		$messages = apply_filters(
			'dpsp_get_admin_notice_message',
			[
				__( 'Settings saved.', 'social-pug' ),
				__( 'Settings imported.', 'social-pug' ),
				__( 'Please select an import file.', 'social-pug' ),
				__( 'Import file is not valid.', 'social-pug' ),
				__( 'Hubbub App authorized successfully.', 'social-pug' ),
				'<p>Welcome to the Hubbub Pro family. To get set up, go to <a href="' . admin_url( 'admin.php?page=dpsp-toolkit' ) . '">Hubbub > Toolkit</a> and activate the ones you\'d like to use. After you save, you\'ll find new settings pages for each; you can add networks and configure them from there.</p><p>You may also find our <a href="https://morehubbub.com/docs/getting-started-with-hubbub-pro/">Getting Started</a> guide to be helpful, and if you have any questions, just send us an <a href="mailto:support@morehubbub.com?subject=Help setting up Hubbub Pro&body=Hi! I\'m setting up Hubbub Pro on: '.site_url().' and I have a question: " title="Sending an email to support@morehubbub.com will open a new support request. We try to reply to all new requests within a business day.">email</a>.</p>',
			]
		);

		return $messages[ $message_id ];
	}

	/**
	 * Adds an admin notification if the license is
	 * Empty
	 * Invalid
	 * Expired
	 */
	function dpsp_license_admin_notification() {
		if ( !$this->dpsp_is_hubbub_screen() ) return; // Limit to just Hubbub screens
		
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Used to determine if the current page
		// is the Hubbub settings page
		$current_screen = get_current_screen();
		$is_hubbub_settings_page = ($current_screen->id == 'hubbub_page_dpsp-settings') ? true : false;

		$dpsp_settings = Settings::get_setting( 'dpsp_settings' );

		$serial  = ( ! empty( $dpsp_settings['product_serial'] ) ? $dpsp_settings['product_serial'] : '' );
		$license = ( ! empty( $dpsp_settings['mv_grow_license'] ) ? $dpsp_settings['mv_grow_license'] : '' );
		
		if ( empty( $serial ) && empty( $license ) ) {
			echo '<div class="dpsp-admin-notice notice notice-warning dpsp-serial-missing">';
			echo '<h4>Action needed: Add Your Hubbub Pro License Key</h4>';
			echo '<p>Your Hubbub Pro license key is empty. You should have received it via email. Please add your key';
			if ( ! $is_hubbub_settings_page ) :
				echo ' in <a href="' . admin_url( 'admin.php?page=dpsp-settings' ) . '">Hubbub > Settings</a> ';
			else:
				echo ' below ';
			endif;
			echo 'to receive security updates, bug fixes, new features, and support. If you need a new license key, click the button below. Of course, if you have any questions, please <a href="mailto:support@morehubbub.com?subject=Hubbub Pro License Key Help&body=Hi! I\'m having trouble with my license key on: '.site_url().'%0D%0A%0D%0A(please enter more details here - thanks!)" title="Sending an email to support@morehubbub.com will open a new support request. We try to reply to all new requests within a business day.">email us</a>.</p>';
			echo '<p></p>';
			echo '<p>';
			if ( ! $is_hubbub_settings_page ) :
				echo '<a class="dpsp-get-license dpsp-button-secondary" href="' . admin_url( 'admin.php?page=dpsp-settings' ) . '">Update Settings</a> ';
			endif;
			
			echo '<a class="dpsp-get-license dpsp-button-primary" target="_blank" href="https://morehubbub.com/pricing/">Get License</a></p>';
			echo '</div>';
			return;
		}

		$license_status      = get_option( 'mv_grow_license_status' );
		$license_status_date = get_option( 'mv_grow_license_status_date' );

		if ( ! $license_status ) {
			return;
		}

		$license_key 		= get_option( 'mv_grow_license' );

		switch ( $license_status ) {
			case 'valid':
				return;
				break;
			case 'invalid':
				echo '<div class="dpsp-admin-notice notice notice-warning">';
				echo '<h4>Action needed: Update Invalid Hubbub Pro License Key</h4>';
				echo '<p>Oops! Your Hubbub Pro license key appears to be invalid. Please';
				if ( ! $is_hubbub_settings_page ) :
					echo ' go to <a href="' . admin_url( 'admin.php?page=dpsp-settings' ) . '">Hubbub > Settings</a>, and double-check that your key is entered correctly.';
				else:
					echo ' double-check your key and try entering it again below.';
				endif;
				
				echo '</p><p>A valid license is needed to receive security updates, bug fixes, new features, and support. If you need a new license key, please click the button below. If you\'re still having trouble, please <a href="mailto:support@morehubbub.com?subject=Hubbub Pro License Key Is Invalid&body=Hi! I\'m having trouble with my license key on: '.site_url().'%0D%0A%0D%0A(please enter more details here - thanks!)" title="Sending an email to support@morehubbub.com will open a new support request. We try to reply to all new requests within a business day.">email us</a>.</p>';
				echo '<p></p>';
				echo '<p>';
				if ( ! $is_hubbub_settings_page ) :
					echo '<a class="dpsp-get-license dpsp-button-secondary" href="' . admin_url( 'admin.php?page=dpsp-settings' ) . '">Update Settings</a> ';
				endif;
				
				echo '<a class="dpsp-get-license dpsp-button-primary" target="_blank" href="https://morehubbub.com/pricing/">Get License</a></p>';
				echo '</div>';
				return;
				break;
			case 'expired':
				echo '<div class="dpsp-admin-notice notice notice-warning">';
				echo '<h4>Action needed: Renew Your Hubbub Pro License Today</h4>';
				echo '<p>Oh no! Your Hubbub Pro license key has expired. Your subscription fuels the ongoing development and support of Hubbub Pro. A current license key is required to receive security updates, bug fixes, new features, and support.</p><p>It\'s easy to renew: Click the button below and follow the instructions. If you\'ve already renewed your license, please click "Check License". Of course, if you have any questions, please <a href="mailto:support@morehubbub.com?subject=Hubbub Pro License Key Expiration Help&body=Hi! I\'m having trouble with my license key on: '.site_url().'%0D%0A%0D%0A(please enter more details here - thanks!)" title="Sending an email to support@morehubbub.com will open a new support request. We try to reply to all new requests within a business day.">email us</a>. Thanks!</p>';
				$check_license_url = esc_attr( add_query_arg( [ '_wpnonce' => wp_create_nonce( 'dpsp_check_license' ), 'dpsp_check_license' => 'dpsp_check_license' ] ), remove_query_arg( ['_wpnonce', 'dpsp_check_license' ], $_SERVER['REQUEST_URI'] ) );
				echo '<p><a class="dpsp-get-license dpsp-button-secondary" href="' . $check_license_url . '">Check License</a> <a class="dpsp-button-primary" title="Click this Renew License button to purchase a renewal for your current license" target="_blank" href="https://morehubbub.com/checkout/?edd_license_key='. $license_key . '&download_id=28&utm_source=WordPressAdmin&utm_medium=button&utm_campaign=HubbubProExpireNotice&utm_content=RenewLicense">Renew License</a></p>';
				echo '</div>';
				return;
				break;
			default:
				return;
		}
	}

	/**
	 * Determines the number of admin notices that require attention
	 * 
	 * @return int
	 */

	public static function dpsp_count_hubbub_admin_notices() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return false;
		}
		$admin_notices_instance = Admin_Notices::get_instance();

		$numberOfNoticesToShow = 0;

		// From dpsp_admin_notice_grow_name_change_hubbub
		$numberOfNoticesToShow = ( ! $admin_notices_instance->was_first_activation_after( '2023-12-12 00:00:00' ) && '' === get_user_meta( get_current_user_id(), 'dpsp_admin_notice_grow_name_change_hubbub', true ) && empty( get_option( 'dpsp_admin_notice_grow_name_change_hubbub' ) ) ) ? $numberOfNoticesToShow+1 : $numberOfNoticesToShow;

		// From dpsp_admin_notice_initial_setup_nag
		$numberOfNoticesToShow = ( 'yes' === Settings::get_setting( 'dpsp_run_setup_info_nag', 'no' ) ) ? $numberOfNoticesToShow+1 : $numberOfNoticesToShow;

		// License related checks
		$license_key 		 = get_option( 'mv_grow_license' );

		// If license key is empty
		$numberOfNoticesToShow = ( empty( $license_key) ) ? $numberOfNoticesToShow+1 : $numberOfNoticesToShow;

		if ( empty( $license_key) ) : // No need to continue without a license key
			return $numberOfNoticesToShow;
		endif;

		$license_status      = get_option( 'mv_grow_license_status' );

		// Increase notice count if the license is invalid or expired
		switch ( $license_status ) {
			case 'invalid':
				$numberOfNoticesToShow++;
				break;
			case 'expired':
				$numberOfNoticesToShow++;
				break;
			default:
				return $numberOfNoticesToShow;
		}

		return $numberOfNoticesToShow;
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
		if ( !$this->dpsp_is_hubbub_screen() ) return; // Limit to just Hubbub screens

		// Do not display this notice if user cannot activate plugins
		if ( ! current_user_can( 'activate_plugins' ) ) :
			return;
		endif;

		// Don't show this if the plugin has been activated after December 12, 2023
		if ( $this->was_first_activation_after( '2023-12-12 00:00:00' ) ) :
			return;
		endif;

		// Do not display this notice for USERS that have dismissed it
		// And, if one user has dismissed it, hide it for all users.
		if ( '' !== get_user_meta( get_current_user_id(), 'dpsp_admin_notice_grow_name_change_hubbub', true ) ) :
			if ( empty( get_option( 'dpsp_admin_notice_grow_name_change_hubbub' ) ) ) : // If a single user has dismissed this notice, hide for all users
				update_option( 'dpsp_admin_notice_grow_name_change_hubbub', '1', false );
			endif;
			return;
		endif;

		// Do not display this notice any user on the site has dismissed it
		if ( ! empty( get_option( 'dpsp_admin_notice_grow_name_change_hubbub' ) ) ) :
			return;
		endif;

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
		echo '<p><a href="' . $this->dpsp_create_dismiss_notice_admin_url( 'dpsp_admin_notice_grow_name_change_hubbub' ) . '">' . esc_html__( 'Awesome - Click to dismiss this notice.', 'social-pug' ) . '</a></p>';
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

	function dpsp_create_dismiss_notice_admin_url( $action ) {
		return esc_attr( add_query_arg( [ '_wpnonce' => wp_create_nonce( 'dpsp_admin_notice_dismiss_' . $action ), 'dpsp_admin_notice_dismiss' => $action ] ), remove_query_arg( ['_wpnonce', 'dpsp_admin_notice_dismiss' ], $_SERVER['REQUEST_URI'] ) );
	}

	/**
	 * Add admin notice for initial setup help documentation
	 */
	function dpsp_admin_notice_initial_setup_nag() {
		if ( !$this->dpsp_is_hubbub_screen() ) return; // Limit to just Hubbub screens


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
		echo '<a class="notice-dismiss" href="' . $this->dpsp_create_dismiss_notice_admin_url( 'dpsp_admin_notice_initial_setup_nag' ) . '"></a>';
		echo '<h4>' . esc_html__( 'Getting Started with Hubbub', 'social-pug' ) . '</h4>';
		echo '<p>' . esc_html__( 'Would you like help getting started? Click the button below for a step-by-step guide to setting everything up!', 'social-pug' ) . '</p>';
		echo '<p><a class="dpsp-button-primary" target="_blank" href="https://morehubbub.com/docs/getting-started-with-hubbub-pro/">' . esc_html__( 'Learn how to set up Hubbub', 'social-pug' ) . '</a></p>';
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
			if ( 'yes' == get_option( 'dpsp_run_setup_info_nag' ) ) :
				update_option( 'dpsp_run_setup_info_nag', 'no' );
				wp_redirect($_SERVER['HTTP_REFERER']);
			endif;
		} else {
			// If this is the name change notice, dismiss for all users
			if ( $notice_to_dismiss == 'dpsp_admin_notice_grow_name_change_hubbub' ) :
				update_option( 'dpsp_admin_notice_grow_name_change_hubbub', '1', false );
			else :
				add_user_meta( get_current_user_id(), $notice_to_dismiss, 1, true );
			endif;
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
	 * Checks the license key based on a button click in the Renew License Admin Notice
	 */
	function dpsp_check_license() {
		if ( ! wp_verify_nonce( filter_input( INPUT_GET, '_wpnonce' ), 'dpsp_check_license' ) ) {
			wp_die( 'Sorry, the security token on this URL is invalid. If you believe you have gotten this message in error, please reach out to Hubbub Pro support.' );
		}

		$hubbub_activation = new \Mediavine\Grow\Activation;
		$hubbub_activation->check_license();
	}
}
