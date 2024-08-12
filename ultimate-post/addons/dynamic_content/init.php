<?php

defined( 'ABSPATH' ) || exit;

add_filter( 'ultp_addons_config', 'ultp_dc_config' );
function ultp_dc_config( $config ) {
	$configuration               = array(
		'name'     => __( 'Dynamic Content', 'ultimate-post' ),
		'desc'     => __( 'Insert dynamic, real-time content like excerpts, dates, author names, etc. in PostX blocks. ', 'ultimate-post' ),
		'img'      => ULTP_URL . '/assets/img/addons/dynamic-content.svg',
		'is_pro'   => false,
		'docs'     => 'https://wpxpo.com/docs/postx/postx-features/dynamic-content/',
		'live'     => 'https://www.wpxpo.com/create-custom-fields-in-wordpress/live_demo_args',
		'video'    => '',
		'position' => 6,
		'notice'   => 'ACF, Meta Box and Pods (PRO)',
		'new'      => true,
	);
	$arr['ultp_dynamic_content'] = $configuration;
	return $arr + $config;
}

function ultp_postx_addon_dynamic_content() {
	$settings = ultimate_post()->get_setting( 'ultp_dynamic_content' );
	if ( $settings == 'true' ) {
		require_once ULTP_PATH . '/addons/dynamic_content/includes/DCController.php';
		new \ULTP\DCController();
	}
}
add_action( 'init', 'ultp_postx_addon_dynamic_content' );
