<?php

namespace Divi_Carousel_Lite;

use Divi_Carousel_Lite\ModulesManager;
use Divi_Carousel_Lite\AdminMenu;
use Divi_Carousel_Lite\Plugin_Upgrader;
use Divi_Carousel_Lite\AdminHelper;

class Dashboard
{
    private static $instance;

    private $plugin_menu;

    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->plugin_menu = AdminMenu::get_instance();
        add_action('admin_menu', [$this, 'add_submenu'], 11);
        add_action('admin_post_divi_carousel_lite_rollback', array($this, 'post_divi_carousel_lite_rollback'));
    }

    public function add_submenu()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        if (AdminHelper::is_pro_installed()) {
            return;
        }

        $this->plugin_menu->add_submenu(
            __('Divi Carousel Lite', 'divi-carousel-lite'),
            __('Divi Carousel Lite', 'divi-carousel-lite'),
            'divi-carousel',
            [$this, 'load_page'],
            1
        );
    }

    public function load_page()
    {
        $this->enqueue_scripts();
        echo '<div id="divi-carousel-root"></div>';
    }

    public function enqueue_scripts()
    {
        $manifest_path = DCL_PLUGIN_DIR . 'assets/mix-manifest.json';
        if (!file_exists($manifest_path)) {
            return;
        }

        $manifest_json = file_get_contents($manifest_path);
        $manifest = json_decode($manifest_json, true);

        if (!$manifest) {
            return;
        }

        $assets_url = DCL_PLUGIN_URL . 'assets';
        $app_js = $assets_url . $manifest['/admin/js/app.js'];
        $app_css = $assets_url . $manifest['/admin/css/app.css'];

        wp_enqueue_script('divi-carousel-lite-app', $app_js, $this->wp_deps(), DCL_PLUGIN_VERSION, true);
        wp_enqueue_style('divi-carousel-lite-app', $app_css, ['wp-components'], DCL_PLUGIN_VERSION);

        $module_icon_path = DCL_PLUGIN_URL . 'assets/imgs/icons';

        $localize = [
            'root' => esc_url_raw(get_rest_url()),
            'nonce' => wp_create_nonce('wp_rest'),
            'assetsPath' => esc_url_raw($assets_url),
            'version' => DCL_PLUGIN_VERSION,
            'module_info' => ModulesManager::get_all_modules(),
            'pro_module_info' => ModulesManager::get_all_pro_modules(),
            'module_icon_path' => $module_icon_path,
            'isProInstalled' => AdminHelper::is_pro_installed(),
            'upgradeLink' => dcp_fs()->get_upgrade_url(),
            'rollbackLink' => esc_url(add_query_arg('version', 'VERSION', wp_nonce_url(admin_url('admin-post.php?action=divi_carousel_lite_rollback'), 'divi_carousel_lite_rollback'))),
            'rollbackVersions' => AdminHelper::get_rollback_versions(),
            'currentVersion' => DCL_PLUGIN_VERSION,
        ];

        wp_localize_script('divi-carousel-lite-app', 'diviCarouselLite', $localize);
    }

    public function wp_deps()
    {
        return [
            'react', 'wp-api', 'wp-i18n', 'lodash', 'wp-components', 'wp-element', 'wp-api-fetch',
            'wp-core-data', 'wp-data', 'wp-dom-ready',
        ];
    }

    public function post_divi_carousel_lite_rollback()
    {
        if (!current_user_can('install_plugins')) {
            wp_die(
                esc_html__('You do not have permission to access this page.', ' divi-carousel-lite'),
                esc_html__('Rollback to Previous Version', ' divi-carousel-lite'),
                array(
                    'response' => 200,
                )
            );
        }

        check_admin_referer('divi_carousel_lite_rollback');

        $plugin_version  = isset($_GET['version']) ? sanitize_text_field($_GET['version']) : '';

        if (empty($plugin_version)) {
            wp_die(esc_html__('Error occurred, The version selected is invalid. Try selecting different version.', ' divi-carousel-lite'));
        }

        $plugin_slug = basename(DCL_PLUGIN_FILE, '.php');

        $rollback = new Plugin_Upgrader(
            array(
                'version'           => $plugin_version,
                'plugin_name'       => DCL_PLUGIN_BASE,
                'plugin_slug'       => $plugin_slug,
                'package'           => sprintf('https://downloads.wordpress.org/plugin/%s.%s.zip', $plugin_slug, $plugin_version),
            )
        );

        $rollback->run();

        wp_die(
            ' ',
            esc_html__('Rollback to Previous Version', ' divi-carousel-lite'),
            array(
                'response' => 200,
            )
        );
    }
}
