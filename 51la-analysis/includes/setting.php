<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Yaola
{
    const PRODUCT_NAME = "51LA网站统计";

    public function init()
    {
        // 注册数据、创建菜单设置界面
        register_setting(YAOLA_PRODUCT, YAOLA_PRODUCT_ID);
        register_setting(YAOLA_PRODUCT, YAOLA_PRODUCT_VERSION);
        register_setting(YAOLA_PRODUCT, YAOLA_PRODUCT_IMPORT_TYPE);
        register_setting(YAOLA_PRODUCT, YAOLA_PRODUCT_V6_EVENT);
        register_setting(YAOLA_PRODUCT, YAOLA_PRODUCT_V6_SPA);
        register_setting(YAOLA_PRODUCT, YAOLA_PRODUCT_VENDORS);
        register_setting(YAOLA_PRODUCT, YAOLA_PRODUCT_VENDORS_AK);
        register_setting(YAOLA_PRODUCT, YAOLA_PRODUCT_VENDORS_SK);
        register_setting(YAOLA_PRODUCT, YAOLA_PRODUCT_VENDORS_MODULE_ID);
        add_action("admin_menu", [$this, "createMenuPage"]);
        // 头部嵌入脚本
        add_action("wp_head", [$this, 'toInsertScript']);
    }

    public function createMenuPage()
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        add_options_page(
            esc_html__(self::PRODUCT_NAME),
            esc_html__(self::PRODUCT_NAME),
            "manage_options", "51la-analysis-settings",
            [$this, "toSettingsView"]
        );
        if (empty(trim(get_option(YAOLA_PRODUCT_VERSION))) || empty(trim(get_option(YAOLA_PRODUCT_VENDORS)))) {
            // 防止无效引入
            return;
        }
        if (trim(get_option(YAOLA_PRODUCT_VERSION)) == 'v6' && trim(get_option(YAOLA_PRODUCT_VENDORS)) == '1' ) {
            add_dashboard_page(
                esc_html__('51LA网站统计数据'),
                esc_html__('51LA统计数据'),
                "read", "51la-analysis-vendors",
                [$this, "toVendorsView"]
            );
        }
    }

    public function toSettingsView()
    {
        require_once dirname(__DIR__) . "/admin/views/settings.php";
    }

    public function toVendorsView()
    {
        require_once dirname(__DIR__) . "/admin/views/vendors.php";
    }

    public function toInsertScript()
    {
        if (is_admin()) {
            // 非管理模式
            return;
        }
        // 获取统计版本
        $YLA_Analysis_Version = trim(get_option(YAOLA_PRODUCT_VERSION));
        if (empty($YLA_Analysis_Version)) {
            // 防止无效引入
            return;
        }
        if ($YLA_Analysis_Version == 'v6') {
            // 获取引入方式
            $YLA_Import_Type = trim(get_option(YAOLA_PRODUCT_IMPORT_TYPE));
            // 获取 appid
            $YLA_Appid = trim(get_option(YAOLA_PRODUCT_ID));
            if (empty($YLA_Appid)) {
                return;
            }
            $YLA_V6_EVENT =  trim(get_option(YAOLA_PRODUCT_V6_EVENT)) ? ',autoTrack: true' : '';
            $YLA_V6_SPA =  trim(get_option(YAOLA_PRODUCT_V6_SPA)) ? ',hashMode: true' : '';
            if ($YLA_Import_Type == 'sync') {
                echo '<script charset="UTF-8" id="LA_COLLECT" src="//sdk.51.la/js-sdk-pro.min.js"></script>
                <script>LA.init({id: "' . esc_attr($YLA_Appid) . '",ck: "' . esc_attr($YLA_Appid) . '"' . esc_attr($YLA_V6_EVENT) . esc_attr($YLA_V6_SPA) . '})</script>';
            } else {
                echo '<script>!function(p){"use strict";!function(t){var s=window,e=document,i=p,c="".concat("https:"===e.location.protocol?"https://":"http://","sdk.51.la/js-sdk-pro.min.js"),n=e.createElement("script"),r=e.getElementsByTagName("script")[0];n.type="text/javascript",n.setAttribute("charset","UTF-8"),n.async=!0,n.src=c,n.id="LA_COLLECT",i.d=n;var o=function(){s.LA.ids.push(i)};s.LA?s.LA.ids&&o():(s.LA=p,s.LA.ids=[],o()),r.parentNode.insertBefore(n,r)}()}({id:"' . esc_attr($YLA_Appid) . '",ck:"' . esc_attr($YLA_Appid) . '"' . esc_attr($YLA_V6_EVENT) . esc_attr($YLA_V6_SPA) . '});</script>';
            }
        } else {
            // 获取 appid
            $YLA_Appid = trim(get_option(YAOLA_PRODUCT_ID));
            if (empty($YLA_Appid)) {
                return;
            }
            echo '<script type="text/javascript" src="https://js.users.51.la/' . esc_attr($YLA_Appid) . '.js"></script>';
        }
    }
}

?>