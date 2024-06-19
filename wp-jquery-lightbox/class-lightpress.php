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
		// Frontend & Admin.
		self::$active_lightbox = get_option( 'lightpress_active_lightbox', 'wp-jquery-lightbox' );
		load_plugin_textdomain( 'wp-jquery-lightbox', false, LIGHTPRESS_PLUGIN_DIR . 'languages/' );
		add_action( 'wp_loaded', array( $this, 'jqlb_save_date' ) );

		// Admin.
		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'register_menu_items' ) );
			add_filter( 'plugin_row_meta', array( $this, 'set_plugin_meta' ), 2, 10 );
			add_action( 'admin_init', array( $this, 'add_plugin_settings' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
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
		if ( self::$show_pro_screen && ! class_exists( 'LightPressPro' ) ) {
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
				printf( esc_html__( 'The WP JQuery Lightbox is now the LightPress Lightbox. Settings are now %1$s.', 'wp-jquery-lightbox' ), '<strong><a href="' . esc_url( admin_url( 'admin.php?page=lightpress-settings' ) ) . '">' . esc_html__( 'here', 'easy-fancybox' ) . '</a></strong>' );
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
			__( 'Choose Lighbox', 'easy-fancybox' ),
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
				<?php echo esc_html__( 'Additional settings for the selected lightbox will appear below.', 'easy-fancybox' ); ?>
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
		$screen         = get_current_screen();
		$should_load_js =
			'dashboard' === $screen->id ||
			self::$settings_screen_id === $screen->id ||
			self::$pro_screen_id === $screen->id;

		if ( $should_load_js ) {
			$css_file = LIGHTPRESS_PLUGIN_URL . 'admin/admin.css';
			wp_register_style( 'lightpress-admin-css', $css_file, false, LIGHTPRESS_VERSION );
			wp_enqueue_style( 'lightpress-admin-css' );

			$js_file = LIGHTPRESS_PLUGIN_URL . 'admin/admin.js';
			wp_register_script( 'lightpress-admin-js', $js_file, array( 'jquery', 'wp-dom-ready' ), LIGHTPRESS_VERSION, true );
			wp_enqueue_script( 'lightpress-admin-js' );
		}

		// Localize var to admin JS.
		wp_localize_script(
			'lightpress-admin-js',
			'lightpress',
			array(
				'proAdminUrl' => admin_url( 'admin.php?page=lightpress-pro' ),
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
}
