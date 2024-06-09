<?php
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
require_once( ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php' );
require_once( ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php' );

if( ! function_exists( 'thumbpress_modules' ) ) :
function thumbpress_modules() {
    $modules = [
        'disable-thumbnails'     => [
            'id'                 => 'disable-thumbnails',
            'title'              => __( 'Disable Thumbnails', 'image-sizes' ),
            'desc'               => __( 'Delete and disable unnecessary thumbnails for all uploaded images in a flash.', 'image-sizes' ),
            'class'              => 'Disable_Thumbnails',
            'pro'                => false,
            'url'                => esc_url( 'https://thumbpress.co/modules/disable-thumbnails/?utm_source=in-plugin&utm_medium=Modules+Page+&utm_campaign=Disable+Thumbnails/' )
        ],
        'regenerate-thumbnails'  => [
            'id'                 => 'regenerate-thumbnails',
            'title'              => __( 'Regenerate Thumbnails', 'image-sizes' ),
            'desc'               => __( 'Regenerate previously deleted thumbnails anytime, no matter the size.', 'image-sizes' ),
            'class'              => 'Regenerate_Thumbnails',
            'pro'                => false,
            'url'                => esc_url( 'https://thumbpress.co/modules/regenerate-thumbnails/?utm_source=in-plugin&utm_medium=Modules+Page+&utm_campaign=Regenerate+Thumbnails/' )
        ],
        'detect-unused-image'    => [
            'id'                 => 'detect-unused-image',
            'title'              => __( 'Detect Unused Images', 'image-sizes' ),
            'desc'               => __( 'Find unused images & delete them from your website anytime with just one click.', 'image-sizes' ),
            'class'              => 'Detect_Unused_Image',
            'url'                => esc_url( 'https://thumbpress.co/modules/detect-unused-images/?utm_source=in-plugin&utm_medium=Modules+Page+&utm_campaign=Detect+Unused+Images/' ),
            'pro'                => true,
        ],
        'image-max-size'            => [
            'id'                    => 'image-max-size',
            'title'                 => __( 'Image Upload Limit', 'image-sizes' ),
            'desc'                  => __( 'Set a limit for maximum image upload size and resolution to speed up your website.', 'image-sizes' ),
            'class'                 => 'Image_Max_Size',
            'url'                   => esc_url( 'https://thumbpress.co/modules/image-upload-limit/?utm_source=in-plugin&utm_medium=Modules+Page+&utm_campaign=Image+Upload+Limit/' ),
            'pro'                   => false,
        ],
        'detect-large-image'     => [
            'id'                 => 'detect-large-image',
            'title'              => __( 'Detect Large Images', 'image-sizes' ),
            'desc'               => __( 'Identify and compress or delete large images to free up your website server space.', 'image-sizes' ),
            'class'              => 'Detect_Large_Image',
            'url'                => esc_url( 'https://thumbpress.co/modules/detect-large-images/?utm_source=in-plugin&utm_medium=Modules+Page+&utm_campaign=Detect+Large+Images/' ),
            'pro'                => true,
        ],
        'image-optimizer'        => [
            'id'                 => 'image-optimizer',
            'title'              => __( 'Compress Images', 'image-sizes' ),
            'desc'               => __( 'Compress your images to reduce image size, save server space, and boost page speed.', 'image-sizes' ),
            'class'              => 'Image_Optimizer',
            'url'                => esc_url( 'https://thumbpress.co/modules/compress-images/?utm_source=in-plugin&utm_medium=Modules+Page+&utm_campaign=Compress+Images/' ),
            'pro'                => true,
        ],
        'image-download-disable' => [
            'id'                 => 'image-download-disable',
            'title'              => __( 'Disable Right Click on Image', 'image-sizes' ),
            'desc'               => __( 'Prevent visitors from downloading your images by turning off the right-click option on your website.', 'image-sizes' ),
            'class'              => 'Image_Download_Disable',
            'url'                => esc_url( 'https://thumbpress.co/modules/disable-right-click/?utm_source=in-plugin&utm_medium=Modules+Page+&utm_campaign=Disable+Right+Click+/' ),
            'pro'                => false,
        ],
        'image-replace'          => [
            'id'                 => 'image-replace',
            'title'              => __( 'Replace Images With New Version', 'thumbpress' ),
            'desc'               => __( 'Upload new versions of images and replace the old ones without any issues.', 'codesigner' ),
            'class'              => 'Image_Replace',
            'url'                => esc_url( 'https://thumbpress.co/modules/replace-image-with-new-version/?utm_source=in-plugin&utm_medium=Modules+Page+&utm_campaign=Replace+Images+/' ),
            'pro'                => true,
        ],
        'social-share'           => [
            'id'                 => 'social-share',
            'title'              => __( 'Social Media Thumbnails', 'image-sizes' ),
            'desc'               => __( 'Enjoy the freedom of setting separate thumbnails for different social media channels.', 'image-sizes' ),
            'class'              => 'Social_Share',
            'url'                => esc_url( 'https://thumbpress.co/modules/set-social-media-thumbnails/?utm_source=in-plugin&utm_medium=Modules+Page+&utm_campaign=Social+Media+Thumbnails/' ),
            'pro'                => false,
        ], 
        'image-editor'           => [
            'id'                 => 'image-editor',
            'title'              => __( 'Image Editor', 'image-sizes' ),
            'desc'               => __( 'Enhance images with filters and adjustments to showcase their best versions.', 'image-sizes' ),
            'class'              => 'Image_Editor',
            'url'                => esc_url( 'https://thumbpress.co/modules/image-editor/?utm_source=in-plugin&utm_medium=Modules+Page+&utm_campaign=Image+Editor/' ),
            'pro'                => true,
        ],		               
        'convert-images'         => [
            'id'                 => 'convert-images',
            'title'              => __( 'Convert Images to WebP', 'image-sizes' ),
            'desc'               => __( 'Convert images to WebP format to retain image quality without needing to compress.', 'image-sizes' ),
            'class'              => 'Convert_Images',
            'url'                => esc_url( 'https://thumbpress.co/modules/convert-images-to-webp/?utm_source=in-plugin&utm_medium=Modules+Page+&utm_campaign=Convert+Images+to+WebP/' ),
            'pro'                => false,
        ],               
    ];

	return $modules;
}
endif;
/**
 * add last action schedule log
 * 
 */
if( ! function_exists( 'thumbpress_add_schedule_log' ) ) :
function thumbpress_add_schedule_log( $module_name, $hook_id ) {
    $log                = get_option( 'thumbpress_action_log', [] ); 
    $log[$module_name]  = $hook_id;
    update_option( 'thumbpress_action_log', $log );
}
endif;
/**
 * check the status of scheduled action
 * @return string status
 */
if ( ! function_exists('thumbpress_get_last_action_status_by_module_name') ) :
    function thumbpress_get_last_action_status_by_module_name( $module_name ) {
        $log = get_option('thumbpress_action_log', []);

        if ( isset( $log[$module_name] ) ) {
            global $wpdb;
            $tablename      = $wpdb->prefix . 'actionscheduler_actions';
            $action_id      = $log[$module_name];
            $action_status  = $wpdb->get_var($wpdb->prepare(
                "SELECT status FROM $tablename WHERE action_id = %d",
                $action_id
            ));
            return $action_status;
        }
        return false; 
    }
endif;

if ( ! function_exists( 'thubmpress_get_image_info' ) ) :
function thubmpress_get_image_info( $image_url ) {
    $image_info = [];
    $image_id   = attachment_url_to_postid( $image_url );

    if ( $image_id ) {
        $image_meta             = wp_get_attachment_metadata( $image_id );
        $image_info['width']    = isset( $image_meta['width'] ) ? $image_meta['width'] : 0;
        $image_info['height']   = isset( $image_meta['height'] ) ? $image_meta['height'] : 0;
        $image_info['alt']      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
        $image_info['type']     = wp_check_filetype( $image_url )['type'];

        return $image_info;
    }

    return false;
}
endif;

if ( ! function_exists( 'thumbpress_check_action_tables' ) ) :
function thumbpress_check_action_tables() {
    global $wpdb;

    $log_schema_table       = $wpdb->prefix . 'actionscheduler_logs';
    $store_schema_tables    = [
        $wpdb->prefix . 'actionscheduler_actions',
        $wpdb->prefix . 'actionscheduler_claims',
        $wpdb->prefix . 'actionscheduler_groups'
    ];
    
    $tables_exists = [
        'store_table_missing' => false,
        'log_table_missing'   => false
    ];
    
    // check if store tables exists
    foreach ( $store_schema_tables as $table_name ) {
        $table_exists = $wpdb->get_var( "SHOW TABLES LIKE ' $table_name '" ) === $table_name;
        
        if ( ! $table_exists ) {
            $tables_exists['store_table_missing'] = true;
            break;
        }
    }

    // check if log table exists
    $log_table_exists = $wpdb->get_var( "SHOW TABLES LIKE ' $log_schema_table '" ) === $log_schema_table;

    if ( ! $log_table_exists ) {
        $tables_exists['log_table_missing'] = true;
    }

    return $tables_exists;
}
endif;