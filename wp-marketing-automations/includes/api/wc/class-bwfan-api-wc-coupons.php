<?php

class BWFAN_Api_Get_WC_Coupons extends BWFAN_API_Base {

	public static $ins;

	public static function get_instance() {
		if ( null === self::$ins ) {
			self::$ins = new self();
		}

		return self::$ins;
	}

	public function __construct() {
		parent::__construct();
		$this->method       = WP_REST_Server::READABLE;
		$this->route        = '/wc-coupons/';
		$this->public_api   = true;
		$this->request_args = array(
			'search' => array(
				'description' => __( 'Search from name', 'wp-marketing-automations' ),
				'type'        => 'string',
			),
		);

	}

	public function process_api_call() {
		$search  = ! empty( $this->get_sanitized_arg( 'search', 'text_field' ) ) ? $this->get_sanitized_arg( 'search', 'text_field' ) : '';
		$coupons = $this->get_all_coupons( $search );

		$this->response_code = 200;

		return $this->success_response( $coupons );
	}

	/**
	 * Get all WC coupons
	 *
	 * @return array
	 */
	public function get_all_coupons( $search ) {
		$coupon_posts = get_posts( array(
			'posts_per_page' => 10,
			'orderby'        => 'name',
			'order'          => 'asc',
			'post_type'      => 'shop_coupon',
			'post_status'    => 'publish',
			's'              => $search
		) );

		$coupon_data = [];
		foreach ( $coupon_posts as $coupon_post ) {
			$expiry      = false;
			$coupon      = new WC_Coupon( $coupon_post->ID );
			$expiry_date = $coupon->get_date_expires();
			if ( $expiry_date ) {
				$timezone        = $coupon->get_date_expires()->getTimezone(); // get timezone
				$expiry_datetime = new WC_DateTime( $expiry_date->date( 'Y-m-d' ) );
				$now_datetime    = new WC_DateTime();

				$expiry_datetime->setTimezone( $timezone );
				$now_datetime->setTimezone( $timezone );

				$expiry = $now_datetime->getTimestamp() > $expiry_datetime->getTimestamp();
			}
			$coupon_data[] = [
				'key'     => $coupon_post->post_name,
				'value'   => $coupon_post->ID,
				'expired' => $expiry,
			];
		}

		return $coupon_data;
	}

}

BWFAN_API_Loader::register( 'BWFAN_Api_Get_WC_Coupons' );