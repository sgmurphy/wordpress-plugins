<?php
/**
 * Compatibility Class
 *
 * @file The Wordfence Model file
 * @package HMWP/Compatibility/Wordfence
 * @since 7.0.0
 */

defined('ABSPATH') || die('Cheatin\' uh?');

class HMWP_Models_Compatibility_Wordfence extends HMWP_Models_Compatibility_Abstract
{
    /** @var array wordfence config */
    public static $config = array();

    public function __construct() {
        parent::__construct();
        //
        add_filter('hmwp_process_init', array($this, 'checkWordfenceScan'));
        add_filter('hmwp_process_hide_urls', array($this, 'checkWordfenceScan'));

        add_action('init', function () {
            if(is_admin()) {

                //Add the Wordfence menu when the wp-admin path is changed
                if (is_multisite()) {
                    if (class_exists('wfUtils') && !wfUtils::isAdminPageMU()) {
                        add_action('network_admin_menu', 'wordfence::admin_menus', 10);
                        add_action('network_admin_menu', 'wordfence::admin_menus_20', 20);
                        add_action('network_admin_menu', 'wordfence::admin_menus_30', 30);
                        add_action('network_admin_menu', 'wordfence::admin_menus_40', 40);
                        add_action('network_admin_menu', 'wordfence::admin_menus_50', 50);
                        add_action('network_admin_menu', 'wordfence::admin_menus_60', 60);
                        add_action('network_admin_menu', 'wordfence::admin_menus_70', 70);
                        add_action('network_admin_menu', 'wordfence::admin_menus_80', 80);
                        add_action('network_admin_menu', 'wordfence::admin_menus_90', 90);
                    } //else don't show menu
                }
            }
        });

        //Add compatibility with Wordfence to not load the Bruteforce when 2FA is active
        if( HMWP_Classes_Tools::getOption('hmwp_bruteforce') && HMWP_Classes_Tools::getOption('brute_use_captcha_v3') ) {
            add_filter('hmwp_option_brute_use_captcha_v3', '__return_false');
        }
    }

    /**
     * Get Config data from Wordfence
     * @param $key
     *
     * @return false|mixed
     */
    public function wfConfig($key) {
        global $wpdb;

        if(isset(self::$config[$key])){
            return self::$config[$key];
        }

        $table = $wpdb->base_prefix . 'wfconfig';
        if ($option = $wpdb->get_row($wpdb->prepare("SELECT name, val, autoload FROM {$table} WHERE name = %s", $key))) {
            if(isset($option->val)){
                self::$config[$key] = $option->val;
                return $option->val;
            }
        }

        return false;
    }

    /**
     * Check and return false when Wordfence scan is active
     *
     * @param $status
     *
     * @return false|mixed
     */
    public function checkWordfenceScan($status) {

        if($this->wfConfig('wf_scanRunning')){
            $status = false;
        }

        if($this->wfConfig('scanStartAttempt')){
            $status = false;
        }

        return $status;
    }


}
