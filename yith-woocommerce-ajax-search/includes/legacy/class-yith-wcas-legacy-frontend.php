<?php
/**
 * Legacy frontend class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH WooCommerce Ajax Search Premium
 * @version 1.2
 * @deprecated 2.0.0
 */

if ( ! defined( 'YITH_WCAS' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAS_Legacy_Frontend' ) ) {
	/**
	 * Admin class.
	 * The class manage all the Frontend behaviors.
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAS_Legacy_Frontend {

		/**
		 * Constructor
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {

			// custom styles and javascripts.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );

		}

		/**
		 * Enqueue styles and scripts
		 *
		 * @access public
		 * @return void
		 * @since  1.0.0
		 */
		public function enqueue_styles_scripts() {

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_register_script( 'yith_autocomplete', YITH_WCAS_URL . 'assets/js/legacy/yith-autocomplete' . $suffix . '.js', array( 'jquery' ), YITH_WCAS_VERSION, true );
			wp_register_script( 'yith_wcas_jquery-autocomplete', YITH_WCAS_URL . 'assets/js/legacy/devbridge-jquery-autocomplete' . $suffix . '.js', array( 'jquery' ), YITH_WCAS_VERSION, true );

			wp_register_script( 'yith_wcas_frontend', YITH_WCAS_URL . 'assets/js/legacy/frontend' . $suffix . '.js', array( 'jquery' ), YITH_WCAS_VERSION, true );

			wp_localize_script(
				'yith_wcas_frontend',
				'yith_wcas_params',
				array(
					'loading'  => YITH_WCAS_ASSETS_IMAGES_URL . 'ajax-loader.gif',
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				)
			);
			$css = file_exists( get_stylesheet_directory() . '/woocommerce/yith_ajax_search.css' ) ? get_stylesheet_directory_uri() . '/woocommerce/yith_ajax_search.css' : YITH_WCAS_URL . 'assets/css/legacy/yith_wcas_ajax_search.css';
			wp_register_style( 'yith_wcas_frontend', $css, array(), YITH_WCAS_VERSION );
		}
	}
}
