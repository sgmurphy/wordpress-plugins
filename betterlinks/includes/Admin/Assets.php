<?php

namespace BetterLinks\Admin;

class Assets
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'plugin_scripts']);
        add_action('enqueue_block_editor_assets', [$this, 'block_editor_assets']);
        add_filter( 'fluent_boards/asset_listed_slugs', function($approvedSlugs) {
            return wp_parse_args( [ 'betterlinks-intflboards' ], $approvedSlugs );
        });
    }

    /**
     * Enqueue Files on Start Plugin
     *
     * @function plugin_script
     */
    public function plugin_scripts($hook)
    {
        if (\BetterLinks\Helper::plugin_page_hook_suffix($hook)) {
            add_action(
                'wp_print_scripts',
                function () {
                    $isSkip = apply_filters('BetterLinks/Admin/skip_no_conflict', false);

                    if ($isSkip) {
                        return;
                    }

                    global $wp_scripts;
                    if (!$wp_scripts) {
                        return;
                    }

                    $pluginUrl = plugins_url();
                    foreach ($wp_scripts->queue as $script) {
                        $src = $wp_scripts->registered[$script]->src;
                        if (strpos($src, $pluginUrl) !== false && !strpos($src, BETTERLINKS_PLUGIN_SLUG) !== false) {
                            wp_dequeue_script($wp_scripts->registered[$script]->handle);
                        }
                    }
                },
                1
            );
            $dependencies = include_once BETTERLINKS_ASSETS_DIR_PATH . 'js/betterlinks.core.min.asset.php';
            wp_enqueue_style('betterlinks-admin-style', BETTERLINKS_ASSETS_URI . 'css/betterlinks.css', [], $dependencies['version'], 'all');
            wp_enqueue_script(
                'betterlinks-admin-core',
                BETTERLINKS_ASSETS_URI . 'js/betterlinks.core.min.js',
                array_merge($dependencies['dependencies'], ['regenerator-runtime']),
                $dependencies['version'],
                true
            );
            $betterlinks_links_option =  get_option('betterlinks_links');
            $prefix = !empty($betterlinks_links_option) ? $betterlinks_links_option : '';
            wp_localize_script('betterlinks-admin-core', 'betterLinksGlobal', [
                'betterlinks_nonce' => wp_create_nonce('betterlinks_admin_nonce'),
                'nonce' => wp_create_nonce('wp_rest'),
                'rest_url' => rest_url(),
                'namespace' => BETTERLINKS_PLUGIN_SLUG . '/v1/',
                'plugin_root_url' => BETTERLINKS_PLUGIN_ROOT_URI,
                'plugin_root_path' => BETTERLINKS_ROOT_DIR_PATH,
                'site_url' => apply_filters('betterlinks/site_url', site_url()),
                'route_path' => parse_url(admin_url(), PHP_URL_PATH),
                'exists_links_json' => BETTERLINKS_EXISTS_LINKS_JSON,
                'exists_clicks_json' => BETTERLINKS_EXISTS_CLICKS_JSON,
                'page' => isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '',
                'is_pro_enabled' => apply_filters('betterlinks/pro_enabled', false),
                'prefix' => $prefix,
                'betterlinkspro_version' => defined('BETTERLINKS_PRO_VERSION') ? BETTERLINKS_PRO_VERSION : null,
                'is_extra_data_tracking_compatible' => apply_filters('betterlinks/is_extra_data_tracking_compatible', false),
                'menu_notice' => defined('BETTERLINKS_MENU_NOTICE') ? BETTERLINKS_MENU_NOTICE : null,
                'betterlinks_custom_domain_menu' => get_option( BETTERLINKS_CUSTOM_DOMAIN_MENU, 0 ),
                'betterlinks_settings' => Cache::get_json_settings(),
                'betterlinks_auth' => defined('AUTH_KEY') ? md5(\AUTH_KEY) : null,
                'betterlinks_date_format' => get_option( 'date_format' ),
                'is_fbs_enabled' => defined('FLUENT_BOARDS')
            ]);

            $menu_notice = get_option('betterlinks_menu_notice', 0);
            if( defined( 'BETTERLINKS_MENU_NOTICE' ) && BETTERLINKS_MENU_NOTICE !== $menu_notice ) {
                update_option('betterlinks_menu_notice', BETTERLINKS_MENU_NOTICE);
            }
        }
        wp_set_script_translations('betterlinks-admin-core', 'betterlinks', BETTERLINKS_ROOT_DIR_PATH . 'languages/');
        wp_enqueue_style('betterlinks-admin-notice', BETTERLINKS_ASSETS_URI . 'css/betterlinks-admin-notice.css', [], BETTERLINKS_VERSION, 'all');
        
        if( 'toplevel_page_fluent-boards' == $hook ){
            $dependencies = include_once BETTERLINKS_ASSETS_DIR_PATH . 'js/betterlinks-intflboards.core.min.asset.php';
            wp_enqueue_script(
                'betterlinks-intflboards',
                BETTERLINKS_ASSETS_URI . 'js/betterlinks-intflboards.core.min.js',
                array_merge($dependencies['dependencies'], ['regenerator-runtime']),
                $dependencies['version'],
                [
                    'in_footer' => true,
                ]
            );
            $settings = Cache::get_json_settings();
            wp_localize_script('betterlinks-intflboards', 'betterLinksFlbIntegration', [
                'plugin_root_url' => BETTERLINKS_PLUGIN_ROOT_URI,
                'TASKS' => 'tasks/',
                'betterlinks_nonce' => wp_create_nonce('betterlinks_admin_nonce'),
                'site_url' => apply_filters('betterlinks/site_url', site_url()),
                'admin_url' => admin_url('/admin.php'),
                'fbs_settings' => isset($settings['fbs']) ? $settings['fbs'] : null
            ]);
            wp_enqueue_style('betterlinks-intflboards', BETTERLINKS_ASSETS_URI . 'css/integrations/btl-fbs.css', [], $dependencies['version'], 'all');
        }
    }

    /**
     * Enqueue Guten Scripts
     */
    public function block_editor_assets()
    {
        wp_enqueue_style(
            'betterlinks-gutenberg',
            BETTERLINKS_ASSETS_URI . 'css/betterlinks-gutenberg.css',
            [],
            filemtime(BETTERLINKS_ASSETS_DIR_PATH . 'css/betterlinks-gutenberg.css')
        );

        wp_enqueue_script(
            'betterlinks-gutenberg',
            BETTERLINKS_ASSETS_URI . 'js/betterlinks-gutenberg.core.min.js',
            ['wp-edit-post', 'wp-plugins', 'wp-core-data', 'wp-data', 'wp-block-editor', 'wp-editor', 'wp-components', 'wp-blocks', 'wp-keycodes', 'wp-dom', 'wp-i18n', 'wp-hooks', 'react', 'react-dom', 'regenerator-runtime'],
            filemtime(BETTERLINKS_ASSETS_DIR_PATH . 'js/betterlinks-gutenberg.core.min.js'),
            true
        );
        $betterlinks_links_option =  json_decode(get_option('betterlinks_links'), true);
        // $prefix = isset($betterlinks_links_option['prefix']) ? $betterlinks_links_option['prefix'] : '';
        wp_localize_script('betterlinks-gutenberg', 'betterLinksGlobal', [
            'post_type' => get_post_type(),
            'betterlinks_nonce' => wp_create_nonce('betterlinks_admin_nonce'),
            'nonce' => wp_create_nonce('wp_rest'),
            'rest_url' => rest_url(),
            'namespace' => BETTERLINKS_PLUGIN_SLUG . '/v1/',
            'plugin_root_url' => BETTERLINKS_PLUGIN_ROOT_URI,
            'plugin_root_path' => BETTERLINKS_ROOT_DIR_PATH,
            'site_url' => apply_filters('betterlinks/site_url', site_url()),
            'route_path' => parse_url(admin_url(), PHP_URL_PATH),
            'is_pro_enabled' => apply_filters('betterlinks/pro_enabled', false),
            'betterlinks_links_option' => $betterlinks_links_option,
        ]);
        wp_set_script_translations('betterlinks-gutenberg', 'betterlinks', BETTERLINKS_ROOT_DIR_PATH . 'languages/');
    }
}
