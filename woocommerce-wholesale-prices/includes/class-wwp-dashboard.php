<?php
use Automattic\WooCommerce\Utilities\OrderUtil;
use RymeraWebCo\WWOF\Classes\License_Manager as WWOF_WWS_License_Manager;
use WPML\Collect\Support\Arr;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WWP_Dashboard' ) ) {

    /**
     * Model that houses logic relating to caching.
     *
     * @since 2.0
     */
    class WWP_Dashboard {


        /**
         * Class Properties.
         */

        /**
         * Property that holds the single main instance of WWP_Dashboard.
         *
         * @since 2.0
         * @access private
         * @var WWP_Dashboard
         */
        private static $_instance;

        /**
         * Model that houses the logic of retrieving information relating to wholesale role/s of a user.
         *
         * @since 2.0
         * @access private
         * @var WWP_Wholesale_Roles
         */
        private $_wwp_wholesale_roles;

        /**
         * WWPP plugin path.
         *
         * @since 2.0
         * @access private
         */
        const WWPP_PLUGIN_PATH = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'woocommerce-wholesale-prices-premium' . DIRECTORY_SEPARATOR . 'woocommerce-wholesale-prices-premium.bootstrap.php';

        /**
         * WWOF plugin path.
         *
         * @since 2.0
         * @access private
         */
        const WWOF_PLUGIN_PATH = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'woocommerce-wholesale-order-form' . DIRECTORY_SEPARATOR . 'woocommerce-wholesale-order-form.bootstrap.php';

        /**
         * WWLC plugin path.
         *
         * @since 2.0
         * @access private
         */
        const WWLC_PLUGIN_PATH = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'woocommerce-wholesale-lead-capture' . DIRECTORY_SEPARATOR . 'woocommerce-wholesale-lead-capture.bootstrap.php';

        /**
         * Total wholesale orders cache
         *
         * @since 2.0.1
         */
        const WWP_TOTAL_WHOLESALE_ORDERS_CACHE = 'wwp_total_wholesale_orders_cache';

        /**
         * Total wholesale revenue cache
         *
         * @since 2.0.1
         */
        const WWP_TOTAL_WHOLESALE_REVENUE_CACHE = 'wwp_total_wholesale_revenue_cache';

        /**
         * Top wholesale customers cache
         *
         * @since 2.0.1
         */
        const WWP_TOP_WHOLESALE_CUSTOMERS_CACHE = 'wwp_top_wholesale_customers_cache';

        /**
         * Recent wholesale orders cache
         *
         * @since 2.0.1
         */
        const WWP_RECENT_WHOLEALE_ORDERS_CACHE = 'wwp_recent_wholesale_orders_cache';

        /**
         * Wholesale user ids cache
         *
         * @since 2.0.1
         */
        const WWP_WHOLESALE_USERS_IDS_CACHE = 'wwp_wholesale_users_ids_cache';

        /**
         * Class Methods.
         */

        /**
         * WWP_Dashboard constructor.
         *
         * @since 2.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Dashboard model.
         */
        public function __construct( $dependencies ) {
            $this->_wwp_wholesale_roles = $dependencies['WWP_Wholesale_Roles'];
        }

        /**
         * Ensure that only one instance of WWP_Dashboard is loaded or can be loaded (Singleton Pattern).
         *
         * @since 2.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Dashboard model.
         * @return WWP_Dashboard
         */
        public static function instance( $dependencies ) {
            if ( ! self::$_instance instanceof self ) {
                self::$_instance = new self( $dependencies );
            }

            return self::$_instance;
        }

        /**
         * Enqueue React Scripts
         *
         * @since 2.0
         * @access public
         *
         * @param string $handle Handle of the script.
         */
        public function load_back_end_styles_and_scripts( $handle ) {
            // Don't queue scripts if dashboard is disabled via filter.
            if ( $this->is_wholesale_dashboard_disabled() ) {
                return;
            }

            if ( strpos( $handle, 'wholesale-suite' ) !== false ) {

                // Important: Must enqueue this script in order to use WP REST API via JS.
                wp_enqueue_script( 'wp-api' );

                wp_localize_script(
                    'wp-api',
                    'dashboard_options',
                    array(
                        'root'  => esc_url_raw( rest_url() ),
                        'nonce' => wp_create_nonce( 'wp_rest' ),
                    )
                );

                // React Order Form Scripts.
                $paths = array(
                    'handle'   => 'dashboard_app',
                    'dir_name' => 'dashboard-app',
                    'js_path'  => WWP_JS_PATH,
                    'js_url'   => WWP_JS_URL,
                );

                WWP_Helper_Functions::load_react_scripts( $paths );

            }
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
                        'id'        => 'wholesale-dashboard-page',
                        'screen_id' => 'toplevel_page_wholesale-suite',
                        'title'     => __( 'Dashboard', 'woocommerce-wholesale-prices' ),
                    )
                );
            }
        }

        /**
         * Dashboard menu api.
         *
         * @since 2.0
         * @access public
         */
        public function rest_api_dashboard() {
            register_rest_route(
                'wholesale/v1',
                '/dashboard',
                array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_dashboard_data' ),
					'permission_callback' => array( $this, 'permissions_check' ),
                )
            );
        }

        /**
         * Check whether the user has permission perform the request.
         *
         * @since 2.0
         *
         * @return WP_Error|boolean
         */
        public function permissions_check() {
            // Grant permission if admin or shop manager.
            if ( current_user_can( 'administrator' ) || current_user_can( 'manage_woocommerce' ) ) { // phpcs:ignore
                return true;

            }

            return new WP_Error( 'rest_cannot_view', __( 'Invalid Request.', 'woocommerce-wholesale-prices' ), array( 'status' => rest_authorization_required_code() ) );
        }

        /**
         * Get dashboard data.
         * This function handles fetches the ff:
         * - Plugin Activation response
         * - Translatable/Translation text
         * - Quick stats filter
         * - Get all data seen in the dashboard
         *
         * @since 2.0
         *
         * @param  WP_REST_Request $request Full data about the request.
         * @return WP_Error|boolean
         */
        public function get_dashboard_data( $request ) {
            $activate_plugin      = $request['activate_plugin'];
            $days_filter          = $request['daysFilter'];
            $internationalization = $request['internationalization'];

            // Plugin Activation response.
            if ( isset( $activate_plugin ) ) {

                switch ( $activate_plugin ) {
                    case 'wwof':
                        $plugin_name = __( 'WooCommerce Wholesale Order Form plugin.', 'woocommerce-wholesale-prices' );
                        break;
                    case 'wwlc':
                        $plugin_name = __( 'WooCommerce Wholesale Lead Capture plugin.', 'woocommerce-wholesale-prices' );
                        break;
                    default:
                        $plugin_name = __( 'WooCommerce Wholesale Prices Premium plugin.', 'woocommerce-wholesale-prices' );
                }

                if ( empty( $this->activate_plugin( $activate_plugin ) ) ) {
                    $response = array(
                        'status'  => 'success',
                        'message' => __( 'Successfully activated', 'woocommerce-wholesale-prices' ) . ' ' . $plugin_name,
                    );
                } else {
                    $response = array(
                        'status'  => 'error',
                        'message' => __( 'Unable to activate', 'woocommerce-wholesale-prices' ) . ' ' . $plugin_name,
                    );
                }
            } elseif ( $internationalization ) {

                // Fetch translatable/translation text.
                $response = array(
                    'internationalization' => $this->internationalization(),
                );

            } elseif ( ! empty( $days_filter ) ) {

                $start_date = $request['startDate'];
                $end_date   = $request['endDate'];

                // Filter Quick Stats.
                $response = array(
                    'quick_stats' => array(
                        'wholesale_orders'  => $this->get_total_wholesale_orders( $days_filter, $start_date, $end_date ),
                        'wholesale_revenue' => $this->get_total_wholesale_revenue( $days_filter, $start_date, $end_date ),
                    ),
                );

            } else {

                // Fetch all data in the dashboard.
                $response = array(
                    'quick_stats'             => array(
                        'wholesale_orders'  => $this->get_total_wholesale_orders(),
                        'wholesale_revenue' => $this->get_total_wholesale_revenue(),
                    ),
                    'wholesale_orders_link'   => admin_url( 'edit.php?post_status=all&post_type=shop_order&wwpp_fbwr=all_wholesale_orders' ),
                    'top_wholesale_customers' => $this->get_top_wholesale_customers(),
                    'recent_wholesale_orders' => $this->get_recent_wholesale_orders(),
                    'filter_options'          => array(
                        'options' => array(
                            '30'     => __( 'Last 30 days', 'woocommerce-wholesale-prices' ),
                            '14'     => __( 'Last 14 days', 'woocommerce-wholesale-prices' ),
                            '7'      => __( 'Last 7 days', 'woocommerce-wholesale-prices' ),
                            'year'   => __( 'Last 1 year', 'woocommerce-wholesale-prices' ),
                            'custom' => __( 'Custom', 'woocommerce-wholesale-prices' ),
                        ),
                        'default' => '30',
                    ),
                    'internationalization'    => $this->internationalization(),
                    'license_page_link'       => admin_url( 'admin.php?page=wws-license-settings' ),
                    'wws_logo'                => WWP_IMAGES_URL . 'logo.png',
                    'logo_link'               => 'https://wholesalesuiteplugin.com/bundle/?utm_source=wwp&utm_medium=upsell&utm_campaign=logo',
                    'help_resources_links'    => array(
                        'getting_started_guide_link' => 'https://wholesalesuiteplugin.com/knowledge-base-category/getting-started/?utm_source=wwp&utm_medium=wwsdashboard&utm_campaign=quicklinksgettingstarted',
                        'read_documentation_link'    => 'https://wholesalesuiteplugin.com/knowledge-base/?utm_source=wwp&utm_medium=wwsdashboard&utm_campaign=quicklinksreaddocs',
                        'settings_link'              => admin_url( 'admin.php?page=wholesale-settings' ),
                        'contact_support'            => 'https://wholesalesuiteplugin.com/support/?utm_source=wwp&utm_medium=wwsdashboard&utm_campaign=quicklinkscontactsupport',
                    ),
                    'license_statuses'        => $this->get_wws_plugins_license_statuses(),
                    'wws_plugins'             => array(
                        'wwpp' => array(
                            'key'             => 'wwpp',
                            'name'            => __( 'Wholesale Prices Premium', 'woocommerce-wholesale-prices' ),
                            'installed'       => WWP_Helper_Functions::is_wwpp_installed(),
                            'active'          => WWP_Helper_Functions::is_wwpp_active(),
                            'link'            => 'https://wholesalesuiteplugin.com/woocommerce-wholesale-prices-premium/?utm_source=wwp&utm_medium=wwsdashboard&utm_campaign=licenseboxwwpp',
                            'learn_more_link' => 'https://wholesalesuiteplugin.com/woocommerce-wholesale-prices-premium/?utm_source=wwp&utm_medium=upsell&utm_campaign=dashboardlearnmorewwpp',
                        ),
                        'wwof' => array(
                            'key'             => 'wwof',
                            'name'            => __( 'Wholesale Order Form', 'woocommerce-wholesale-prices' ),
                            'installed'       => WWP_Helper_Functions::is_wwof_installed(),
                            'active'          => WWP_Helper_Functions::is_wwof_active(),
                            'link'            => 'https://wholesalesuiteplugin.com/woocommerce-wholesale-order-form/?utm_source=wwp&utm_medium=wwsdashboard&utm_campaign=licenseboxwwof',
                            'learn_more_link' => 'https://wholesalesuiteplugin.com/woocommerce-wholesale-order-form/?utm_source=wwp&utm_medium=upsell&utm_campaign=dashboardlearnmorewwof',
                        ),
                        'wwlc' => array(
                            'key'             => 'wwlc',
                            'name'            => __( 'Wholesale Lead Capture', 'woocommerce-wholesale-prices' ),
                            'installed'       => WWP_Helper_Functions::is_wwlc_installed(),
                            'active'          => WWP_Helper_Functions::is_wwlc_active(),
                            'link'            => 'https://wholesalesuiteplugin.com/woocommerce-wholesale-lead-capture/?utm_source=wwp&utm_medium=wwsdashboard&utm_campaign=licenseboxwwlc',
                            'learn_more_link' => 'https://wholesalesuiteplugin.com/woocommerce-wholesale-lead-capture/?utm_source=wwp&utm_medium=upsell&utm_campaign=dashboardlearnmorewwlc',
                        ),
                    ),
                );

                $response = apply_filters( 'wwp_dashboard_data', $response );

            }

            return rest_ensure_response( $response );
        }

        /**
         * This function handles fetching/filtering wholesale total orders in the quick stats.
         *
         * @since 2.0
         * @access public
         *
         * @param string $days_filter Days filter.
         * @param string $start_date Start date.
         * @param string $end_date End date.
         *
         * @return int
         */
        public function get_total_wholesale_orders( $days_filter = '30', $start_date = '', $end_date = '' ) {
            $cache = get_transient( self::WWP_TOTAL_WHOLESALE_ORDERS_CACHE );

            if ( $this->enable_dashboard_cache() && ! empty( $cache ) && 30 === $days_filter ) {
                return $cache;
            }

            $date_created = '';

            switch ( $days_filter ) {
                case '14':
                    $date_created = '>' . ( time() - ( WEEK_IN_SECONDS * 2 ) );
                    break;
                case '7':
                    $date_created = '>' . ( time() - WEEK_IN_SECONDS );
                    break;
                case 'year':
                    $date_created = '>' . ( time() - YEAR_IN_SECONDS );
                    break;
                case 'custom':
                    $start_date   = strtotime( gmdate( 'Y-m-d', strtotime( $start_date ) ) );
                    $end_date     = strtotime( gmdate( 'Y-m-d', strtotime( $end_date ) ) );
                    $date_created = $start_date . '...' . $end_date;
                    break;
                default:
                    $date_created = '>' . ( time() - MONTH_IN_SECONDS );

            }

            $order_args = array(
                'status'       => array( 'wc-processing', 'wc-completed' ),
                'date_created' => $date_created,
                'return'       => 'ids',
                'limit'        => -1,
            );

            if ( OrderUtil::custom_orders_table_usage_is_enabled() ) {
                $order_args['meta_query'] = $this->_wholesale_orders_meta_query();
            } else {
                $order_args['wholesale_order'] = true;
            }

            $total_orders = wc_get_orders( $order_args );

            $total_wholesale_orders = (int) count( $total_orders );

            // Store as cache. Cache expires in 1 minute.
            if ( $this->enable_dashboard_cache() ) {
                set_transient( self::WWP_TOTAL_WHOLESALE_ORDERS_CACHE, $total_wholesale_orders, MINUTE_IN_SECONDS );
            }

            return $total_wholesale_orders;
        }

        /**
         * This function handles fetching/filtering total wholesale revenue in the quick stats.
         *
         * @since 2.0
         * @access public
         *
         * @param string $days_filter Days filter.
         * @param string $start_date Start date.
         * @param string $end_date End date.
         *
         * @return float
         */
        public function get_total_wholesale_revenue( $days_filter = '30', $start_date = '', $end_date = '' ) {
            $cache = get_transient( self::WWP_TOTAL_WHOLESALE_REVENUE_CACHE );

            if ( $this->enable_dashboard_cache() && ! empty( $cache ) && 30 === $days_filter ) {
                return $cache;
            }

            $wholesale_customer_total_spent = 0;

            $date_created = '';

            switch ( $days_filter ) {
                case '14':
                    $date_created = '>' . ( time() - ( WEEK_IN_SECONDS * 2 ) );
                    break;
                case '7':
                    $date_created = '>' . ( time() - WEEK_IN_SECONDS );
                    break;
                case 'year':
                    $date_created = '>' . ( time() - YEAR_IN_SECONDS );
                    break;
                case 'custom':
                    $start_date   = strtotime( gmdate( 'Y-m-d', strtotime( $start_date ) ) );
                    $end_date     = strtotime( gmdate( 'Y-m-d', strtotime( $end_date ) ) );
                    $date_created = $start_date . '...' . $end_date;
                    break;
                default:
                    $date_created = '>' . ( time() - MONTH_IN_SECONDS );

            }

            $date_created = apply_filters( 'wwp_dashboard_days_filter', $date_created, $days_filter );

            $order_args = array(
                'status'       => array( 'wc-processing', 'wc-completed' ),
                'date_created' => $date_created,
                'limit'        => -1,
            );

            if ( OrderUtil::custom_orders_table_usage_is_enabled() ) {
                $order_args['meta_query'] = $this->_wholesale_orders_meta_query();
            } else {
                $order_args['wholesale_order'] = true;
            }

            $orders = wc_get_orders( $order_args );

            if ( $orders ) {
                foreach ( $orders as $order ) {
                    $wholesale_customer_total_spent += $order->get_total();
                }
            }

            $total_revenue = wc_price( $wholesale_customer_total_spent );

            // Store as cache. Cache expires in 1 week.
            if ( $this->enable_dashboard_cache() ) {
                set_transient( self::WWP_TOTAL_WHOLESALE_REVENUE_CACHE, $total_revenue, WEEK_IN_SECONDS );
            }

            return $total_revenue;
        }

        /**
         * This function checks for wholesale customers who paid for the orders.
         * This uses wc_get_customer_total_spent() to get the total for each user. This calculates orders with status of 'processing', 'completed'.
         *
         * @since 2.0
         * @access public
         * @return array
         */
        public function get_top_wholesale_customers() {
            $cache = get_transient( self::WWP_TOP_WHOLESALE_CUSTOMERS_CACHE );

            if ( $this->enable_dashboard_cache() && ! empty( $cache ) ) {
                return $cache;
            }

            // Get all current wholesale user ids from cache.
            $wholesale_user_ids_cache = $this->get_wholesale_user_ids();

            $wholesale_spent = array();
            $limit           = apply_filters( 'wwp_top_wholesale_customers_limit', 5 ); // We will only display 5 top wholesale customers.

            foreach ( $wholesale_user_ids_cache as $user_id ) {

                $user  = get_userdata( $user_id );
                $spent = wc_get_customer_total_spent( $user_id );

                if ( $user && $spent > 0 ) {

                    $wholesale_spent[] = array(
                        'id'        => (int) $user_id,
                        'name'      => $user->data->display_name,
                        'spent_raw' => (float) $spent,
                        'spent'     => wc_price( $spent ),
                        'link'      => admin_url( 'user-edit.php?user_id=' . $user_id ),
                    );

                }
            }

            $spent_sort = array_column( $wholesale_spent, 'spent_raw' );

            array_multisort( $spent_sort, SORT_DESC, $wholesale_spent );

            // Get only top 5.
            $wholesale_spent = array_slice( $wholesale_spent, 0, $limit, true );

            // Store as cache. Cache expires in 1 week.
            if ( $this->enable_dashboard_cache() ) {
                set_transient( self::WWP_TOP_WHOLESALE_CUSTOMERS_CACHE, $wholesale_spent, WEEK_IN_SECONDS );
            }

            return $wholesale_spent;
        }

        /**
         * This function fetches the most recent wholesale orders.
         *
         * @since 2.0
         * @access public
         * @return array
         */
        public function get_recent_wholesale_orders() {
            $cache = get_transient( self::WWP_RECENT_WHOLEALE_ORDERS_CACHE );

            if ( $this->enable_dashboard_cache() && ! empty( $cache ) ) {
                return $cache;
            }

            $order_args = array(
                'limit'   => apply_filters( 'wwp_recent_wholesale_orders_limit', 5 ),
                'orderby' => 'date',
                'order'   => 'DESC',
            );

            if ( OrderUtil::custom_orders_table_usage_is_enabled() ) {
                $order_args['meta_query'] = $this->_wholesale_orders_meta_query();
            } else {
                $order_args['wholesale_order'] = true;
            }

            $orders = wc_get_orders( $order_args );

            $wholesale_orders = array();

            if ( $orders ) {

                foreach ( $orders as $order ) {

                    $user            = $order->get_user();
                    $order_user_name = ! $user ? $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() : $user->data->display_name;
                    $wc_order_status = wc_get_order_statuses();

                    $wholesale_orders[] = array(
                        'id'          => $order->get_id(),
                        'name'        => $order_user_name,
                        'order_total' => wc_price( $order->get_total() ),
                        'status'      => $wc_order_status[ 'wc-' . $order->get_status() ] ? $wc_order_status[ 'wc-' . $order->get_status() ] : '',
                        'view_order'  => $order->get_edit_order_url(),
                    );

                }
            }

            // Store as cache. Cache expires in 1 week.
            set_transient( self::WWP_RECENT_WHOLEALE_ORDERS_CACHE, $wholesale_orders, WEEK_IN_SECONDS );

            return $wholesale_orders;
        }

        /**
         * Filter wc_get_orders() query to fetch wholesale orders
         *
         * @since 2.0
         * @access public
         *
         * @param array $query Query arguments.
         * @param array $query_vars Query variables.
         * @return array
         */
        public function handle_custom_query_var( $query, $query_vars ) {
            if ( ! empty( $query_vars['wholesale_order'] ) && true === $query_vars['wholesale_order'] ) {

                $query['meta_query'][] = array(
                    'key'     => '_wwpp_order_type',
                    'value'   => 'wholesale',
                    'compare' => '=',
                );

            }

            return $query;
        }

        /**
         * Add custom meta query for wholesale orders.
         *
         * @since 2.1.8
         * @access public
         *
         * @return array
         */
        private function _wholesale_orders_meta_query() {
            $meta_query = array(
                array(
                    'key'     => '_wwpp_order_type',
                    'value'   => 'wholesale',
                    'compare' => '=',
                ),
            );

            return $meta_query;
        }

        /**
         * Text Internationalization for Dashboard App
         *
         * @since 2.0
         * @access public
         * @return array
         */
        public function internationalization() {
            $texts = array(
                'dashboard'                 => __( 'Dashboard', 'woocommerce-wholesale-prices' ),
                'quick_stats'               => __( 'Quick Stats:', 'woocommerce-wholesale-prices' ),
                'quick_stats_note'          => __( 'The stats will only count orders that are in processing or completed status.', 'woocommerce-wholesale-prices' ),
                'wholesale_orders'          => __( 'Wholesale Orders', 'woocommerce-wholesale-prices' ),
                'wholesale_revenue'         => __( 'Wholesale Revenue', 'woocommerce-wholesale-prices' ),
                'top_wholesale_customers'   => __( 'Top Wholesale Customers:', 'woocommerce-wholesale-prices' ),
                'recent_wholesale_orders'   => __( 'Recent Wholesale Orders:', 'woocommerce-wholesale-prices' ),
                'view_order'                => __( 'View Order', 'woocommerce-wholesale-prices' ),
                'view_all_wholesale_orders' => __( 'View All Wholesale Orders &rarr;', 'woocommerce-wholesale-prices' ),
                'helpful_resources'         => __( 'Helpful Resources:', 'woocommerce-wholesale-prices' ),
                'getting_started_guides'    => __( 'Getting Started Guides', 'woocommerce-wholesale-prices' ),
                'read_documentation'        => __( 'Read Documentation', 'woocommerce-wholesale-prices' ),
                'settings'                  => __( 'Settings', 'woocommerce-wholesale-prices' ),
                'contact_support'           => __( 'Contact Support', 'woocommerce-wholesale-prices' ),
                'license_activation_status' => __( 'License Activation Status:', 'woocommerce-wholesale-prices' ),
                'wholesale_prices_premium'  => __( 'Wholesale Prices Premium', 'woocommerce-wholesale-prices' ),
                'wholesale_order_form'      => __( 'Wholesale Order Form', 'woocommerce-wholesale-prices' ),
                'wholesale_lead_capture'    => __( 'Wholesale Lead Capture', 'woocommerce-wholesale-prices' ),
                'view_licenses'             => __( 'View Licenses &rarr;', 'woocommerce-wholesale-prices' ),
                'wholesale_suite_plugins'   => __( 'Wholesale Suite Plugins:', 'woocommerce-wholesale-prices' ),
                'deactivated_plugins'       => __( 'Deactivated Plugins:', 'woocommerce-wholesale-prices' ),
                'activate_plugin'           => __( 'Activate', 'woocommerce-wholesale-prices' ),
                'click_to_activate'         => __( 'Click to activate the plugin.', 'woocommerce-wholesale-prices' ),
                'no_data'                   => __( 'No Data', 'woocommerce-wholesale-prices' ),
                'upgrade_now'               => __( 'Upgrade Now', 'woocommerce-wholesale-prices' ),
                'links'                     => array(
                    'upgrade_now' => 'https://wholesalesuiteplugin.com/bundle/?utm_source=wwp&utm_medium=upsell&utm_campaign=dashboardupgradenowbutton',
                ),
                'learn_more'                => __( 'Learn More &rarr;', 'woocommerce-wholesale-prices' ),
            );

            $texts = apply_filters( 'wwp_dashboard_texts', $texts );

            return $texts;
        }

        /**
         * Get WWS Plugins License Statuses.
         * The license is being cached using transient. The expiration is set to 1 week.
         *
         * @since 2.0
         * @since 2.1.9    Change cache expiry to 1 week. Force cache usage.
         * @since 2.1.10.2 Get license status from wws_license_data.
         *                 Remove cache usage.
         * @access public
         *
         * @return array
         */
        public function get_wws_plugins_license_statuses() {
            $wws_license_statuses = array();
            $license_data         = WWP_Helper_Functions::get_wws_license_data();

            $wws_plugins_license_drm = array(
                'WWPP' => array(
                    'name'    => __( 'Wholesale Prices Premium', 'woocommerce-wholesale-prices' ),
                    'status'  => WWP_Helper_Functions::is_wwpp_active(),
                    'version' => '1.30.4',
                ),
                'WWLC' => array(
                    'name'    => __( 'Wholesale Lead Capture', 'woocommerce-wholesale-prices' ),
                    'status'  => WWP_Helper_Functions::is_wwlc_active(),
                    'version' => '1.17.7',
                ),
                'WWOF' => array(
                    'name'    => __( 'Wholesale Order Form', 'woocommerce-wholesale-prices' ),
                    'status'  => WWP_Helper_Functions::is_wwof_active(),
                    'version' => '3.0.4',
                ),
            );

            foreach ( $wws_plugins_license_drm as $plugin_key => $plugin_data ) {
                if ( WWP_Helper_Functions::check_wws_plugin_min_version( strtolower( $plugin_key ), $plugin_data['version'] ) ) {
                    $license_status      = array_key_exists( $plugin_key, $license_data ) ? $license_data[ $plugin_key ]['license_status'] : $license_status = 'invalid';
                    $license_status_i18n = WWP_Helper_Functions::get_license_status_i18n( $license_status );

                    // If license is disabled, set the status to expired.
                    $license_status = 'disabled' === $license_status ? 'expired' : $license_status;

                    $wws_license_statuses[ strtolower( $plugin_key ) ] = array(
                        'status' => $license_status,
                        'text'   => $plugin_data['name'] . " (<span class='. $license_status .'>" . $license_status_i18n . '</span>)',
                    );
                } else {
                    $wws_license_statuses[ strtolower( $plugin_key ) ] = array(
                        'status' => 'inactive',
                        'text'   => $plugin_data['name'] . " (<span class='inactive'>" . __( 'Update Available', 'woocommerce-wholesale-prices' ) . '</span>)',
                    );
                }
            }

            return $wws_license_statuses;
        }

        /**
         * Clear Cache.
         * The hook "save_post_shop_order" is called on the following events:
         * - order creation (both customer checkout process & admin)
         * - single order update
         * - bulk status update
         * - trashing the order
         * - untrashing the order
         *
         * @since 2.0
         * @access public
         */
        public function clear_cache_on_new_orders() {
            $this->clear_cache();
        }

        /**
         * Clear Cache.
         *
         * @since 2.0
         * @access public
         */
        public function clear_cache() {
            // Total wholesale orders cache.
            delete_transient( self::WWP_TOTAL_WHOLESALE_ORDERS_CACHE );

            // Total wholesale revenue cache.
            delete_transient( self::WWP_TOTAL_WHOLESALE_REVENUE_CACHE );

            // Top wholesale customers cache.
            delete_transient( self::WWP_TOP_WHOLESALE_CUSTOMERS_CACHE );

            // Recent wholesale orders cache.
            delete_transient( self::WWP_RECENT_WHOLEALE_ORDERS_CACHE );

            // Wholesale user ids cache.
            delete_transient( self::WWP_WHOLESALE_USERS_IDS_CACHE );
        }

        /**
         * Clear Cache.
         *
         * @since 2.0
         * @access public
         * @return array
         */
        public function enable_dashboard_cache() {
            return apply_filters( 'wwp_enable_dashboard_cache', true );
        }

        /**
         * Activate Plugin.
         *
         * @since 2.0
         * @access public
         *
         * @param string $plugin_name Plugin name.
         * @return array
         */
        public function activate_plugin( $plugin_name ) {
            // Define the new plugin you want to activate.
            switch ( $plugin_name ) {
                case 'wwof':
                    $plugin_path = self::WWOF_PLUGIN_PATH;
                    break;
                case 'wwlc':
                    $plugin_path = self::WWLC_PLUGIN_PATH;
                    break;
                default:
                    $plugin_path = self::WWPP_PLUGIN_PATH;
            }

            // Get already-active plugins.
            $active_plugins = get_option( 'active_plugins' );

            // Make sure your plugin isn't active.
            if ( isset( $active_plugins[ $plugin_path ] ) ) {
                return;
            }

            // Include the plugin.php file so you have access to the activate_plugin() function.
            require_once ABSPATH . '/wp-admin/includes/plugin.php';

            // Activate your plugin.
            return activate_plugin( $plugin_path );
        }

        /**
         * Option to toggle dashboard on/off
         *
         * @since 2.0.1
         * @access public
         * @return array
         */
        public function is_wholesale_dashboard_disabled() {
            return apply_filters( 'wwp_disable_wholesale_dashboard', false );
        }

        /**
         * Get all wholesale user ids.
         *
         * @since 2.0.1
         * @access public
         * @return array
         */
        public function get_wholesale_user_ids() {
            $cache = get_transient( self::WWP_WHOLESALE_USERS_IDS_CACHE );

            if ( $this->enable_dashboard_cache() && ! empty( $cache ) ) {
                return $cache;
            }

            $wholesale_user_ids_cache = $this->_wwp_wholesale_roles->get_all_wholesale_user_ids();

            // Store as cache. Cache expires in 1 day.
            if ( $this->enable_dashboard_cache() ) {
                set_transient( self::WWP_WHOLESALE_USERS_IDS_CACHE, $wholesale_user_ids_cache, HOUR_IN_SECONDS );
            }

            return $wholesale_user_ids_cache;
        }

        /**
         * Execute model.
         *
         * @since 2.0
         * @access public
         */
        public function run() {
            // Load react scripts.
            add_action( 'admin_enqueue_scripts', array( $this, 'load_back_end_styles_and_scripts' ), 10, 1 );

            // Add wc navigation bar.
            add_action( 'init', array( $this, 'wc_navigation_bar' ) );

            // REST API for dashboard page.
            add_action( 'rest_api_init', array( $this, 'rest_api_dashboard' ) );

            // Wholesale Orders query.
            add_filter( 'woocommerce_order_data_store_cpt_get_orders_query', array( $this, 'handle_custom_query_var' ), 10, 2 );

            // Clear cache on new/update order.
            add_action( 'save_post_shop_order', array( $this, 'clear_cache_on_new_orders' ), 10 );
        }
    }

}
