<?php
const AHSC_CORE = array(
	'plugin_name' => 'aruba-hispeed-cache',
    'debug'=>WP_DEBUG
);
$file=realpath(dirname(__FILE__)."/..")."/".AHSC_CORE['plugin_name'].".php";

define( "AHSC_REQUIREMENTS", array(
	'minimum_php'       => '5.6',
	'minimum_wp'        => '5.4',
	'is_legacy_pre_59'  => version_compare(get_bloginfo('version'), '5.8.22', '<='),
	'is_legacy_post_61' => version_compare(get_bloginfo('version'), '6.1.0', '>=')
) );

const  AHSC_CHECKER = array(
	'transient_name' => 'ahsc_activation_check',
	'transient_life_time' => 15 * MINUTE_IN_SECONDS,
	'request_timeout' => 15,
);

const AHSC_OPTIONS_LIST = array(
	'ahsc_enable_purge' => true,
	'ahsc_purge_homepage_on_edit' =>   true,
	'ahsc_purge_homepage_on_del' =>  true,
	'ahsc_purge_archive_on_edit' =>  true,
	'ahsc_purge_archive_on_del' =>   true,
	'ahsc_purge_archive_on_new_comment' => true, // non utilizzata
	'ahsc_purge_archive_on_deleted_comment' => true, // non utilizzata
	'ahsc_purge_page_on_mod' =>  true,
	'ahsc_purge_page_on_new_comment' => true,
	'ahsc_purge_page_on_deleted_comment' =>  true,
	'ahsc_cache_warmer' =>true,
	'ahsc_static_cache'=>true,
);

define( "AHSC_CONSTANT", array(
	'ARUBA_HISPEED_CACHE_VERSION'      => '2.0.12',
	'ARUBA_HISPEED_CACHE_PLUGIN'       => true,
	'ARUBA_HISPEED_CACHE_FILE'         => $file,
	'ARUBA_HISPEED_CACHE_BASEPATH'     => \plugin_dir_path( $file ),
	'ARUBA_HISPEED_CACHE_BASEURL'      => \plugin_dir_url( $file ),
	'ARUBA_HISPEED_CACHE_BASENAME'     => \plugin_basename( $file ),
	'ARUBA_HISPEED_CACHE_OPTIONS_NAME' => 'aruba_hispeed_cache_options',
	'HOME_URL'                         => \get_home_url( null, '/' ),
	'ARUBA_HISPEED_CACHE_OPTIONS'      => (get_site_option( 'aruba_hispeed_cache_options' ))?get_site_option( 'aruba_hispeed_cache_options' ):AHSC_OPTIONS_LIST,
) );


const AHSC_OPTIONS_LIST_DEFAULT = array(
	'ahsc_enable_purge' => array('default'=>true),
	'ahsc_purge_homepage_on_edit' =>   array('default'=>true),
	'ahsc_purge_homepage_on_del' =>   array('default'=>true),
	'ahsc_purge_archive_on_edit' =>   array('default'=>true),
	'ahsc_purge_archive_on_del' =>   array('default'=>true),
	'ahsc_purge_archive_on_new_comment' =>  array('default'=>true), // non utilizzata
	'ahsc_purge_archive_on_deleted_comment' =>   array('default'=>true), // non utilizzata
	'ahsc_purge_page_on_mod' =>  array('default'=>true),
	'ahsc_purge_page_on_new_comment' =>  array('default'=>true),
	'ahsc_purge_page_on_deleted_comment' =>   array('default'=>true),
	'ahsc_cache_warmer' => array('default'=>true),
	'ahsc_static_cache' => array('default'=>true)
);



const AHSC_PURGER = array(
	'server_host' => '127.0.0.1',
	'server_port' => '8889',
	'time_out' => 5,
);

define( "AHSC_AJAX", array(
	'security_error' => array(
		'code'    => 404,
		'message' => __( 'An error occurred. Please try again later or contact support.', 'aruba-hispeed-cache' ),
		'type'    => 'error',
	),
	'success'        => array(
		'code'    => 200,
		'message' => __( 'Cache purged.', 'aruba-hispeed-cache' ),
		'type'    => 'success',
	),
	'warning'        => array(
		'code'    => 202,
		'message' => __( 'An error occurred. Please try again later or contact support.', 'aruba-hispeed-cache' ),
		'type'    => 'warning',
	),
) );

const AHSC_LOCALIZE_LINK = array(
	'link_base' => array(
		'it' => 'https://hosting.aruba.it/',
		'en' => 'https://hosting.aruba.it/en/',
		'es' => 'https://hosting.aruba.it/es/',
	),
	'link_guide' => array(
		'it' => 'https://guide.hosting.aruba.it/hosting/cache-manager/gestione-cache.aspx',
	),
	'link_assistance' => array(
		'it' => 'https://assistenza.aruba.it/home.aspx',
		'en' => 'https://assistenza.aruba.it/en/home.aspx',
		'es' => 'https://assistenza.aruba.it/es/home.aspx',
	),
	'link_hosting_truck' => array(
		'it' => 'https://hosting.aruba.it/home.aspx?utm_source=pannello-wp&utm_medium=error-bar&utm_campain=aruba-hispeed-cache',
		'en' => 'https://hosting.aruba.it/en/home.aspx?utm_source=pannello-wp&utm_medium=error-bar&utm_campain=aruba-hispeed-cache',
		'es' => 'https://hosting.aruba.it/es/home.aspx?utm_source=pannello-wp&utm_medium=error-bar&utm_campain=aruba-hispeed-cache',
	),
	'link_aruba_pca' => array(
		'it' => 'https://admin.aruba.it/PannelloAdmin/Login.aspx?Lang=it',
		'en' => 'https://admin.aruba.it/PannelloAdmin/login.aspx?Op=ChangeLanguage&Lang=EN',
		'es' => 'https://admin.aruba.it/PannelloAdmin/login.aspx?Op=ChangeLanguage&Lang=ES',
	),
);