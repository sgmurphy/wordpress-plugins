<?php
namespace Codexpert\ThumbPress\Modules;

use Codexpert\ThumbPress\Helper;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\Settings as Settings_API;

class Regenerate_Thumbnails extends Base {
    public $slug;
	public $version;
	public $id = 'regenerate-thumbnails';

	/**
	 * Constructor
	 */
    public function __construct() {
        $this->plugin	= get_plugin_data( THUMBPRESS );
        $this->slug		= $this->plugin['TextDomain'];
        $this->version	= $this->plugin['Version'];

        $this->action( 'admin_enqueue_scripts', 'enqueue_scripts' );
        $this->action( 'plugins_loaded', 'init_menu', 11 );
        $this->action( 'wp_ajax_image_sizes-regen-thumbs', 'regen_thumbs' );
        $this->priv( 'thumbpress_schedule_regenerate-thumbs', 'schedule_regenerate' );
		$this->action( 'thumbpress_regenerate_all_image', 'regenerate_all_image' );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( "regenerate-thumbnails-js", plugins_url( 'js/admin.js', __FILE__), [ 'jquery' ], $this->version, true );
    }

	public function init_menu() {
		$modules_settings = [
			'id'            => "thumbpress-regenerate-thumbnails",
			'parent'        => 'thumbpress',
			'icon'      	=> 'dashicons-format-gallery',
			'label'         => __( 'Regenerate Thumbnails', 'image-sizes' ),
			'title'         => __( 'Regenerate Thumbnails', 'image-sizes' ),
			'header'        => __( 'Regenerate Thumbnails', 'image-sizes' ),
			'sections'      => [
				'regenerate-thumbnails'	=> [
					'id'        => 'regenerate-thumbnails',
					'label'     => __( 'Regenerate Thumbnails', 'image-sizes' ),
					'icon'      => 'dashicons-format-gallery',
					'sticky'	=> false,
					'fields'	=> [],
					'hide_form'	=> true,
					'template'  => apply_filters( 'thumbpress_regenerate_thumbnails_template', THUMBPRESS_DIR . '/modules/regenerate-thumbnails/views/settings.php' ),
				]
			]
		];

		new Settings_API( apply_filters( 'thumbpress-modules_optimizer_settings_args', $modules_settings ) );
	}

	public function regen_thumbs() {

		$response = [
			'status'	=> 0,
			'message'	=> __( 'Failed', 'image-sizes' ),
		];

		if( ! wp_verify_nonce( $_POST['_nonce'], $this->slug ) ) {
			$response['message'] = __( 'Unauthorized', 'image-sizes' );
			wp_send_json( $response );
		}

		$offset				= $this->sanitize( $_POST['offset'] );
		$limit				= $this->sanitize( $_POST['limit'] );
		$thumbs_deleteds	= $this->sanitize( $_POST['thumbs_deleteds'] );
		$thumbs_createds	= $this->sanitize( $_POST['thumbs_createds'] );

		global $wpdb;

		$images_count 		= $wpdb->get_results( "SELECT `ID` FROM `$wpdb->posts` WHERE `post_type` = 'attachment' AND `post_mime_type` LIKE 'image/%'" );
		$total_images_count = count( $images_count );

		$images 			= $wpdb->get_results( $wpdb->prepare( "SELECT `ID` FROM `$wpdb->posts` WHERE `post_type` = 'attachment' AND `post_mime_type` LIKE 'image/%'  LIMIT %d OFFSET %d", $limit, $offset ) );
		$offsets 			= $offset + count( $images );

		$has_image 			= false;
		if ( count( $images ) > 0 ) {
			$has_image = true;
		}

		$thumbs_created 	= $thumbs_deleted = 0;

		foreach ( $images as $image ) {
			$image_id 		= $image->ID;
			$main_img 		= get_attached_file( $image_id );
			$file_info 		= pathinfo( $main_img );
			$extension 		= strtolower( $file_info['extension'] );
			$main_img 		= str_replace( "-scaled.{$extension}", ".{$extension}", $main_img );

			// remove old thumbnails first
			$old_metadata 	= wp_get_attachment_metadata( $image_id );
			$thumb_dir 		= dirname( $main_img ) . DIRECTORY_SEPARATOR;

			foreach ( $old_metadata['sizes'] as $old_size => $old_size_data ) {
				// For SVG file
				if ( 'image/svg+xml' == $old_size_data['mime-type'] ) {
					continue;
				}
				
				wp_delete_file( $thumb_dir . $old_size_data['file'] );
				$thumbs_deleted++;
			}
			//delete scaled image
			if ( strpos( $file_info['basename'], "-scaled.{$extension}" ) !== false ) {
				wp_delete_file( $thumb_dir . $file_info['basename'] );
				$thumbs_deleted++;
			}

			// generate new thumbnails
			if ( false !== $main_img && file_exists( $main_img ) ) {
				$new_thumbs = wp_generate_attachment_metadata( $image_id, $main_img );

				wp_update_attachment_metadata( $image_id, $new_thumbs );

				$updated_metadata 	= wp_get_attachment_metadata( $image_id );
				$file_path 			= $updated_metadata['file'];
				
				update_post_meta( $image_id, '_wp_attached_file', $file_path );
				$thumbs_created += is_array( $new_thumbs['sizes'] ) ? count( $new_thumbs['sizes'] ) : 0;
			}
		}

		$_thumbs_deleteds 		= $thumbs_deleteds + $thumbs_deleted;
		$_thumbs_createds 		= $thumbs_createds + $thumbs_created;

		$response['status'] 	= 1;
		$response['message'] 	= '<p id="cx-processed"><span class="dashicons dashicons-yes-alt cx-icon cx-success"></span>' . sprintf( __( '%d images processed', 'image-sizes' ), $offsets ) . '</p>';
		$response['message'] 	.= '<p id="cx-removed"><span class="dashicons dashicons-yes-alt cx-icon cx-success"></span>' . sprintf( __( '%d thumbnails removed', 'image-sizes' ), $_thumbs_deleteds ) . '</p>';
		$response['message'] 	.= '<p id="cx-regenerated"><span class="dashicons dashicons-yes-alt cx-icon cx-success"></span>' . sprintf( __( '%d thumbnails regenerated', 'image-sizes' ), $_thumbs_createds ) . '</p>';

		$response['counter'] 	= [
			'handled'	=> $offsets,
			'deleted'	=> $_thumbs_deleteds,
			'created'	=> $_thumbs_createds,
		];
		
		$response['offset'] 			= $offsets;
		$response['has_image'] 			= $has_image;
		$response['thumbs_deleted'] 	= $_thumbs_deleteds;
		$response['thumbs_created'] 	= $_thumbs_createds;
		$response['total_images_count'] = $total_images_count;

		wp_send_json( $response );
	}
	public function schedule_regenerate() {
		$response = [
			'status'	=> 0,
			'message'	=> __( 'Failed', 'image-sizes' ),
		];

		if( ! wp_verify_nonce( $_POST['_wpnonce'], $this->slug ) ) {
			$response['message'] = __( 'Unauthorized', 'image-sizes' );
			wp_send_json_error( $response );
		}

		$action_id = as_schedule_single_action( wp_date( 'U' ) + 5, 'thumbpress_regenerate_all_image' );

		thumbpress_add_schedule_log( $this->id, $action_id );

		if( ! $action_id ) {
			$response['message'] = __( 'Failed to schedule image regeneration', 'image-sizes' );
			wp_send_json_error( $response );
		}

		$response['status'] 	= 1;
		$response['message'] 	= __( 'Your images are being regenerating. Please wait...', 'image-sizes' );
		$response['action_id'] 	= $action_id;

		wp_send_json( $response );

	}

	public function regenerate_all_image() {
		global $wpdb;
		$images = $wpdb->get_results( $wpdb->prepare( "SELECT `ID` FROM `$wpdb->posts` WHERE `post_type` = 'attachment' AND `post_mime_type` LIKE 'image/%' " ) );
		if ( count( $images ) > 0 ) {
			foreach ( $images as $image ) {
				$image_id 		= $image->ID;
				$main_img 		= get_attached_file( $image_id );
				$file_info 		= pathinfo( $main_img );
				$extension 		= strtolower( $file_info['extension'] );
				$main_img 		= str_replace( "-scaled.{$extension}", ".{$extension}", $main_img );
	
				// remove old thumbnails first
				$old_metadata 	= wp_get_attachment_metadata( $image_id );
				$thumb_dir 		= dirname( $main_img ) . DIRECTORY_SEPARATOR;
				foreach ( $old_metadata['sizes'] as $old_size => $old_size_data ) {
					// For SVG file
					if ('image/svg+xml' == $old_size_data['mime-type']) {
						continue;
					}
					
					wp_delete_file( $thumb_dir . $old_size_data['file'] );
					$thumbs_deleted++;
				}

				if ( strpos( $file_info['basename'], "-scaled.{$extension}" ) !== false ) {
					wp_delete_file( $thumb_dir . $file_info['basename'] );
					$thumbs_deleted++;
				}
	
				// generate new thumbnails
				if ( false !== $main_img && file_exists( $main_img ) ) {
					$new_thumbs = wp_generate_attachment_metadata( $image_id, $main_img );
					
					wp_update_attachment_metadata( $image_id, $new_thumbs );

					$updated_metadata 	= wp_get_attachment_metadata( $image_id );
					$file_path 			= $updated_metadata['file'];
	
					update_post_meta( $image_id, '_wp_attached_file', $file_path );

					$thumbs_created += count( $new_thumbs['sizes'] );
				}
			}
		}
	}
}