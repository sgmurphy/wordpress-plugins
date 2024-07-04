<?php
/**
 * Class objects instance list.
 *
 * @since   13.3.3
 * @package AdTribes\PFP
 */

use AdTribes\PFP\Classes\WP_Admin;
use AdTribes\PFP\Classes\Marketing;

defined( 'ABSPATH' ) || exit;

return array(
    new WP_Admin(),
    new Marketing(),
);
