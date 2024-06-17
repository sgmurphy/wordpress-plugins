<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_disabled_helpers' ) ){
	function flat_pm_disabled_helpers( $method, $meta ){

		$flat_pm_personalization = get_option( 'flat_pm_personalization' );

		$flat_pm_personalization['disabled_helpers'] = 'true';

		update_option( 'flat_pm_personalization', $flat_pm_personalization );

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">check</i> ' . __( 'Settings updated', 'flatpm_l10n' ),
				'status' => 'success'
			)
		) ) );
	}
}