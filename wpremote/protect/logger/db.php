<?php
if (!defined('ABSPATH') && !defined('MCDATAPATH')) exit;

if (!class_exists('WPRProtectLoggerDB_V556')) :
class WPRProtectLoggerDB_V556 {
	private $tablename;
	private $bv_tablename;

	const MAXROWCOUNT = 100000;

	function __construct($tablename) {
		$this->tablename = $tablename;
		$this->bv_tablename = WPRProtect_V556::$db->getBVTable($tablename);
	}

	public function log($data) {
		if (is_array($data)) {
			if (WPRProtect_V556::$db->rowsCount($this->bv_tablename) > WPRProtectLoggerDB_V556::MAXROWCOUNT) {
				WPRProtect_V556::$db->deleteRowsFromtable($this->tablename, 1);
			}

			WPRProtect_V556::$db->replaceIntoBVTable($this->tablename, $data);
		}
	}
}
endif;