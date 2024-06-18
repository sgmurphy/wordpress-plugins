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
	 * The name of the plugin
	 *
	 * @var string
	 */
	public static $name = 'LightPress Lightbox';

	/**
	 * The plugin slug
	 *
	 * @var string
	 */
	public static $plugin_slug = 'wp-jquery-lightbox';

	/**
	 * The group of the lightbox
	 *
	 * @var int
	 */
	public static $lightbox_group = -1;

	/**
	 * Holds the options for the JQuery Lightbox
	 *
	 * @var array
	 */
	public static $jqlb_options;

	/**
	 * Holds the currently active lightbox
	 *
	 * @var string|null
	 */
	private static $active_lightbox = null;

	/**
	 * The screen id for the settings page
	 *
	 * @var string
	 */
	public static $screen_id = 'toplevel_page_lightpress-settings';

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
		include LIGHTPRESS_PLUGIN_DIR . 'wp-jquery-lightbox-options.php';

		// Frontend & Admin.
		self::$active_lightbox = get_option( 'lightpress_active_lightbox', 'wp-jquery-lightbox' );
		self::$jqlb_options    = $wp_jquery_lightbox_options;
		load_plugin_textdomain( 'wp-jquery-lightbox', false, LIGHTPRESS_PLUGIN_DIR . 'languages/' );
		add_action( 'wp_loaded', array( $this, 'jqlb_save_date' ) );

		// Frontend.
		if ( 'wp-jquery-lightbox' === self::$active_lightbox ) {
			add_action( 'wp_print_styles', array( $this, 'enqueue_css' ) );
			add_action( 'wp_print_scripts', array( $this, 'enqueue_js' ) );
			add_filter( 'the_content', array( $this, 'filter_content' ), 99 );
			add_filter( 'post_gallery', array( $this, 'filter_groups' ), 10, 2 );
			if ( get_option( 'jqlb_comments' ) === 1 ) {
				remove_filter( 'pre_comment_content', 'wp_rel_nofollow' );
				add_filter( 'comment_text', array( $this, 'lightbox_comment' ), 99 );
			}
		}

		// Admin.
		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'register_menu_items' ) );
			add_filter( 'plugin_row_meta', array( $this, 'set_plugin_meta' ), 2, 10 );
			add_action( 'admin_init', array( $this, 'register_and_add_settings' ) );
			add_action( 'admin_init', array( __CLASS__, 'add_settings_sections' ) );
			add_action( 'admin_init', array( __CLASS__, 'add_settings_fields' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
			if ( 'wp-jquery-lightbox' === self::$active_lightbox ) {
				// Removes rel-attributes to image-links added by WP.
				add_filter( 'image_send_to_editor', array( $this, 'remove_rel' ), 10, 2 );
			}
		}
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
		include LIGHTPRESS_PLUGIN_DIR . '/views/pro-landing-page.php';
	}

	/**
	 * Registers and adds settings for plugin and WP JQuery Lightbox.
	 */
	public static function register_and_add_settings() {
		// Register general settings that apply to all lightboxes.
		register_setting(
			'lightpress-settings-group',
			'lightpress_active_lightbox',
			array(
				'default'           => 'wp-jquery-lightbox',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		add_option( 'lightpress_active_lightbox', 'wp-jquery-lightbox' );

		// Register settings for WP Jquery lightbox.
		foreach ( self::$jqlb_options as $key => $setting ) {
			$id                = $setting['id'];
			$default           = isset( $setting['default'] ) ? $setting['default'] : '';
			$sanitize_callback = isset( $setting['sanitize_callback'] ) ? $setting['sanitize_callback'] : null;
			register_setting(
				'lightpress-settings-group',
				$id,
				array(
					'sanitize_callback' => $sanitize_callback,
					'show_in_rest'      => true,
					'default'           => $default,
				)
			);
			add_option( $id, $default );
		}
	}

	/**
	 * Adds settings sections for plugin and WP JQuery lightbox.
	 */
	public static function add_settings_sections() {
		// General Lightbox Settings.
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

		// WP JQuery Lightbox.
		add_settings_section(
			'wp-jquery-lightbox-settings-section', // Section ID.
			__( 'WP JQuery Lightbox: All Settings', 'wp-jquery-lightbox' ), // Section title.
			null, // Callback for top-of-section content.
			'lightpress-settings', // Page ID.
			array(
				'before_section' => '<div id="wp-jquery-lightbox-settings-section" class="wp-jquery-lightbox wp-jquery-lightbox-settings-section settings-section sub-settings-section">',
				'after_section'  => '</div>',
			)
		);
	}

	/**
	 * Add setting fields to settings page using Settings API.
	 */
	public static function add_settings_fields() {
		// "Choose Lightbox" field
		add_settings_field(
			'lightpress_active_lightbox',
			__( 'Choose Lighbox', 'easy-fancybox' ),
			array( __CLASS__, 'render_choose_lightbox_field' ),
			'lightpress-settings',
			'lightpress-general-settings-section',
			array( 'label_for' => 'lightpress_active_lightbox' )
		);

		// Fields for WP Jquery Lightbox Settings.
		foreach ( self::$jqlb_options as $key => $setting ) {
			$id    = $setting['id'];
			$title = $setting['title'] ?? '';
			add_settings_field(
				$id, // Setting ID.
				$title, // Setting label.
				array( __CLASS__, 'render_settings_fields' ), // Setting callback.
				'lightpress-settings', // Page ID.
				'wp-jquery-lightbox-settings-section', // Section ID.
				$setting
			);
		}
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
			self::$screen_id === $screen->id ||
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
	 * Enqueues JavaScript for the LightPress plugin.
	 */
	public function enqueue_js() {
		$enqueue_in_footer = get_option( 'jqlb_enqueue_in_footer' ) ? true : false;
		$version           = defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : LIGHTPRESS_VERSION;

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script(
			'wp-jquery-lightbox-swipe',
			LIGHTPRESS_PLUGIN_URL . 'jquery.touchwipe.min.js',
			array( 'jquery' ),
			$version,
			$enqueue_in_footer
		);
		wp_enqueue_script(
			'wp-jquery-lightbox-purify',
			LIGHTPRESS_PLUGIN_URL . 'inc/purify.min.js',
			array(),
			$version,
			$enqueue_in_footer
		);
		if ( get_option( 'jqlb_pinchzoom' ) === '1' ) {
			wp_enqueue_script(
				'wp-jquery-lightbox-panzoom',
				plugins_url( 'panzoom.min.js', __FILE__ ),
				array( 'jquery' ),
				$version,
				$enqueue_in_footer
			);
			wp_enqueue_script(
				'wp-jquery-lightbox',
				plugins_url( 'jquery.lightbox.js', __FILE__ ),
				array( 'jquery', 'wp-jquery-lightbox-panzoom' ),
				$version,
				$enqueue_in_footer
			);
		} else {
			wp_enqueue_script(
				'wp-jquery-lightbox',
				plugins_url( 'jquery.lightbox.js', __FILE__ ),
				array( 'jquery' ),
				$version,
				$enqueue_in_footer
			);
		}

		wp_localize_script(
			'wp-jquery-lightbox',
			'JQLBSettings',
			array(
				'showTitle'        => get_option( 'jqlb_showTitle' ),
				'useAltForTitle'   => get_option( 'jqlb_useAltForTitle' ),
				'showCaption'      => get_option( 'jqlb_showCaption' ),
				'showNumbers'      => get_option( 'jqlb_showNumbers' ),
				'fitToScreen'      => get_option( 'jqlb_resize_on_demand' ),
				'resizeSpeed'      => get_option( 'jqlb_resize_speed' ),
				'showDownload'     => get_option( 'jqlb_showDownload' ),
				'navbarOnTop'      => get_option( 'jqlb_navbarOnTop' ),
				'marginSize'       => get_option( 'jqlb_margin_size' ),
				'mobileMarginSize' => get_option( 'jqlb_mobile_margin_size' ),
				'slideshowSpeed'   => get_option( 'jqlb_slideshow_speed' ),
				'allowPinchZoom'   => get_option( 'jqlb_pinchzoom' ),
				'borderSize'       => get_option( 'jqlb_borderSize' ),
				'borderColor'      => get_option( 'jqlb_borderColor' ),
				'overlayColor'     => get_option( 'jqlb_overlayColor' ),
				'overlayOpacity'   => get_option( 'jqlb_overlayOpacity' ),
				'newNavStyle'      => get_option( 'jqlb_newNavStyle' ),
				'fixedNav'         => get_option( 'jqlb_fixedNav' ),
				'showInfoBar'      => get_option( 'jqlb_showInfoBar' ),
				'prevLinkTitle'    => __( 'previous image', 'wp-jquery-lightbox' ),
				'nextLinkTitle'    => __( 'next image', 'wp-jquery-lightbox' ),
				'closeTitle'       => __( 'close image gallery', 'wp-jquery-lightbox' ),
				'image'            => __( 'Image ', 'wp-jquery-lightbox' ),
				'of'               => __( ' of ', 'wp-jquery-lightbox' ),
				'download'         => __( 'Download', 'wp-jquery-lightbox' ),
				'pause'            => __( '(Pause Slideshow)', 'wp-jquery-lightbox' ),
				'play'             => __( '(Play Slideshow)', 'wp-jquery-lightbox' ),
			)
		);
	}

	/**
	 * Enqueues CSS for the LightPress plugin.
	 */
	public function enqueue_css() {
		$locale         = $this->get_locale();
		$file_name      = "lightbox.min.{$locale}.css";
		$have_theme_css = false;

		if ( get_option( 'jqlb_use_theme_styles' ) === 1 ) {
			$path_theme     = get_stylesheet_directory() . "/{$file_name}";
			$have_theme_css = is_readable( $path_theme );
			if ( ! $have_theme_css ) {
				$file_name      = 'lightbox.min.css';
				$path_theme     = get_stylesheet_directory() . "/{$file_name}";
				$have_theme_css = is_readable( $path_theme );
			}
		}

		if ( ! $have_theme_css ) {
			$path = plugin_dir_path( __FILE__ ) . "styles/{$file_name}";
			if ( ! is_readable( $path ) ) {
				$file_name = 'lightbox.min.css';
			}
		}
		$uri = ( $have_theme_css )
			? get_stylesheet_directory_uri() . '/' . $file_name
			: LIGHTPRESS_PLUGIN_URL . 'styles/' . $file_name;

		wp_enqueue_style(
			'jquery.lightbox.min.css',
			$uri,
			false,
			defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : LIGHTPRESS_VERSION
		);
		wp_enqueue_style(
			'jqlb-overrides',
			plugin_dir_url( __FILE__ ) . 'styles/overrides.css',
			false,
			defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : LIGHTPRESS_VERSION
		);

		// Add inline styles for new nav arrow styling.
		// Needed to apply styles to :before pseudo-selectors.
		$nav_arrow_color      = get_option( 'jqlb_navArrowColor' );
		$nav_background_color = get_option( 'jqlb_navBackgroundColor' );
		$border_width         = get_option( 'jqlb_borderSize' );
		$has_box_shadow       = get_option( 'jqlb_boxShadow' );
		$has_info_bar         = get_option( 'jqlb_showInfoBar' );
		$image_box_shadow     = $has_box_shadow ? '0 0 4px 2px rgba(0,0,0,.2)' : '';
		$infobar_box_shadow   = ( $has_box_shadow && $has_info_bar )
			? '0 -4px 0 0 #fff, 0 0 4px 2px rgba(0,0,0,.1);'
			: '';
		$custom_css           = "
			#outerImageContainer {
				box-shadow: {$image_box_shadow};
			}
			#imageContainer{
				padding: {$border_width}px;
			}
			#imageDataContainer {
				box-shadow: {$infobar_box_shadow};
			}
			#prevArrow,
			#nextArrow{
				background-color: {$nav_background_color};
				color: {$nav_arrow_color};
			}";
		wp_add_inline_style( 'jqlb-overrides', $custom_css );
	}

	/**
	 * Gets the locale for the LightPress plugin.
	 *
	 * @return string The locale.
	 */
	public function get_locale() {
		global $lang_locales;
		if ( defined( 'ICL_LANGUAGE_CODE' ) && isset( $lang_locales[ ICL_LANGUAGE_CODE ] ) ) {
			$locale = $lang_locales[ ICL_LANGUAGE_CODE ];
		} else {
			$locale = get_locale();
		}
		return $locale;
	}

	/**
	 * Filters the content for the LightPress plugin.
	 *
	 * @param string $content The content to filter.
	 * @return string The filtered content.
	 */
	public function filter_content( $content ) {
		if ( get_option( 'jqlb_automate' ) === '1' ) {
			global $post;
			$id      = isset( $post->ID ) ? $post->ID : -1;
			$content = $this->do_regexp( $content, $id );
		}
		return $content;
	}

	/**
	 * Performs a regular expression operation.
	 *
	 * @param string $content The content to perform the operation on.
	 * @param int    $id Post id.
	 * @return string The result of the operation.
	 */
	public function do_regexp( $content, $id ) {
		$id          = esc_attr( $id );
		$content     = preg_replace( '/\s+rel="attachment wp-att-[0-9]+"/i', '', $content ); // Remove WP 4.4 garbage.
		$pattern     = "/(<a(?![^>]*?rel=['\"]lightbox.*)[^>]*?href=['\"][^'\"]+?\.(?:bmp|gif|jpg|jpeg|png|webp)(\?\S{0,}){0,1}['\"][^\>]*)>/i";
		$replacement = '$1 rel="lightbox[' . $id . ']">';
		return preg_replace( $pattern, $replacement, $content );
	}

	/**
	 * Determines whether to add filter for grouping images in a gallery.
	 *
	 * Runs on the post_gallery filter.
	 *
	 * @param string $html Content to filter.
	 * @param array  $attr Array of attributes.
	 * @return string
	 */
	public function filter_groups( $html, $attr ) {
		if ( empty( $attr['group'] ) ) {
			$this->lightbox_group = -1;
			remove_filter( 'wp_get_attachment_link', array( $this, 'lightbox_gallery_links' ), 10, 1 );
		} else {
			$this->lightbox_group = $attr['group'];
			add_filter( 'wp_get_attachment_link', array( $this, 'lightbox_gallery_links' ), 10, 1 );
		}
		return '';
	}

	/**
	 * Modifies gallery links to use lightbox, honoring custom group attributes.
	 *
	 * @param  string $html Content to filter.
	 * @return string $html
	 */
	public function lightbox_gallery_links( $html ) {
		// No grouping.
		if ( ! isset( $this->lightbox_group ) || -1 === $this->lightbox_group ) {
			return $html;
		}

		// Grouping.
		return str_replace( '<a', '<a rel="lightbox[' . $this->lightbox_group . ']"', $html );
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
