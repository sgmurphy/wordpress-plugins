<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fpm_migrate_3_1_06 = get_option( 'fpm_migrate_3_1_06' );
if( ! $fpm_migrate_3_1_06 ){

	$upload_dir = wp_get_upload_dir();

	$old_txt = ABSPATH . 'ip.txt';
	if( file_exists( $old_txt ) ){
		$content = file_get_contents( $old_txt );

		file_put_contents( ABSPATH . 'ip.html', $content );

		unlink( $old_txt );
	}


	$old_txt = $upload_dir['basedir'] . '/fpm/ip.txt';
	if( file_exists( $old_txt ) ){
		$content = file_get_contents( $old_txt );

		file_put_contents( ABSPATH . 'ip.html', $content );

		unlink( $old_txt );
	}

	// update_option( 'fpm_migrate_3_1_06', true );
}