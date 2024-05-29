<?php

namespace cBuilder\Classes;

class CCBAdminActions {
	private static function file_upload() {
		if ( is_array( $_FILES ) && current_user_can( 'manage_options' ) ) {
			if ( ! function_exists( 'wp_handle_upload' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}

			$file_info = wp_handle_upload( $_FILES['file'], array( 'test_form' => false ) );

			if ( ! empty( $file_info['file'] ) && str_contains( $_FILES['file']['type'], 'svg' ) ) {
				$svg_sanitizer = new \enshrined\svgSanitize\Sanitizer();
				$dirty_svg     = file_get_contents( $file_info['file'] ); //phpcs:ignore
				$clean_svg     = $svg_sanitizer->sanitize( $dirty_svg );
				file_put_contents( $file_info['file'], $clean_svg ); //phpcs:ignore
			}

			if ( empty( $file_info['error'] ) ) {
				wp_send_json_success(
					array(
						'file_url' => $file_info['url'],
						'name'     => $_FILES['file']['name'],
					)
				);
			}
		}
	}

	public static function upload_invoice_logo() {
		check_ajax_referer( 'ccb_save_invoice_logo', 'nonce' );
		self::file_upload();
	}

	public static function upload_email_logo() {
		check_ajax_referer( 'ccb_save_email_logo', 'nonce' );
		self::file_upload();
	}

	public static function upload_pickup_icon() {
		check_ajax_referer( 'ccb_save_pickup_icon', 'nonce' );
		self::file_upload();
	}

	public static function upload_marker_icon() {
		check_ajax_referer( 'ccb_save_marker_icon', 'nonce' );
		self::file_upload();
	}
}
