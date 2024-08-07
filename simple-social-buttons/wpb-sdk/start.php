<?php

/**
 * WPBrigade SDK
 *
 * @package WPB_SDK
 * @since 3.0.0
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Telemetry SDK Version.
 *
 * @var string
 */
$this_sdk_version = '3.0.0';

require_once dirname(__FILE__) . '/require.php';

if (!defined('WP_WPB__SDK_VERSION')) {
    define('WP_WPB__SDK_VERSION', $this_sdk_version);
}


if (!function_exists('wpb_dynamic_init')) {
    function wpb_dynamic_init($module)
    {
        $wpb = Logger::instance($module['id'], $module['slug'], true);
        $wpb->wpb_init($module);
        return [
            'logger' => $wpb,
            'slug' => $module['slug'],
            'id' => $module['id']
        ];
    }
}
