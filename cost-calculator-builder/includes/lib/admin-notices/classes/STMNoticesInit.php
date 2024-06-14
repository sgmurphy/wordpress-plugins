<?php

class STMNoticesInit {
	public static function init($plugin_data) {
		if ( ! class_exists( 'STMDashboard' ) ) {
			require_once __DIR__ . '/STMDashboard.php';
		}

		if ( ! class_exists( 'STMHandler' ) ) {
			require_once __DIR__ . '/STMHandler.php';
		}

		if ( ! class_exists( 'STMNotices' ) ) {
			require_once __DIR__ . '/STMNotices.php';
		}

		new STMDashboard($plugin_data);
	}
}
