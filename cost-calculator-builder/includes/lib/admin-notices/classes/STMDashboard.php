<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * STM PLugin Notices class
 */
class STMDashboard {

	public $json_file_url = 'https://promo-dashboard.stylemixthemes.com/wp-content/dashboard-promo/';
	public $json_file_path;
	public $product_name ;
	public $json_data;

	/**
	 * Initializa building of admin notice
	 *
	 * @param array $plugin_data - data related to plugin.
	 * @return void
	 */
	public function __construct( $plugin_data ) {
		$this->product_name = $plugin_data['plugin_name'];

		$this->json_file_path = $this->get_prefix_product();
		$this->get_notice_data_from_json();

		add_action( 'admin_notices', array( $this, 'get_dashboard_popup' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ), 100 );

		STMHandler::getInstance();
		$this->add_notices_all();
	}

	/**
	 * Enqueue admin notice scripts
	 *
	 * @return void
	 */
	public function admin_enqueue() {
		wp_enqueue_style( 'stm_admin_notice', STM_ADMIN_NOTICES_URL . 'assets/css/admin.css', false ); // phpcs:ignore
		wp_enqueue_script( 'stm_admin_notice', STM_ADMIN_NOTICES_URL . 'assets/js/an-scripts.js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'stm_admin_notice', 'stmNotices', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'notices-nonce' ),
		));
	}

	public function add_notices_all() {
		if ( ! empty( $this->json_data ) ) {
			foreach ( $this->json_data as $notice ) {
				$post_logo = $notice['product_logo'];

				$post_logo_class = substr( $post_logo, 0, strrpos( $post_logo, '.' ) );
				$type_notices    = $notice['post_terms']['type_notices'][0]['slug'] ?? '';
				$notice_id       = $notice['post_id'];

				$notices_data = $this->getNotificationData( 'notices_data' );
				$notice_status     = $notices_data[$notice_id]['notice_status'] ?? '';

				if ( $type_notices === 'notice' && $notice_status !== 'not-show-again' ) {
					$last_shown_time = $notices_data[$notice_id]['last_shown_time'] ?? 0;
					$impressions     = $notices_data[$notice_id]['impressions'] ?? 0;
					$current_time    = time();
					$next_show_time  = $last_shown_time + $this->intervalImpressions( $notice['interval_days'], $notice['interval_hours'], $notice['interval_minutes'] );
					$status_click    = $notices_data[$notice_id]['status_click'] ?? '';
					$status_views    = $notices_data[$notice_id]['status_views'] ?? '';
					if ( $current_time >= $next_show_time && $impressions < $notice['impressions_post'] ) {


						$init_data = array(
							'notice_id'            => 'notice_' . $notice_id,
							'id'                   => $notice_id,
							'status_click'         => $status_click,
							'status_views'         => $status_views,
							'notice_type'          => 'notice is-dismissible stm-notice stm-notice-' . $post_logo_class,
							'notice_logo'          => $post_logo,
							'notice_title'         => $notice['post_title'],
							'notice_desc'          => $notice['post_content'],
							'notice_btn_one'       => esc_url( $notice['button_url_post'] ),
							'notice_btn_one_title' => $notice['button_text_post'],
						);
						stm_admin_notices_init( $init_data );
					}
				}
			}
		}

	}

	public function get_prefix_product () {
		if( ! empty( $this->product_name ) ) {
			return $this->json_file_url . $this->product_name . '_posts.json';
		}
	}

	public function get_notice_data_from_json() {
		if( empty( $this->json_data ) ) $this->json_data = array();
		if (! empty( $this->json_file_path ) ) {
			$notices = file_get_contents( $this->json_file_path );
			if( ! empty( $notices ) ) {
				$this->json_data = array_merge( $this->json_data, json_decode( $notices, true ) );
			}
		}
	}

	public function get_dashboard_popup() {
		if ( ! empty( $this->json_data ) ) {
			foreach ( $this->json_data as $notice ) {
				$type_category = $notice['post_terms']['type_category'][0]['slug'] ?? '';

				if ( $type_category === 'promo' ) {
					extract( $notice );
					$post_id           = $notice['post_id'];
					$notices_data      = $this->getNotificationData( 'notices_data' );
					$popup_data        = $this->getNotificationData( 'popup_data' );
					$post_status       = $notices_data[$post_id]['notice_status'] ?? '';

					$notice_cl_vi['status_click'] = $notices_data[$post_id]['status_click'] ?? '';
					$notice_cl_vi['status_views'] = $popup_data[$post_id]['status_views'] ?? '';
					extract( $notice_cl_vi );

					if ( $post_status !== 'not-show-again' ) {
						$last_shown_time = $notices_data[$post_id]['last_shown_time'] ?? 0;
						$impressions     = $notices_data[$post_id]['impressions'] ?? 0;

						$current_time    = time();
						$next_show_time  = $last_shown_time + $this->intervalImpressions( $notice['interval_days'], $notice['interval_hours'], $notice['interval_minutes'] );

						if ( $current_time >= $next_show_time && $impressions < $notice['impressions_post'] ) {
							if ( isset( $_GET['page'] ) && str_contains( $_GET['page'], $notice['product_page'] ) ) {
								if ( file_exists( STM_ADMIN_NOTICES_PATH . '/templates/dashboard-popup.php' ) ) {
									require_once STM_ADMIN_NOTICES_PATH . '/templates/dashboard-popup.php';
								}
								$popup_data   = $this->getNotificationData( 'popup_data' );
								$popup_data[$post_id]['status_views'] = 'viewed';
								update_option( 'popup_data', $popup_data, false );
							}
						}
					}
				}
			}
		}
	}

	public function getNotificationData( $key ) {
		$option_value = get_option( $key );
		if ( is_array( $option_value ) ) {
			return $option_value;
		} else {
			return array();
		}
	}

	public function intervalImpressions( $days, $hours, $minutes ) {
		$seconds_per_day    = 24 * 60 * 60;
		$seconds_per_hour   = 60 * 60;
		$seconds_per_minute = 60;

		return ( intval ( $days ) * $seconds_per_day ) + ( intval( $hours ) * $seconds_per_hour ) + ( intval( $minutes ) * $seconds_per_minute );
	}
}
