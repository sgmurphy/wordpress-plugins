<?php

namespace AIAssistantTenWeb;

class RestApi {

  const NAMESPACE = 'ai-assistant-tenweb/ai';
  const CORE_ENDPOINTS = [
    'core/paraphrase',
    'core/conclusion',
    'core/intro',
    'core/outline',
    'core/paragraph'
  ];
  protected static $instance = null;

  private function __construct(){
    add_action('rest_api_init', array($this, "init_rest_api"));
  }

  public function init_rest_api(){

    $default_rest_routs_args = [
      'methods' => 'POST',
      'callback' => array($this, 'core_default'),
      'permission_callback' => array($this, 'check_permission'),
    ];

    $default_rest_routs = [];
    foreach(self::CORE_ENDPOINTS as $endpoint) {

      $default_rest_routs[$endpoint] = array_merge($default_rest_routs_args, array('args' => [
        'prompt' => [
          'required' => true,
          'validate_callback' => array($this, 'validate_not_empty')
        ]
      ]));
    }

    $rest_routs = apply_filters('taa_rest_routs', $default_rest_routs);
    foreach($rest_routs as $endpoint => $args) {
      $args = array_merge($default_rest_routs_args, $args);
      register_rest_route(self::NAMESPACE, $endpoint, $args);
    }

    register_rest_route(self::NAMESPACE, 'ai_output',
      array(
        'methods' => 'GET',
        'callback' => array($this, 'get_ai_output'),
        'permission_callback' => array($this, 'check_permission'),
      )
    );

    register_rest_route(self::NAMESPACE, 'finish',
      array(
        'methods' => 'POST',
        'callback' => array($this, 'store_ai_output'),
        'permission_callback' => array($this, 'check_tenweb_token'),
      )
    );

  }

  public function core_default(\WP_REST_Request $request){
    $route = trim(explode(self::NAMESPACE, $request->get_route())[1], '/');

    if(get_transient(\AIAssistantTenWeb::NOTIFICATION_OPTION) === "in_progress") {
      wp_send_json_error("there_is_in_progress_request");
    }

    $params = [];
    foreach($request->get_body_params() as $param_name => $value) {
      $param_name = sanitize_textarea_field($param_name);
      $value = sanitize_textarea_field($value);
      $params[$param_name] = $value;
    }

    $api_response = TenWebApi::get_instance()->ai_action($params, $route);
    if($api_response !== "ok") {

      if(in_array($api_response, ['input_is_long', 'plan_limit_exceeded'])) {
        wp_send_json_error($api_response);
      } else {
        wp_send_json_error("api_error");
      }
    }

    set_transient(\AIAssistantTenWeb::NOTIFICATION_OPTION, "in_progress", 10 * MINUTE_IN_SECONDS);
    wp_send_json_success();
  }

  public function get_ai_output(){
    $response = [
      "status" => "",
      "output" => ""
    ];

    $transient = get_transient(\AIAssistantTenWeb::NOTIFICATION_OPTION);

    if($transient === false){
      $response["status"] = "done";
      wp_send_json_success($response);
    }

    $response["status"] = esc_html($transient);

    if($transient !== "done") {
      wp_send_json_success($response);
    }


    $response['output'] = htmlspecialchars_decode(wp_kses_post(get_option(\AIAssistantTenWeb::AI_OUTPUT, false)));
    delete_option(\AIAssistantTenWeb::AI_OUTPUT);
    delete_transient(\AIAssistantTenWeb::NOTIFICATION_OPTION);
    wp_send_json_success($response);
  }


  public function store_ai_output(\WP_REST_Request $request){

    $response = $request->get_json_params();

    update_option(\AIAssistantTenWeb::AI_OUTPUT, sanitize_textarea_field($response['output']));
    set_transient(\AIAssistantTenWeb::NOTIFICATION_OPTION, "done", MINUTE_IN_SECONDS);

    Utils::update_limitations($response['limitation']);

    wp_send_json_success();
  }

  public static function check_permission(\WP_REST_Request $request){
    $nonce = $request->get_headers()['x_wp_nonce'][0];

    if(wp_verify_nonce($nonce, \AIAssistantTenWeb::REST_NONCE_ACTION) === false) {
      return wp_send_json_error("invalid_nonce");
    }

    if(!current_user_can("edit_posts")) {
      return wp_send_json_error("permission_error");
    }

    return true;
  }

  public function check_tenweb_token(\WP_REST_Request $request){
    $auth_header = $request->get_header('tenweb_authorization');

    if(!$auth_header) {
      return false;
    }

    return TenWebApi::get_instance()->check_single_token($auth_header) === false;
  }

  public static function validate_not_empty($prompt){
    return !empty($prompt);
  }

  public static function get_instance(){
    if(null == self::$instance) {
      self::$instance = new self;
    }

    return self::$instance;
  }

}
