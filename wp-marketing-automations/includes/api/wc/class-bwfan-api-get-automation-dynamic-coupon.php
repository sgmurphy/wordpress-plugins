<?php

class BWFAN_Api_Get_Automation_Dynamic_Coupons extends BWFAN_API_Base {

	public static $ins;
	public $products = array();

	public static function get_instance() {
		if ( null === self::$ins ) {
			self::$ins = new self();
		}

		return self::$ins;
	}

	public function __construct() {
		parent::__construct();
		$this->method       = WP_REST_Server::READABLE;
		$this->route        = '/autonami/coupons/';
		$this->public_api   = true;
		$this->request_args = array(
			'search' => array(
				'description' => __( 'Search from name', 'wp-marketing-automations' ),
				'type'        => 'string',
			),
		);

	}

	public function process_api_call() {
		$automation_id = ! empty( $this->get_sanitized_arg( 'id', 'text_field' ) ) ? $this->get_sanitized_arg( 'id', 'text_field' ) : '';
		$coupons       = [];
		if ( ! empty( $automation_id ) ) {
			$coupons = $this->get_dynamic_coupons( $automation_id );
		}

		$this->response_code = 200;

		return $this->success_response( $coupons );
	}

	public function get_dynamic_coupons( $automationId ) {
		global $wpdb;

		/** To get automation step with action create coupon and stataus is 1 */
		$query   = "SELECT * FROM {$wpdb->prefix}bwfan_automation_step WHERE `aid` = {$automationId} AND `action` LIKE '%wc_create_coupon%' AND `status` = '1'";
		$results = $wpdb->get_results( $query, ARRAY_A );

		/** Check for empty step */
		if ( empty( $results ) ) {
			return [];
		}

		$finalarr = [];

		/** @var  $automation_obj */
		$automation_obj = BWFAN_Automation_V2::get_instance( $automationId );

		/** Get automation meta data */
		$automation_data = $automation_obj->get_automation_meta_data();
		$mapped_arr      = [];

		/** Form  mapped array with step id and node id */
		foreach ( $automation_data['steps'] as $step ) {
			if ( isset( $step['stepId'] ) ) {
				$mapped_arr[ $step['stepId'] ] = $step['id'];
			}
		}

		/** Iterating over resulting steps */
		foreach ( $results as $data ) {
			$stepid    = $data['ID'];
			$step_data = ( array ) json_decode( $data['data'], true );

			/** Checking for title in coupon sidebar data */
			if ( isset( $step_data['sidebarData'] ) && isset( $step_data['sidebarData']['coupon_data'] ) && isset( $step_data['sidebarData']['coupon_data']['general'] ) && isset( $step_data['sidebarData']['coupon_data']['general']['title'] ) && ! empty( $step_data['sidebarData']['coupon_data']['general']['title'] ) ) {
				$coupon_title = $step_data['sidebarData']['coupon_data']['general']['title'] . ' ( #' . ( ! empty( $mapped_arr ) && isset( $mapped_arr[ $stepid ] ) ? $mapped_arr[ $stepid ] : $stepid ) . ' )';
			} else {
				$coupon_title = '#' . ( ! empty( $mapped_arr ) && isset( $mapped_arr[ $stepid ] ) ? $mapped_arr[ $stepid ] : $stepid );
			}

			$finalarr[] = [
				'key'   => '{{wc_dynamic_coupon id="' . $stepid . '"}}',
				'value' => $coupon_title,
			];
		}

		return $finalarr;
	}

}

BWFAN_API_Loader::register( 'BWFAN_Api_Get_Automation_Dynamic_Coupons' );