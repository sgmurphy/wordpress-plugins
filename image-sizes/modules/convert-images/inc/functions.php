<?php
use WebPConvert\WebPConvert;

if( ! function_exists( 'thumbpress_convert_image_to_webp' ) ) :
function thumbpress_convert_image_to_webp( $source ) {
    $file_info      = pathinfo( $source );
    $extension      = strtolower( $file_info['extension'] );

    if( $extension === 'webp' ) return false;

    $webp_file_path = str_replace( '.' . $extension, '.webp', $source );
    $options        = [];

    WebPConvert::convert( $source, $webp_file_path, $options );

    return $webp_file_path;
}
endif;

if( ! function_exists( 'thumbpress_generate_webp_file_url' ) ) :
function thumbpress_generate_webp_file_url( $webp_file_path ) {
    // Assuming WebP file has the same directory structure and name but with a different extension
    $webp_file_path = pathinfo( $webp_file_path, PATHINFO_DIRNAME ) . '/' . pathinfo( $webp_file_path, PATHINFO_FILENAME ) . '.webp';

    // Replace the base directory path with the base URL
    $webp_file_url = str_replace( ABSPATH, home_url( '/' ), $webp_file_path );

    return $webp_file_url;
}
endif;
