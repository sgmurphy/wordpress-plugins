<?php
namespace BetterLinks;

class Integration {
	public static function init() {
		$self = new self();
		$self->load_integrations();
	}

	public function load_integrations() {
		if ( defined( 'FLUENT_BOARDS' ) ) {
			Integration\FluentBoards::init();
		}
	}
}
