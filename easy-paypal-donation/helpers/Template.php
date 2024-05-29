<?php

namespace WPEasyDonation\Helpers;

class Template
{
	/**
	 * get template
	 * @param $name
	 * @param bool $require_once
	 * @param array $args
	 * @return string
	 */
	public static function getTemplate ($name, $require_once = true, $args = []): string
	{
		$located = '';
		if (file_exists(WPEDON_FREE_DIR_PATH . 'templates/'. $name)) {
			$located = WPEDON_FREE_DIR_PATH . 'templates/'. $name;
			load_template($located, $require_once, $args);
		}
		return $located;
	}
}