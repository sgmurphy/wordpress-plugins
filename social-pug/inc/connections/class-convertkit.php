<?php
/**
 * Connection to ConvertKit API
 * ConvertKit API v3 docs: https://developers.convertkit.com/
 * 
 */
namespace Mediavine\Grow\Connections;

Class ConvertKit extends \Social_Pug {

    /** @var null */
	private static $instance    = null;

    static $api_url;
    static $api_key;

    /**
     * 
	 * @return Connection|ConverKit|\Social_Pug|null
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
            self::$api_url  = 'https://api.convertkit.com/v3/';
            $settings       = self::get_prepared_settings();
            self::$api_key  = $settings['convertkit-apikey'];
        }
	}

    /**
     * Get list of forms
     * 
     * @return array|false
     */
    public static function get_forms() {
        $response = wp_remote_get( self::$api_url . 'forms?api_key=' . self::$api_key );
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
		return class_exists( 'Mediavine\Grow\Connections\ConvertKit' );
	}

   /**
    * 
    * Add subscriber to a specific ConvertKit form
	*
	* @param  array  $args    Request arguments
	* @return object          Response object
	*/
	public static function add_subscriber( $args ) {
        if ( ! is_array( $args ) ) { return false; }

        $combined_args = array_merge( $args, array('api_key' => self::$api_key));

        $request_args = array(
            'headers'     => array( 'Content-Type' => 'application/json; charset=utf-8' ),
            'body'        => json_encode( $combined_args ),
            'method'      => 'POST',
            'data_format' => 'body',
        );

        $response = wp_remote_post( self::$api_url . 'forms/' . $args['form'] . '/subscribe' , $request_args );

        if ( $response ) {
            $results = json_decode( $response['body'] );

            if ( ! isset( $results->subscriber->id ) ) {
                error_log( 'Hubbub Error: Subscriber was not added to ConvertKit.', 0 );
            }
        }

        return true;
   }
}