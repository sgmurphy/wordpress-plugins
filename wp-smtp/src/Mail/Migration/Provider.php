<?php

namespace SolidWP\Mail\Migration;

use SolidWP\Mail\Contracts\Service_Provider;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The provider for all Admin related functionality.
 *
 * @since 1.3.0
 *
 * @package SolidWP\Mail
 */
class Provider extends Service_Provider {
	/**
	 * {@inheritdoc}
	 */
	public function register(): void {
		$this->container->get( MigrationVer130::class )->register_hooks();
	}
}
