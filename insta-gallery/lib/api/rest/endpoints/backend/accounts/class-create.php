<?php
namespace QuadLayers\IGG\Api\Rest\Endpoints\Backend\Accounts;

use QuadLayers\IGG\Api\Rest\Endpoints\Backend\Base;
use QuadLayers\IGG\Models\Accounts as Models_Account;

/**
 * Api_Rest_Accounts_Create Class
 */
class Create extends Base {

	protected static $route_path = 'accounts';

	public function callback( \WP_REST_Request $request ) {

		try {

			$body = json_decode( $request->get_body() );

			if ( empty( $body->access_token ) ) {
				throw new \Exception( esc_html__( 'access_token not set.', 'insta-gallery' ), 412 );
			}

			if ( empty( $body->id ) ) {
				throw new \Exception( esc_html__( 'id not set.', 'insta-gallery' ), 412 );
			}

			$account = ( new Models_Account() )->create(
				array(
					'access_token' => $body->access_token,
					'id'           => $body->id,
				)
			);

			if ( ! isset( $account['access_token'] ) ) {
				throw new \Exception( isset( $account['message'] ) ? $account['message'] : esc_html__( 'Unable to create account.', 'insta-gallery' ), 412 );
			}

			return $this->handle_response( $account );

		} catch ( \Exception $e ) {
			$response = array(
				'code'    => $e->getCode(),
				'message' => $e->getMessage(),
			);
			return $this->handle_response( $response );
		}
	}

	public static function get_rest_args() {
		return array(
			'body' => array(),
		);
	}

	public static function get_rest_method() {
		return \WP_REST_Server::EDITABLE;
	}
}
