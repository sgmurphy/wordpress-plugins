<?php

namespace SweetCode\Pixel_Manager\Pixels;

use SweetCode\Pixel_Manager\Options;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Optimizely {

	public static function enqueue_scripts() {

		wp_enqueue_script(
			'optimizely',
			'https://cdn.optimizely.com/js/' . Options::get_optimizely_project_id() . '.js',
			[ 'jquery' ],
			PMW_CURRENT_VERSION,
			false
		);
	}
}
