<?php
/**
 * Connection to Flodesk API
 * Flodesk API docs: https://developers.flodesk.com/
 * 
 */
namespace Mediavine\Grow\Connections;

Class Flodesk extends \Social_Pug {

    /** @var null */
	private static $instance    = null;

    static $api_url;
    static $api_key;

    /**
     * 
	 * @return Connection|Flodesk|\Social_Pug|null
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

    /**
	 *
	 */
	public function init() {
        if ( $this->should_run() ) {
            
            $settings       = self::get_prepared_settings();
            self::$api_key  = $settings['flodesk-apikey'];

            self::$api_url  = 'https://api.flodesk.com/v1/';
        }
	}

    /**
     * Get list of forms
     * 
     * @return array|false
     */
    public static function get_segments() {

        $request_args = array(
            'headers'     => array( 
                'Content-Type' => 'application/json; charset=utf-8',
                'Authorization' => 'Basic ' . base64_encode(self::$api_key . ':')
                ),
            'method'      => 'GET',
            'data_format' => 'body',
        );

        $response = wp_remote_get( self::$api_url . 'segments', $request_args );
        
        return ( is_wp_error( $response ) ) ? false : json_decode( $response['body'] );
    }

    /**
     * Retrieve settings for Save This
     * 
     * @return array
     */
    public static function get_prepared_settings() {
        $settings = \Mediavine\Grow\Settings::get_setting( 'dpsp_email_save_this', [] );
		return $settings['connection'];
    }

    /**
	 * @return bool|mixed
	 */
	public function should_run() {
		return class_exists( 'Mediavine\Grow\Connections\Flodesk' );
	}

   /**
    * 
    * Add subscriber to a specific Flodesk Segment
	*
	* @param  array  $args    Request arguments
	* @return object          Response object
	*/
	public static function add_subscriber( $args ) {
        if ( ! is_array( $args ) ) { return false; }

        $request_args = array(
            'headers'               => array( 
                'Content-Type'      => 'application/json; charset=utf-8',
                'Authorization'     => 'Basic ' . base64_encode(self::$api_key . ':') 
            ),
            'body'                  => json_encode( $args ),
            'method'                => 'POST',
            'skip_merge_validation' => true,
            'data_format'           => 'body',
        );

        $response = wp_remote_post( self::$api_url . 'subscribers/' , $request_args );

        if ( $response ) {
            $results = json_decode( $response['body'] );

            if ( ! isset( $results->id ) ) {
                error_log( 'Hubbub Error: Subscriber was not added to Flodesk.', 0 );
            }
        }

        if ( $args['segment'] != 'none' ) {

            $segment_request_args = array(
                'headers'               => array( 
                    'Content-Type'      => 'application/json; charset=utf-8',
                    'Authorization'     => 'Basic ' . base64_encode(self::$api_key . ':') 
                ),
                'body'                  => json_encode( array( 'segment_ids' => array( $args['segment'] ) ) ),
                'method'                => 'POST',
                'skip_merge_validation' => true,
                'data_format'           => 'body',
            );

            $segment_response = wp_remote_post( self::$api_url . 'subscribers/' . $results->id . '/segments' , $segment_request_args );

            if ( $segment_response ) {
                $results = json_decode( $segment_response['body'] );

                if ( ! isset( $results->subscriber->id ) ) {
                    error_log( 'Hubbub Error: Subscriber was not added to Flodesk Segment.', 0 );
                }
            }

        }

        return true;
   }
}