<?php

class Logger
{
    private static $_instances = array();
    private static $product_data;
    private static $_module_id;
    private $_slug;

    // Constructor for the Logger class
    private function __construct($module_id, $slug = false, $is_init = false)
    {
        if (!$is_init && !is_numeric($module_id) && !is_string($slug)) {
            return false;
        }
        self::$_module_id = $module_id;
        $this->_slug = $slug;
    }

    // Method to create or retrieve a Logger instance
    public static function instance($module_id, $slug = false, $is_init = false)
    {
        if (empty($module_id)) {
            return false;
        }
        if (!$is_init && true === $slug) {
            $is_init = true;
        }
        $key = 'm_' . $slug;

        if (!isset(self::$_instances[$key])) {
            self::$_instances[$key] = new Logger($module_id, $slug, $is_init);
        }

        return self::$_instances[$key];
    }

    // Method to initialize the Logger with module data
    public function wpb_init(array $module)
    {
        self::$product_data = $module;
        $this->hooks();
    }

    // Method to attach hooks for scheduled events and AJAX
    public function hooks()
    {
        $slug = self::$product_data['slug'];

        add_action('init', array($this, 'set_logs_schedule'));
        add_action('wpb_logger_cron_' . $slug, array($this, 'weekly_log_plugin'));
        add_action('wpb_daily_sync_cron_' . $slug, array($this, 'daily_log_plugin'));
        add_action('admin_footer', array($this, 'deactivation_model'));
        add_action('wp_ajax_wpb_sdk_' . $slug . '_deactivation', array($this, 'ajax_deactivation'));

        register_activation_hook(wpb_get_plugin_path($slug), array($this, 'log_activation'));
        register_deactivation_hook(wpb_get_plugin_path($slug), array($this, 'product_deactivation'));
        register_uninstall_hook(wpb_get_plugin_path($slug), array(__CLASS__, 'log_uninstallation'));
    }

    // Method to set scheduled events for logging
    public function set_logs_schedule()
    {
        $slug = self::$product_data['slug'];
        // Calculate future timestamps for scheduling
        $daily_start_time = strtotime('+1 day');
        $weekly_start_time = strtotime('+1 week');

        // Schedule daily cron event if not already scheduled
        if (!wp_next_scheduled('wpb_daily_sync_cron_' . $slug)) {
            wp_schedule_event($daily_start_time, 'daily', 'wpb_daily_sync_cron_' . $slug);
        }

        // Schedule weekly cron event if not already scheduled
        if (!wp_next_scheduled('wpb_logger_cron_' . $slug)) {
            wp_schedule_event($weekly_start_time, 'weekly', 'wpb_logger_cron_' . $slug);
        }
    }

    // Method to log plugin activity on daily scheduled events
    public function daily_log_plugin()
    {
        $slug = self::$product_data['slug'];
        $logs_data = array_merge(
            self::get_logs_data(),
            array(
                'explicit_logs' => array(
                    'action' => 'daily',
                ),
            )
        );

        self::send($logs_data);
    }

    // Method to log plugin activity on weekly scheduled events
    public function weekly_log_plugin()
    {
        $slug = self::$product_data['slug'];
        $logs_data = array_merge(
            self::get_logs_data(),
            array(
                'explicit_logs' => array(
                    'action' => 'weekly',
                ),
            )
        );

        self::send($logs_data);
    }

    // Method to log plugin activation
    public function log_activation()
    {
        $slug = self::$product_data['slug'];

        $logs_data = array_merge(
            self::get_logs_data(),
            array(
                'explicit_logs' => array(
                    'action' => 'activate',
                ),
            )
        );

        self::send($logs_data);
    }

    // Method to add deactivation model HTML to admin footer
    public function deactivation_model()
    {
        if (function_exists('get_current_screen')) {
            $screen = get_current_screen();

            if ('plugins.php' === $screen->parent_file) {
                $product_slug = self::$product_data['slug'];

                $plugin_data = wpb_get_plugin_details($product_slug);
                $product_name = $plugin_data['Name'];
                $has_pro_version = self::$product_data['is_premium'] === true;
                include dirname(__DIR__) . '/views/wpb-sdk-deactivate-form.php';
            }
        }
    }

    // Method to handle AJAX request for plugin deactivation
    public function ajax_deactivation()
    {
        $slug = self::$product_data['slug'];
        $path = wpb_get_plugin_path($slug);

        if (isset($_POST['nonce']) && empty($_POST['nonce'])) {
            return;
        }

        $nonce = sanitize_text_field(wp_unslash($_POST['nonce']));
        $verify_nonce = wp_verify_nonce($nonce, 'deactivate-plugin_' . plugin_basename($path));

        if (!$verify_nonce) {
            return;
        }

        $this->log_deactivation();

        wp_die();
    }

    // Method to handle plugin deactivation
    public function product_deactivation()
    {
        $slug = self::$product_data['slug'];

        wp_clear_scheduled_hook('wpb_logger_cron_' . $slug);
        wp_clear_scheduled_hook('wpb_daily_sync_cron_' . $slug);
    }

    // Method to log plugin deactivation
    public function log_deactivation()
    {
        $reason = isset($_POST['reason']) ? $_POST['reason'] : '';
        $reason_detail = isset($_POST['reason_detail']) ? $_POST['reason_detail'] : '';

        $logs_data = array_merge(
            self::get_logs_data(),
            array(
                'explicit_logs' => array(
                    'action' => 'deactivate',
                    'reason' => sanitize_text_field(wp_unslash($reason)),
                    'reason_detail' => sanitize_text_field(wp_unslash($reason_detail)),
                ),
            )
        );

        self::send($logs_data);
    }

    // Method to log plugin uninstallation
    public static function log_uninstallation()
    {
        $logs_data = array_merge(
            self::get_logs_data(),
            array(
                'explicit_logs' => array(
                    'action' => 'uninstall',
                ),
            )
        );
        self::send($logs_data);
        // Call Plugin uninstall hook
        do_action('wp_wpb_sdk_after_uninstall');
    }

    /**
     * Collect all data for logging.
     *
     * @return array
     */
    public static function get_logs_data()
    {
        global $wpdb;

        // Get product data
        $module = self::$product_data;
        $slug = $module['slug'];

        // Initialize variables
        $data = array();
        $theme_data = wp_get_theme();
        $curl_version = '';
        $external_http_blocked = '';
        $users_count = '';

        // Get admin user data
        $admin_users = get_users(array('role' => 'Administrator'));
        $admin = isset($admin_users[0]) ? $admin_users[0]->data : '';
        $admin_meta = !empty($admin) ? get_user_meta($admin->ID) : '';
        $ip = self::get_ip();
        $location = self::get_location_details($ip);

        // Check if get_plugins function exists
        if (!function_exists('get_plugins')) {
            include ABSPATH . '/wp-admin/includes/plugin.php';
        }

        // Get users count if function exists
        if (function_exists('count_users')) {
            $users_count = count_users();
            $users_count = isset($users_count['total_users']) ? intval($users_count['total_users']) : '';
        }

        // Check external http request blocking
        if (!defined('WP_HTTP_BLOCK_EXTERNAL') || !WP_HTTP_BLOCK_EXTERNAL) {
            $external_http_blocked = 'none';
        } else {
            $external_http_blocked = defined('WP_ACCESSIBLE_HOSTS') ? 'partially (accessible hosts: ' . esc_html(WP_ACCESSIBLE_HOSTS) . ')' : 'all';
        }

        // Get curl version if function exists
        if (function_exists('curl_init')) {
            $curl = curl_version();
            $curl_version = '(' . $curl['version'] . ' ' . $curl['ssl_version'] . ')';
        }

        // Collect data
        $data['authentication']['public_key'] = $module['public_key'];
        $data['site_info'] = array(
            'site_url' => site_url(),
            'home_url' => home_url(),
        );
        $data['site_meta_info'] = array(
            'is_multisite' => is_multisite(),
            'multisites' => self::get_multisites(),
            'php_version' => phpversion(),
            'wp_version' => get_bloginfo('version'),
            'server' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '',
            'timezoneoffset' => date('P'),
            'ext/mysqli' => isset($wpdb->use_mysqli) && !empty($wpdb->use_mysqli) ? true : false,
            'mysql_version' => function_exists('mysqli_get_server_info') ? mysqli_get_server_info($wpdb->dbh) : mysql_get_server_info(),
            'memory_limit' => (defined(WP_MEMORY_LIMIT) ? WP_MEMORY_LIMIT : ini_get('memory_limit')) ? ini_get('memory_limit') : '',
            'external_http_blocked' => $external_http_blocked,
            'wp_locale' => get_locale(),
            'db_charset' => defined('DB_CHARSET') ? DB_CHARSET : '',
            'debug_mode' => defined('WP_DEBUG') && WP_DEBUG ? true : false,
            'wp_max_upload' => size_format(wp_max_upload_size()),
            'php_time_limit' => function_exists('ini_get') ? ini_get('max_execution_time') : '',
            'php_error_log' => function_exists('ini_get') ? ini_get('error_log') : '',
            'fsockopen' => function_exists('fsockopen') ? true : false,
            'open_ssl' => defined('OPENSSL_VERSION_TEXT') ? OPENSSL_VERSION_TEXT : '',
            'curl' => $curl_version,
            'ip' => $ip,
            'user_count' => $users_count,
            'admin_email' => sanitize_email(get_bloginfo('admin_email')),
            'theme_name' => sanitize_text_field($theme_data->Name),
            'theme_version' => sanitize_text_field($theme_data->Version),
        );
        $data['user_info'] = array(
            'user_email' => !empty($admin) ? sanitize_email($admin->user_email) : '',
            'user_nickname' => !empty($admin) ? sanitize_text_field($admin->user_nicename) : '',
            'user_firstname' => isset($admin_meta['first_name'][0]) ? sanitize_text_field($admin_meta['first_name'][0]) : '',
            'user_lastname' => isset($admin_meta['last_name'][0]) ? sanitize_text_field($admin_meta['last_name'][0]) : '',
        );
        $data['sdk_version'] = '3.0.1';
        $data['location_details'] = $location !== null ? $location : '';
        $data['product_info'] = self::get_product_data($slug);
        $data['product_settings'] = self::get_product_settings();
        $data['site_plugins_info'] = self::get_plugins();

        return $data;
    }


    /**
     * Retrieve plugin settings related to the product.
     *
     * @return array
     */
    private static function get_product_settings()
    {
        $product_data = self::$product_data;
        $plugin_options = array();

        // Pull settings data from db.
        foreach ($product_data['settings'] as $option_name => $default_value) {
            $get_option = get_option($option_name);
            $plugin_options[] = array(
                'option' => $option_name,
                'value' => !empty($get_option) ? wp_json_encode($get_option) : $default_value
            );
        }

        return $plugin_options;
    }

    /**
     * Collect multisite data.
     *
     * @return array|false
     */
    private static function get_multisites()
    {
        if (!is_multisite()) {
            return false;
        }

        $sites_info = array();
        $sites = get_sites();

        foreach ($sites as $site) {
            $sites_info[$site->blog_id] = array(
                'name' => get_blog_details($site->blog_id)->blogname,
                'domain' => $site->domain,
                'path' => $site->path,
            );
        }

        return $sites_info;
    }

    /**
     * Get user IP information.
     *
     * @return string|null
     */
    private static function get_ip()
    {
        $fields = array(
            'HTTP_CF_CONNECTING_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        );

        foreach ($fields as $ip_field) {
            if (!empty($_SERVER[$ip_field])) {
                return $_SERVER[$ip_field];
            }
        }

        return null;
    }

    /**
     * Collect plugins information: Active/Inactive plugins.
     *
     * @return string
     */
    private static function get_plugins()
    {
        $plugins = array_keys(get_plugins());
        $active_plugins = get_option('active_plugins', array());

        foreach ($plugins as $key => $plugin) {
            if (in_array($plugin, $active_plugins)) {
                // Remove active plugins from list.
                unset($plugins[$key]);
            }
        }

        return wp_json_encode(
            array(
                'active' => $active_plugins,
                'inactive' => $plugins,
            )
        );
    }

    /**
     * Get location details based on IP.
     *
     * @param string|null $ip
     * @return array
     */
    private static function get_location_details($ip)
    {
        $location_details = array();
        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://api.iplocation.net/?ip={$ip}");

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $execute = curl_exec($ch);

            curl_close($ch);

            $result = json_decode($execute);

            if ($result && $result->response_code === '200') {
                if ($result->country_name !== '-' && $result->country_code2 !== '-') {
                    $location_details['response_code'] = $result->response_code;
                    $location_details['message'] = 'Success';
                    $location_details['data']['country_name'] = $result->country_name;
                    $location_details['data']['country_code'] = $result->country_code2;
                } else {
                    $missing_info = array();
                    if ($result->country_name === '-') {
                        $missing_info[] = 'country_name';
                    }
                    if ($result->country_code2 === '-') {
                        $missing_info[] = 'country_code';
                    }
                    $location_details['response_code'] = '400';
                    $location_details['message'] = 'Error: Missing information for ' . implode(', ', $missing_info) . ' for the IP Address: ' . $ip;
                }
            } else {
                $location_details['response_code'] = '400';
                $location_details['message'] = 'Error: Invalid response code or data for the IP Address: ' . $ip;
            }

            return $location_details;
        } catch (\Exception $e) {
            $location_details['response_code'] = '400';
            $location_details['message'] = 'Error: ' . $e->getMessage();
            return $location_details;
        }
    }

    /**
     * Get product data.
     *
     * @param string $slug
     * @return array
     */
    private static function get_product_data($slug)
    {
        $plugin_data = wpb_get_plugin_details($slug);
        $data = array();
        $data['name'] = isset($plugin_data['Name']) ? $plugin_data['Name'] : $plugin_data['Title'];
        $data['slug'] = $slug;
        $data['id'] = self::$_module_id;
        $data['type'] = 'Plugin';
        $data['path'] = wpb_get_plugin_path($slug);
        $data['version'] = $plugin_data['Version'];
        return $data;
    }


    /**
     * Send log data to the API.
     *
     * @param array $payload The log data payload.
     */
    private static function send($payload)
    {
        // Add timestamp to the payload
        $payload['sent_at'] = current_time('mysql', 1);

        // Check if the logs table exists
        $logsTableExists = self::isLogsExists();

        // Determine the log status
        $logStatus = $logsTableExists ? 'update' : 'new';
        $payload['log_status'] = $logStatus;

        if ($logStatus === 'new') {
            self::sendNewLog($payload);
        } else {
            self::sendUpdatedLog($payload);
        }
    }

    /**
     * Check if the logs table exists.
     *
     * @return bool
     */
    private static function isLogsExists()
    {
        $token = self::$product_data['public_key'];
        $url = site_url();

        $response = wp_remote_post(
            WPB_SDK_API_ENDPOINT . '/raw-logs', // Ensure the URL is properly formatted
            array(
                'body' => json_encode(array('url' => $url)), // Convert body to JSON
                'timeout' => 5,
                'headers' => array(
                    'Authorization' => 'Bearer ' . $token, // Add the token in the request headers
                    'Content-Type' => 'application/json', // Set the Content-Type to application/json
                ),
            )
        );

        if (is_wp_error($response)) {
            error_log('Error fetching logs: ' . $response->get_error_message());
            // Return false as default when encountering an error
            return false;
        } else {
            // Extracting just the body from the response
            $body = wp_remote_retrieve_body($response);
            error_log('Log fetched successfully: ' . $body);

            // Decode the response body
            $data = json_decode($body, true);

            // Check for "Logs not found" response
            if (isset($data['error']) && $data['error'] === 'Logs not found') {
                return false;
            }

            // Parse the response body to determine if the logs table exists
            $logsTableExists = !empty($data);
            return $logsTableExists;
        }
    }

    /**
     * Send new log to the API.
     *
     * @param array $payload The log data payload.
     */
    private static function sendNewLog($payload)
    {
        // $this->createLogsTable();
        self::sendDataToAPI($payload);
        // $this->storeLogInDatabase($payload);
    }

    /**
     * Send updated log to the API.
     *
     * @param array $payload The log data payload.
     */
    private static function sendUpdatedLog($payload)
    {
        $explicit_logs = $payload['explicit_logs'];
        $new_plugin = self::preparePluginData($payload, $explicit_logs);
        self::sendDataToAPI([
            'plugins' => [$new_plugin],
            'all_plugins' => $payload['site_plugins_info'],
            'all_themes' => self::getAllThemesData(),
            'log_status' => 'update',
            'site_url' => site_url(),
            'product_settings' => $payload['product_settings'],
            'explicit_logs' => $payload['explicit_logs'],
        ]);
    }

    /**
     * Send data to the API endpoint.
     *
     * @param array $data The data to be sent.
     */
    private static function sendDataToAPI($data)
    {
        $token = self::$product_data['public_key'];

        $response = wp_remote_post(
            WPB_SDK_API_ENDPOINT . '/logger',
            array(
                'method' => 'POST',
                'body' => $data,
                'headers' => array(
                    'Authorization' => 'Bearer ' . $token, // Add the token in the request headers
                ),
            )
        );
        if (is_wp_error($response)) {
            error_log('Error sending data: ' . $response->get_error_message());
        } else {
            error_log('Log sent successfully' . wp_json_encode($data));
        }
    }

    /**
     * Prepare plugin data for logging.
     *
     * @param array $payload The log data payload.
     * @param array $explicit_logs Explicit logs data.
     * @return array
     */
    private static function preparePluginData($payload, $explicit_logs)
    {
        $new_plugin = array(
            'slug' => $payload['product_info']['slug'],
            'version' => $payload['product_info']['version'],
            'title' => $payload['product_info']['name'],
            'is_active' => ($explicit_logs['action'] === 'activate'),
            'is_uninstalled' => ($explicit_logs['action'] === 'uninstalled')
        );

        if ($explicit_logs['action'] === 'deactivate') {
            $new_plugin['reason'] = $explicit_logs['reason'];
            $new_plugin['reason_detail'] = $explicit_logs['reason_detail'];
        }
        return $new_plugin;
    }

    /**
     * Get data of all themes installed on the site.
     *
     * @return array
     */
    private static function getAllThemesData()
    {
        $all_themes = wp_get_themes();
        $active_theme = wp_get_theme();
        $active_theme_slug = $active_theme->get_stylesheet();
        $themes_update_data = [];

        foreach ($all_themes as $slug => $data) {
            $is_active = ($slug === $active_theme_slug);
            $themes_update_data[] = [
                'slug' => $slug,
                'version' => $data->version,
                'title' => $data->name,
                'is_active' => $is_active,
                'is_uninstalled' => false,
            ];
        }
        return $themes_update_data;
    }
}