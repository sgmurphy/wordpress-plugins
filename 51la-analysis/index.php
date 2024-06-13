<?php
/**
 * Plugin Name: 51la Analysis
 * Description: 51LA网站统计 WordPress 版本插件，快速引入到您的网站或博客中，用于统计网站访客、来路、事件分析和搜索引擎蜘蛛分析等，插件直接引入，无需修改主题文件。使用方式：激活插件，然后转到<a href=\"options-general.php?page=51la-analysis-settings\">设置页面</a>来填写您的 ID 即可开始使用统计。
 * Author: 51.la
 * Author URI: https://www.51.la/
 * Version: 1.1.0
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain: 51la
 */

define('YAOLA_PRODUCT', 'yaola');
define('YAOLA_PRODUCT_ID', '_51la_site_id_');
define('YAOLA_PRODUCT_VERSION', '_51la_site_version_');
define('YAOLA_PRODUCT_IMPORT_TYPE', '_51la_site_imoport_type_');
define('YAOLA_PRODUCT_V6_EVENT', '_51la_v6_event_');
define('YAOLA_PRODUCT_V6_SPA', '_51la_v6_spa_');
define('YAOLA_PRODUCT_VENDORS', '_51la_vendors_');
define('YAOLA_PRODUCT_VENDORS_AK', '_51la_vendors_ak_');
define('YAOLA_PRODUCT_VENDORS_SK', '_51la_vendors_sk_');
define('YAOLA_PRODUCT_VENDORS_MODULE_ID', '_51la_vendors_mmodule_id_');

/* 注册激活插件时要调用的函数 */
register_activation_hook( __FILE__,  'yaola_analysis_install' );

/* 注册停用插件时要调用的函数 */
register_deactivation_hook( __FILE__, 'yaola_analysis_remove' );

function yaola_analysis_install() {
    /* 在数据库的 wp_options 表中添加一条记录，第二个参数为默认值 */
    add_option( YAOLA_PRODUCT_VERSION, 'v6', '', 'yes' );
    add_option( YAOLA_PRODUCT_IMPORT_TYPE, 'sync', '', 'yes' );
    add_option( YAOLA_PRODUCT_V6_EVENT, '0', '', 'yes' );
    add_option( YAOLA_PRODUCT_V6_SPA, '0', '', 'yes' );
    add_option( YAOLA_PRODUCT_VENDORS, '0', '', 'yes' );
    add_option( YAOLA_PRODUCT_VENDORS_AK, '', '', 'yes' );
    add_option( YAOLA_PRODUCT_VENDORS_SK, '', '', 'yes' );
    add_option( YAOLA_PRODUCT_VENDORS_MODULE_ID, '', '', 'yes' );
}

function yaola_analysis_remove() {
    /* 删除 wp_options 表中的对应记录 */
    // delete_option( '' );
}

/* 入口文件 */
add_action('plugins_loaded', 'plugin_init_51la');

function plugin_init_51la()
{
    require_once __DIR__ . '/includes/setting.php';
    (new Yaola())->init();
}

?>