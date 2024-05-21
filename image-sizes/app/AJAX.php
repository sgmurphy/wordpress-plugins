<?php
namespace Codexpert\ThumbPress\App;

use Codexpert\Plugin\Base;
use Codexpert\ThumbPress\Helper;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author Codexpert <hi@codexpert.io>
 */
class Ajax extends Base {
	public $plugin;

	public $slug;

	public $name;
	
	public $version;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}

	public function dismiss_notice() {
		$response = [
			 'status'	=> 0,
			 'message'	=>__( 'Unauthorized!', 'image-sizes' )
		];

		if( ! wp_verify_nonce( $_POST['_wpnonce'], $this->slug ) ) {
		    wp_send_json( $response );
		}

		$add_24_hours 	= wp_date('U') + WEEK_IN_SECONDS;
		update_option( 'thumbpress_pro_notice_recurring_every_week', $add_24_hours );
		
		$response['status'] 	= 1;
		$response['message'] 	= __( 'Notice Removed', 'image-sizes' );
		wp_send_json( $response );
		
	}

	// public function dismiss_pointer() {

	// 	$response = [
	// 		 'status'	=> 0,
	// 		 'message'	=>__( 'Unauthorized!', 'image-sizes' )
	// 	];

	// 	if( ! wp_verify_nonce( $_POST['_wpnonce'], $this->slug ) ) {
	// 	    wp_send_json( $response );
	// 	}

	// 	$add_1_month 	= wp_date('U') + MONTH_IN_SECONDS ;
	// 	update_option( 'thumbpress_pro_notice_recurring_every_1_month', $add_1_month );
	// 	// update_option('thumbpress_pro_notice_1_time', true);

	// 	$response['status'] 	= 1;
	// 	$response['message'] 	= __( 'Pointer Removed', 'image-sizes' );
	// 	wp_send_json( $response );

	// }

	public function image_sizes_dismiss(){		

		if ( 'cx-setup-notice' ==  $_POST['meta_key'] ) {
			update_option( "{$this->slug}_dismiss", 1 );
		}
	}
}