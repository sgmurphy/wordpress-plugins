<?php
/**
 * Connection to Mailchimp API
 * Mailchimp API docs: https://mailchimp.com/developer/marketing/api/
 * 
 */
namespace Mediavine\Grow\Connections;

Class Mailchimp extends \Social_Pug {

    /** @var null */
	private static $instance    = null;

    static $api_url;
    static $api_key;
    static $server;

    /**
     * 
	 * @return Connection|Mailchimp|\Social_Pug|null
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
            self::$api_key  = $settings['mailchimp-apikey'];
            self::$server   = self::get_server($settings['mailchimp-apikey']);

            self::$api_url  = 'https://' . self::$server . '.api.mailchimp.com/3.0/';
        }
	}

    /**
     * 
     * Extracts the Mailchimp server from the API Key
     * 
	 * @return string|false
	 */
    public static function get_server( $api_key ) {
        if ( empty($api_key) ) return false;

        $api_key_parts = explode('-',$api_key);
        return ( isset($api_key_parts[1]) ) ? $api_key_parts[1] : false;
    }

    /**
     * Get list of forms
     * 
     * @return array|false
     */
    public static function get_lists() {

        $request_args = array(
            'headers'     => array( 
                'Content-Type' => 'application/json; charset=utf-8',
                'Authorization' => 'Bearer ' . self::$api_key
                ),
            'method'      => 'GET',
            'data_format' => 'body',
        );

        $response = wp_remote_get( self::$api_url . 'lists', $request_args );
        
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
		return class_exists( 'Mediavine\Grow\Connections\Mailchimp' );
	}

   /**
    * 
    * Add subscriber to a specific Mailchimp List/Audience
	*
	* @param  array  $args    Request arguments
	* @return object          Response object
	*/
	public static function add_subscriber( $args ) {
        if ( ! is_array( $args ) ) { return false; }

        $request_args = array(
            'headers'               => array( 
                'Content-Type'      => 'application/json; charset=utf-8',
                'Authorization'     => 'Bearer ' . self::$api_key 
            ),
            'body'                  => json_encode( $args ),
            'method'                => 'POST',
            'skip_merge_validation' => true,
            'data_format'           => 'body',
        );

        if ( empty( $args['list'] ) || $args['list'] == 'none' ) { // Set to default list
            $lists = self::get_lists();

            foreach( $lists->lists as $list ) {
                $args['list'] = strval($list->id);
                continue;
            }
        }

        $response = wp_remote_post( self::$api_url . 'lists/' . $args['list'] . '/members' , $request_args );

        if ( $response ) {
            $results = json_decode( $response['body'] );

            if ( ! isset( $results->subscriber->id ) ) {
                error_log( 'Hubbub Error: Subscriber was not added to MailChimp.', 0 );
            }
        }

        return true;
   }
}