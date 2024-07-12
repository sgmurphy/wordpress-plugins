<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WWP_Admin_Menu' ) ) {

    /**
     * Model that houses logic relating to caching.
     *
     * @since 2.0
     */
    class WWP_Admin_Menu {

        /**
         * Class Properties
         */

        /**
         * Property that holds the single main instance of WWP_Admin_Menu.
         *
         * @since 2.0
         * @access private
         * @var WWP_Admin_Menu
         */
        private static $_instance;

        /**
         * Class Methods
         */

        /**
         * WWP_Admin_Menu constructor.
         *
         * @since 2.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Admin_Menu model.
         */
        public function __construct( $dependencies ) {         }

        /**
         * Ensure that only one instance of WWP_Admin_Menu is loaded or can be loaded (Singleton Pattern).
         *
         * @since 2.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Admin_Menu model.
         * @return WWP_Admin_Menu
         */
        public static function instance( $dependencies ) {
            if ( ! self::$_instance instanceof self ) {
                self::$_instance = new self( $dependencies );
            }

            return self::$_instance;
        }

        /**
         * Register Wholesale Top Level Menu
         *
         * @since 2.0
         * @access public
         */
        public function register_page() {
            // Admin has access by default.
            $default_roles = array( 'administrator' );
            $saved_roles   = (array) get_option( 'wwp_roles_allowed_dashboard_access', array() );

            // Shop manager has access if not disallowed by the admin.
            if ( empty( $saved_roles ) ) {
                $default_roles[] = 'shop_manager';
            }

            /**
             * Filter to allow other roles to access the wholesale dashboard.
             * By default, only admin and shop manager can see the top level menu.
             *
             * @since 2.2.0
             *
             * @param array $allowed_roles Array of roles allowed to access the wholesale dashboard.
             * @param array $default_roles Default roles allowed to access the wholesale dashboard.
             * @return array
             */
            $allowed_roles = apply_filters(
                'wwp_roles_allowed_dashboard_access',
                array_merge( $default_roles, $saved_roles ),
            );

            $user = wp_get_current_user();

            if ( ! empty( array_intersect( (array) $user->roles, $allowed_roles ) ) ) {
                global $wc_wholesale_prices;

                $wws_icon        = WWP_IMAGES_URL . 'wholesale-suite-icon.svg';
                $dashboard_label = $wc_wholesale_prices->wwp_dashboard->is_wholesale_dashboard_disabled() ? __( 'Dashboard (Disabled)', 'woocommerce-wholesale-prices' ) : __( 'Dashboard', 'woocommerce-wholesale-prices' );

                // Wholesale Top Level Menu.
                add_menu_page( __( 'Wholesale', 'woocommerce-wholesale-prices' ), __( 'Wholesale', 'woocommerce-wholesale-prices' ), 'manage_woocommerce', 'wholesale-suite', array( $this, 'wholesale_dashboard' ), $wws_icon, '55.5' );

                // Dashboard Submenu.
                add_submenu_page( 'wholesale-suite', $dashboard_label, $dashboard_label, 'manage_woocommerce', 'wholesale-suite', array( $this, 'wholesale_dashboard' ) );

                // Reports Submenu.
                if ( WWP_Helper_Functions::is_plugin_active( 'woocommerce-wholesale-prices-premium/woocommerce-wholesale-prices-premium.bootstrap.php' ) ) {
                    add_submenu_page( 'wholesale-suite', __( 'Reports', 'woocommerce-wholesale-prices' ), __( 'Reports', 'woocommerce-wholesale-prices' ), 'manage_woocommerce', 'wholesale-reports', array( $this, 'wholesale_reports' ), 5 );
                }

                // Orders Submenu.
                add_submenu_page( 'wholesale-suite', __( 'Orders', 'woocommerce-wholesale-prices' ), __( 'Orders', 'woocommerce-wholesale-prices' ), 'manage_woocommerce', 'wholesale-orders', array( $this, 'wholesale_orders' ), 1 );

                // Settings Submenu.
                add_submenu_page( 'wholesale-suite', __( 'Settings', 'woocommerce-wholesale-prices' ), __( 'Settings', 'woocommerce-wholesale-prices' ), 'manage_woocommerce', 'wholesale-settings', array( $this, 'wholesale_settings' ), 7 );

            }
        }

        /**
         * Wholesale Dashboard react element wrapper
         *
         * @since 2.0
         * @access public
         */
        public function wholesale_dashboard() {
            do_action( 'before_wholesale-suite_submenu_page_callback' ); // phpcs:ignore

            global $wc_wholesale_prices;

            if ( $wc_wholesale_prices->wwp_dashboard->is_wholesale_dashboard_disabled() ) {
                echo '<style>#wpcontent{background:#fff;}</style>';
                echo '<div class="wrap">';
                echo '<h3 style="margin-left: 20px;">Dashboard Disabled</h3>';
                echo '</div>';
            } else {
                echo '<div class="wrap">';
                echo '<div id="wholesale-dashboard"></div>';
                echo '</div>';
            }
        }

        /**
         * Redirect Wholesale > Reports submenu to WC Reports page
         *
         * @since 2.0
         * @access public
         */
        public function wholesale_reports() {
            do_action( 'before_wholesale-reports_submenu_page_callback' ); // phpcs:ignore

            wp_safe_redirect( admin_url( 'admin.php?page=wc-reports&tab=wwpp_reports' ) );
            exit;
        }

        /**
         * Redirect Wholesale > Orders submenu to WC Orders page
         *
         * @since 2.0
         * @access public
         */
        public function wholesale_orders() {
            do_action( 'before_wholesale-orders_submenu_page_callback' ); // phpcs:ignore

            wp_safe_redirect( admin_url( 'edit.php?post_status=all&post_type=shop_order&wwpp_fbwr=all_wholesale_orders' ) );
            exit;
        }

        /**
         * Display links to old settings.
         *
         * @since 2.0
         * @access public
         */
        public function wholesale_settings() {
            do_action( 'before_wholesale-settings_submenu_page_callback' ); // phpcs:ignore

            echo '<div class="wrap">';
            echo '<div class="logo" style="padding: 20px 0;"><a href="https://wholesalesuiteplugin.com/bundle/?utm_source=wwp&utm_medium=upsell&utm_campaign=logo" target="_blank" rel="noreferrer"><img src="' . esc_url( WWP_IMAGES_URL . 'logo.png' ) . '" /></a></div>';
            echo '<div class="wp-header-end"></div>';
            echo '<h1 class="wwp-settings-heading" style="font-size: 26px; font-weight: 700;">' . esc_html__( 'Settings', 'woocommerce-wholesale-prices' ) . '</h1>';
            echo '<div id="wwp-admin-settings"></div>';
            echo '</div>';
        }

        /**
         * Integration of WC Navigation Bar.
         *
         * @since 2.0
         * @access public
         */
        public function wc_navigation_bar() {
            if ( function_exists( 'wc_admin_connect_page' ) ) {

                wc_admin_connect_page(
                    array(
                        'id'        => 'wholesale-suite-settings',
                        'screen_id' => 'wholesale_page_wholesale-settings',
                        'title'     => __( 'Settings', 'woocommerce-wholesale-prices' ),
                    )
                );

            }
        }

        /**
         * Removes admin notices displaying in the dashboard.
         *
         * @since 2.0
         * @access public
         */
        public function remove_admin_notices_in_dashboard() {
            $screen = get_current_screen();

            if ( 'toplevel_page_wholesale-suite' === $screen && $screen->id ) {
                remove_all_actions( 'admin_notices' );
            }
        }

        /*
        |-------------------------------------------------------------------------------------------------------------------
        | Execute Model
        |-------------------------------------------------------------------------------------------------------------------
         */

        /**
         * Execute model.
         *
         * @since 2.0
         * @access public
         */
        public function run() {
            add_action( 'admin_menu', array( $this, 'register_page' ), 98 );
            add_action( 'init', array( $this, 'wc_navigation_bar' ) );

            // Removes admin notices in dashboard.
            add_action( 'admin_head', array( $this, 'remove_admin_notices_in_dashboard' ), 1 );
        }
    }
}
