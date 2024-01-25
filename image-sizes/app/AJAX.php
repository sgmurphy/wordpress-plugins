<?php
namespace Codexpert\ThumbPress\App;

use Codexpert\Plugin\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage AJAX
 * @author Codexpert <hi@codexpert.io>
 */
class AJAX extends Base {

	public $plugin;

	public $slug;

	public $name;

	public $version;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}

	/**
	 * Regenerate thumbnails
	 *
	 * @since 3.0
	 */
	public function regen_thumbs() {

		$response = [
			'status'	=> 0,
			'message'	=> __( 'Failed', 'image-sizes' ),
		];

		if( !wp_verify_nonce( $_POST['_nonce'], $this->slug ) ) {
			$response['message'] = __( 'Unauthorized', 'image-sizes' );
			wp_send_json( $response );
		}

		$offset				= $this->sanitize( $_POST['offset'] );
		$limit				= $this->sanitize( $_POST['limit'] );
		$thumbs_deleteds	= $this->sanitize( $_POST['thumbs_deleteds'] );
		$thumbs_createds	= $this->sanitize( $_POST['thumbs_createds'] );

		global $wpdb;

		$images_count = $wpdb->get_results( "SELECT `ID` FROM `$wpdb->posts` WHERE `post_type` = 'attachment' AND `post_mime_type` LIKE 'image/%'" );
		$total_images_count = count( $images_count );

		$images = $wpdb->get_results( $wpdb->prepare( "SELECT `ID` FROM `$wpdb->posts` WHERE `post_type` = 'attachment' AND `post_mime_type` LIKE 'image/%'  LIMIT %d OFFSET %d", $limit, $offset ) );

		$offsets = $offset + count( $images );

		$has_image = false;
		if ( count( $images ) > 0 ) {
			$has_image = true;
		}

		$thumbs_created = $thumbs_deleted = 0;

		foreach ( $images as $image ) {
			$image_id = $image->ID;
			$main_img = get_attached_file( $image_id );

			// remove old thumbnails first
			$old_metadata = wp_get_attachment_metadata( $image_id );
			$thumb_dir = dirname( $main_img ) . DIRECTORY_SEPARATOR;
			foreach ( $old_metadata['sizes'] as $old_size => $old_size_data ) {
				// For SVG file
				if ('image/svg+xml' == $old_size_data['mime-type']) {
					continue;
				}
				
				wp_delete_file( $thumb_dir . $old_size_data['file'] );
				$thumbs_deleted++;
			}

			// generate new thumbnails
			if ( false !== $main_img && file_exists( $main_img ) ) {
				$new_thumbs = wp_generate_attachment_metadata( $image_id, $main_img );
				wp_update_attachment_metadata( $image_id, $new_thumbs );
				$thumbs_created += count( $new_thumbs['sizes'] );
			}
		}

		$_thumbs_deleteds 	= $thumbs_deleteds + $thumbs_deleted;
		$_thumbs_createds 	= $thumbs_createds + $thumbs_created;

		$response['status'] 	= 1;
		$response['message'] 	= '<p id="cx-processed"><span class="dashicons dashicons-yes-alt cx-icon cx-success"></span>' . sprintf( __( '%d images processed', 'image-sizes' ), $offsets ) . '</p>';
		$response['message'] 	.= '<p id="cx-removed"><span class="dashicons dashicons-yes-alt cx-icon cx-success"></span>' . sprintf( __( '%d thumbnails removed', 'image-sizes' ), $_thumbs_deleteds ) . '</p>';
		$response['message'] 	.= '<p id="cx-regenerated"><span class="dashicons dashicons-yes-alt cx-icon cx-success"></span>' . sprintf( __( '%d thumbnails regenerated', 'image-sizes' ), $_thumbs_createds ) . '</p>';

		$response['counter'] 	= [
			'handled'	=> $offsets,
			'deleted'	=> $_thumbs_deleteds,
			'created'	=> $_thumbs_createds,
		];
		
		$response['offset'] 		= $offsets;
		$response['has_image'] 		= $has_image;
		$response['thumbs_deleted'] = $_thumbs_deleteds;
		$response['thumbs_created'] = $_thumbs_createds;
		$response['total_images_count'] = $total_images_count;

		wp_send_json( $response );
	}
}