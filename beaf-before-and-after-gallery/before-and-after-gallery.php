<?php
/**
 * Plugin Name: BEAF - Ultimate Before After Image Slider & Gallery
 * Plugin URI: https://themefic.com/plugins/beaf/
 * Description: Would you like to show a comparison of two images? With BEAF, you can easily create before and after image sliders or galleries. Elementor Supported.
 * Version: 4.5.21
 * Author: Themefic
 * Author URI: https://themefic.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: bafg
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

//define all necessary constants
define( 'BEAF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'BEAF_VERSION', '4.5.21' );
define( 'BEAF_ADMIN_PATH', BEAF_PLUGIN_PATH . 'admin/' );
define( 'BEAF_OPTIONS_PATH', BEAF_ADMIN_PATH . 'tf-options/' );
//define assets url
define( 'BEAF_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets/' );

class BAFG_Before_After_Gallery {

	public function __construct() {

		/**
		 * Include wp plugin.php file
		 */
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		/**
		 * Include admin function file
		 */
		if ( file_exists( BEAF_ADMIN_PATH . 'inc/functions.php' ) ) {
			require_once BEAF_ADMIN_PATH . 'inc/functions.php';
		}

		/**
		 * Option framework include
		 */
		if ( file_exists( BEAF_OPTIONS_PATH . 'BEAF_Options.php' ) ) {
			require_once BEAF_OPTIONS_PATH . 'BEAF_Options.php';
		} else {
			self::beaf_file_missing( BEAF_OPTIONS_PATH . 'BEAF_Options.php' );
		}

		/*
		 * Enqueue css and js for BAFG
		 */
		add_action( 'wp_enqueue_scripts', array( $this, 'bafg_image_before_after_foucs_scripts' ), 999 );

		// Check if Elementor installed and activated
		if ( did_action( 'elementor/loaded' ) ) {
			add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'bafg_image_before_after_foucs_scripts' ) );
		}

		/*
		 * BAFG init
		 */
		add_action( 'init', array( $this, 'bafg_image_before_after_foucs_posttype' ) );

		// BEAF_PLUGIN_URL
		if ( ! defined( 'BAFG_PLUGIN_URL' ) ) {
			define( 'BAFG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		if ( ! defined( 'BAFG_PLUGIN_PATH' ) ) {
			define( 'BAFG_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
		}
 
		/*
		 * BAFG meta fields
		 */
		$this->bafg_meta_fields();

		/*
		 * Require admin file
		 */
		require_once( 'admin/bafg-admin.php' );

		/*
		 * Adding shortcode for bafg
		 */
		add_shortcode( 'bafg', array( $this, 'bafg_post_shortcode' ) );

		/*
		 * Gallery shortcode
		 */
		add_shortcode( 'bafg_gallery', array( $this, 'bafg_gallery_shortcode' ) );

		/*
		 * Submenu for pro version
		 */
		add_action( 'admin_menu', array( $this, 'bafg_register_submenu_page' ) );

		/*
		 * Require bafg wp widget
		 */
		require_once( 'inc/widget/bafg-widget.php' );

		/*
		 * Require function file
		 */
		require_once( 'inc/functions.php' );

		/*
		 * Require elementor widget
		 */
		require_once( 'inc/bafg-elementor/bafg-elementor.php' );

		/* 
		 * Filter the single_template with our custom function
		 */
		add_filter( 'single_template', array( $this, 'bafg_custom_single_template' ) );

	}

	/**
	 * File missing notice
	 * @author Abu Hena
	 * @since 5.0.0
	 */
	public static function beaf_file_missing( $files = '' ) {
		if ( is_admin() ) {
			if ( ! empty( $files ) ) {
				$class = 'notice notice-error';
				$message = '<strong>' . $files . '</strong>' . __( ' file is missing! It is required to function properly!', 'bafg' );
printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_attr($message) );

			}
		}
	}


	/**
	 * Global Admin Get Option
	 */
	public static function beaf_opt( $option = '', $default = null ) {
		$options = get_option( 'beaf_settings' );
		return ( isset( $options[ $option ] ) ) ? $options[ $option ] : $default;
	}

	/*
	 * Enqueue css and js in frontend
	 */
	public function bafg_image_before_after_foucs_scripts() {
		$version = time();

		wp_enqueue_style( 'bafg_twentytwenty', plugin_dir_url( __FILE__ ) . 'assets/css/twentytwenty.css', array(), BEAF_VERSION );
		wp_enqueue_style( 'bafg-style', plugin_dir_url( __FILE__ ) . 'assets/css/bafg-style.css', array(), BEAF_VERSION );		

		$debug_mode = is_array( get_option( 'beaf_settings' ) ) && ! empty( get_option( 'beaf_settings' )['enable_debug_mode'] ) ? get_option( 'beaf_settings' )['enable_debug_mode'] : '';

		$in_footer = false;
		if ( ! empty( $debug_mode ) ) {
			$in_footer = true;
		}

		wp_enqueue_script( 'eventMove', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.event.move.js', array( 'jquery' ), BEAF_VERSION, $in_footer );
		wp_enqueue_script( 'bafg_twentytwenty', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.twentytwenty.js', array( 'jquery', 'eventMove' ), BEAF_VERSION, $in_footer );
		wp_enqueue_script( 'bafg_custom_js', plugin_dir_url( __FILE__ ) . 'assets/js/bafg-custom-js.js', array( 'jquery', 'bafg_twentytwenty' ), BEAF_VERSION, true );

		/*
		 *  Localize the script
		 *  Return @perams
		 */
		wp_localize_script( 'bafg_custom_js', 'bafg_constant_obj',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'site_url' => plugin_dir_url( __FILE__ )
			)
		);
	}

	//register post type
	public function bafg_image_before_after_foucs_posttype() {
		$beaf_opt = ! empty( get_option( 'beaf_settings' ) ) ? get_option( 'beaf_settings' ) : '';
		$bafg_publicly_queriable = ! empty( $beaf_opt['publicly_queriable'] ) ? $beaf_opt['publicly_queriable'] : '';
		if ( $bafg_publicly_queriable == '1' ) {
			$bafg_publicly_queriable = false;
		} else {
			$bafg_publicly_queriable = true;
		}
		register_post_type( 'bafg',
			array(
				'labels' => array(
					'name' => _x( 'Before and After Slider', 'bafg' ),
					'singular_name' => _x( 'Before and After Slider', 'bafg' ),
					'add_new' => __( 'Add New', 'bafg' ),
					'add_new_item' => __( 'Add New Slider', 'bafg' ),
					'new_item' => __( 'New Slider', 'bafg' ),
					'edit_item' => __( 'Edit Slider', 'bafg' ),
					'view_item' => __( 'View Slider', 'bafg' ),
					'all_items' => __( 'All Sliders', 'bafg' ),
					'search_items' => __( 'Search Sliders', 'bafg' ),
					'not_found' => __( 'No slider found.', 'bafg' ),
					'not_found_in_trash' => __( 'No slider found in Trash.', 'bafg' ),
				),
				'public' => false,
				'publicly_queryable' => apply_filters( 'beaf_publicly_queryable', $bafg_publicly_queriable ),
				'show_ui' => true,
				'exclude_from_search' => true,
				'show_in_nav_menus' => false,
				'has_archive' => false,
				'rewrite' => false,
				'supports' => apply_filters( 'bafg_post_type_supports', array( 'title' ) ),
				'menu_icon' => 'dashicons-format-gallery'
			)
		);

		// Register Custom Taxonomy
		$labels = array(
			'name' => _x( 'Categories', 'Taxonomy General Name', 'bafg' ),
			'singular_name' => _x( 'Category', 'Taxonomy Singular Name', 'bafg' ),
			'menu_name' => __( 'Category', 'bafg' ),
			'all_items' => __( 'All Items', 'bafg' ),
			'parent_item' => __( 'Parent Item', 'bafg' ),
			'parent_item_colon' => __( 'Parent Item:', 'bafg' ),
			'new_item_name' => __( 'New Item Name', 'bafg' ),
			'add_new_item' => __( 'Add New Item', 'bafg' ),
			'edit_item' => __( 'Edit Item', 'bafg' ),
			'update_item' => __( 'Update Item', 'bafg' ),
			'view_item' => __( 'View Item', 'bafg' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'bafg' ),
			'add_or_remove_items' => __( 'Add or remove items', 'bafg' ),
			'choose_from_most_used' => __( 'Choose from the most used', 'bafg' ),
			'popular_items' => __( 'Popular Items', 'bafg' ),
			'search_items' => __( 'Search Items', 'bafg' ),
			'not_found' => __( 'Not Found', 'bafg' ),
			'no_terms' => __( 'No items', 'bafg' ),
			'items_list' => __( 'Items list', 'bafg' ),
			'items_list_navigation' => __( 'Items list navigation', 'bafg' ),
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'public' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud' => true,
		);

		register_taxonomy( 'bafg_gallery', array( 'bafg' ), $args );

	}

	/*
	 * Adding submenu for pro version
	 * Retrun @Pro Batch 
	 */
	public function bafg_register_submenu_page() {

		if ( ! is_plugin_active( 'beaf-before-and-after-gallery-pro/before-and-after-gallery-pro.php' ) ) {
			add_submenu_page(
				'edit.php?post_type=bafg',
				'Go Pro',
				'<span class="bafg-pro-link">★ Go Pro</span>',
				'manage_options',
				'https://themefic.com/plugins/beaf/pro/'
			);
		}

	}
		/*
		metabox included
		*/
		public function bafg_meta_fields() {
			require_once( 'metabox/bafg-metaboxs.php' );
		}
	/*
	 * BAFG shortcode callback
	 */
	public function bafg_post_shortcode( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'id' => ''
		), $atts ) );

		ob_start();

		$meta = ! empty( get_post_meta( $id, 'beaf_meta', true ) ) ? get_post_meta( $id, 'beaf_meta', true ) : '';

		$b_image = ! empty( $meta['bafg_before_image'] ) ? $meta['bafg_before_image'] : '';
		$a_image = ! empty( $meta['bafg_after_image'] ) ? $meta['bafg_after_image'] : '';
		$orientation = ! empty( $meta['bafg_image_styles'] ) ? $meta['bafg_image_styles'] : 'horizontal';
		$offset = ! empty( $meta['bafg_default_offset'] ) ? $meta['bafg_default_offset'] : '0.5';
		$before_label = ! empty( $meta['bafg_before_label'] ) ? $meta['bafg_before_label'] : esc_html(__('Before', 'bafg'));
		$after_label = ! empty( $meta['bafg_after_label'] ) ? $meta['bafg_after_label'] :  esc_html(__('After', 'bafg'));
		$overlay = ! empty( $meta['bafg_no_overlay'] ) ? $meta['bafg_no_overlay'] : '';
		$move_slider_on_hover = ! empty( $meta['bafg_move_slider_on_hover'] ) ? $meta['bafg_move_slider_on_hover'] : '';
		$click_to_move = ! empty( $meta['bafg_click_to_move'] ) ? $meta['bafg_click_to_move'] : '';
		$skip_lazy_load = ! empty( $meta['skip_lazy_load'] ) ? $meta['skip_lazy_load'] : '';
		$before_img_alt = ! empty( $meta['before_img_alt'] ) ? $meta['before_img_alt'] : '';
		$after_img_alt = ! empty( $meta['after_img_alt'] ) ? $meta['after_img_alt'] : '';
		if ( $skip_lazy_load == '1' ) {
			$skip_lazy = 'skip-lazy';
			$data_skip_lazy = 'data-skip-lazy';
		} else {
			$skip_lazy = '';
			$data_skip_lazy = '';
		}
		$beaf_opt = ! empty( get_option( 'beaf_settings' ) ) ? get_option( 'beaf_settings' ) : '';
		$enable_preloader = ! empty( $beaf_opt['enable_preloader'] ) ? $beaf_opt['enable_preloader'] : '';

		if ( ! empty( $meta['bafg_custom_color'] ) && $meta['bafg_custom_color'] == '1' ) {
			$bafg_custom_color = 'bafg-custom-color';
		} else {
			$bafg_custom_color = '';
		}

		if ( get_post_status( $id ) == 'publish' ) :
			?>

			<?php do_action( 'bafg_before_slider', $id ); ?>

			<div class="bafg-twentytwenty-container <?php echo esc_attr( 'slider-' . $id . '' ); ?> <?php echo esc_attr( $bafg_custom_color ) ?> "
				bafg-orientation="<?php echo esc_attr( $orientation ); ?>" bafg-default-offset="<?php echo esc_attr( $offset ); ?>"
				bafg-before-label="<?php echo esc_html( $before_label ); ?>"
				bafg-after-label="<?php echo esc_attr($after_label ); ?>"
				bafg-overlay="<?php echo esc_attr( $overlay ); ?>"
				bafg-move-slider-on-hover="<?php echo esc_attr( $move_slider_on_hover ); ?>"
				bafg-click-to-move="<?php echo esc_attr( $click_to_move ); ?>">

				<?php
				if ( is_plugin_active( 'beaf-before-and-after-gallery-pro/before-and-after-gallery-pro.php' ) ) {
					if ( ! empty( $enable_preloader ) && ! is_admin() ) {
						?>
						<!-- the preloader -->
						<div class="bafg-preloader">
							<div class="bafg-preloader-img"></div>
						</div>
						<?php
					}
				}
				?>
				<img class="<?php echo esc_attr( $skip_lazy ); ?>" <?php echo esc_attr( $data_skip_lazy ); ?>
					src="<?php echo esc_url( $b_image ); ?>" alt="<?php echo esc_attr( $before_img_alt ); ?>">
				<img class="<?php echo esc_attr( $skip_lazy ); ?>" <?php echo esc_attr( $data_skip_lazy ); ?>
					src="<?php echo esc_url( $a_image ); ?>" alt="<?php echo esc_attr( $after_img_alt ); ?>">

			</div>

			<?php do_action( 'bafg_after_slider', $id ); ?>

			<style type="text/css">
				<?php
				$bafg_before_label_background = ! empty( $meta['bafg_before_label_background'] ) ? $meta['bafg_before_label_background'] : '';
				$bafg_before_label_color = ! empty( $meta['bafg_before_label_color'] ) ? $meta['bafg_before_label_color'] : '';
				$bafg_after_label_background = ! empty( $meta['bafg_after_label_background'] ) ? $meta['bafg_after_label_background'] : '';
				$bafg_after_label_color = ! empty( $meta['bafg_after_label_color'] ) ? $meta['bafg_after_label_color'] : '';

				if ( ! empty( $bafg_before_label_background ) || ! empty( $bafg_before_label_color ) ) {
					?>
					. <?php echo esc_attr('slider-' . $id . ' '); ?>
					.twentytwenty-before-label::before {
						background:
							<?php echo esc_attr( $bafg_before_label_background );
							?>
						;
						color:
							<?php echo esc_attr( $bafg_before_label_color );
							?>
						;
					}

					<?php
				}

				?>
				<?php if ( ! empty( $bafg_after_label_background ) || ! empty( $bafg_after_label_color ) ) {
					?>
					. <?php echo esc_attr( 'slider-' . $id . ' '); ?>
					.twentytwenty-after-label::before {
						background:
							<?php echo esc_attr( $bafg_after_label_background );
							?>
						;
						color:
							<?php echo esc_attr( $bafg_after_label_color );
							?>
						;
					}

					<?php
				}

				?>
			</style>
			<?php
		endif;

		return ob_get_clean();
	}

	/*
	 * BAFG Gallery shortcode callback
	 */
	public function bafg_gallery_shortcode( $atts, $content = null ) {

		ob_start();

		extract( shortcode_atts( array(
			'category' => '',
			'column' => '',
			'items' => -1,
			'info' => ''
		), $atts ) );


		if ( $category != '' ) {

			if ( $category == 'all' ) {
				$gallery_query = new WP_Query( array(
					'post_type' => 'bafg',
					'posts_per_page' => $items,
				) );
			} else {
				$gallery_query = new WP_Query( array(
					'post_type' => 'bafg',
					'posts_per_page' => $items,
					'tax_query' => array(
						array(
							'taxonomy' => 'bafg_gallery',
							'field' => 'id',
							'terms' => $category,
						)
					),
				) );
			}

			$column = ! empty( $column ) ? $column : '2';

			switch ( $column ) {
				case "2":
					$col = '6';
					break;
				case "3":
					$col = '4';
					break;
				case "4":
					$col = '3';
					break;
				default:
					$col = '6';
			}

			?>
			<?php $gallery_id = wp_rand( 10, 200 ); ?>
			<?php if ( $info != 'true' ) : ?>
				<style>
					.bafg-gallery-row.gallery-id-

					<?php echo esc_attr( $gallery_id );

					?>
					.bafg-slider-info {
						display: none !important
					}
				</style>
			<?php endif; ?>

			<div class="bafg-row bafg-gallery-row gallery-id-<?php echo esc_attr( $gallery_id ); ?>">
				<?php
				while ( $gallery_query->have_posts() ) :
					$gallery_query->the_post();

					echo '<div class="bafg-col-' . esc_attr($col) . '">';
					echo do_shortcode( '[bafg id="' . get_the_id() . '"]' );
					echo '</div>';

				endwhile;
				?>
			</div>
			<?php
			wp_reset_postdata();
		}

		return ob_get_clean();
	}

	public function bafg_custom_single_template( $single ) {

		global $post;

		/* Checks for single template by post type */
		if ( $post->post_type == 'bafg' ) {
			if ( file_exists( plugin_dir_path( __FILE__ ) . 'inc/templates/single-bafg.php' ) ) {
				return plugin_dir_path( __FILE__ ) . 'inc/templates/single-bafg.php';
			}
		}
		return $single;
	}
}

new BAFG_Before_After_Gallery();
