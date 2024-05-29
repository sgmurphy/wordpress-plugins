<?php
define('TAA_VERSION', '1.0.19');
define('TAA_DIR', plugin_dir_path(TAA_PLUGIN_FILE));
define('TAA_BASENAME', plugin_basename(TAA_PLUGIN_FILE));
define('TAA_URL', plugins_url(plugin_basename(dirname(__FILE__))));

if(!defined('TENWEB_VERSION')) {
  define('TENWEB_VERSION', 'aa-' . TAA_VERSION);
}

require_once 'env.php';
