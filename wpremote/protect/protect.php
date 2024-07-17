<?php
if (!defined('ABSPATH') && !defined('MCDATAPATH')) exit;

if (!class_exists('WPRProtect_V565')) :
require_once dirname( __FILE__ ) . '/logger.php';
require_once dirname( __FILE__ ) . '/ipstore.php';
require_once dirname( __FILE__ ) . '/request.php';
require_once dirname( __FILE__ ) . '/wp_user.php';
require_once dirname( __FILE__ ) . '/lib.php';
require_once dirname( __FILE__ ) . '/fw.php';
require_once dirname( __FILE__ ) . '/lp.php';
require_once dirname( __FILE__ ) . '/../helper.php';

class WPRProtect_V565 {
	public static $settings;
	public static $db;
	public static $info;

	const MODE_PREPEND = 0;
	const MODE_WP      = 1;

	const CONF_VERSION = '2';

	public static function init($mode) {
		if (defined('WP_CLI') && WP_CLI) {
			return false;
		}

		if ($mode == WPRProtect_V565::MODE_PREPEND) {
			$config_file = MCDATAPATH .  MCCONFKEY . '-' . 'mc.conf';
			$config = WPRProtectUtils_V565::parseFile($config_file);

			if (empty($config['time']) || !($config['time'] > time() - (48*3600)) ||
					!isset($config['mc_conf_version']) ||
					(WPRProtect_V565::CONF_VERSION !== $config['mc_conf_version'])) {
				return false;

			}

			$brand_name = array_key_exists('brandname', $config) ? $config['brandname'] : 'Protect';
			$request_ip_header = array_key_exists('ipheader', $config) ? $config['ipheader'] : null;
			$req_config = array_key_exists('reqconfig', $config) ? $config['reqconfig'] : array();
			$request = new WPRProtectRequest_V565($request_ip_header, $req_config);
			$fw_config = array_key_exists('fw', $config) ? $config['fw'] : array();

			WPRProtectFW_V565::getInstance($mode, $request, $fw_config, $brand_name)->init();
		} else {
			//For backward compatibility.
			self::$settings = new WPRWPSettings();
			self::$db = new WPRWPDb();
			self::$info = new WPRInfo(self::$settings);

			$plug_config = self::$settings->getOption(self::$info->services_option_name);
			$config = array_key_exists('protect', $plug_config) ? $plug_config['protect'] : array();
			if (!is_array($config) || !array_key_exists('mc_conf_version', $config) ||
				(WPRProtect_V565::CONF_VERSION !== $config['mc_conf_version'])) {

				return false;
			}

			$brand_name = self::$info->getBrandName();
			$request_ip_header = array_key_exists('ipheader', $config) ? $config['ipheader'] : null;
			$req_config = array_key_exists('reqconfig', $config) ? $config['reqconfig'] : array();
			$request = new WPRProtectRequest_V565($request_ip_header, $req_config);
			$fw_config = array_key_exists('fw', $config) ? $config['fw'] : array();
			$lp_config = array_key_exists('lp', $config) ? $config['lp'] : array();

			WPRProtectFW_V565::getInstance($mode, $request, $fw_config, $brand_name)->init();
			WPRProtectLP_V565::getInstance($request, $lp_config, $brand_name)->init();
		}
	}

	public static function uninstall() {
		self::$settings->deleteOption('bvptconf');
		self::$settings->deleteOption('bvptplug');
		WPRProtectIpstore_V565::uninstall();
		WPRProtectFW_V565::uninstall();
		WPRProtectLP_V565::uninstall();

		WPRProtect_V565::removeWPPrepend();
		WPRProtect_V565::removePHPPrepend();
		WPRProtect_V565::removeMCData();

		return true;
	}

	private static function removeWPPrepend() {
		$wp_conf_paths = array(
			dirname(ABSPATH) . "/wp-config.php",
			dirname(ABSPATH) . "/../wp-config.php"
		);

		if (file_exists($wp_conf_paths[0])) {
			$fname = $wp_conf_paths[0];
		} elseif (file_exists($wp_conf_paths[1])) {
			$fname = $wp_conf_paths[1];
		} else {
			return;
		}

		$pattern = "@include '" . dirname(ABSPATH) . "/malcare-waf.php" . "';";
		
		WPRProtectUtils_V565::fileRemovePattern($fname, $pattern);
	}

	private static function removePHPPrepend() {
		WPRProtect_V565::removeHtaccessPrepend();
		WPRProtect_V565::removeUseriniPrepend();
	}

	private static function removeHtaccessPrepend() {
		$pattern = "/# MalCare WAF(.|\n)*# END MalCare WAF/i";

		WPRProtectUtils_V565::fileRemovePattern(dirname(ABSPATH) . "/.htaccess", $pattern, true);
	}

	private static function removeUseriniPrepend() {
		$pattern = "/; MalCare WAF(.|\n)*; END MalCare WAF/i";

		WPRProtectUtils_V565::fileRemovePattern(dirname(ABSPATH) . "/.user.ini", $pattern, true);
	}

	private static function removeMCData() {
		$content_dir = defined('WP_CONTENT_DIR') ? WP_CONTENT_DIR : dirname(ABSPATH) . "/wp-content";
		$mc_data_dir = $content_dir . "/mc_data";

		WPRProtectUtils_V565::rrmdir($mc_data_dir);
	}
}
endif;