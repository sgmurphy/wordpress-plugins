<?php

namespace QuadLayers\QLWAPP;

use QuadLayers\QLWAPP\Models\Box as Models_Box;
use QuadLayers\QLWAPP\Models\Button as Models_Button;
use QuadLayers\QLWAPP\Models\Display as Models_Display;
use QuadLayers\QLWAPP\Models\Scheme as Models_Scheme;
use QuadLayers\QLWAPP\Models\Contacts as Models_Contacts;
use QuadLayers\QLWAPP\Services\Entity_Visibility;


class Frontend {

	protected static $instance;

	private function __construct() {
		add_action(
			'wp',
			function () {
				$is_elementor_library = isset( $_GET['post_type'] ) && 'elementor_library' === $_GET['post_type'] && isset( $_GET['render_mode'] ) && 'template-preview' === $_GET['render_mode'];

				if ( $is_elementor_library ) {
					return;
				}

				if ( is_admin() ) {
					return;
				}

				do_action( 'qlwapp_load' );
			}
		);
		add_action(
			'qlwapp_load',
			function () {
				add_action( 'wp_enqueue_scripts', array( __CLASS__, 'add_assets' ) );
				add_action( 'wp_footer', array( __CLASS__, 'add_app' ) );
			}
		);

		add_shortcode( 'whatsapp', array( __CLASS__, 'do_shortcode' ) );
	}

	public static function add_assets() {

		$frontend = include QLWAPP_PLUGIN_DIR . 'build/frontend/js/index.asset.php';

		wp_enqueue_script(
			QLWAPP_DOMAIN,
			plugins_url( '/build/frontend/js/index.js', QLWAPP_PLUGIN_FILE ),
			$frontend['dependencies'],
			$frontend['version'],
			true
		);

		wp_enqueue_style(
			QLWAPP_DOMAIN,
			plugins_url( '/build/frontend/css/style.css', QLWAPP_PLUGIN_FILE ),
			array(),
			QLWAPP_PLUGIN_VERSION
		);
	}

	public static function add_app() {
		$button  = Models_Button::instance()->get();
		$display = Models_Display::instance()->get();
		$box     = Models_Box::instance()->get();
		$scheme  = Models_Scheme::instance()->get();
		$display = Models_Display::instance()->get();

		$is_visible = Entity_Visibility::instance()->is_show_view( $display );

		if ( ! $is_visible ) {
			return;
		}

		$style = self::get_scheme_css_properties( $scheme );

		// Filter the contacts based on the display settings.
		$contacts = array_values(
			array_slice(
				array_filter(
					Models_Contacts::instance()->get_contacts_reorder(),
					function ( $contact ) {
						if ( ! isset( $contact['display'] ) ) {
							return true;
						}
						$is_visible = Entity_Visibility::instance()->is_show_view( $contact['display'] );
						return $is_visible;
					}
				),
				0,
				1
			)
		);

		$contacts = htmlentities( wp_json_encode( $contacts ), ENT_QUOTES, 'UTF-8' );
		$display  = htmlentities( wp_json_encode( $display ), ENT_QUOTES, 'UTF-8' );
		$button   = htmlentities( wp_json_encode( $button ), ENT_QUOTES, 'UTF-8' );
		$box      = htmlentities( wp_json_encode( $box ), ENT_QUOTES, 'UTF-8' );

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<div class="qlwapp" style="' . $style . '" data-contacts="' . $contacts . '" data-display="' . $display . '" data-button="' . $button . '" data-box="' . $box . '"></div>';
	}

	public static function get_scheme_css_properties( $scheme ) {
		$style = '';
		foreach ( $scheme as $key => $value ) {
			if ( is_numeric( $value ) ) {
				$value = "{$value}px";
			}
			if ( '' !== $value ) {
				$style .= sprintf( '--%s-scheme-%s:%s;', QLWAPP_DOMAIN, esc_attr( str_replace( '_', '-', $key ) ), esc_attr( $value ) );
			}
		}
		return $style;
	}

	public static function do_shortcode( $atts, $content = null ) {
			$button             = Models_Button::instance()->get();
			$button['text']     = $content;
			$button['position'] = '';
			$button['box']      = 'no';
			$button             = htmlentities( wp_json_encode( wp_parse_args( $atts, $button ) ), ENT_QUOTES, 'UTF-8' );
			$scheme             = Models_Scheme::instance()->get();
			$style              = self::get_scheme_css_properties( $scheme );
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return '<div style="' . $style . '" class="qlwapp qlwapp--shortcode" data-button="' . $button . '"></div>';
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
