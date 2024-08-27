<?php
if (!defined('ABSPATH') && !defined('MCDATAPATH')) exit;

if (!class_exists('BVProtectLogger_V568')) :
require_once dirname( __FILE__ ) . '/logger/fs.php';
require_once dirname( __FILE__ ) . '/logger/db.php';

class BVProtectLogger_V568 {
	private $log_destination;

	const TYPE_FS = 0;
	const TYPE_DB = 1;

	function __construct($name, $type = BVProtectLogger_V568::TYPE_DB) {
		if ($type == BVProtectLogger_V568::TYPE_FS) {
			$this->log_destination = new BVProtectLoggerFS_V568($name);
		} else {
			$this->log_destination = new BVProtectLoggerDB_V568($name);
		}
	}

	public function log($data) {
		$this->log_destination->log($data);
	}
}
endif;