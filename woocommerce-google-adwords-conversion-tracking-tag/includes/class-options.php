<?php
/**
 * Options class
 * https://stackoverflow.com/a/55658771/4688612
 *
 * TODO: in an new db version move consent_management to the general section
 * TODO: change ->google->consent_mode->active to ->google->consent_mode->is_active
 */

namespace SweetCode\Pixel_Manager;

use SweetCode\Pixel_Manager\Admin\Environment;

defined('ABSPATH') || exit; // Exit if accessed directly

class Options {

	private static $options;
	private static $options_obj;

	private static $did_init = false;

	private static function init() {

		// If already initialized, do nothing
		if (self::$did_init) {
			return;
		}

		self::$did_init = true;

		self::$options = get_option(PMW_DB_OPTIONS_NAME);

		if (self::$options) { // If option retrieved, update it with new defaults

			// running the DB updater
			Database::run_options_db_upgrade();

			// Update options that are missing with defaults, recursively
			self::$options = self::update_with_defaults(self::$options, self::get_default_options());
		} else { // If option not available, get default options and save it

			self::$options = self::get_default_options();
			update_option(PMW_DB_OPTIONS_NAME, self::$options);
		}

		self::$options_obj = self::encode_options_object(self::$options);
	}

	public static function invalidate_cache() {
		self::$did_init = false;
		self::$options  = null;
	}

	private function __construct() {
		// Do nothing
	}

	public static function get_options() {
		self::init();

		return self::$options;
	}

	public static function get_options_obj() {
		self::init();

		return self::$options_obj;
	}

	public static function encode_options_object( $options ) {

		// This is the most elegant way to convert an array to an object recursively
		$options_obj = json_decode(wp_json_encode($options));

		if (function_exists('get_woocommerce_currency')) {
			$options_obj->shop->currency = get_woocommerce_currency();
		}

		return $options_obj;
	}

	// get the default options
	public static function get_default_options() {

		// default options settings
		return [
			'bing'       => [
				'uet_tag_id'           => '',
				'enhanced_conversions' => false,
			],
			'facebook'   => [
				'pixel_id'  => '',
				'microdata' => false,
				'capi'      => [
					'token'             => '',
					'test_event_code'   => '',
					'user_transparency' => [
						'process_anonymous_hits'             => false,
						'send_additional_client_identifiers' => false,
					],
				],
			],
			'google'     => [
				'ads'          => [
					'conversion_id'            => '',
					'conversion_label'         => '',
					'aw_merchant_id'           => '',
					'product_identifier'       => 0, // TODO: Move to general section
					'google_business_vertical' => 0,
					'dynamic_remarketing'      => true, // TODO is always active, can be removed
					'phone_conversion_number'  => '',
					'phone_conversion_label'   => '',
					'enhanced_conversions'     => false,
					'conversion_adjustments'   => [
						'conversion_name' => '',
					],
				],
				'analytics'    => [
					'universal'        => [                // TODO remove
														   'property_id' => '',
					],
					'ga4'              => [
						'measurement_id'          => '',
						'api_secret'              => '',
						'data_api'                => [
							'property_id' => '',
							'credentials' => [],
						],
						'page_load_time_tracking' => false,
					],
					'link_attribution' => false,
				],
				'optimize'     => [
					'container_id'         => '',
					'anti_flicker'         => false,
					'anti_flicker_timeout' => 4000,
				],
				'consent_mode' => [
					'active'  => true,
					'regions' => [],  // TODO: Move to the consent management section
				],
				'tcf_support'  => false,
				'user_id'      => false,
			],
			'hotjar'     => [
				'site_id' => '',
			],
			'pinterest'  => [
				'pixel_id'          => '',
				'ad_account_id'     => '',
				'enhanced_match'    => false,
				'advanced_matching' => false,
				'apic'              => [
					'token'                  => '',
					'process_anonymous_hits' => false,
				],
			],
			'snapchat'   => [
				'pixel_id'          => '',
				'advanced_matching' => false,
				'capi'              => [
					'token' => '',
				],
			],
			'tiktok'     => [
				'pixel_id'          => '',
				'advanced_matching' => false,
				'eapi'              => [
					'token'                  => '',
					'test_event_code'        => '',
					'process_anonymous_hits' => false,
				],
			],
			'twitter'    => [
				'pixel_id'  => '',
				'event_ids' => [
					'view_content'      => '',
					'search'            => '',
					'add_to_cart'       => '',
					'add_to_wishlist'   => '',
					'initiate_checkout' => '',
					'add_payment_info'  => '',
					'purchase'          => '',
				],
			],
			'pixels'     => [
				'ab_tasty'   => [
					'account_id' => '',
				],
				'adroll'     => [
					'advertiser_id' => '',
					'pixel_id'      => '',
				],
				'linkedin'   => [
					'partner_id'     => '',
					'conversion_ids' => [
						'search'         => '',
						'view_content'   => '',
						'add_to_list'    => '',
						'add_to_cart'    => '',
						'start_checkout' => '',
						'purchase'       => '',
					],
				],
				'optimizely' => [
					'project_id' => '',
				],
				'outbrain'   => [
					'advertiser_id' => '',
				],
				'reddit'     => [
					'advertiser_id'     => '',
					'advanced_matching' => false,
				],
				'taboola'    => [
					'account_id' => '',
				],
				'vwo'        => [
					'account_id' => '',
				],
			],
			'shop'       => [
				'order_total_logic'             => 0,
				// TODO: Move to the general section
				'cookie_consent_mgmt'           => [
					'explicit_consent' => false,
				],
				'order_deduplication'           => true,
				'disable_tracking_for'          => [],
				'order_list_info'               => true,
				'subscription_value_multiplier' => 1.00,
				'ltv'                           => [
					'order_calculation'       => [
						'is_active' => false,
					],
					'automatic_recalculation' => [
						'is_active' => false,
					],
				],
			],
			'general'    => [
				'variations_output'          => true,  // TODO maybe should be in the shop section
				'maximum_compatibility_mode' => false,
				'pro_version_demo'           => false,
				'scroll_tracker_thresholds'  => [],
				'lazy_load_pmw'              => false,
				'logger'                     => [
					'is_active'         => false,
					'level'             => 'warning',
					'log_http_requests' => false,
				],
			],
			'db_version' => PMW_DB_VERSION,
		];
	}

	public static function update_with_defaults( $target_array, $default_array ) {

//		error_log(print_r($target_array, true));

		// Walk through every key in the default array
		foreach ($default_array as $default_key => $default_value) {

			// If the target key doesn't exist yet
			// copy all default values,
			// including the subtree if one exists,
			// into the target array.
			if (!isset($target_array[$default_key])) {
				$target_array[$default_key] = $default_value;

				// We only want to keep going down the tree
				// if the array contains more settings in an associative array,
				// otherwise we keep the settings of what's in the target array.
			} elseif (self::is_associative_array($default_value)) {

				$target_array[$default_key] = self::update_with_defaults($target_array[$default_key], $default_value);
			}
		}

//		error_log(print_r($target_array, true));
		return $target_array;
	}

	protected static function does_contain_nested_arrays( $array ) {

		foreach ($array as $key) {
			if (is_array($key)) {
				return true;
			}
		}

		return false;
	}

	protected static function is_associative_array( $array ) {

		if (is_array($array)) {
			return ( array_values($array) !== $array );
		} else {
			return false;
		}
	}

	public static function get_db_version() {
		return self::get_options_obj()->db_version;
	}

	/**
	 * Facebook (Meta)
	 */

	public static function get_facebook_pixel_id() {
		return self::get_options_obj()->facebook->pixel_id;
	}

	public static function is_facebook_active() {
		return (bool) self::get_facebook_pixel_id();
	}

	public static function get_facebook_capi_token() {
		return self::get_options_obj()->facebook->capi->token;
	}

	public static function get_facebook_capi_test_event_code() {
		return self::get_options_obj()->facebook->capi->test_event_code;
	}

	public static function is_facebook_capi_user_transparency_process_anonymous_hits_active() {
		return (bool) self::get_options_obj()->facebook->capi->user_transparency->process_anonymous_hits;
	}

	public static function is_facebook_capi_advanced_matching_enabled() {
		return (bool) self::get_options_obj()->facebook->capi->user_transparency->send_additional_client_identifiers;
	}

	public static function is_facebook_capi_active() {
		return self::is_facebook_active() && self::get_facebook_capi_token();
	}

	public static function is_facebook_microdata_active() {
		return (bool) self::get_options_obj()->facebook->microdata;
	}

	/**
	 * TikTok
	 */

	public static function get_tiktok_pixel_id() {
		return self::get_options_obj()->tiktok->pixel_id;
	}

	public static function get_tiktok_eapi_token() {
		return self::get_options_obj()->tiktok->eapi->token;
	}

	public static function get_tiktok_eapi_test_event_code() {
		return self::get_options_obj()->tiktok->eapi->test_event_code;
	}

	public static function is_tiktok_active() {
		return (bool) self::get_tiktok_pixel_id();
	}

	public static function is_tiktok_eapi_test_event_code_set() {
		return (bool) self::get_tiktok_eapi_test_event_code();
	}

	public static function is_tiktok_eapi_active() {
		return self::is_tiktok_active() && self::get_tiktok_eapi_token();
	}

	public static function is_tiktok_advanced_matching_enabled() {
		return (bool) self::get_options_obj()->tiktok->advanced_matching;
	}

	public static function is_tiktok_eapi_process_anonymous_hits_active() {
		return (bool) self::get_options_obj()->tiktok->eapi->process_anonymous_hits;
	}

	/**
	 * Hotjar
	 */

	public static function get_hotjar_site_id() {
		return self::get_options_obj()->hotjar->site_id;
	}

	public static function is_hotjar_enabled() {
		return (bool) self::get_hotjar_site_id();
	}

	/**
	 * Microsoft Ads (Bing)
	 */

	public static function get_bing_uet_tag_id() {
		return self::get_options_obj()->bing->uet_tag_id;
	}

	public static function is_bing_active() {
		return (bool) self::get_bing_uet_tag_id();
	}

	public static function is_bing_enhanced_conversions_enabled() {
		return (bool) self::get_options_obj()->bing->enhanced_conversions;
	}

	/**
	 * Snapchat
	 */

	public static function get_snapchat_pixel_id() {
		return self::get_options_obj()->snapchat->pixel_id;
	}

	public static function is_snapchat_active() {
		return (bool) self::get_snapchat_pixel_id();
	}

	public static function is_snapchat_advanced_matching_enabled() {
		return (bool) self::get_options_obj()->snapchat->advanced_matching;
	}

	public static function get_snapchat_capi_token() {
		return self::get_options_obj()->snapchat->capi->token;
	}

	public static function is_snapchat_capi_active() {
		return self::is_snapchat_active() && self::get_snapchat_capi_token();
	}

	/**
	 * Pinterest
	 */

	public static function get_pinterest_pixel_id() {
		return self::get_options_obj()->pinterest->pixel_id;
	}

	public static function is_pinterest_active() {
		return (bool) self::get_pinterest_pixel_id();
	}

	public static function get_pinterest_ad_account_id() {
		return self::get_options_obj()->pinterest->ad_account_id;
	}

	// https://help.pinterest.com/en/business/article/enhanced-match
	public static function is_pinterest_enhanced_match_enabled() {
		return (bool) self::get_options_obj()->pinterest->enhanced_match;
	}

	public static function get_pinterest_apic_token() {
		return self::get_options_obj()->pinterest->apic->token;
	}

	public static function is_pinterest_apic_active() {
		return self::get_pinterest_ad_account_id() && self::get_pinterest_apic_token();
	}

	public static function is_pinterest_advanced_matching_active() {
		return (bool) self::get_options_obj()->pinterest->advanced_matching;
	}

	public static function is_pinterest_apic_process_anonymous_hits_active() {
		return (bool) self::get_options_obj()->pinterest->apic->process_anonymous_hits;
	}

	/**
	 * Twitter
	 */

	public static function get_twitter_pixel_id() {
		return self::get_options_obj()->twitter->pixel_id;
	}

	public static function is_twitter_active() {
		return (bool) self::get_twitter_pixel_id();
	}

	public static function get_twitter_event_ids() {
		return self::get_options_obj()->twitter->event_ids;
	}

	public static function get_twitter_event_id( $event ) {
		return self::get_options_obj()->twitter->event_ids->$event;
	}

	/**
	 * Google
	 */

	public static function get_google_ads_conversion_id() {
		return self::get_options_obj()->google->ads->conversion_id;
	}

	public static function is_google_ads_active() {
		return (bool) self::get_google_ads_conversion_id();
	}

	public static function get_google_ads_conversion_label() {
		return self::get_options_obj()->google->ads->conversion_label;
	}

	public static function is_google_ads_purchase_conversion_enabled() {
		return self::is_google_ads_active() && self::get_google_ads_conversion_label();
	}

	public static function is_google_ads_conversion_active() {
		return self::get_google_ads_conversion_id() && self::get_google_ads_conversion_label();
	}

	public static function is_google_enhanced_conversions_active() {
		return (bool) self::get_options_obj()->google->ads->enhanced_conversions;
	}

	public static function is_google_ads_conversion_adjustments_active() {
		return self::is_google_ads_purchase_conversion_enabled() && self::is_google_ads_conversion_adjustments_conversion_name_set();
	}

	public static function get_google_ads_conversion_adjustments_conversion_name() {
		return self::get_options_obj()->google->ads->conversion_adjustments->conversion_name;
	}

	public static function is_google_ads_conversion_adjustments_conversion_name_set() {
		return (bool) self::get_google_ads_conversion_adjustments_conversion_name();
	}

	public static function get_google_ads_merchant_id() {
		return (int) self::get_options_obj()->google->ads->aw_merchant_id;
	}

	public static function is_google_ads_conversion_cart_data_enabled() {
		return self::is_google_ads_purchase_conversion_enabled() && self::get_google_ads_merchant_id();
	}

	public static function is_google_active() {
		return self::is_google_ads_active() || self::is_google_analytics_active();
	}

	public static function get_google_ads_business_vertical_id() {
		return self::get_options_obj()->google->ads->google_business_vertical;
	}

	public static function get_ga4_measurement_id() {
		return self::get_options_obj()->google->analytics->ga4->measurement_id;
	}

	public static function is_ga4_enabled() {
		return (bool) self::get_ga4_measurement_id();
	}

	public static function get_ga4_data_api_property_id() {
		return self::get_options_obj()->google->analytics->ga4->data_api->property_id;
	}

	public static function get_ga4_data_api_credentials() {
		return (array) self::get_options_obj()->google->analytics->ga4->data_api->credentials;
	}

	public static function is_ga4_data_api_active() {
		return
			self::get_ga4_data_api_property_id()
			&& !empty(self::get_ga4_data_api_credentials());
	}

	public static function is_google_analytics_active() {
		return self::is_ga4_enabled();
	}

	public static function get_ga4_mp_api_secret() {
		return self::get_options_obj()->google->analytics->ga4->api_secret;
	}

	public static function is_ga4_mp_active() {
		return self::is_ga4_enabled() && self::get_ga4_mp_api_secret();
	}

	public static function is_google_tcf_support_active() {
		return (bool) self::get_options_obj()->google->tcf_support;
	}

	public static function is_google_consent_mode_active() {
		return (bool) self::get_options_obj()->google->consent_mode->active;
	}

	public static function is_google_user_id_active() {
		return (bool) self::get_options_obj()->google->user_id;
	}

	public static function is_google_link_attribution_active() {
		return (bool) self::get_options_obj()->google->analytics->link_attribution;
	}

	public static function get_google_ads_phone_conversion_number() {
		return self::get_options_obj()->google->ads->phone_conversion_number;
	}

	public static function get_google_ads_phone_conversion_label() {
		return self::get_options_obj()->google->ads->phone_conversion_label;
	}

	public static function is_ga4_page_load_time_tracking_active() {
		return (bool) self::get_options_obj()->google->analytics->ga4->page_load_time_tracking;
	}

	public static function get_google_ads_product_identifier() {
		return (int) self::get_options_obj()->google->ads->product_identifier;
	}

	/**
	 * Adroll
	 */

	public static function get_adroll_advertiser_id() {
		return self::get_options_obj()->pixels->adroll->advertiser_id;
	}

	public static function is_adroll_advertiser_id_set() {
		return (bool) self::get_adroll_advertiser_id();
	}

	public static function get_adroll_pixel_id() {
		return self::get_options_obj()->pixels->adroll->pixel_id;
	}

	public static function is_adroll_pixel_id_set() {
		return (bool) self::get_adroll_pixel_id();
	}

	public static function is_adroll_active() {
		return self::is_adroll_advertiser_id_set() && self::is_adroll_pixel_id_set();
	}

	/**
	 * LinkedIn
	 */

	public static function get_linkedin_partner_id() {
		return self::get_options_obj()->pixels->linkedin->partner_id;
	}

	public static function is_linkedin_active() {
		return (bool) self::get_linkedin_partner_id();
	}

	public static function get_linkedin_conversion_id( $event ) {
		return self::get_options_obj()->pixels->linkedin->conversion_ids->$event;
	}

	public static function get_linkedin_conversion_ids() {
		return self::get_options_obj()->pixels->linkedin->conversion_ids;
	}

	/**
	 * Outbrain
	 */

	public static function get_outbrain_advertiser_id() {
		return self::get_options_obj()->pixels->outbrain->advertiser_id;
	}

	public static function is_outbrain_active() {
		return (bool) self::get_outbrain_advertiser_id();
	}

	/**
	 * Reddit
	 */

	public static function get_reddit_advertiser_id() {
		return self::get_options_obj()->pixels->reddit->advertiser_id;
	}

	public static function is_reddit_active() {
		return (bool) self::get_reddit_advertiser_id();
	}

	public static function is_reddit_advanced_matching_enabled() {
		return (bool) self::get_options_obj()->pixels->reddit->advanced_matching;
	}

	/**
	 * Taboola
	 */

	public static function get_taboola_account_id() {
		return self::get_options_obj()->pixels->taboola->account_id;
	}

	public static function is_taboola_active() {
		return (bool) self::get_taboola_account_id();
	}

	/**
	 * VWO
	 */

	public static function get_vwo_account_id() {
		return self::get_options_obj()->pixels->vwo->account_id;
	}

	public static function is_vwo_active() {
		return (bool) self::get_vwo_account_id();
	}

	/**
	 * Optimizely
	 */

	public static function get_optimizely_project_id() {
		return self::get_options_obj()->pixels->optimizely->project_id;
	}

	public static function is_optimizely_active() {
		return (bool) self::get_optimizely_project_id();
	}

	/**
	 * AB Tasty
	 */

	public static function get_ab_tasty_account_id() {
		return self::get_options_obj()->pixels->ab_tasty->account_id;
	}

	public static function is_ab_tasty_active() {
		return (bool) self::get_ab_tasty_account_id();
	}

	/**
	 * Logger
	 */

	public static function is_logging_enabled() {
		return (bool) self::get_options_obj()->general->logger->is_active;
	}

	public static function get_log_level() {
		return self::get_options_obj()->general->logger->level;
	}

	public static function is_http_request_logging_enabled() {
		return (bool) self::get_options_obj()->general->logger->log_http_requests;
	}

	public static function disable_http_request_logging() {
		self::init();
		self::$options['general']['logger']['log_http_requests'] = false;
		update_option(PMW_DB_OPTIONS_NAME, self::$options);
	}

	/**
	 * Consent Management
	 */

	public static function get_restricted_consent_regions_raw() {
		return self::get_options_obj()->google->consent_mode->regions;
	}

	public static function are_restricted_consent_regions_set() {
		return !empty(self::get_options_obj()->google->consent_mode->regions);
	}

	public static function get_restricted_consent_regions() {

		$regions = self::get_restricted_consent_regions_raw();

		/**
		 * If the user selected the European Union,
		 * we have to add all EU country codes,
		 * then remove the 'EU' value.
		 */
		if (in_array('EU', $regions, true)) {
			$regions = array_diff(array_merge($regions, WC()->countries->get_european_union_countries()), [ 'EU' ]);
		}

		/**
		 * If any manipulation happened beforehand,
		 * make sure to deduplicate the values
		 * and make sure the array starts with a 0 key,
		 * otherwise the JSON output is wrong.
		 */
		return array_values(array_unique($regions));
	}

	public static function consent_management_is_explicit_consent_active_override() {
		return (bool) apply_filters('pmw_consent_management_is_explicit_consent_active', false);
	}

	public static function is_consent_management_explicit_consent_active() {
		return
			self::get_options_obj()->shop->cookie_consent_mgmt->explicit_consent
			|| self::consent_management_is_explicit_consent_active_override();
	}

	public static function get_cookie_consent_explicit_consent_input_field_name() {
		return PMW_DB_OPTIONS_NAME . '[shop][cookie_consent_mgmt][explicit_consent]';
	}

	/**
	 * General settings
	 */

	public static function get_scroll_tracking_thresholds() {
		return (array) self::get_options_obj()->general->scroll_tracker_thresholds;
	}

	public static function pro_version_demo_active() {

		if (self::get_options_obj()->general->pro_version_demo) {
			return true;
		}

		// If the option is off and
		// if the server is playground.wordpress.net then return true.
		// This way the toggle will still work.
		if (
			!self::get_options_obj()->general->pro_version_demo
			&& Environment::is_on_playground_wordpress_net()
		) {
			return true;
		}

		return false;
	}

	public static function is_maximum_compatiblity_mode_active() {
		return (bool) self::get_options_obj()->general->maximum_compatibility_mode;
	}

	public static function is_lazy_load_pmw_active() {
		return (bool) self::get_options_obj()->general->lazy_load_pmw;
	}

	/**
	 * Ensure that lazy loading is only active if the optimizers (VWO, Optimizely, AB Tasty, etc.) allow it.
	 * The reason is, because optimizers might flicker the page during loading (when test variations are applied).
	 *
	 * @return bool
	 */
	public static function lazy_load_requirements() {

		// If Google Optimize is active we need to make sure that the Google Optimize anti flicker snippet is active too

//		if (self::is_google_optimize_active() && !self::is_google_optimize_anti_flicker_active()) {
//			return false;
//		}

		return true;
	}

	public static function is_at_least_one_statistics_pixel_active() {
		return self::is_ga4_enabled()
			|| self::is_hotjar_enabled()
			|| self::is_vwo_active();
	}

	public static function is_at_least_one_marketing_pixel_active() {
		return self::is_adroll_active()
			|| self::is_bing_active()
			|| self::is_facebook_active()
			|| self::is_google_ads_active()
			|| self::is_linkedin_active()
			|| self::is_outbrain_active()
			|| self::is_pinterest_active()
			|| self::is_reddit_active()
			|| self::is_snapchat_active()
			|| self::is_taboola_active()
			|| self::is_tiktok_active()
			|| self::is_twitter_active();
	}

	public static function server_2_server_enabled() {
		return
			self::is_facebook_capi_active()
			|| self::is_tiktok_eapi_active()
			|| self::is_pinterest_apic_active()
			|| self::is_snapchat_capi_active();
	}

	public static function get_excluded_roles() {
		return (array) self::get_options_obj()->shop->disable_tracking_for;
	}

	/**
	 * Shop settings
	 */

	public static function is_order_duplication_prevention_option_active() {
		return (bool) self::get_options_obj()->shop->order_deduplication;
	}

	public static function is_order_duplication_prevention_option_disabled() {
		return !self::is_order_duplication_prevention_option_active();
	}

	public static function is_shop_variations_output_active() {
		return (bool) self::get_options_obj()->general->variations_output;
	}

	public static function is_order_level_ltv_calculation_active() {
		return (bool) self::get_options_obj()->shop->ltv->order_calculation->is_active;
	}

	public static function is_automatic_ltv_recalculation_active() {
		return (bool) self::get_options_obj()->shop->ltv->automatic_recalculation->is_active;
	}

	public static function enable_duplication_prevention() {
		self::init();
		self::$options['shop']['order_deduplication'] = true;
		update_option(PMW_DB_OPTIONS_NAME, self::$options);
	}

	public static function get_marketing_value_logic() {
		return self::get_options_obj()->shop->order_total_logic;
	}

	public static function get_marketing_value_logic_input_field_name() {
		return PMW_DB_OPTIONS_NAME . '[shop][order_total_logic]';
	}

	public static function is_shop_order_list_info_enabled() {
		return (bool) self::get_options_obj()->shop->order_list_info;
	}

	public static function is_dynamic_remarketing_enabled() {
		return true;
	}

	public static function is_dynamic_remarketing_variations_output_enabled() {
		return (bool) self::get_options_obj()->general->variations_output;
	}

	public static function get_subscription_multiplier() {
		return self::get_options_obj()->shop->subscription_value_multiplier;
	}
}
