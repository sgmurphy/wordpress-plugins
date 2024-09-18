<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Updates\Version_13_3_5_Update;
use AdTribes\PFP\Traits\Singleton_Trait;

/**
 * General wp-admin related functionalities and/or overrides.
 *
 * @since 13.3.3
 */
class WP_Admin extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Enqueue admin scripts.
     *
     * @since 13.3.3
     * @access public
     *
     * @param string $hook The current admin page.
     */
    public function admin_enqueue_scripts( $hook ) {
        // Enqueue scripts and styles only on the plugin pages.
        if ( Helper::is_plugin_page() ) {
            // Enqueue Jquery.
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-dialog' );
            wp_enqueue_script( 'jquery-ui-calender' );
            wp_enqueue_script( 'jquery-ui-datepicker' );
            wp_enqueue_script( 'jquery-tiptip' );
            wp_enqueue_script( 'select2' );

            wp_enqueue_style( 'woocommerce_admin_styles' );
            wp_enqueue_style( 'pfp-admin-css', WOOCOMMERCESEA_PLUGIN_URL . '/css/pfp-admin.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
            wp_enqueue_style( 'woosea_admin-css', WOOCOMMERCESEA_PLUGIN_URL . '/css/woosea_admin.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
            wp_enqueue_style( 'woosea_jquery_ui-css', WOOCOMMERCESEA_PLUGIN_URL . '/css/jquery-ui.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
            wp_enqueue_style( 'woosea_jquery_typeahead-css', WOOCOMMERCESEA_PLUGIN_URL . '/css/jquery.typeahead.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );

            if ( preg_match( '/woosea_manage_license/i', $hook ) ) {
                wp_enqueue_style( 'woosea_license_settings-css', WOOCOMMERCESEA_PLUGIN_URL . '/css/license-settings.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
            }

            // Bootstrap typeahead.
            wp_enqueue_script( 'typeahead-js', WOOCOMMERCESEA_PLUGIN_URL . '/js/woosea_typeahead.js', '', WOOCOMMERCESEA_PLUGIN_VERSION, true );

            // JS for adding input field validation.
            wp_enqueue_script( 'woosea_validation-js', WOOCOMMERCESEA_PLUGIN_URL . '/js/woosea_validation.js', '', WOOCOMMERCESEA_PLUGIN_VERSION, true );

            // JS for autocomplete.
            wp_enqueue_script( 'woosea_autocomplete-js', WOOCOMMERCESEA_PLUGIN_URL . '/js/woosea_autocomplete.js', '', WOOCOMMERCESEA_PLUGIN_VERSION, true );

            // JS for adding table rows to the rules page.
            wp_enqueue_script( 'woosea_rules-js', WOOCOMMERCESEA_PLUGIN_URL . '/js/woosea_rules.js', '', WOOCOMMERCESEA_PLUGIN_VERSION, true );

            // JS for adding table rows to the field mappings page.
            wp_enqueue_script( 'woosea_field_mapping-js', WOOCOMMERCESEA_PLUGIN_URL . '/js/woosea_field_mapping.js', '', WOOCOMMERCESEA_PLUGIN_VERSION, true );

            // JS for getting channels.
            wp_enqueue_script( 'woosea_channel-js', WOOCOMMERCESEA_PLUGIN_URL . '/js/woosea_channel.js', '', WOOCOMMERCESEA_PLUGIN_VERSION, true );

            // JS for manage projects page.
            wp_enqueue_script( 'woosea_manage-js', WOOCOMMERCESEA_PLUGIN_URL . '/js/woosea_manage.js?yo=12', array( 'clipboard' ), WOOCOMMERCESEA_PLUGIN_VERSION, true );
            wp_localize_script( 'woosea_manage-js', 'woosea_manage_params', array( 'total_product_feeds' => Product_Feed_Helper::get_total_product_feed() ) );
        }

        // Admin wide styles and scripts.
        wp_enqueue_style( 'pfp-admin-wide-css', WOOCOMMERCESEA_PLUGIN_URL . '/css/pfp-admin-wide.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
        wp_enqueue_script( 'pfp-admin-wide-js', WOOCOMMERCESEA_PLUGIN_URL . '/js/pfp-admin-wide.js', array( 'jquery' ), WOOCOMMERCESEA_PLUGIN_VERSION, true );
        wp_localize_script(
            'pfp-admin-wide-js',
            'pfp_admin_wide',
            array(
                'upgradelink' => 'https://adtribes.io/pricing/?utm_source=pfp&utm_medium=upsell&utm_campaign=menuprolink',
            )
        );
    }

    /**
     * Register about page menu
     *
     * @since 13.3.4
     * @access public
     */
    public function register_page_menu() {
        add_menu_page(
            apply_filters( 'adt_admin_plugin_page_title', __( 'Product Feed Pro for WooCommerce', 'woo-product-feed-pro' ) ),
            apply_filters( 'adt_admin_plugin_menu_title', __( 'Product Feed Pro', 'woo-product-feed-pro' ) ),
            apply_filters( 'woosea_user_cap', 'manage_options' ),
            'woo-product-feed-pro',
            array( $this, 'view_generate_pages' ),
            esc_url( WOOCOMMERCESEA_PLUGIN_URL . '/images/icon-16x16.png' ),
            99
        );

        $submenus = array(
            'create_feed'      => array(
                'page_title' => __( 'Feed configuration', 'woo-product-feed-pro' ),
                'menu_title' => __( 'Create feed', 'woo-product-feed-pro' ),
                'menu_slug'  => 'woo-product-feed-pro',
                'callback'   => array( $this, 'view_generate_pages' ),
                'position'   => 10,
            ),
            'manage_feed'      => array(
                'page_title' => __( 'Manage feeds', 'woo-product-feed-pro' ),
                'menu_title' => __( 'Manage feeds', 'woo-product-feed-pro' ),
                'menu_slug'  => 'woosea_manage_feed',
                'callback'   => array( $this, 'view_manage_feed' ),
                'position'   => 20,
            ),
            'manage_settings'  => array(
                'page_title' => __( 'Settings', 'woo-product-feed-pro' ),
                'menu_title' => __( 'Settings', 'woo-product-feed-pro' ),
                'menu_slug'  => 'woosea_manage_settings',
                'callback'   => array( $this, 'view_manage_settings' ),
                'position'   => 30,
            ),
            'manage_license'   => array(
                'page_title' => __( 'License', 'woo-product-feed-pro' ),
                'menu_title' => __( 'License', 'woo-product-feed-pro' ),
                'menu_slug'  => 'woosea_manage_license',
                'callback'   => array( $this, 'view_manage_license' ),
                'position'   => 40,
            ),
            'help_page'        => array(
                'page_title' => __( 'Help', 'woo-product-feed-pro' ),
                'menu_title' => __( 'Help', 'woo-product-feed-pro' ),
                'menu_slug'  => 'pfp-help-page',
                'callback'   => array( $this, 'view_help_page' ),
                'position'   => 50,
            ),
            'about_page'       => array(
                'page_title' => __( 'About', 'woo-product-feed-pro' ),
                'menu_title' => __( 'About', 'woo-product-feed-pro' ),
                'menu_slug'  => 'pfp-about-page',
                'callback'   => array( $this, 'view_about_page' ),
                'position'   => 60,
            ),
            'upgrade_to_elite' => array(
                'page_title' => __( 'Upgrade To Elite', 'woo-product-feed-pro' ),
                'menu_title' => __( 'Upgrade To Elite', 'woo-product-feed-pro' ),
                'menu_slug'  => 'pfp-upgrade-to-elite-page',
                'callback'   => '',
                'position'   => 70,
            ),
        );

        $this->register_submenu_pages( $submenus );
    }

    /**
     * Register submenu pages.
     *
     * @since 13.3.6
     * @access public
     *
     * @param array $submenus Array of submenu pages.
     */
    public function register_submenu_pages( $submenus ) {
        $submenus = apply_filters( 'adt_register_submenu_pages', $submenus );

        if ( empty( $submenus ) ) {
            return;
        }

        foreach ( $submenus as $submenu ) {
            add_submenu_page(
                'woo-product-feed-pro',
                $submenu['page_title'],
                $submenu['menu_title'],
                apply_filters( 'woosea_user_cap', 'manage_options' ),
                $submenu['menu_slug'],
                $submenu['callback'],
                $submenu['position']
            );
        }
    }

    /**
     * Function for serving different HTML templates while configuring the feed
     * Some cases are left blank for future steps and pages in the configurations process.
     *
     * Legacy code from the original plugin.
     *
     * @since 13.3.6
     * @access public
     */
    public function view_generate_pages() {
        do_action( 'adt_view_generate_pages' );
    }

    /**
     * View for Manage Feed page.
     *
     * @since 13.3.6
     * @access public
     */
    public function view_manage_settings() {
        require_once WOOCOMMERCESEA_VIEWS_ROOT_PATH . 'view-manage-settings.php';
    }

    /**
     * View for Manage License page.
     *
     * @since 13.3.6
     * @access public
     */
    public function view_manage_license() {
        require_once WOOCOMMERCESEA_VIEWS_ROOT_PATH . 'view-manage-license.php';
    }

    /**
     * View for Manage Settings page.
     *
     * @since 13.3.6
     * @access public
     */
    public function view_manage_feed() {
        require_once WOOCOMMERCESEA_VIEWS_ROOT_PATH . 'manage-feed/view-manage-feed.php';
    }

    /**
     * View for About page.
     *
     * @since 13.3.4
     * @access public
     */
    public function view_about_page() {
        require_once WOOCOMMERCESEA_VIEWS_ROOT_PATH . 'view-about-page.php';
    }

    /**
     * View for Help page.
     *
     * @since 13.3.4
     * @access public
     */
    public function view_help_page() {
        require_once WOOCOMMERCESEA_VIEWS_ROOT_PATH . 'view-help-page.php';
    }

    /**
     * Add WC navigation bar to page.
     *
     * @since 13.3.4
     * @access public
     */
    public function wc_navigation_bar() {
        if ( function_exists( 'wc_admin_connect_page' ) ) {
            wc_admin_connect_page(
                array(
                    'id'        => 'php-about-page',
                    'screen_id' => 'product-feed-pro_page_pfp-about-page',
                    'title'     => __( 'About Page', 'woo-product-feed-pro' ),
                )
            );

            wc_admin_connect_page(
                array(
                    'id'        => 'php-help-page',
                    'screen_id' => 'product-feed-pro_page_pfp-help-page',
                    'title'     => __( 'Help Page', 'woo-product-feed-pro' ),
                )
            );
        }
    }

    /**
     * Show lite notice bar.
     *
     * This is a notice bar that will be shown on the top of the page.
     *
     * @since 13.3.4
     * @access public
     */
    public function show_notice_bar_lite() {
        if ( Helper::is_show_notice_bar_lite() ) {
            $upgrade_link = apply_filters( 'pfp_notice_bar_lite_upgrade_link', 'https://adtribes.io/pricing/?utm_source=pfp&utm_medium=upsell&utm_campaign=litebar' );
            $message      = apply_filters(
                'adt_pfp_notice_bar_lite_message',
                sprintf(
                    // translators: %1$s and %2$s are placeholders for html tags.
                    __( 'You\'re using Product Feed Pro FREE VERSION. To unlock more features consider %1$supgrading to Elite%2$s.', 'woo-product-feed-pro' ),
                    '<a href="%s" target="_blank">',
                    '</a>'
                )
            );

            require_once WOOCOMMERCESEA_VIEWS_ROOT_PATH . 'view-notice-bar-lite.php';
        }
    }

    /**
     * Add links to the plugin page.
     *
     * @since 13.3.3
     * @access public
     *
     * @param array  $links The links to add.
     * @param string $file The plugin file.
     */
    public function plugin_action_links( $links, $file ) {
        // Check to make sure we are on the correct plugin.
        if ( WOOCOMMERCESEA_BASENAME === $file ) {
            $plugin_links[] = '<a href="' . admin_url( 'admin.php?page=woosea_manage_license' ) . '">License</a>';
            $plugin_links[] = '<a href="https://adtribes.io/support/?utm_source=pfp&utm_medium=pluginpage&utm_campaign=support" target="_blank" rel="noopener noreferrer">Support</a>';
            $plugin_links[] = '<a href="https://adtribes.io/tutorials/?utm_source=pfp&utm_medium=pluginpage&utm_campaign=tutorials" target="_blank" rel="noopener noreferrer">Tutorials</a>';
            $plugin_links[] = '<a href="' . admin_url( 'admin.php?page=woosea_manage_settings' ) . '">Settings</a>';
            $plugin_links[] = '<a href="https://adtribes.io/pricing/?utm_source=pfp&utm_medium=pluginpage&utm_campaign=goelite" target="_blank" style="color:green;" rel="noopener noreferrer"><b>Upgrade To Elite</b></a>';

            // Add the links to the list of links already there.
            foreach ( $plugin_links as $link ) {
                if ( is_array( $links ) ) {
                    array_unshift( $links, $link );
                }
            }
        }

        return $links;
    }

    /**
     * Add other settings on the plugin settings page.
     *
     * @since 13.3.7
     * @access public
     */
    public function add_other_settings() {
        $settings = array(
            array(
                'label'     => __( 'Sync Product Feed to custom post type and legacy options (Backwards compatibility)', 'woo-product-feed-pro' ),
                'btn_label' => __( 'Sync Product Feed', 'woo-product-feed-pro' ),
                'btn_id'    => 'adt_migrate_to_custom_post_type',
            ),
            array(
                'label'     => __( 'Clear custom attributes product meta keys cache', 'woo-product-feed-pro' ),
                'btn_label' => __( 'Clear custom attributes cache', 'woo-product-feed-pro' ),
                'btn_id'    => 'adt_clear_custom_attributes_product_meta_keys',
            ),
        );

        /**
         * Filter the other settings arguments.
         *
         * @since 13.3.7
         *
         * @param array $settings Array of settings.
         * @return array
         */
        $settings = apply_filters( 'adt_settings_other_settings_args', $settings );

        require_once WOOCOMMERCESEA_VIEWS_ROOT_PATH . '/settings/view-settings-other-settings.php';
    }

    /***************************************************************************
     * AJAX ACTIONS
     * **************************************************************************
     */

    /**
     * Migrate to custom post type.
     *
     * @since 13.3.5
     * @access public
     */
    public function ajax_migrate_to_custom_post_type() {
        if ( ! Product_Feed_Helper::is_current_user_allowed() ) {
            wp_send_json_error( array( 'message' => __( 'You do not have permission to perform this action.', 'woo-product-feed-pro' ) ) );
        }

        if ( ! wp_verify_nonce( $_REQUEST['security'], 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        // Run the migration.
        ( new Version_13_3_5_Update( true ) )->run();

        /**
         * Action hook to run after migrating to custom post type via settings page.
         *
         * @since 13.3.7
         */
        do_action( 'adt_after_migrate_to_custom_post_type' );

        wp_send_json_success( array( 'message' => __( 'Migration successful.', 'woo-product-feed-pro' ) ) );
    }

    /**
     * Migrate to custom post type.
     *
     * @since 13.3.5
     * @access public
     */
    public function ajax_adt_clear_custom_attributes_product_meta_keys() {
        if ( ! Product_Feed_Helper::is_current_user_allowed() ) {
            wp_send_json_error( array( 'message' => __( 'You do not have permission to perform this action.', 'woo-product-feed-pro' ) ) );
        }

        if ( ! wp_verify_nonce( $_REQUEST['security'], 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        // Clear the cache.
        if ( delete_transient( ADT_TRANSIENT_CUSTOM_ATTRIBUTES ) ) {
            wp_send_json_success( array( 'message' => __( 'Custom attributes cache cleared.', 'woo-product-feed-pro' ) ) );
        } else {
            wp_send_json_error( array( 'message' => __( 'Custom attributes cache not found.', 'woo-product-feed-pro' ) ) );
        }
    }

    /**
     * Dismiss the get Elite notification.
     *
     * @since 13.3.6
     * @access public
     **/
    public function ajax_dismiss_get_elite_notice() {
        if ( ! wp_verify_nonce( $_REQUEST['security'], 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        if ( ! Product_Feed_Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You do not have permission to do this', 'woo-product-feed-pro' ) );
        }

        if ( update_option( 'woosea_getelite_notification', 'no', false ) ) {
            wp_send_json_success( __( 'Notification dismissed', 'woo-product-feed-pro' ) );
        } else {
            wp_send_json_error( __( 'Error dismissing notification', 'woo-product-feed-pro' ) );
        }
    }

    /**
     * Run the class
     *
     * @codeCoverageIgnore
     * @since 13.3.3
     */
    public function run() {

        if ( ! is_admin() ) {
            return;
        }

        // Enqueue admin styles and scripts.
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        // Add a new submenus.
        add_action( 'admin_menu', array( $this, 'register_page_menu' ), 99 );

        // Add WC navigation bar to page.
        add_action( 'init', array( $this, 'wc_navigation_bar' ) );

        // Add notice bar.
        add_action( 'in_admin_header', array( $this, 'show_notice_bar_lite' ), 10 );

        // Add plugin action links.
        add_filter( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 2 );

        // Add other settings on the plugin settings page.
        add_action( 'adt_after_manage_settings_table', array( $this, 'add_other_settings' ) );

        // AJAX actions.
        add_action( 'wp_ajax_woosea_getelite_notification', array( $this, 'ajax_dismiss_get_elite_notice' ) );
        add_action( 'wp_ajax_adt_migrate_to_custom_post_type', array( $this, 'ajax_migrate_to_custom_post_type' ) );
        add_action( 'wp_ajax_adt_clear_custom_attributes_product_meta_keys', array( $this, 'ajax_adt_clear_custom_attributes_product_meta_keys' ) );
    }
}
