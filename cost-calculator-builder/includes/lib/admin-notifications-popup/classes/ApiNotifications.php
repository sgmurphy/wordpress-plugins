<?php

use ANP\NotificationEnqueueControl;

/**
 * STM PLugin Notices class
 */
class ApiNotifications {
	public static $json_file_url = 'https://promo-dashboard.stylemixthemes.com/wp-content/dashboard-promo/';
	public static $json_file_path;
	public static $json_file_data = array();
	public static $text_domain;

	/**
	 * Initializa building of admin notice
	 *
	 * @param array $plugin_data - data related to plugin.
	 * @return void
	 */
	public static function init( $plugin_data ) {
		self::$text_domain    = $plugin_data['plugin_name'];
		self::$json_file_path = self::get_prefix_product();

		if ( ! empty( self::get_notice_data_from_json() ) ) {
			self::$json_file_data = array_merge( self::get_notice_data_from_json(), self::$json_file_data );
		}

		add_action( 'anp_popup_items', [ self::class, 'get_post_dashboard' ] );

		STMHandlerNotification::getInstance();
		add_action( 'wp_ajax_stm_anp_notice_viewed', array( self::class, 'noticeUpdateViewedStatus' ) );
	}

	static function get_prefix_product () {
		if( !empty( self::$text_domain ) ) {
			return self::$json_file_url . self::$text_domain . '_posts.json';
		}
	}

	static function get_notice_data_from_json() {
		$notices = file_get_contents( self::$json_file_path );
		return json_decode( $notices, true );
	}

	public static function get_post_dashboard() {
		foreach ( self::$json_file_data as $notice ) {
			$notice_logo = $notice['product_logo'];
			$notice_id   = $notice['post_id'];

			$post_logo_class = substr( $notice_logo, 0, strrpos( $notice_logo, '.' ) );

			$notification_data = self::getNotificationData( 'notification_data' );
			$post_status  = $notification_data[$notice_id]['notice_status'] ?? '';
			$type_notices = $notice['post_terms']['type_notices'][0]['slug'] ?? '';

			if ( $type_notices === 'notification' && $post_status !== 'not-show-again' ) {

				$last_shown_time = $notification_data[$notice_id]['last_shown_time'] ?? 0;
				$impressions     = $notification_data[$notice_id]['impressions'] ?? 0;
				$current_time    = time();
				$next_show_time  = $last_shown_time + self::intervalImpressions( $notice['interval_days'], $notice['interval_hours'], $notice['interval_minutes'] );
				$status_click    = $notification_data[$notice_id]['status_click'] ?? '';
				$status_views    = $notification_data[$notice_id]['status_views'] ?? '';
				$logo_exists     = file_exists(STM_ANP_PATH . '/assets/img/' . $notice_logo);
				$post_logo_class = ! empty( $logo_exists ) ? $post_logo_class : '';

				if ( $current_time >= $next_show_time && $impressions < $notice['impressions_post'] ) {

					$status = (NotificationEnqueueControl::checkNotificationStatus('id-' . $notice_id)) ? 'new' : '';
					$html = '<div class="anp-item-base ' . esc_attr( $status ) . ' anp-item-theme-rate-wrap stm-notice-' . esc_attr( $post_logo_class ) . '" data-notify="id-' . esc_attr( $notice_id ) . '" data-status-click="'. esc_attr( $status_click ) .'" data-status-views="'. esc_attr( $status_views ) .'" data-notice-id="'. esc_attr( $notice_id ) .'">';
					$html .= ( ! empty( $logo_exists ) ) ? '<div class="left img"><img src="' . STM_ANP_URL . 'assets/img/' . $notice_logo . '"></div>' : '';
					$html .= '<div class="right"><h4>' . esc_html( $notice['post_title'] ) . '</h4><div class="desc">' . wp_kses_post( $notice['post_content'] ) . '</div>';
					$html .= '<div class="btns-wrap">';
					$html .= ( ! empty( $notice['button_text_post'] ) ) ? '<a href="' . esc_url( $notice['button_url_post'] ) . '" target="_blank" data-id="' . esc_attr( $notice_id ) . '" class="anp-btn anp-action-btn">' . esc_html( $notice['button_text_post'] ) . '</a>' : '';
					$html .= '<a href="#" class="anp-btn anp-skip-btn skip-notice" data-id="' . esc_attr( $notice_id ) . '">Later</a></div>';
					$html .= '</div>';
					$html .= '</div>';

					$notification_data[$notice_id]['status_views'] = 'viewed';
					update_option( 'notification_data', $notification_data, false );
					NotificationEnqueueControl::addMainItem( 'id-' . $notice_id, $html );
				}
			}
		}
	}

	public static function noticeUpdateViewedStatus() {
		check_ajax_referer( 'anp_nonce', 'security');

		$notifyKey = sanitize_text_field($_POST['item_key']);

		NotificationEnqueueControl::updateNotificationStatus( $notifyKey );
	}

	public static function getNotificationData( $key ) {
		$option_value = get_option( $key );
		if ( is_array( $option_value ) ) {
			return $option_value;
		} else {
			return array();
		}
	}

	public static function intervalImpressions( $days, $hours, $minutes ) {
		$seconds_per_day    = 24 * 60 * 60;
		$seconds_per_hour   = 60 * 60;
		$seconds_per_minute = 60;

		return ( intval ( $days ) * $seconds_per_day ) + ( intval( $hours ) * $seconds_per_hour ) + ( intval( $minutes ) * $seconds_per_minute );
	}
}
