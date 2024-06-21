<?php
/**
 * Main LightPress Plugin Class
 *
 * This file contains the main class for the LightPress plugin.
 *
 * @package    LightPress Lightbox
 * @author     LightPress
 * @copyright  Copyright (c) 2024, LightPress
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @version    2.0.0
 */

/**
 * LightPress Class
 *
 * This is the main LightPress Lightbox plugin class.
 *
 * @package    LightPress Lightbox
 * @author     LightPress
 * @since      2.0.0
 */
class LightPress {
	/**
	 * Holds the singleton instance of this class
	 *
	 * @var LightPress|null
	 */
	public static $instance = null;

	/**
	 * Holds the currently active lightbox
	 *
	 * @var string|null
	 */
	public static $active_lightbox = null;

	/**
	 * The screen id for the settings page
	 *
	 * @var string
	 */
	public static $settings_screen_id = 'toplevel_page_lightpress-settings';

	/**
	 * The screen id for the pro page
	 *
	 * @var string
	 */
	public static $pro_screen_id = 'lightbox_page_lightpress-pro';

	/**
	 * Conditional for whether to load pro upgrade screen.
	 *
	 * Enable or remove this when pro plugin is ready.
	 *
	 * @var bool
	 */
	public static $show_pro_screen = false;

	/**
	 * Return instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor for the LightPress class.
	 *
	 * Initializes the LightPress and sets up hooks and filters.
	 */
	public function __construct() {
		self::$active_lightbox = get_option( 'lightpress_active_lightbox', 'wp-jquery-lightbox' );
		load_plugin_textdomain( 'wp-jquery-lightbox', false, LIGHTPRESS_PLUGIN_DIR . 'languages/' );
		add_action( 'wp_loaded', array( $this, 'jqlb_save_date' ) );

		// Admin.
		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'register_menu_items' ) );
			add_filter( 'plugin_row_meta', array( $this, 'set_plugin_meta' ), 2, 10 );
			add_action( 'admin_init', array( $this, 'add_plugin_settings' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
			add_action( 'admin_notices', array( $this, 'show_review_request' ) );
			add_action( 'wp_ajax_lightpress-review-action', array( $this, 'process_lightpress_review_action' ) );
		}

		// Include WP JQuery Lightbox.
		require_once LIGHTPRESS_PLUGIN_DIR . 'lightboxes/wp-jquery-lightbox/class-wp-jquery-lightbox.php';
		$wp_jquery_lightbox = WP_JQuery_Lightbox::get_instance();
	}

	/**
	 * Registers the menu items for the plugin.
	 *
	 * This method adds the settings and pro pages to the WordPress admin menu.
	 */
	public function register_menu_items() {
		add_menu_page(
			__( 'Lightbox Settings - LightPress', 'wp-jquery-lightbox' ),
			'Lightbox',
			'manage_options',
			'lightpress-settings',
			array( __CLASS__, 'options_page' ),
			'dashicons-format-image',
			85
		);
		if ( self::$show_pro_screen && ! class_exists( 'LightPress_Pro' ) ) {
			add_submenu_page(
				'lightpress-settings',
				'LightPress Settings',
				'Settings',
				'manage_options',
				'lightpress-settings'
			);
			add_submenu_page(
				'lightpress-settings',
				'Go Pro',
				'Go Pro',
				'manage_options',
				'lightpress-pro',
				array( __CLASS__, 'pro_landing_page' )
			);
		}

		// Keep the old settings section in place temporarily with notice.
		add_options_page(
			'jQuery Lightbox Options',
			'jQuery Lightbox',
			'manage_options',
			'jquery-lightbox-options',
			array( __CLASS__, 'old_options_page' )
		);
	}

	/**
	 * Renders the plugin settings page.
	 *
	 * This method generates the HTML for the settings page.
	 */
	public static function options_page() {
		settings_errors();
		echo '<img class="lightpress-logo" src="' . esc_url( LIGHTPRESS_PLUGIN_URL ) . 'admin/lightpress-logo.png">';
		echo '<form method="post" action="options.php">';
		settings_fields( 'lightpress-settings-group' );
		do_settings_sections( 'lightpress-settings' );
		submit_button();
		echo '</form>';
	}

	/**
	 * Renders the old settings page.
	 *
	 * This is temporary so users know settings have moved.
	 */
	public static function old_options_page() {
		if ( ! function_exists( 'current_user_can' ) || ! current_user_can( 'manage_options' ) ) {
			die( esc_html__( 'Cheatin&#8217; uh?', 'wp-jquery-lightbox' ) );
		}

		?>
			<div class="wrap">
			<h2><?php esc_html_e( 'WP JQuery Lightbox', 'wp-jquery-lightbox' ); ?></h2>
			<p style="font-size:18px;">
				<span style="font-weight:bold;"><?php esc_html_e( 'Big news!', 'wp-jquery-lightbox' ); ?></span>
				<?php
				/* translators: %1$s is replaced with a link, ie <a> tag */
				printf( esc_html__( 'The WP JQuery Lightbox is now the LightPress Lightbox. Settings are now %1$s.', 'wp-jquery-lightbox' ), '<strong><a href="' . esc_url( admin_url( 'admin.php?page=lightpress-settings' ) ) . '">' . esc_html__( 'here', 'wp-jquery-lightbox' ) . '</a></strong>' );
				?>
			</p>
		<?php
	}

	/**
	 * Renders the pro upgrade page.
	 *
	 * This method generates the HTML for the pro upgrade page.
	 */
	public static function pro_landing_page() {
		include LIGHTPRESS_PLUGIN_DIR . 'admin/views/pro-landing-page.php';
	}

	/**
	 * Registers and adds settings for plugin and WP JQuery Lightbox.
	 */
	public static function add_plugin_settings() {
		// Register general plugin settings.
		register_setting(
			'lightpress-settings-group',
			'lightpress_active_lightbox',
			array(
				'default'           => 'wp-jquery-lightbox',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		add_option( 'lightpress_active_lightbox', 'wp-jquery-lightbox' );

		// Add general plugin settings section.
		add_settings_section(
			'lightpress-general-settings-section', // Section ID.
			__( 'General Settings', 'wp-jquery-lightbox' ), // Section title.
			null, // Callback for top-of-section content.
			'lightpress-settings', // Page ID.
			array(
				'before_section' => '<div class="general-settings-section settings-section">',
				'after_section'  => '</div>',
			)
		);

		// Add general plugin settings fields.
		add_settings_field(
			'lightpress_active_lightbox',
			__( 'Choose Lighbox', 'wp-jquery-lightbox' ),
			array( __CLASS__, 'render_choose_lightbox_field' ),
			'lightpress-settings',
			'lightpress-general-settings-section',
			array( 'label_for' => 'lightpress_active_lightbox' )
		);
	}

	/**
	 * Renders the 'Choose Lightbox' field on the settings page.
	 */
	public static function render_choose_lightbox_field() {
		$selected             = get_option( 'lightpress_active_lightbox', 'wp-jquery-lightbox' );
		$available_lightboxes = self::get_lightboxes();

		?>
			<select name="lightpress_active_lightbox" id="lightpress_active_lightbox">
				<?php foreach ( $available_lightboxes as $slug => $title ) { ?>
					<option
						value="<?php echo $slug; // phpcs:ignore ?>"
						<?php selected( $selected, $slug ); ?>
					>
						<?php echo $title // phpcs:ignore ?>
					</option>
				<?php } ?>
			</select>
			<span class="description">
				<?php echo esc_html__( 'Additional settings for the selected lightbox will appear below.', 'wp-jquery-lightbox' ); ?>
			</span>
		<?php
	}

	/**
	 * Renders settings fields.
	 *
	 * @param array $setting The settings field details.
	 */
	public static function render_settings_fields( $setting ) {
		$output      = array();
		$id          = $setting['id'];
		$default     = isset( $setting['default'] ) ? $setting['default'] : '';
		$description = isset( $setting['description'] ) ? $setting['description'] : '';
		$value       = get_option( $id, $default );

		if ( isset( $setting['input'] ) ) {
			switch ( $setting['input'] ) {
				case 'select':
					$output[] = '<select name="' . $id . '" id="' . $id . '">';
					foreach ( $setting['options'] as $optionkey => $optionvalue ) {
						$output[] =
							'<option value="'
							. esc_attr( $optionkey )
							. '"'
							. selected( get_option( $id, $default ) === $optionkey, true, false )
							. ' '
							. disabled( isset( $setting['status'] ) && 'disabled' === $setting['status'], true, false )
							. ' >'
							. $optionvalue
							. '</option>';
					}
					$output[] = '</select> ';
					if ( empty( $setting['label_for'] ) ) {
						$output[] = '<label for="' . $id . '">' . $description . '</label> ';
					} elseif ( $description ) {
						$output[] = $description;
					}
					break;

				case 'checkbox':
					$output[] =
						'<input type="checkbox" name="'
						. $id
						. '" id="' . $id
						. '" value="1" '
						. checked( get_option( $id, $default ), true, false )
						. ' '
						. disabled( isset( $setting['status'] ) && 'disabled' === $setting['status'], true, false )
						. ' /> '
						. $description
						. '<br />';
					break;

				case 'text':
				case 'color':
					$css_class = isset( $setting['class'] ) ? $setting['class'] : '';
					$output[]  =
						'<input type="text" name="'
						. $id
						. '" id="'
						. $id
						. '" value="'
						. esc_attr( $value )
						. '" class="'
						. $css_class
						. '"'
						. disabled( isset( $setting['status'] ) && 'disabled' === $setting['status'], true, false )
						. ' /> ';

					if ( empty( $setting['label_for'] ) ) {
						$output[] = '<label for="' . $id . '">' . $description . '</label> ';
					} elseif ( $description ) {
						$output[] = $description;
					}
					break;

				case 'number':
					$css_class = isset( $setting['class'] ) ? $setting['class'] : '';
					// Fix for past options saving below minimums.
					$is_value_above_minimum = isset( $args['min'] )
						? $value > $args['min']
						: true;
					$value                  = $is_value_above_minimum ? $value : $args['min'];

					$output[] =
						'<input type="number" step="'
						. ( isset( $setting['step'] ) ? $setting['step'] : '' )
						. '" min="'
						. ( isset( $args['min'] ) ? $args['min'] : '' )
						. '" max="'
						. ( isset( $args['max'] ) ? $setting['max'] : '' )
						. '" name="' . $id . '" id="'
						. $id
						. '" value="'
						. esc_attr( $value )
						. '" class="'
						. $css_class
						. '"'
						. disabled( isset( $setting['status'] ) && 'disabled' === $setting['status'], true, false )
						. ' /> ';

					if ( empty( $setting['label_for'] ) ) {
						$output[] = '<label for="' . $id . '">' . $description . '</label> ';
					} elseif ( $description ) {
						$output[] = $description;
					}
					break;

				default:
					if ( $description ) {
						$output[] = $description;
					}
			}
		} elseif ( $description ) {
			$output[] = $description;
		}

		echo implode( '', $output ); // phpcs:ignore
	}

	/**
	 * Sets the plugin meta for the LightPress plugin.
	 *
	 * @param array  $links Array of links to filter.
	 * @param string $file  Plugin file.
	 */
	public function set_plugin_meta( $links, $file ) {
		if ( LIGHTPRESS_PLUGIN_BASE === $file ) {
			$settings_link = '<a href="admin.php?page=lightpress-settings">' . __( 'Settings', 'wp-jquery-lightbox' ) . '</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}

	/**
	 * Returns an array of available lightboxes.
	 *
	 * Also create 'lightpress_get_lightboxes' filter, which
	 * can be used to add lightboxes from elsewhere.
	 *
	 * @return array The array of lightboxes.
	 */
	public static function get_lightboxes() {
		$free_lightboxes = array(
			'wp-jquery-lightbox' => esc_html__( 'WP JQuery Lightbox', 'wp-jquery-lightbox' ),
		);
		return apply_filters( 'lightpress_get_lightboxes', $free_lightboxes );
	}

	/**
	 * Enqueues admin assets for the LightPress plugin.
	 */
	public function enqueue_admin_assets() {
		$screen                 = get_current_screen();
		$is_lightpress_settings = self::$settings_screen_id === $screen->id;
		$is_pro_landing         = self::$pro_screen_id === $screen->id;
		$is_dashboard           = 'dashboard' === $screen->id;
		$freemius_js            = 'https://checkout.freemius.com/checkout.min.js';
		$purchase_js            = LIGHTPRESS_PLUGIN_URL . 'admin/admin-purchase.js';
		$settings_js            = LIGHTPRESS_PLUGIN_URL . 'admin/admin-settings.js';
		$notice_js              = LIGHTPRESS_PLUGIN_URL . 'admin/admin-notice.js';
		$css_file               = LIGHTPRESS_PLUGIN_URL . 'admin/admin.css';
		$version                = defined( 'WP_DEBUG' ) ? time() : EASY_FANCYBOX_PRO_VERSION;

		if ( $is_pro_landing ) {
			wp_register_script( 'lightpress-freemius-js', $freemius_js, array( 'jquery', 'wp-dom-ready' ), $version, true );
			wp_register_script( 'lightpress-purchase-js', $purchase_js, array( 'jquery', 'wp-dom-ready' ), $version, true );
			wp_enqueue_script( 'lightpress-freemius-js' );
			wp_enqueue_script( 'lightpress-purchase-js' );
		}

		if ( $is_lightpress_settings ) {
			wp_register_script( 'lightpress-settings-js', $settings_js, array( 'jquery', 'wp-dom-ready' ), $version, true );
			wp_enqueue_script( 'lightpress-settings-js' );
		}

		if ( $is_lightpress_settings || $is_dashboard ) {
			wp_register_script( 'lightpress-notice-js', $notice_js, array( 'jquery', 'wp-dom-ready' ), $version, true );
			wp_enqueue_script( 'lightpress-notice-js' );
		}

		if ( $is_lightpress_settings || $is_pro_landing || $is_dashboard ) {
			wp_register_style( 'lightpress-admin-css', $css_file, false, $version );
			wp_enqueue_style( 'lightpress-admin-css' );
		}

		wp_localize_script(
			'lightpress-settings-js',
			'settings',
			array(
				'proLandingUrl' => admin_url( 'admin.php?page=lightpress-pro' ),
			)
		);
	}

	/**
	 * Add date time stampe when plugin activated
	 */
	public function jqlb_save_date() {
		if ( ! is_admin() ) {
			return;
		}

		$date = get_option( 'jqlb_date' );
		if ( $date ) {
			return;
		}

		$now           = new DateTimeImmutable( gmdate( 'Y-m-d' ) );
		$now_as_string = $now->format( 'Y-m-d' );
		update_option( 'jqlb_date', $now_as_string );
	}

	/**
	 * Determine if the review request should be shown.
	 *
	 * To summarize, this will only show:
	 * if is options screen and
	 * if has not already been rated and
	 * if user is selected for metered rollout and
	 * if user has plugin more than 60 days and
	 * if use has not interacted with reviews within 90 days.
	 *
	 * @access public
	 *
	 * @return bool Returns true if the review request should be shown, false otherwise.
	 */
	public function should_show_review_request() {
		// Don't show if not on options screen or dashboard, or if already rated.
		$screen                         = get_current_screen();
		$is_dashboard_or_plugin_options = 'dashboard' === $screen->id || self::$settings_screen_id === $screen->id;
		$already_rated                  = get_option( 'lightpress_plugin_rated' ) && get_option( 'lightpress_plugin_rated' ) === 'true';

		if ( ! $is_dashboard_or_plugin_options || $already_rated ) {
			return false;
		}

		// Limit review notices to 10% of users initially.
		$user_review_number = get_option( 'lightpress_user_review_number' );
		if ( ! $user_review_number ) {
			$user_review_number = rand( 1, 10 ); // phpcs:ignore
			update_option( 'lightpress_user_review_number', $user_review_number );
		}
		$selected = '1' === $user_review_number || '2' === $user_review_number || '3' === $user_review_number || '4' === $user_review_number;
		if ( ! $selected ) {
			return false;
		}

		// Only show if user has been using plugin for more than 60 days.
		$current_date      = new DateTimeImmutable( gmdate( 'Y-m-d' ) );
		$plugin_time_stamp = get_option( 'jqlb_date' );
		$activation_date   = $plugin_time_stamp
			? new DateTimeImmutable( $plugin_time_stamp )
			: $current_date;
		$days_using_plugin = $activation_date->diff( $current_date )->days;
		if ( $days_using_plugin < 60 ) {
			return false;
		}

		// Do not show if user interacted with reviews within last 90 days.
		$lightpress_last_review_interaction = get_option( 'lightpress_last_review_interaction' );
		if ( $lightpress_last_review_interaction ) {
			$last_review_interaction_date = new DateTimeImmutable( $lightpress_last_review_interaction );
			$days_since_last_interaction  = $last_review_interaction_date->diff( $current_date )->days;
			if ( $days_since_last_interaction < 90 ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Render the review request to the user.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function show_review_request() {
		if ( $this->should_show_review_request() ) {
			?>
				<div class="notice notice-success is-dismissible lightpress-review-notice">
					<p><?php esc_html_e( 'You\'ve been using LightPress (WP JQuery Lightbox) for a long time! Awesome and thanks!', 'wp-jquery-lightbox' ); ?></p>
					<p>
						<?php
						printf(
							__( 'We work hard to maintain it - for over 10 years! Would you do us a BIG favor and give us a 5-star review on WordPress.org? Or share feedback <a %s>here</a>.', 'wp-jquery-lightbox' ), // phpcs:ignore
							'href="https://lightpress.io/contact/" target="_blank"'
						);
						?>
					</p>

					<ul class="lightpress-review-actions" data-nonce="<?php echo esc_attr( wp_create_nonce( 'lightpress_review_action_nonce' ) ); ?>">
						<li style="display:inline;"><a class="button-primary" data-rate-action="do-rate"
							href="https://wordpress.org/support/plugin/wp-jquery-lightbox/reviews/#new-post" target="_blank"><?php esc_html_e( 'Ok, you deserve it!', 'wp' ); ?></a>
						</li>
						<li style="display:inline;"><a class="button-secondary" data-rate-action="maybe-later" href="#"><?php esc_html_e( 'Maybe later', 'wp-jquery-lightbox' ); ?></a></li>
						<li style="display:inline;"><a class="button-secondary" data-rate-action="done" href="#"><?php esc_html_e( 'Already did!', 'wp-jquery-lightbox' ); ?></a></li>
					</ul>
				</div>

			<?php
		}
	}

	/**
	 * Process Ajax request when user interacts with review requests
	 */
	public function process_lightpress_review_action() {
		check_admin_referer( 'lightpress_review_action_nonce', '_n' );
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$rate_action            = isset( $_POST['rate_action'] )
			? sanitize_text_field( wp_unslash( $_POST['rate_action'] ) )
			: '';
		$current_date           = new DateTimeImmutable( gmdate( 'Y-m-d' ) );
		$current_date_as_string = $current_date->format( 'Y-m-d' );
		update_option( 'lightpress_last_review_interaction', $current_date_as_string );

		if ( 'done' === $rate_action ) {
			update_option( 'lightpress_plugin_rated', 'true' );
		}

		exit;
	}

	/**
	 * Disables/hides core lightbox for editor > image blocks.
	 *
	 * Helper function designed to be used by individual lightboxes
	 * to disable core lightbox if they offer that option.
	 *
	 * @param array $theme_json  Theme json to filter.
	 * @return array $theme_json Filtered theme json.
	 */
	public static function hide_core_lightbox_in_editor( $theme_json ) {
		$new_data = array(
			'version'  => 2,
			'settings' => array(
				'blocks' => array(
					'core/image' => array(
						'lightbox' => array(
							'allowEditing' => false,
							'enabled'      => false,
						),
					),
				),
			),
		);
		return $theme_json->update_with( $new_data );
	}

	/**
	 * Removes filter and dequeues JS for core lightbox.
	 *
	 * Helper function designed to be used by individual lightboxes
	 * to disable core lightbox if they offer that option.
	 */
	public static function disable_core_lightbox_on_frontend() {
		// These are added for the core lightbox here:
		// https://github.com/WordPress/gutenberg/blob/8dc36f6d30cc163671bdaa33f0656fdfe91f1447/packages/block-library/src/image/index.php#L64 .
		if ( function_exists( 'wp_dequeue_script_module' ) ) {
			wp_dequeue_script_module( '@wordpress/block-library/image' );
		}
		remove_filter( 'render_block_core/image', 'block_core_image_render_lightbox', 15 );
		remove_filter( 'render_block_core/image', 'block_core_image_render_lightbox', 15, 2 );
	}
}
