<?php
/**
 * Plugin Name: AI Assistant by 10Web
 * Plugin URI: https://10web.io/ai-assistant/
 * Description: 10Web AI Assistant creates perfect, unique, and SEO-optimized content 10x faster. Use AI Assistant directly inside your WordPress environment.
 * Version: 1.0.19
 * Author: 10Web - AI Assistant team
 * Author URI: https://10web.io/
 * Text Domain: ai-assistant-tenweb
 */



if(!defined('ABSPATH')) {
  exit;
}

if(!defined('TAA_PLUGIN_FILE')) {
  define('TAA_PLUGIN_FILE', __FILE__);
}


class AIAssistantTenWeb {
  const PREFIX = 'taa';

  protected static $instance = null;

  private $gutenberg = TRUE;
  private $classic = TRUE;
  public $plugin_url;
  public $plugin_dir;
  public $localize_popup_data = array();

  const REST_NONCE_ACTION = 'wp_rest';
  const CONNECTION_NONCE_ACTION = 'taa_10web_connection';
  const NONCE_ACTION = 'taa_10web_connection';
  const NOTIFICATION_OPTION = 'taa_notification';
  const AI_OUTPUT = 'taa_ai_output';
  const MENU_SLUG = 'ai_assistant_tenweb';
  const LIMITATION_OPTION = 'taa_limitation';


  private function __construct(){
    $this->define_params();
    require_once 'config.php';
    require_once 'vendor/autoload.php';

    if(!empty($_GET['nonce']) && wp_verify_nonce(sanitize_text_field($_GET['nonce']), self::CONNECTION_NONCE_ACTION)) {
      add_action('in_admin_header', array($this, 'connect_to_tenweb'));
    }

    if(isset($_GET['taa_disconnect']) && !empty($_GET['nonce']) && wp_verify_nonce(sanitize_text_field($_GET['nonce']), self::NONCE_ACTION)) {
      \AIAssistantTenWeb\Utils::disconnect_from_tenweb();
      \AIAssistantTenWeb\Utils::redirect_main_page();
    }

    \AIAssistantTenWeb\RestApi::get_instance();

    add_action('admin_init', array($this, 'update'));
    add_action('admin_menu', array($this, 'add_menu_page'), 20);
    add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    add_action('admin_footer', array($this, 'make_submenu_blank'));
    add_action('wp_ajax_install_plugin', array($this, 'install_plugin'));
    add_action('wp_ajax_get_word_usage', array($this, 'get_word_usage'));
    add_action('wp_ajax_how_to_use_intro_finished', array($this, 'how_to_use_intro_finished'));

    if ( \AIAssistantTenWeb\Utils::get_access_token() ) {
      if ( $this->gutenberg ) {
        require_once('views/gutenberg.php');
        new AIAssistantGutenberg($this);
      }
      if ( $this->classic ) {
        require_once('views/classic.php');
        new AIAssistantClassic($this);
      }
    }
  }

  public function how_to_use_intro_finished() {
    $ajax_nonce = isset($_POST['ajax_nonce']) ? sanitize_text_field($_POST['ajax_nonce']) : '';
    if ( !wp_verify_nonce($ajax_nonce, self::REST_NONCE_ACTION) ){
      wp_send_json_error();
    }
    update_option('taa_how_to_use_intro_finished', 1);
  }

  /* Download and activate plugins/add-ons from Ajax action */
  public function install_plugin() {
      $ajax_nonce = isset($_POST['ajax_nonce']) ? sanitize_text_field($_POST['ajax_nonce']) : '';
      if ( !wp_verify_nonce($ajax_nonce, self::REST_NONCE_ACTION) ){
          wp_send_json_error();
      }

      if(!current_user_can('install_plugins')){
        wp_send_json_error();
      }

      $plugin_zip_name = isset($_POST['plugin_zip_name']) ? sanitize_text_field($_POST['plugin_zip_name']) : '';
      $plugin_zip_url = esc_url("https://downloads.wordpress.org/plugin/".$plugin_zip_name.".latest-stable.zip");
      $plugin_file = isset($_POST['plugin_file']) ? sanitize_text_field($_POST['plugin_file']) : '';
      $activated = FALSE;
      if ( !file_exists(WP_PLUGIN_DIR . "/" . $plugin_file) ) {
          include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
          wp_cache_flush();
          $upgrader = new Plugin_Upgrader();
          $installed = $upgrader->install($plugin_zip_url);
          if ( is_wp_error( $installed ) ) {
              wp_send_json_error();
          }
     }
      else {
          $installed = TRUE;
      }

      if ( !is_wp_error( $installed ) && $installed ) {
         activate_plugin($plugin_file);
      }

      wp_send_json_success();
  }

  /**
   * Get the new data about word usage.
   *
   * @return void
   */
  public function get_word_usage() {
    $ajax_nonce = isset($_POST['ajax_nonce']) ? sanitize_text_field($_POST['ajax_nonce']) : '';
    if ( !wp_verify_nonce($ajax_nonce, self::REST_NONCE_ACTION) ){
      wp_send_json_error();
    }
    $limitation = \AIAssistantTenWeb\Utils::get_limitation();
    if ( !empty($limitation) && !empty($limitation['planLimit']) ) {
      if ( empty($limitation['alreadyUsed']) ) {
        $limitation['alreadyUsed'] = 0;
      }
      wp_send_json_success($limitation);
    }
    wp_send_json_error();
  }

  public function admin_enqueue_scripts(){
    $screen = get_current_screen();

    wp_enqueue_style('taa_main_css', TAA_URL . '/assets/css/main.css', array('taa-open-sans'), TAA_VERSION);

    if($screen->base === 'toplevel_page_' . self::MENU_SLUG) {
      wp_enqueue_script('taa_circle_progress_js', TAA_URL . '/assets/js/circle-progress.js', array('taa_main_js'), TAA_VERSION);
    }

    wp_register_style('taa-open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800&display=swap');
    wp_register_script('taa_main_js', TAA_URL . '/assets/js/main.js', array('jquery'), TAA_VERSION);
    wp_enqueue_script('taa_main_js');
    wp_register_style('taa_button_css', TAA_URL . '/assets/css/gutenberg.css', array('taa-open-sans'), TAA_VERSION);

    $limitation_data  = $this->get_limitation_data();
    $total_allowed_words = !empty ($limitation['planLimit']) ? intval($limitation['planLimit']) : 0;
    $popup_data = array(
      'free_limit_reached' => array(
              'title' => __('Free plan Limit Reached', 'ai-assistant-tenweb'),
              'text' => __('You have reached your monthly limit of Free Plan. Upgrade to a higher plan to continue using AI Assistant.', 'ai-assistant-tenweb'),
              'button' => __('Upgrade', 'ai-assistant-tenweb'),
              'action' => TENWEB_DASHBOARD.'/ai-assistant?open=livechat',
              'target_blank' => 1
          ),
      'plan_limit_reached' => array(
              'title' => __('Plan Limit Reached', 'ai-assistant-tenweb'),
              'text' => __('You have reached your monthly limit for the Personal Plan. Upgrade to a higher plan to continue using AI Assistant.', 'ai-assistant-tenweb'),
              'button' => __('Upgrade', 'ai-assistant-tenweb'),
              'action' => TENWEB_DASHBOARD.'/ai-assistant?open=livechat',
              'target_blank' => 1
          ),
      'permission_error' => array(
              'title' => __('Insufficient Permissions', 'ai-assistant-tenweb'),
              'text' => __('You cannot edit this page because you do not have the necessary permissions. Please log in with an administrator account to proceed.', 'ai-assistant-tenweb'),
              'button' => __('Got it', 'ai-assistant-tenweb'),
              'action' => '',
              'target_blank' => 0
          ),
      'there_is_in_progress_request' => array(
              'title' => __('Another request in progress', 'ai-assistant-tenweb'),
              'text' => __('It seems like another text generation request is in progress. Please retry once its finished.', 'ai-assistant-tenweb'),
              'button' => __('Got it', 'ai-assistant-tenweb'),
              'action' => '',
              'target_blank' => 0
          ),
      'input_is_long' => array(
              'title' => __('Input text is long', 'ai-assistant-tenweb'),
              'text' => __('Selected text is too long, please select a short text and try again.', 'ai-assistant-tenweb'),
              'button' => __('Got it', 'ai-assistant-tenweb'),
              'action' => '',
              'target_blank' => 0
          ),
      'something_wrong' => array(
            'title' => __('Something went wrong', 'ai-assistant-tenweb'),
            'text' => __('There was an issue while attempting to access 10Web services. Please try again later.', 'ai-assistant-tenweb'),
            'button' => __('Got it', 'ai-assistant-tenweb'),
            'action' => '',
            'target_blank' => 0
      ),
    );

    $popup_data = apply_filters("taa_localize_new_data", $popup_data);
    wp_localize_script('taa_main_js', 'taa_admin_vars', array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'ajaxnonce' => wp_create_nonce(self::REST_NONCE_ACTION),
      "rest_route" => get_rest_url(null, \AIAssistantTenWeb\RestApi::NAMESPACE),
      "notification_status" => get_transient(\AIAssistantTenWeb::NOTIFICATION_OPTION),
      'limitation_expired' => $limitation_data['limitation_expired'],
      'plan' => \AIAssistantTenWeb\Utils::is_free( $total_allowed_words ) ? 'Free' : '',
      'popup_data' => $popup_data,
   ));
  }

  /**
   * Get limitation expired or not and plan title
   *
   * @return array
   */
  public function get_limitation_data() {
      $limitation = \AIAssistantTenWeb\Utils::get_limitation();
      if ( !empty($limitation) && ($limitation['planLimit'] <= $limitation['alreadyUsed']) )  {
          return array(
              'limitation_expired'  => 1,
              'plan' => $limitation['planTitle'],
          );
      }
      return array(
          'limitation_expired'  => 0,
          'plan' => isset($limitation['planTitle']) ? $limitation['planTitle'] : __('Free', 'ai-assistant-tenweb'),
      );
  }

  public function add_menu_page(){
    add_menu_page('AI Assistant','AI Assistant','manage_options', self::MENU_SLUG,  array($this, 'settings_page_callback'), esc_url($this->plugin_url.'/assets/images/menu_icon.svg'), 30);
    add_submenu_page( self::MENU_SLUG, 'Main', 'Main', 'manage_options', self::MENU_SLUG, array($this, 'settings_page_callback'));

    $access_token = \AIAssistantTenWeb\Utils::get_access_token();
    if ( !empty($access_token) ) {
      add_submenu_page(
        self::MENU_SLUG,
        'Templates',
        '<span class="taa-submenu-templates taa-submenu-blank">Templates</span>',
        'manage_options',
                  esc_url(TENWEB_DASHBOARD . '/ai-assistant/templates')
      );
      $limitation = \AIAssistantTenWeb\Utils::get_limitation();
      $plan_limit = !empty ($limitation['planLimit']) ? intval($limitation['planLimit']) : 0;
      if ( \AIAssistantTenWeb\Utils::is_free( $plan_limit ) ) {
        add_submenu_page(
        self::MENU_SLUG,
        'Upgrade',
        '<span class="taa-submenu-upgrade taa-submenu-blank">Upgrade</span>',
        'manage_options',
                  esc_url(TENWEB_DASHBOARD . '/ai-assistant/')
        );
      }
      add_submenu_page(
        self::MENU_SLUG,
        'Customer Support',
        'Customer Support',
        'manage_options',
        'taa_customer_support',
        array($this,'customer_support')
      );
    }
  }

  public function customer_support() {
    require_once "views/customer_support.php";
  }

  /* Adding target blank attribut for templates and upgrade menu links */
  public function make_submenu_blank()
  {
    ?>
    <script type="text/javascript">
      jQuery(document).ready(function($) {
        jQuery('.taa-submenu-blank').parent().attr('target','_blank');
      });
    </script>
    <?php
  }

  public function settings_page_callback() {
    if ( isset($_GET['mode']) && $_GET['mode'] == 'advanced' ) {
      require_once 'views/logs.php';
    }
    else {
      require_once 'views/setting.php';
    }
  }

  public function connect_to_tenweb(){

    if(!empty($_GET['email']) && !empty($_GET['token']) && !empty($_GET['nonce']) && wp_verify_nonce(sanitize_text_field($_GET['nonce']), self::CONNECTION_NONCE_ACTION)) {
      delete_site_option("first_critical_generation_flag");
      $email = sanitize_email($_GET['email']);
      $token = sanitize_text_field($_GET['token']);
      $pwd = md5($token);
      $class_login = \Tenweb_Authorization\Login::get_instance();
      $args = ['connected_from' => "ai_assistant"];
      if($class_login->login($email, $pwd, $token, $args) == true && $class_login->check_logged_in()) {
        $taa_first_connect = get_option("taa_first_connect", false);
        $date = time();
        if(!$taa_first_connect) {
          update_option("taa_first_connect", $date);
        }

        \Tenweb_Authorization\Helper::remove_error_logs();

      } else {
        $errors = $class_login->get_errors();
        $err_msg = (!empty($errors)) ? $errors['message'] : 'Something went wrong.';
        set_site_transient('taa_auth_error_logs', $err_msg, MINUTE_IN_SECONDS);
      }

    }

    \AIAssistantTenWeb\TenWebApi::get_instance()->get_limitations();
    \AIAssistantTenWeb\Utils::redirect_main_page();
  }

  public function update(){
    include_once TAA_DIR . 'includes/Library.php';
    $version = get_option('taa_version');
    $new_version = TAA_VERSION;

    if(version_compare($version, $new_version, '<')) {
      update_option('taa_version', $new_version);
      if(\AIAssistantTenWeb\Utils::get_access_token()) {
        \AIAssistantTenWeb\TenWebApi::get_instance()->get_limitations();
      }
    }
  }

  private function define_params(){
    $this->plugin_url = plugins_url(plugin_basename(dirname(__FILE__)));
    $this->plugin_dir = WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__));

    if ( !function_exists('is_plugin_active') ) {
      include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    if ( !is_plugin_active("classic-editor/classic-editor.php") ) {
      $this->classic = FALSE;
    }
    else {
      $this->gutenberg = FALSE;
    }
  }

  public static function get_instance(){
    if(null == self::$instance) {
      self::$instance = new self;
    }

    return self::$instance;
  }

}

add_action("plugins_loaded", array('AIAssistantTenWeb', 'get_instance'));

