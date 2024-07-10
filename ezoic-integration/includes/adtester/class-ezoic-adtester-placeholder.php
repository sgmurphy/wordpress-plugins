<?php

namespace Ezoic_Namespace;

class Ezoic_AdTester_Placeholder {
	const EMBED_CODE_TEMPLATE = '<!-- Ezoic - %s - %s --><div id="ezoic-pub-ad-placeholder-%d" %s data-inserter-version="%d"></div><!-- End Ezoic - %s - %s -->';

	public $id;
	public $position_id;
	public $position_type;
	public $name;
	public $is_video_placeholder;

	public function __construct($id, $position_id, $name, $position_type, $is_video_placeholder) {
		$this->id					= $id;
		$this->position_id			= $position_id;
		$this->position_type		= $position_type;
		$this->name					= $name;
		$this->is_video_placeholder	= $is_video_placeholder;
	}

	/**
	 * Calculates the correct embed code to inject into the page
	 */
	public function embed_code( $inserter_version = -1 ) {
		$class = "";
		if ($this->is_video_placeholder) {
			$class = 'class="ezoic-ad-video-placeholder"';
		}
		return sprintf(self::EMBED_CODE_TEMPLATE, $this->name, $this->position_type, $this->position_id, $class, $inserter_version, $this->name, $this->position_type);
	}

	public static function from_pubad( $ad ) {
		$placeholder = new Ezoic_AdTester_Placeholder( $ad->id, $ad->adPositionId, $ad->name, $ad->positionType, $ad->isVideoPlaceholder );

		return $placeholder;
	}
}
