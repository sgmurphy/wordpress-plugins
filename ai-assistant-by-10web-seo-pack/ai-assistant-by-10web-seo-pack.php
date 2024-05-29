<?php
/**
 * Plugin Name: AI Assistant by 10Web - SEO Pack
 * Plugin URI: https://10web.io/ai-assistant/
 * Description: AI Assistant by 10Web for SEO plugins
 * Version: 1.0.5
 * Author: 10Web - AI Assistant team
 * Author URI: https://10web.io/
 * Text Domain: ai-assistant-tenweb
 */

defined('ABSPATH') || die('Access Denied');

class AA_SEO_Pack_TenWeb {
  const PREFIX = 'taa_yoast';
  const VERSION = '1.0.5';

  protected static $instance = null;
  public $plugin_url;
  public $plugin_dir;

  private $main_plugin_status = "notInstalled";
  public $yoast_active = FALSE;
  public $edit_page = FALSE;
  const MENU_SLUG = "ai_assistant_tenweb";
  const PLUGIN_FILE = "ai-assistant-by-10web/ai-assistant-by-10web.php";
  const YOAST_PLUGIN_FILE = "wordpress-seo/wp-seo.php";
  const PLUGIN_ZIP = "https://downloads.wordpress.org/plugin/ai-assistant-by-10web.latest-stable.zip";


  public $main_page = array(
    'title' => 'AI Assistant by 10Web - SEO Pack',
    'desc' => 'Automatically fix SEO issues',
    'features' => array(
      'Meta description',
      'Keyphrase errors',
      'SEO Tittle errors',
      'SEO Analysis errors',
    ),
  );

  private $solutions = [];

  private function __construct(){
    $this->define_params();
    $this->init_solutions();
    $this->add_actions();
  }

  private function add_actions(){
    if ( $this->main_plugin_status != "active"
      && !class_exists("AIAssistantTenWebClassic") ) {
      add_action('admin_menu', array( $this, 'add_menu' ), 20);
    }
    else {
      add_filter('taa_rest_routs', array( $this, 'add_yoast_rest_routs' ));
      if ( $this->yoast_active && $this->edit_page ) {
        add_action('admin_footer', array( $this, 'button_template' ));
      }
    }
    if ( $this->yoast_active ) {
      add_action('admin_enqueue_scripts', array( $this, 'register_admin_scripts' ));
      add_action('wp_ajax_taa', array( $this, 'admin_ajax' ));
    }
  }

  public function register_admin_scripts(){
    wp_register_style('taa_yoast-editor-styles', $this->plugin_url . '/assets/css/editor.css', array('taa-gutenberg'), self::VERSION);

    wp_register_script('taa_yoast_solutions', $this->plugin_url . '/assets/js/solutions.js', array('taa_main_js'), self::VERSION);
    wp_register_script('taa_yoast', $this->plugin_url . '/assets/js/yoast.js', array('taa_yoast_solutions'), self::VERSION);

    wp_localize_script('taa_yoast_solutions', 'taa_yoast_vars', array(
      "solutions" => $this->solutions,
    ));

    $required_scripts = array('jquery');
    $required_styles = array(self::PREFIX . '-open-sans');
    wp_register_style(self::PREFIX . '-open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800&display=swap');
    wp_register_style(self::PREFIX . '-main', $this->plugin_url . '/assets/css/main.css', $required_styles, self::VERSION);

    wp_register_script(self::PREFIX . '-main', $this->plugin_url . '/assets/js/main.js', $required_scripts, self::VERSION);
    wp_localize_script(self::PREFIX . '-main', 'taa', array(
      'nonce' => wp_create_nonce('taa_nonce'),
      'button_text' => esc_html__('INSTALL MAIN PLUGIN', 'ai-assistant-tenweb')
    ));
  }

  public function add_yoast_rest_routs($endpoints){
    foreach($this->solutions as $solution) {

      $args = [];
      foreach($solution['params'] as $param => $val) {
        if(isset($val['required']) && $val['required']) {
          $args[$param] = [
            'required' => true,
            'validate_callback' => array('\AIAssistantTenWeb\RestApi', 'validate_not_empty')
          ];
        }
      }

      $endpoints[$solution['endpoint']] = [
        'args' => $args
      ];
    }

    return $endpoints;
  }

  public function button_template(){
    if ( !class_exists('\AA_SEO_Pack_TenWeb\Library') ) {
      include_once 'includes/Library.php';
    }

    if ( method_exists('\AA_SEO_Pack_TenWeb\Library', 'simple_ai_button') ) {
      wp_enqueue_style('taa_yoast-editor-styles');
      wp_enqueue_script('taa_yoast');
      \AA_SEO_Pack_TenWeb\Library::simple_ai_button();
    }
  }

  public function admin_ajax(){
    $nonce = isset($_POST['taa_nonce']) ? sanitize_text_field($_POST['taa_nonce']) : '';
    if(!wp_verify_nonce($nonce, 'taa_nonce')) {
      die('Permission Denied.');
    }
    if(!isset($_POST['action'])) {
      return;
    }
    $page = sanitize_text_field($_POST['action']);
    $allowed_pages = array('taa');
    if(!in_array($page, $allowed_pages)) {
      return;
    }
    if(!isset($_POST['task'])) {
      return;
    }
    $task = sanitize_text_field($_POST['task']);
    $allowed_tasks = array('install_plugin');
    if(in_array($task, $allowed_tasks)) {
      $this->$task();
    }
  }

  /**
   * Install/activate the main plugin.
   *
   * @return bool|int|true|WP_Error|null
   */
  private function install_plugin(){
    $activated = FALSE;

    if(!class_exists('Plugin_Upgrader')) {
      include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
    }

    if($this->main_plugin_status == "notInstalled") {
      if(!class_exists('Plugin_Upgrader')) {
        include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
      }
      wp_cache_flush();
      $upgrader = new Plugin_Upgrader();
      $installed = $upgrader->install(self::PLUGIN_ZIP);
    } else {
      $installed = TRUE;
    }

    if(!is_wp_error($installed) && $installed) {
      $activated = activate_plugin(self::PLUGIN_FILE);
    } else {
      wp_send_json_error();
    }

    // activate_plugin function returns null when the plugin activated successfully.
    if(is_null($activated)) {
      $this->main_plugin_status = "activated";
      wp_send_json_success();
    }

    wp_send_json_error();
  }


  private function define_params(){
    $this->plugin_dir = plugin_dir_path(__FILE__);
    $this->plugin_url = plugins_url(plugin_basename(dirname(__FILE__)));
    $this->main_plugin_status = $this->get_main_plugin_status();
    if ( is_plugin_active(self::YOAST_PLUGIN_FILE) ) {
      $this->yoast_active = TRUE;
    }
    global $pagenow;
    if ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) {
      $this->edit_page = TRUE;
    }
  }

  public function add_menu(){
    add_menu_page('10Web AI', '10Web AI', 'manage_options', self::MENU_SLUG, array($this, 'settings_page_callback'), $this->plugin_url . '/assets/images/menu_icon.svg', 30);
  }

  public function settings_page_callback(){
    require_once 'views/setting.php';
  }

  /**
   * Check the plugin status.
   *
   * @return string
   */
  private function get_main_plugin_status(){
    if(!function_exists('is_plugin_active')) {
      include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    if(is_plugin_active("ai-assistant-by-10web/ai-assistant-by-10web.php")) {
      return "active";
    } elseif($this->is_plugin_installed()) {
      return "installed";
    } else {
      return "notInstalled";
    }
  }

  /**
   * Check if the plugin already installed.
   *
   * @param string $slug plugin's slug
   *
   * @return bool
   */
  private function is_plugin_installed(){
    if(!function_exists('get_plugins')) {
      require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
    $all_plugins = get_plugins();

    return !empty($all_plugins[self::PLUGIN_FILE]);
  }


  private function init_solutions(){
    $this->solutions = [
      "keyphrase_in_intro" => [
        'class_name' => 'KeyphraseIntroTAA',
        'endpoint' => 'seo/keyphrase_in_intro',
        'solution_category' => 'seo_analysis',
        'yoast_url' => 'https://yoa.st/33e',
        'params' => [
          'keyphrase' => ['required' => true],
          'intro' => ['required' => true],
        ],
        'button_title' => __('Fix with 10Web AI', "ai-assistant-tenweb")
      ],
      "keyphrase_length" => [
        'class_name' => 'KeyphraseLengthTAA',
        'endpoint' => 'seo/keyphrase_length',
        'solution_category' => 'seo_analysis',
        'yoast_url' => 'https://yoa.st/33i',
        'params' => ['keyphrase' => ['required' => true]],
        'button_title' => __('Fix with 10Web AI', "ai-assistant-tenweb")
      ],
      "keyphrase_in_meta_description" => [
        'class_name' => 'KeyphraseInMetaDescriptionTAA',
        'endpoint' => 'seo/keyphrase_in_meta_description',
        'solution_category' => 'seo_analysis',
        'yoast_url' => 'https://yoa.st/33k',
        'params' => [
          'keyphrase' => ['required' => true],
          'text' => ['required' => true]
        ],
        'button_title' => __('Fix with 10Web AI', "ai-assistant-tenweb")
      ],
      "keyphrase_in_title" => [
        'class_name' => 'KeyphraseInTitleTAA',
        'endpoint' => 'seo/keyphrase_in_title',
        'solution_category' => 'seo_analysis',
        'yoast_url' => 'https://yoa.st/33g',
        'params' => [
          'keyphrase' => ['required' => true],
          'title' => ['required' => true],
        ],
        'requirements' => [
          'short_keyphrase' => ['required' => true]
        ],
        'button_title' => __('Fix with 10Web AI', "ai-assistant-tenweb")
      ],
      "title_length" => [
        'class_name' => 'TitleLengthTAA',
        'endpoint' => 'seo/title_length',
        'solution_category' => 'seo_analysis',
        'yoast_url' => 'https://yoa.st/34h',
        'params' => [
          'keyphrase' => ['required' => true],
          'title' => ['required' => true],
        ],
        'requirements' => [
          'short_keyphrase' => ['required' => true]
        ],
        'button_title' => __('Fix with 10Web AI', "ai-assistant-tenweb")
      ],
      "rephrase_meta_description" => [
        'class_name' => 'RephraseMetaDescriptionTAA',
        'endpoint' => 'seo/rephrase_meta_description',
        'solution_category' => 'seo_analysis',
        'yoast_url' => 'https://yoa.st/34d',
        'params' => [
          'keyphrase' => ['required' => true],
          'text' => ['required' => true]
        ],
        'button_title' => __('Fix with 10Web AI', "ai-assistant-tenweb")
      ],
      "meta_description" => [
        'class_name' => 'GenerateMetaDescriptionTAA',
        'endpoint' => 'seo/meta_description',
        'solution_category' => 'seo_analysis',
        'params' => [
          'keyphrase' => ['required' => true],
          'title' => ['required' => true],
          'subheadings' => ['required' => true]
        ],
        'button_title' => __('Generate with 10Web AI', "ai-assistant-tenweb")
      ],
    ];
  }

  public static function instance(){
    if(null == self::$instance) {
      self::$instance = new self;
    }

    return self::$instance;
  }
}

/**
 * Main instance of TAAY.
 *
 * @return TAAY The main instance to prevent the need to use globals.
 */
function AA_SEO_Pack_TenWeb(){
  return AA_SEO_Pack_TenWeb::instance();
}

AA_SEO_Pack_TenWeb();
