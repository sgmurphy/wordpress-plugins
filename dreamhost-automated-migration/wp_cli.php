<?php
if (!defined('ABSPATH')) exit;
if (!class_exists('DHWPCli')) :

require_once dirname( __FILE__ ) . '/recover.php';

class DHWPCli {
  public $settings;
  public $siteinfo;
  public $bvinfo;
  public $bvapi;

  public function __construct($settings, $bvinfo, $bvsiteinfo, $bvapi) {
    $this->settings = $settings;
    $this->siteinfo = $bvsiteinfo;
    $this->bvinfo = $bvinfo;
    $this->bvapi = $bvapi;
  }

  public function get_connection_key() {
    WP_CLI::line($this->bvinfo->getConnectionKey());
  }

  public function refresh_connection_key() {
    DHRecover::refreshDefaultSecret($this->settings);
    WP_CLI::success('Key Refreshed Successfully.');
  }

}
endif;