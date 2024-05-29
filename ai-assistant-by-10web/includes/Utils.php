<?php

namespace AIAssistantTenWeb;

class Utils {
  public static function get_tenweb_connection_link($endpoint = 'sign-up', $args = []){
    // copied from manager.py
    $return_url = get_admin_url() . 'admin.php';
    if(is_multisite()) {
      $return_url = network_admin_url() . 'admin.php';
    }

    $return_url_args = array('page' => \AIAssistantTenWeb::MENU_SLUG);
    $register_url_args = array(
      'site_url' => urlencode(get_site_url()),
      'utm_source' => 'ai_assistant',
      'from_plugin' => 205,
      'plugin_id' => 205,
      'utm_medium' => 'freeplugin',
      'nonce' => wp_create_nonce(\AIAssistantTenWeb::CONNECTION_NONCE_ACTION),
      'subscr_id' => TENWEB_SO_FREE_SUBSCRIPTION_ID,
      'version' => TAA_VERSION
    );

    if(!empty($args)) {
      $register_url_args = $register_url_args + $args;
      $return_url_args = $return_url_args + $args;
    }

    $register_url_args['return_url'] = urlencode(add_query_arg($return_url_args, $return_url));

    $plugin_from = get_site_option("tenweb_manager_installed");
    if($plugin_from !== false) {
      $plugin_from = json_decode($plugin_from, true);
      if(is_array($plugin_from) && reset($plugin_from) !== false) {
        $register_url_args['plugin_id'] = reset($plugin_from);
        if(isset($plugin_from["type"])) {
          $register_url_args['utm_source'] = $plugin_from["type"];
        }
      }
    }

    $url = add_query_arg($register_url_args, TENWEB_DASHBOARD . '/' . $endpoint . '/');
    return $url;
  }

  public static function disconnect_from_tenweb(){
    $class_login = \Tenweb_Authorization\Login::get_instance();
    \Tenweb_Authorization\Helper::remove_error_logs();
    $class_login->logout(false, 'ai_assistant');


    delete_option("tenweb_ai_assistant_access_token");
    delete_option("tenweb_ai_assistant_domain_id");
    delete_option("tenweb_workspace_id");
    delete_option(\AIAssistantTenWeb::LIMITATION_OPTION);
  }

  public static function redirect_main_page(){
    if(is_multisite()) {
      \AIAssistantTenWeb\Utils::redirect(network_admin_url() . 'admin.php?page=' . \AIAssistantTenWeb::MENU_SLUG);
    }
    \AIAssistantTenWeb\Utils::redirect(get_admin_url() . 'admin.php?page=' . \AIAssistantTenWeb::MENU_SLUG);
  }

  public static function update_limitations($limitations){

    $tmp_limits = self::get_limitation();

    if(!empty($tmp_limits)){
      $limitations = array_merge($tmp_limits, $limitations);
    }

    foreach($limitations as $key => $value) {
      $key = sanitize_text_field($key);
      $value = sanitize_text_field($value);
      $limitations[$key] = $value;
    }

    update_option(\AIAssistantTenWeb::LIMITATION_OPTION, $limitations);
  }

  public static function is_connected() {
    $is_hosted = \Tenweb_Authorization\Helper::check_if_manager_mu();
    $is_connected = \Tenweb_Authorization\Login::get_instance()->check_logged_in();
    if ( $is_hosted || $is_connected ) {
      return true;
    }

    return false;
  }
  public static function get_access_token() {
    if ( \AIAssistantTenWeb\Utils::is_connected() ) {
      return get_site_option('tenweb_access_token');
    }

    return get_option('tenweb_ai_assistant_access_token');
  }

  public static function get_domain_id() {
    if ( \AIAssistantTenWeb\Utils::is_connected() ) {
      return get_site_option('tenweb_domain_id');
    }

    return get_option('tenweb_ai_assistant_domain_id');
  }

  public static function get_workspace_id(){
    return get_option('tenweb_workspace_id');
  }

  public static function get_limitation(){
    return get_option(\AIAssistantTenWeb::LIMITATION_OPTION);
  }

  public static function redirect($url){
    echo('<script>window.location.href="'.esc_url_raw($url).'"</script>');
    die;
  }


  /**
   * Function return user contract type
   * ai_assistant_free, platform, ...
  */
  public static function get_subscription_category() {
    $limitation = self::get_limitation();
    if ( !empty($limitation) && isset($limitation['subscriptionCategory'])) {
        return $limitation['subscriptionCategory'];
    } else {
        $user_info = get_option(TENWEB_PREFIX . '_user_info');
        if ( !empty($user_info) ) {
          return $user_info['agreement_info']->subscription_category;
        }
    }
    return '';
  }

  public static function is_free( $total_allowed_words ) {
    if ( intval($total_allowed_words) <= 5000 ) {
      return true;
    }
    return false;
  }
}