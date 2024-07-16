<?php
/**
 * Connection to MailerLite API
 * MailerLite API docs: https://developers.mailerlite.com/docs/ 
 * 
 */
namespace Mediavine\Grow\Connections;

Class MailerLite extends \Social_Pug {

    /** @var null */
	private static $instance    = null;

    static $api_url;
    static $token;

    /**
     * 
	 * @return Connection|MailerLite|\Social_Pug|null
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
            self::$token    = $settings['mailerlite-token'];

            self::$api_url  = 'https://connect.mailerlite.com/api/';
        }
	}

    /**
     * Get list of forms
     * 
     * @return array|false
     */
    public static function get_groups() {

        // MailerLite's API no likey the extra parameters that
        // wp_remote_get adds to a request.
        // So I've nulled out most of them. Left blocking as default.
        $request_args = array(
            'headers'     => array( 
                'Content-Type'      => 'application/json',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . self::$token
            ),
            'body' => '',
            'compress' => null,
            'decompress' => null,
            'sslverify' => null,
            'sslcertificates' => null,
            'stream' => null,
            'filename' => null,
            'limit_response_size' => null,
            '_redirection' => null,
            'timeout' => null,
            'redirection' => null,
            'httpversion' => null,
            'user-agent' => null,
            'reject_unsafe_urls' => false,
        );

        $response = wp_remote_get( self::$api_url . 'groups', $request_args );

        
        return ( is_wp_error( $response ) || ( isset( $response['code'] ) && $response['code'] != 200 ) ) ? false : json_decode( $response['body'] );
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
		return class_exists( 'Mediavine\Grow\Connections\MailerLite' );
	}

   /**
    * 
    * Add subscriber to a specific MailerLite Group
	*
	* @param  array  $args    Request arguments
	* @return object          Response object
	*/
	public static function add_subscriber( $args ) {
        if ( ! is_array( $args ) ) { return false; }

        $request_args = array(
            'headers'               => array( 
                'Content-Type'      => 'application/json',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . self::$token 
            ),
            'body'                  => json_encode( $args ),
            'method'                => 'POST'
        );

        $response = wp_remote_post( self::$api_url . 'subscribers/', $request_args );

        if ( $response ) {
            $results = json_decode( $response['body'] );

            if ( ! isset( $results->subscriber->id ) ) {
                error_log( 'Hubbub Error: Subscriber was not added to MailerLite.', 0 );
            }
        }

        return true;
   }
}