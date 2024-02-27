<?php
/**
 * The class provides utility functions related to WordPress.
 *
 * @package AdvancedAds
 * @author  Advanced Ads <info@wpadvancedads.com>
 * @since   1.47.0
 */

namespace AdvancedAds\Utilities;

use AdvancedAds\Framework\Utilities\Params;

defined( 'ABSPATH' ) || exit;

/**
 * Utilities WordPress.
 */
class WordPress {

	/**
	 * Get the current action selected from the bulk actions dropdown.
	 *
	 * @return string|false The action name or False if no action was selected
	 */
	public static function current_action() {
		$action = Params::request( 'action' );
		if ( '-1' !== $action ) {
			return sanitize_key( $action );
		}

		$action = Params::request( 'action2' );
		if ( '-1' !== $action ) {
			return sanitize_key( $action );
		}

		return false;
	}

	/**
	 * Returns whether the current user has the specified capability.
	 *
	 * @param string $capability Capability name.
	 *
	 * @return bool
	 */
	public static function user_can( $capability = 'manage_options' ): bool {
		// Admins can do everything.
		if ( current_user_can( 'manage_options' ) ) {
			return true;
		}

		return current_user_can(
			apply_filters( 'advanced-ads-capability', $capability )
		);
	}

	/**
	 * Returns the capability needed to perform an action
	 *
	 * @param string $capability A capability to check, can be internal to Advanced Ads.
	 *
	 * @return string
	 */
	public static function user_cap( $capability = 'manage_options' ) {
		// Admins can do everything.
		if ( current_user_can( 'manage_options' ) ) {
			return 'manage_options';
		}

		return apply_filters( 'advanced-ads-capability', $capability );
	}

	/**
	 * Get site domain
	 *
	 * @param string $part Part of domain.
	 *
	 * @return string
	 */
	public static function get_site_domain( $part = 'host' ): string {
		$domain = wp_parse_url( home_url( '/' ), PHP_URL_HOST );

		if ( 'name' === $part ) {
			$domain = explode( '.', $domain );
			$domain = count( $domain ) > 2 ? $domain[1] : $domain[0];
		}

		return $domain;
	}
}
