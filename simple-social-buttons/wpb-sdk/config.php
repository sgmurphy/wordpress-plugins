<?php

if ( ! defined( 'WPB_SDK_DIR' ) ) {
	define( 'WPB_SDK_DIR', __DIR__ );
}

if ( ! defined( 'WPB_PLUGIN_DIR' ) ) {
    define( 'WPB_PLUGIN_DIR', dirname(WPB_SDK_DIR) );
}

// if (!defined('WPB_SDK_MOD_DIR')) {
//     define('WPB_SDK_MOD_DIR', dirname(__FILE__) . '/wpb-sdk/start.php');
// }
// require_once dirname(__FILE__) . '/wpb-sdk/start.php';



if (!defined('WPB_SDK_DIR_INCLUDES')) {
    define('WPB_SDK_DIR_INCLUDES', WPB_SDK_DIR . '/includes');
}
if ( ! defined( 'WPB_SDK_API_ENDPOINT' ) ) {
	define( 'WPB_SDK_API_ENDPOINT', 'https://app.telemetry.wpbrigade.com/api/v1' );
}


// if (!defined('WPB_SDK_REMOTE_ADDR')) {
//     define('WPB_SDK_REMOTE_ADDR', wpb_get_ip());
// }
// if (!defined('WPB_SDK_DIR_TEMPLATES')) {
//     define('WPB_SDK_DIR_TEMPLATES', WPB_SDK_DIR . '/templates');
// }
// if (!defined('WPB_SDK_DIR_ASSETS')) {
//     define('WPB_SDK_DIR_ASSETS', WPB_SDK_DIR . '/assets');
// }
// if (!defined('WPB_SDK_DIR_CSS')) {
//     define('WPB_SDK_DIR_CSS', WPB_SDK_DIR_ASSETS . '/css');
// }
// if (!defined('WPB_SDK_DIR_JS')) {
//     define('WPB_SDK_DIR_JS', WPB_SDK_DIR_ASSETS . '/js');
// }
// if (!defined('WPB_SDK_DIR_IMG')) {
//     define('WPB_SDK_DIR_IMG', WPB_SDK_DIR_ASSETS . '/img');
// }
if (!defined('WPB_SDK_DIR_SDK')) {
    define('WPB_SDK_DIR_SDK', WPB_SDK_DIR_INCLUDES);
}
