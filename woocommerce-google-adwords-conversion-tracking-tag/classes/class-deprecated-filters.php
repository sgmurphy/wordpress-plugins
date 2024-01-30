<?php

/**
 * Class for deprecated filters
 */

namespace WCPM\Classes;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Deprecated_Filters {

	public static function load_deprecated_filters() {

		// Choose what purchase event name has to be emitted, as TikTok has a choice of those
		// "CompletePayment" seems to be the one that is used to optimize catalog sales
		// "Purchase" seems also to work as per TikTok Pixel Helper
		apply_filters_deprecated(
			'wpm_tiktok_purchase_event_name',
			[ 'CompletePayment' ],
			'1.25.1',
			null,
			'This filter has been deprecated without replacement'
		);

		/**
		 * GA3 MP logger
		 */
		$ga3_mp_logger = apply_filters_deprecated('wooptpm_send_http_api_ga_ua_requests_blocking', [ false ], '1.13.0', 'wpm_send_http_api_ga_ua_requests_blocking');
		apply_filters_deprecated('wpm_send_http_api_ga_ua_requests_blocking', [ $ga3_mp_logger ], '1.27.9', 'pmw_http_send_hit_logger');

		/**
		 * GA4 MP logger
		 */
		$ga4_mp_logger = apply_filters_deprecated('wooptpm_send_http_api_ga_4_requests_blocking', [ false ], '1.13.0', 'wpm_send_http_api_ga_4_requests_blocking');
		apply_filters_deprecated('wpm_send_http_api_ga_4_requests_blocking', [ $ga4_mp_logger ], '1.27.9', 'pmw_http_send_hit_logger');

		/**
		 * Applies a deprecated filter 'pmw_maximum_number_of_orders_for_clv_query'.
		 *
		 * This filter was used to limit the number of orders queried for CLV (Customer Lifetime Value) calculations.
		 * It's deprecated from version '1.35.1' without any replacement.
		 *
		 * @deprecated 1.35.1 No replacement filter
		 *
		 * @see        apply_filters_deprecated()
		 */
		apply_filters_deprecated(
			'pmw_maximum_number_of_orders_for_clv_query',
			[ 100 ],
			'1.35.1',
			null,
			'This filter has been deprecated without replacement'
		);

		apply_filters_deprecated(
			'pmw_http_send_hit_logger',
			[ false ],
			'1.36.0',
			null,
			'This filter has been deprecated. Use the new logger in the user interface.'
		);

		apply_filters_deprecated(
			'wooptpm_send_http_api_requests_blocking', [ false ],
			'1.36.0',
			null,
			'This filter has been deprecated. Use the new logger in the user interface.'
		);

		apply_filters_deprecated(
			'wpm_send_http_api_requests_blocking', [ false ],
			'1.36.0',
			null,
			'This filter has been deprecated. Use the new logger in the user interface.'
		);

		apply_filters_deprecated(
			'pmw_send_http_api_requests_blocking',
			[ false ],
			'1.36.0',
			null,
			'This filter has been deprecated. Use the new logger in the user interface.'
		);

		apply_filters_deprecated(
			'wpm_facebook_capi_event_logger', [ false ],
			'1.36.0',
			null,
			'This filter has been deprecated. Use the new logger in the user interface.'
		);

		apply_filters_deprecated(
			'pmw_facebook_capi_event_logger',
			[ false ],
			'1.36.0',
			null,
			'This filter has been deprecated. Use the new logger in the user interface.'
		);

		apply_filters_deprecated(
			'wooptpm_facebook_capi_purchase_logging', [ false ],
			'1.36.0',
			null,
			'This filter has been deprecated. Use the new logger in the user interface.'
		);

		apply_filters_deprecated(
			'wpm_facebook_capi_purchase_logging', [ false ],
			'1.36.0',
			null,
			'This filter has been deprecated. Use the new logger in the user interface.'
		);

		apply_filters_deprecated(
			'pmw_facebook_capi_purchase_logging', [ false ],
			'1.36.0',
			null,
			'This filter has been deprecated. Use the new logger in the user interface.'
		);

		$mini_cart_filter_deprecation_message
			= 'The filter has become obsolete since PMW now tracks cart item data using the browser cache and doesn\'t rely entirely on the server anymore.';
		apply_filters_deprecated('wooptpm_track_mini_cart', [ true ], '1.13.0', '', $mini_cart_filter_deprecation_message);
		apply_filters_deprecated('wpm_track_mini_cart', [ true ], '1.15.5', '', $mini_cart_filter_deprecation_message);
	}
}
