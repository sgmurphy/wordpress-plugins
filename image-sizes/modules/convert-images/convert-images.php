<?php
namespace Codexpert\ThumbPress\Modules;

use Codexpert\ThumbPress\Helper;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\Settings as Settings_API;

class Convert_Images extends Base {
    public $plugin;
    public $slug;
	public $version;
	public $id = 'convert-images';

	/**
	 * Constructor
	 */
	public function __construct() {

		require_once( __DIR__ . '/inc/functions.php' );

        $this->plugin	= get_plugin_data( THUMBPRESS );
		$this->slug		= $this->plugin['TextDomain'];
		$this->version	= $this->plugin['Version'];

		$this->action( 'plugins_loaded', 'init_menu', 11 );
		$this->action( 'admin_enqueue_scripts', 'enqueue_scripts' );
        $this->filter( 'wp_handle_upload', 'convert_image_on_upload' );
		$this->filter( 'attachment_fields_to_edit', 'display_convert_image_btn', 10, 2 );
		$this->action( 'thumbpress_convert_all_image', 'convert_all_image' );

		// Ajax Hooks
		$this->priv( 'thumbpress_convert_single_image', 'convert_single_image' );
		$this->priv( 'thumbpress_schedule_image_conversion', 'schedule_image_conversion' );

		// Stop regenerating thumbnails
		$this->filter( 'intermediate_image_sizes_advanced', 'image-sizes' );
		$this->filter( 'big_image_size_threshold', 'big_image_size', 10, 1 );
	}

	public function __settings ( $settings ) {
        
        $settings['sections'][ $this->id ] = [
            'id'        => $this->id,
            'label'     => __( 'Convert to WebP', 'image-sizes' ),
            'icon'      => 'dashicons-image-rotate-left',
            'sticky'    => false,
            'fields'    => [
				[
                    'id'       => 'convert-img-on-upload',
					'label'    => __( 'Convert Image on Upload', 'image-sizes' ),
					'desc'     => __( 'Enable this if you want to convert your image to webp on upload.', 'image-sizes' ),
                    'type'     => 'switch',
                    'disabled' => false,
                ],
				[
                    'id'       => 'convert-img-one-by-one',
					'label'    => __( 'Single Image Conversion', 'image-sizes' ),
					'desc'     => __( 'Enable this if you want to convert your image to webp one by one.', 'image-sizes' ),
                    'type'     => 'switch',
                    'disabled' => false,
                ],
			],
        ];

        return $settings;
    }

	public function init_menu() {
		$actions_menu = [
			'id'            => "thumbpress-convert-images",
			'parent'        => 'thumbpress',
			'label'         => __( 'Convert to WebP', 'image-sizes' ),
			'title'         => __( 'Convert to WebP', 'image-sizes' ),
			'header'        => __( 'Convert to WebP', 'image-sizes' ),
			'sections'      => [
				'thumbpress_convert_images'	=> [
					'id'        => 'thumbpress_convert_images',
					'label'     => __( 'Convert to WebP', 'image-sizes' ),
					'icon'      => 'dashicons-image-rotate-left',
					'sticky'	=> false,
					'fields'	=> [],
					'hide_form'	=> true,
					'template'  => THUMBPRESS_DIR . '/modules/convert-images/views/actions.php',
				]
			]
		];

		new Settings_API( apply_filters( 'thumbpress_convert_images_actions_menu', $actions_menu ) );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'thumbpress-convert-images', plugins_url( 'assets/js/admin.js', __FILE__ ), [ 'jquery' ], $this->version, true );
	}

	public function convert_image_on_upload( $file_info ) {
        if( ! Helper::get_option( 'convert-images', 'convert-img-on-upload', false ) ) return $file_info;

		if( ! in_array( $file_info['type'], ['image/jpeg', 'image/jpg', 'image/png'] ) ) return $file_info;

		$original_img_path 	= $file_info['file'];
		$webp_file_path 	= thumbpress_convert_image_to_webp( $original_img_path );

		if( ! $webp_file_path ) return $file_info;

		$webp_file_url 	    = thumbpress_generate_webp_file_url( $webp_file_path );

		// delete original image
		unlink( $original_img_path );

		return [
			'file'	=> $webp_file_path,
			'url'	=> $webp_file_url,
			'type'	=> 'image/webp',
		];
	}

	public function display_convert_image_btn( $form_fields, $post ) {
		if( ! in_array( $post->post_mime_type, [ 'image/jpeg', 'image/png', 'image/jpg' ] ) ) return $form_fields;

		if( ! Helper::get_option( 'convert-images', 'convert-img-one-by-one', false ) ) return $form_fields;

		$html = sprintf( '<button id="thumbpress-convert-image" data-image_id="%1s" class="button thumbpress_img_btn" type="button"><b>%2s</b></button>', $post->ID, __( 'Convert Image', 'image-sizes' ) );

		$form_fields[ 'thumbpress_convert_image' ] = [
			'label' => sprintf( '%1s', __( 'Convert to WebP', 'image-sizes' ) ),
			'input' => 'html',
			'html'  => $html,
		];

		return $form_fields;
	}

	public function convert_all_image() {
		$images = thumbpress_get_images_by_types( [ 'image/png', 'image/jpeg', 'image/jpg' ], false );

		foreach( $images as $image ) {
			$img_id 		= $image->ID;
			$main_img 		= get_attached_file( $img_id );
			$file_info 		= pathinfo( $main_img );
			$extension 		= strtolower( $file_info['extension'] );
			$main_img 		= str_replace( "-scaled.{$extension}", ".{$extension}", $main_img );
			$webp_file_path = thumbpress_convert_image_to_webp( $main_img );

			// remove old thumbnails first
			$old_metadata 	= wp_get_attachment_metadata( $img_id );
			$thumb_dir 		= dirname( $main_img ) . DIRECTORY_SEPARATOR;
			
			foreach ( $old_metadata['sizes'] as $old_size => $old_size_data ) {
				// For SVG file
				if ( 'image/svg+xml' == $old_size_data['mime-type'] ) {
					continue;
				}
				
				// delete thumbnails
				wp_delete_file( $thumb_dir . $old_size_data['file'] );
			}

			//check scaled image
			if ( strpos( $file_info['basename'], "-scaled.{$extension}" ) !== false ) {
				// delete scaled image
				wp_delete_file( $thumb_dir . $file_info['basename'] );

				// delete original image
				wp_delete_file( $thumb_dir . str_replace( "-scaled.{$extension}", ".{$extension}", $file_info['basename'] ) );
			}
			else {
				// delete original image
				$_main_img 		= get_attached_file( $img_id );
				wp_delete_file( $_main_img );
			}

			/**
			 * Skip to the next image if conversion fails 
			 */
			if ( ! $webp_file_path ) {
				continue;
			}

			/**
			 * Load the Regenerate Thumbnails library 
			 */
			require_once ABSPATH . 'wp-admin/includes/image.php';

			$webp_metadata 		= wp_generate_attachment_metadata( $img_id, $webp_file_path );

			update_attached_file( $img_id, $webp_file_path );
			wp_update_attachment_metadata( $img_id, $webp_metadata );

			$updated_metadata 	= wp_get_attachment_metadata( $img_id );
			$file_path 			= $updated_metadata['file'];
			
			update_post_meta( $img_id, '_wp_attached_file', $file_path );

			// Update mime type
			$image_data = array(
				'ID'           		=> $img_id,
				'post_mime_type' 	=> 'image/webp',
			);

			// Update the post into the database
			wp_update_post( $image_data );
		}
	}

	public function convert_single_image() {
		$response = [
			'status'	=> 0,
			'message'	=> __( 'Failed', 'image-sizes' ),
		];

		if( ! wp_verify_nonce( $_POST['_wpnonce'], $this->slug ) ) {
			$response['message'] = __( 'Unauthorized', 'image-sizes' );
			wp_send_json_error( $response );
		}

		$img_id 		= $_POST['image_id'];
		$main_img 		= get_attached_file( $img_id );
		$file_info 		= pathinfo( $main_img );
		$extension 		= strtolower( $file_info['extension'] );
		$main_img 		= str_replace( "-scaled.{$extension}", ".{$extension}", $main_img );
		$webp_file_path = thumbpress_convert_image_to_webp( $main_img );

		// remove old thumbnails first
		$old_metadata 	= wp_get_attachment_metadata( $img_id );
		$thumb_dir 		= dirname( $main_img ) . DIRECTORY_SEPARATOR;
		
		foreach ( $old_metadata['sizes'] as $old_size => $old_size_data ) {
			// For SVG file
			if ( 'image/svg+xml' == $old_size_data['mime-type'] ) {
				continue;
			}
			
			// delete thumbnails
			wp_delete_file( $thumb_dir . $old_size_data['file'] );
		}

		//check scaled image
		if ( strpos( $file_info['basename'], "-scaled.{$extension}" ) !== false ) {
			// delete scaled image
			wp_delete_file( $thumb_dir . $file_info['basename'] );

			// delete original image
			wp_delete_file( $thumb_dir . str_replace( "-scaled.{$extension}", ".{$extension}", $file_info['basename'] ) );
		}
		else {
			// delete original image
			$_main_img 		= get_attached_file( $img_id );
			wp_delete_file( $_main_img );
		}

		if ( ! $webp_file_path ) {
			$response['message'] = __( 'Failed to convert image', 'image-sizes' );
			wp_send_json_error( $response );
		}

		// Load the Regenerate Thumbnails library
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$webp_metadata 	= wp_generate_attachment_metadata( $img_id, $webp_file_path );

		if ( empty( $webp_metadata ) ) {
			$response['message'] = __( 'Failed to update attachment metadata', 'image-sizes' );
			wp_send_json_error( $response );
		}

		update_attached_file( $img_id, $webp_file_path );
		wp_update_attachment_metadata( $img_id, $webp_metadata );

		$updated_metadata 	= wp_get_attachment_metadata( $img_id );
		$file_path 			= $updated_metadata['file'];
		
		update_post_meta( $img_id, '_wp_attached_file', $file_path );

		// Update mime type
		$image_data = array(
			'ID'           		=> $img_id,
			'post_mime_type' 	=> 'image/webp',
		);

		// Update the post into the database
		wp_update_post( $image_data );

		$response['status'] 	= 1;
		$response['message'] 	= __( 'Success', 'image-sizes' );
		wp_send_json_success( $response );
	
	}

	public function schedule_image_conversion() {
		$response = [
			'status'	=> 0,
			'message'	=> __( 'Failed', 'image-sizes' ),
		];

		if( ! wp_verify_nonce( $_POST['_wpnonce'], $this->slug ) ) {
			$response['message'] = __( 'Unauthorized', 'image-sizes' );
			wp_send_json_error( $response );
		}

		$action_id = as_schedule_single_action( wp_date( 'U' ) + 5, 'thumbpress_convert_all_image' );

		thumbpress_add_schedule_log( $this->id, $action_id );

		if( ! $action_id ) {
			$response['message'] = __( 'Failed to schedule image conversion', 'image-sizes' );
			wp_send_json_error( $response );
		}

		$response['status'] 	= 1;
		$response['message'] 	= __( 'Your images are being converted. Please wait...', 'image-sizes' );
		$response['action_id'] 	= $action_id;

		wp_send_json( $response );
	}

    public function image_sizes( $sizes ){
        $disables = Helper::get_option( 'prevent_image_sizes', 'disables', [] );

        if( count( $disables ) ) :
	        foreach( $disables as $disable ){
	            unset( $sizes[ $disable ] );
	        }
        endif;
        
        return $sizes;
    }

    public function big_image_size( $threshold ) {
    	$disables = Helper::get_option( 'prevent_image_sizes', 'disables', [] );

    	return in_array( 'scaled', $disables ) ? false : $threshold;
    }
}