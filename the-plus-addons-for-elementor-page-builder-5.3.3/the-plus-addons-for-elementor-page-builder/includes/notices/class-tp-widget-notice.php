<?php
/**
 * Exit if accessed directly.
 *
 * @link       https://posimyth.com/
 * @since      5.3.3
 *
 * @package    Theplus
 * @subpackage ThePlus/Notices
 * */

namespace Tp\Notices\WidgetNotice;

/**
 * Exit if accessed directly.
 * */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Tp_Widget_Notice' ) ) {

	/**
	 * This class used for only load widget notice
	 *
	 * @since 5.3.3
	 */
	class Tp_Widget_Notice {

		/**
		 * Instance
		 *
		 * @since 5.3.3
		 * @access private
		 * @static
		 * @var instance of the class.
		 */
		private static $instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @since 5.3.3
		 * @access public
		 * @static
		 * @return instance of the class.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * Perform some compatibility checks to make sure basic requirements are meet.
		 *
		 * @since 5.2.3
		 * @version 5.3.3
		 * @access public
		 */
		public function __construct() {
			add_action( 'admin_notices', array( $this, 'tp_widget_banner_notice' ) );
			add_action( 'wp_ajax_wb_dismiss_notice', array( $this, 'tp_widget_dismiss_notice' ) );
		}

		/**
		 * New widget demos link notice
		 *
		 * @since 5.3.1
		 * @version 5.3.3
		 * @access public
		 */
		public function tp_widget_banner_notice() {
			$current_screen_id = get_current_screen()->id;

			if ( get_user_meta( get_current_user_id(), 'tp_dismissed_notice_widget', true ) ) {
				return;
			}

			if ( ! in_array( $current_screen_id, array( 'toplevel_page_tpgb_welcome_page', 'theplus-settings_page_theplus_options', 'edit-clients-listout', 'edit-plus-mega-menu', 'edit-nxt_builder', 'appearance_page_nexter_settings_welcome', 'toplevel_page_wdesign-kit', 'toplevel_page_theplus_welcome_page', 'toplevel_page_elementor', 'edit-elementor_library', 'elementor_page_elementor-system-info', 'dashboard', 'update-core', 'plugins' ), true ) ) {
				return false;
			}

			$ouput          = '';
			$ouput         .= '<div class="notice notice-info is-dismissible tpae-bf-sale" style="display:grid;grid-template-columns: 100px auto;padding-top: 25px; padding-bottom: 22px;border-left-color: #8072fc;margin-left: 0;">';
				$ouput     .= '<div style="display: flex;justify-content: center;flex-direction: row;margin: 0;padding: 0;">';
					$ouput .= '<img alt="tp-notice-blackfdy-image" src="' . esc_url( L_THEPLUS_ASSETS_URL . '/images/theplus-gif.gif' ) . '" width="74" height="74" style="grid-row: 1 / 4;align-self: center;justify-self: center;height: 100%;width: 100%;">';
				$ouput     .= '</div>';

				$ouput          .= '<div style="display: flex;flex-direction: column;margin-left: 15px;justify-content: space-between;">';
					$ouput      .= '<h2 style="margin:0;">' . esc_html__( 'Try out the Horizontal Scroll Widget for Elementor!', 'tpebl' ) . '</h2>';
						$message = sprintf(
							__( 'It comes with lots of animations and effects. Easily create a stunning full-page horizontal scrolling animation to amaze your website visitors', 'tpebl' ),
							'<strong>',
							'</strong>'
						);

						$ouput .= sprintf( '<p style="margin:0 0 2px;">%1$s</p>', $message );

						$ouput     .= '<p style="margin:0;">';
							$ouput .= '<a class="button button-primary" href="' . esc_url( '"https://theplusaddons.com/widgets/elementor-horizontal-scroll/?utm_source=wpbackend&utm_medium=banner&utm_campaign=link' ) . '" target="_blank" rel="noopener noreferrer" style="margin-right:10px;">' . esc_html__( 'Check Demos', 'tpebl' ) . '</a>';
							$ouput .= '<a class="button-dismiss" href="' . esc_url( 'https://etemplates.wdesignkit.com/theplusaddons/widgets/creative-digital-agency/?utm_source=wpbackend&utm_medium=banner&utm_campaign=links' ) . '" target="_blank" rel="noopener noreferrer" style="color: #2271b1;text-decoration: none;font-weight: 500;">' . esc_html__( 'Our Popular Demo', 'tpebl' ) . '</a>';
						$ouput     .= '</p>';
					$ouput         .= '</div>';
				$ouput             .= '</div>';

			$ouput .= '<script>;
				jQuery(document).ready(function ($) {
					$(".tpae-bf-sale.is-dismissible").on("click", ".notice-dismiss", function () {
						$.ajax({
							type: "POST",
							url: ajaxurl,
							data: {
								action: "wb_dismiss_notice",
							},
						});
					});
				});
			</script>';

			echo $ouput;
		}

		/**
		 * New widget demos link notice
		 *
		 * @since 5.3.1
		 * @version 5.3.3
		 * @access public
		 */
		public function tp_widget_dismiss_notice() {

			if ( ! is_user_logged_in() ) {
				wp_send_json_error( array( 'content' => __( 'Insufficient permissions.', 'tpebl' ) ) );
			}

			update_user_meta( get_current_user_id(), 'tp_dismissed_notice_widget', 1 );

			wp_die();
		}
	}

	Tp_Widget_Notice::instance();
}
