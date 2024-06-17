<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_print_head_js' ) ){
	function flat_pm_print_head_js() {
		$flat_pm_pagespeed      = get_option( 'flat_pm_pagespeed' );
		$flat_pm_main           = get_option( 'flat_pm_main' );
		$flat_pm_advanced       = get_option( 'flat_pm_advanced' );
		$flat_pm_stylization    = get_option( 'flat_pm_stylization' );

		if( is_user_logged_in() ){
			$user = wp_get_current_user();
			$roles = (array) $user->roles;
			$role = $roles[0];
		}else{
			$role = 'not_logged_in';
		}

		$output_in_header = array(
			'timer_text'  => __( 'Close in', 'flatpm_l10n' ),
			'lazyload'    => $flat_pm_pagespeed['lazyload'],
			'threshold'   => $flat_pm_pagespeed['threshold'],
			'dublicate'   => $flat_pm_main['dublicate_adblock'],
			'rtb'         => $flat_pm_advanced['disabled_rtb'],
			'sidebar'     => $flat_pm_advanced['sidebar'],
			'selector'    => ! empty( $flat_pm_advanced['sidebar_selector'] ) ? $flat_pm_advanced['sidebar_selector'] : '.fpm_end',
			'bottom'      => ! empty( $flat_pm_advanced['sidebar_bottom'] ) ? $flat_pm_advanced['sidebar_bottom'] : '0',
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'ip_to_block' => get_home_url() . '/ip.html',
			'get_ip'      => FLATPM_URL . 'ip.php',
			'speed'       => $flat_pm_stylization['outgoing']['speed'],
			'overlay'     => isset( $flat_pm_stylization['cross']['overlay'] ) ? $flat_pm_stylization['cross']['overlay'] : 'false',
			'locale'      => explode( '_', get_locale() )[0],
			'key'         => 'U2R1elQ1TzNENElVcTF6',
			'role'        => $role
		);

		echo '<!--noptimize-->';
		echo wp_get_inline_script_tag(
			'window.fpm_settings = ' . wp_json_encode( $output_in_header ) . ';',
			array( 'data-noptimize' => '', 'data-wpfc-render' => 'false' )
		);
		echo '<!--/noptimize-->';

		include_once 'scripts.php';
	}
}


// !--sub_functions


add_action( 'wp_head', 'flat_pm_print_head_js', FLATPM_INT_MAX );
add_action( 'admin_head', 'flat_pm_print_head_js', FLATPM_INT_MAX );
?>