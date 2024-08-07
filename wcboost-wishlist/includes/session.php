<?php
/**
 * Wishlist Session handler
 *
 * @since 1.1.2
 */
namespace WCBoost\Wishlist;

defined( 'ABSPATH' ) || exit;

use WCBoost\Packages\Utilities\Singleton_Trait;

/**
 * Wishlist Session and Cookie Handler Class
 */
final class Session {
	use Singleton_Trait;

	const SESSION_NAME = 'wcboost_wishlist_session';
	const HASH_COOKIE = 'wcboost_wishlist_hash';

	/**
	 * Class constructor
	 */
	public function __construct() {
		// Cookie events.
		add_action( 'wcboost_wishlist_add_item', [ $this, 'maybe_set_hash_cookies' ] );
		add_action( 'wcboost_wishlist_removed_item', [ $this, 'maybe_set_hash_cookies' ] );
		add_action( 'wp', [ $this, 'maybe_set_hash_cookies' ], 99 );
		add_action( 'shutdown', [ $this, 'maybe_set_hash_cookies' ], 0 );
	}

	/**
	 * Will set cookies if needed and when possible.
	 *
	 * @since 1.1.2
	 *
	 * @return void
	 */
	public function maybe_set_hash_cookies() {
		if ( headers_sent() || ! did_action( 'wp_loaded' ) ) {
			return;
		}

		$this->set_hash_cookies();
	}

	/**
	 * Set wishlist hash cookie
	 *
	 * @since 1.1.2
	 *
	 * @param  bool $set Should the cookie be set or unset.
	 *
	 * @return void
	 */
	private function set_hash_cookies( $set = true )  {
		if ( $set ) {
			$wishlist = Helper::get_wishlist();
			$hash     = $wishlist->get_hash();

			wc_setcookie( static::HASH_COOKIE, $hash );
			$_COOKIE[ static::HASH_COOKIE ] = $hash;
		} else {
			wc_setcookie( static::HASH_COOKIE, '', time() - HOUR_IN_SECONDS );
			unset( $_COOKIE[ static::HASH_COOKIE ] );
		}
	}

	/**
	 * Get guest wishlist session ID.
	 *
	 * @since 1.1.2
	 *
	 * @return string
	 */
	public static function get_session_id() {
		if ( empty( $_COOKIE[ self::SESSION_NAME ] ) ) {
			return '';
		}

		return $_COOKIE[ self::SESSION_NAME ];
	}

	/**
	 * Set session id for guests.
	 * Store the session ID in cookie for 30 days. It can be changed via a hook.
	 *
	 * @since 1.1.2
	 *
	 * @param string $session_id
	 */
	public static function set_session_id( $session_id ) {
		$expire = time() + absint( apply_filters( 'wcboost_wishlist_session_expire', MONTH_IN_SECONDS ) );
		wc_setcookie( self::SESSION_NAME, $session_id, $expire );
		$_COOKIE[ self::SESSION_NAME ] = $session_id;
	}

	/**
	 * Clear session ID in the cookie
	 *
	 * @since 1.1.2
	 */
	public static function clear_session_id() {
		wc_setcookie( self::SESSION_NAME, '', time() - HOUR_IN_SECONDS );
		unset( $_COOKIE[ self::SESSION_NAME ] );
	}
}
