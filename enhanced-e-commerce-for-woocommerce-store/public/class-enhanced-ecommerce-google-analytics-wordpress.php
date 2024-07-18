<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       conversios.io
 * @since      1.0.0
 *
 * @package    Enhanced_Ecommerce_Google_Analytics
 * @subpackage Enhanced_Ecommerce_Google_Analytics/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Enhanced_Ecommerce_Google_Analytics
 * @subpackage Enhanced_Ecommerce_Google_Analytics/public
 * @author     Conversios
 */
require_once(ENHANCAD_PLUGIN_DIR . 'public/class-con-settings.php');
class Enhanced_Ecommerce_Google_Analytics_Wordpress extends Con_Settings
{
  /**
   * Init and hook in the integration.
   *
   * @access public
   * @return void
   */
  //set plugin version
  protected $plugin_name;
  protected $version;
  protected $fb_page_view_event_id;
  protected $gtm;

  /**
   * Enhanced_Ecommerce_Google_Analytics_Public constructor.
   * @param $plugin_name
   * @param $version
   */

  public function __construct($plugin_name, $version)
  {
    parent::__construct();
    $this->gtm = new Con_GTM_WP_Tracking($plugin_name, $version);
    $this->TVC_Admin_Helper = new TVC_Admin_Helper();
    $this->plugin_name = sanitize_text_field($plugin_name);
    $this->version = sanitize_text_field($version);
    $this->tvc_call_hooks_wp();
    $this->fb_page_view_event_id = $this->get_fb_event_id();

    /*
     * start tvc_options
     */
    $current_user = wp_get_current_user();
    //$current_user ="";
    $user_id = "";
    $user_type = "guest_user";
    if (isset($current_user->ID) && $current_user->ID != 0) {
      $user_id = $current_user->ID;
      $current_user_type = 'register_user';
    }
    $this->tvc_options = array(
      "local_time" => esc_js(time()),
      "is_admin" => esc_attr(is_admin()),
      "tracking_option" => esc_js($this->tracking_option),
      "property_id" => esc_js($this->ga_id),
      "measurement_id" => esc_js($this->gm_id),
      "google_ads_id" => esc_js($this->google_ads_id),
      "google_merchant_center_id" => esc_js($this->google_merchant_id),
      "o_enhanced_e_commerce_tracking" => esc_js($this->ga_eeT),
      "o_log_step_gest_user" => esc_js($this->ga_gUser),
      "o_impression_thresold" => esc_js($this->ga_imTh),
      "o_ip_anonymization" => esc_js($this->ga_IPA),
      "ads_tracking_id" => esc_js($this->ads_tracking_id),
      "remarketing_tags" => esc_js($this->ads_ert),
      "dynamic_remarketing_tags" => esc_js($this->ads_edrt),
      "google_ads_conversion_tracking" => esc_js($this->google_ads_conversion_tracking),
      "conversio_send_to" => esc_js($this->conversio_send_to),
      "ga_EC" => esc_js($this->ga_EC),
      "user_id" => esc_js($user_id),
      "user_type" => esc_js($user_type),
      "day_type" => esc_js($this->add_day_type()),
      "remarketing_snippet_id" => esc_js($this->remarketing_snippet_id),
      "fb_pixel_id" => esc_js($this->fb_pixel_id),
      "fb_event_id" => $this->get_fb_event_id(),
      "tvc_ajax_url" => esc_url(admin_url('admin-ajax.php'))
    );
    /*
     * end tvc_options
     */
    add_action('wp_ajax_datalayer_push', array($this, 'datalayer_push'));
    add_action('wp_ajax_nopriv_datalayer_push', array($this, 'datalayer_push'));
  }

  /*
   * it push datalayer by global ajax sucess event
   */
  public function datalayer_push()
  {
    if (!isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'conv_aio_nonce'))
    wp_die('only human allowed!');

    $data_layer['event'] = 'form_lead_submit';

    // WpForms plugin's form whenever submit via ajax then we will push datalayer.
    if ( isset($_POST['form_action']) && $_POST['form_action'] == "wpforms_submit" ) {      
      $data_layer['cov_form_name'] = 'Submited by WpForm plugin';
      $data_layer['cov_form_type'] = 'WpForm plugin';
      $data_layer['cov_form_id'] = isset($_POST['form_id']) ? sanitize_text_field($_POST['form_id']) : '' ;

      $form = wpforms()->form->get($data_layer['cov_form_id']);
      if ( $form ) {
        $data_layer['cov_form_name'] = $form->post_title;
      }
      wp_send_json($data_layer);
    }

    // Formidable plugin's form whenever submit via ajax then we will push datalayer.
    if ( isset($_POST['form_action']) && $_POST['form_action'] == "frm_entries_create" ) {      
      $data_layer['cov_form_name'] = 'Submited by Formidable plugin';
      $data_layer['cov_form_type'] = 'Formidable plugin';
      $data_layer['cov_form_id'] = isset($_POST['form_id']) ? sanitize_text_field($_POST['form_id']) : '' ;

      if (class_exists('FrmForm')) {
        $form = FrmForm::getOne($data_layer['cov_form_id']);
        if ( $form ) {
          $data_layer['cov_form_name'] = $form->name;
        }
      }
      wp_send_json($data_layer);
    }

    wp_die();
  }

  public function tvc_call_hooks_wp()
  {
    /**
     * add global site tag js or settings
     **/
    add_action("wp_head", array($this->gtm, "begin_datalayer"));
    add_action("wp_enqueue_scripts", array($this->gtm, "enqueue_scripts"));
    add_action("wp_head", array($this, "add_google_site_verification_tag"), 1);
    add_action("wp_footer", array($this->gtm, "add_gtm_data_layer_wp"), 1);

    if (!$this->disable_tracking($this->ga_eeT, "form_submit")) {

      if (is_plugin_active('gravityforms/gravityforms.php')) {
        add_action("wp_footer", array($this->gtm, "track_gravity_plugin_submission"));
      }

      // WPFrom plugin - form submit hook
      if (is_plugin_active('wpforms-lite/wpforms.php') || is_plugin_active('wpforms/wpforms.php')) {
        add_action("wpforms_process_complete", array($this->gtm, "track_wpform_plugin_submission"), 10, 4);
      }

      // Formidable form plugin - form submit hook
      if (is_plugin_active('formidable/formidable.php')) {
        //Note: even entry is disabled it will call/work.
        add_action("frm_after_create_entry", array($this->gtm, "track_formidable_plugin_submission"), 10, 2);
        if( isset($_POST['frm_action']) && isset($_POST['form_key']) ) {
          add_action("wp_footer", array($this->gtm, "track_formidable_plugin_submission_post"));
        }
      }
    }

    //Add Dev ID
    add_action("wp_head", array($this, "add_dev_id"));
    add_action("wp_enqueue_scripts", array($this, "tvc_store_meta_data"));
  }

  /**
   * Google Analytics Day type
   *
   * @access public
   * @return void
   */
  function add_day_type()
  {
    $date = gmdate("Y-m-d");
    $day = strtolower(gmdate('l', strtotime($date)));
    if (($day == "saturday") || ($day == "sunday")) {
      $day_type = esc_html__("weekend", "enhanced-e-commerce-for-woocommerce-store");
    } else {
      $day_type = esc_html__("weekday", "enhanced-e-commerce-for-woocommerce-store");
    }
    return $day_type;
  }
  /*
   * Site verification using tag method
   */
  public function add_google_site_verification_tag()
  {
    $TVC_Admin_Helper = new TVC_Admin_Helper();
    $ee_additional_data = $TVC_Admin_Helper->get_ee_additional_data();
    if (isset($ee_additional_data['add_site_varification_tag']) && isset($ee_additional_data['site_varification_tag_val']) && $ee_additional_data['add_site_varification_tag'] == 1 && $ee_additional_data['site_varification_tag_val'] != "") {
      echo wp_kses(
        html_entity_decode(base64_decode($ee_additional_data['site_varification_tag_val'])),
        array(
          'meta' => array(
            'name' => array(),
            'content' => array()
          )
        )
      );
    }
  }
  /**
   * Get store meta data for trouble shoot
   * @access public
   * @return void
   */
  function tvc_store_meta_data()
  {
    //only on home page
    global $woocommerce;
    $google_detail = $this->TVC_Admin_Helper->get_ee_options_data();
    $googleDetail = array();
    if (isset($google_detail['setting'])) {
      $googleDetail = $google_detail['setting'];
    }
    $tvc_sMetaData = array(
      'tvc_wcv' => isset($woocommerce->version) ? esc_js($woocommerce->version) : '',
      'tvc_wpv' => esc_js(get_bloginfo('version')),
      'tvc_eev' => esc_js($this->tvc_eeVer),
      'tvc_cnf' => array(
        't_cg' => esc_js($this->ga_CG),
        't_ec' => esc_js($this->ga_EC),
        't_ee' => esc_js($this->ga_eeT),
        't_df' => esc_js($this->ga_DF),
        't_gUser' => esc_js($this->ga_gUser),
        't_UAen' => esc_js($this->ga_ST),
        't_thr' => esc_js($this->ga_imTh),
        't_IPA' => esc_js($this->ga_IPA),
        //'t_OptOut' => esc_js($this->ga_OPTOUT),
        't_PrivacyPolicy' => esc_js($this->ga_PrivacyPolicy)
      ),
      'tvc_sub_data' => array(
        'sub_id' => esc_js(isset($googleDetail->id) ? sanitize_text_field($googleDetail->id) : ""),
        'cu_id' => esc_js(isset($googleDetail->customer_id) ? sanitize_text_field($googleDetail->customer_id) : ""),
        'pl_id' => esc_js(isset($googleDetail->plan_id) ? sanitize_text_field($googleDetail->plan_id) : ""),
        'ga_tra_option' => esc_js(isset($googleDetail->tracking_option) ? sanitize_text_field($googleDetail->tracking_option) : ""),
        'ga_property_id' => esc_js(isset($googleDetail->property_id) ? sanitize_text_field($googleDetail->property_id) : ""),
        'ga_measurement_id' => esc_js(isset($googleDetail->measurement_id) ? sanitize_text_field($googleDetail->measurement_id) : ""),
        'ga_ads_id' => esc_js(isset($googleDetail->google_ads_id) ? sanitize_text_field($googleDetail->google_ads_id) : ""),
        'ga_gmc_id' => esc_js(isset($googleDetail->google_merchant_center_id) ? sanitize_text_field($googleDetail->google_merchant_center_id) : ""),
        'ga_gmc_id_p' => esc_js(isset($googleDetail->merchant_id) ? sanitize_text_field($googleDetail->merchant_id) : ""),
        'op_gtag_js' => esc_js(isset($googleDetail->add_gtag_snippet) ? sanitize_text_field($googleDetail->add_gtag_snippet) : ""),
        'op_en_e_t' => esc_js(isset($googleDetail->enhanced_e_commerce_tracking) ? sanitize_text_field($googleDetail->enhanced_e_commerce_tracking) : ""),
        'op_rm_t_t' => esc_js(isset($googleDetail->remarketing_tags) ? sanitize_text_field($googleDetail->remarketing_tags) : ""),
        'op_dy_rm_t_t' => esc_js(isset($googleDetail->dynamic_remarketing_tags) ? esc_attr($googleDetail->dynamic_remarketing_tags) : ""),
        'op_li_ga_wi_ads' => esc_js(isset($googleDetail->link_google_analytics_with_google_ads) ? sanitize_text_field($googleDetail->link_google_analytics_with_google_ads) : ""),
        'gmc_is_product_sync' => esc_js(isset($googleDetail->is_product_sync) ? sanitize_text_field($googleDetail->is_product_sync) : ""),
        'gmc_is_site_verified' => esc_js(isset($googleDetail->is_site_verified) ? sanitize_text_field($googleDetail->is_site_verified) : ""),
        'gmc_is_domain_claim' => esc_js(isset($googleDetail->is_domain_claim) ? sanitize_text_field($googleDetail->is_domain_claim) : ""),
        'gmc_product_count' => esc_js(isset($googleDetail->product_count) ? sanitize_text_field($googleDetail->product_count) : ""),
        'fb_pixel_id' => esc_js($this->fb_pixel_id),
        'tracking_method' => esc_js($this->tracking_method),
        'user_gtm_id' => ($this->tracking_method == 'gtm' && $this->want_to_use_your_gtm == 1) ? esc_js($this->use_your_gtm_id) : (($this->tracking_method == 'gtm') ? "conversios-gtm" : ""),
      )
    );
    $this->wp_version_compare("tvc_smd=" . wp_json_encode($tvc_sMetaData) . ";");
  }

  /**
   * add dev id
   *
   * @access public
   * @return void
   */
  function add_dev_id()
  {
?>
    <script>
      (window.gaDevIds = window.gaDevIds || []).push('5CDcaG');
    </script>
  <?php
  }
}
/**
 * GTM Tracking Data Layer Push
 **/
class Con_GTM_WP_Tracking extends Con_Settings
{
  protected $plugin_name;
  protected $version;
  protected $user_data;
  public function __construct($plugin_name, $version)
  {
    parent::__construct();
    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->TVC_Admin_Helper = new TVC_Admin_Helper();
    $this->tvc_options = array(
      "affiliation" => esc_js(get_bloginfo('name')),
      "is_admin" => esc_attr(is_admin()),
      "tracking_option" => esc_js($this->tracking_option),
      "property_id" => esc_js($this->ga_id),
      "measurement_id" => esc_js($this->gm_id),
      "google_ads_id" => esc_js($this->google_ads_id),
      "fb_pixel_id" => esc_js($this->fb_pixel_id),
      "fb_event_id" => $this->get_fb_event_id(),
      "tvc_ajax_url" => esc_url(admin_url('admin-ajax.php')),
      "is_global_fs_enabled" => $this->disable_tracking($this->ga_eeT, "form_submit"),
    );
  }
  public function get_user_data()
  {
    if (empty($this->user_data)) {
      $this->set_user_data();
    }
    return $this->user_data;
  }

  public function set_user_data()
  {
    $enhanced_conversion = array();
    if (is_user_logged_in()) {
      global $current_user;
      wp_get_current_user();
    }
  }


  /**
   * begin datalayer like settings
   **/
  public function begin_datalayer()
  {

    if ($this->disable_tracking($this->ga_eeT)) {
      return;
    }

    /*start uset tracking*/
    $enhanced_conversion = array();

    $dataLayer = array("event" => "begin_datalayer");

    // For woocommerce only
    if (CONV_IS_WC) {
      global $woocommerce;

      //login user
      if (is_user_logged_in() && !is_order_received_page()) {
        global $current_user;
        wp_get_current_user();
        $billing_country    = WC()->customer->get_billing_country();
        $calling_code = WC()->countries->get_country_calling_code($billing_country);
        $phone = get_user_meta($current_user->ID, 'billing_phone', true);
        if ($phone != "") {
          $phone = str_replace($calling_code, "", $phone);
          $phone = $calling_code . $phone;
          $enhanced_conversion["phone_number"] = esc_js($phone);
        }
        $email = esc_js($current_user->user_email);
        if ($email != "") {
          $enhanced_conversion["email"] = esc_js($email);
        }
        $first_name         = esc_js($current_user->user_firstname);
        if ($first_name != "") {
          $enhanced_conversion["address"]["first_name"] = esc_js($first_name);
        }
        $last_name          = $current_user->user_lastname;
        if ($last_name != "") {
          $enhanced_conversion["address"]["last_name"] = esc_js($last_name);
        }
        $billing_address_1  = WC()->customer->get_billing_address_1();
        if ($billing_address_1 != "") {
          $enhanced_conversion["address"]["street"] = esc_js($billing_address_1);
        }
        $billing_postcode   = WC()->customer->get_billing_postcode();
        if ($billing_postcode != "") {
          $enhanced_conversion["address"]["postal_code"] = esc_js($billing_postcode);
        }
        $billing_city       = WC()->customer->get_billing_city();
        if ($billing_city != "") {
          $enhanced_conversion["address"]["city"] = esc_js($billing_city);
        }
        $billing_state      = WC()->customer->get_billing_state();
        if ($billing_state != "") {
          $enhanced_conversion["address"]["region"] = esc_js($billing_state);
        }
        $billing_country    = WC()->customer->get_billing_country();
        if ($billing_country != "") {
          $enhanced_conversion["address"]["country"] = esc_js($billing_country);
        }
      } else if (is_order_received_page()) { // get user       
        $order = "";
        $order_id = "";
        
        $order = $this->tvc_get_order_from_order_received_page();
        if( $order != false && $order !="" && !empty($order) ) {
          $order_id = $order->get_id();
        }
        
        if ($order_id) {
          $billing_country  = $order->get_billing_country();
          $calling_code = WC()->countries->get_country_calling_code($billing_country);
          $billing_email  = $order->get_billing_email();
          if ($billing_email != "") {
            $enhanced_conversion["email"] = esc_js($billing_email);
          }
          $billing_phone  = $order->get_billing_phone();
          if ($billing_phone != "") {
            $billing_phone = str_replace($calling_code, "", $billing_phone);
            $billing_phone = $calling_code . $billing_phone;
            $enhanced_conversion["phone_number"] = esc_js($billing_phone);
          }
          $billing_first_name = $order->get_billing_first_name();
          if ($billing_first_name != "") {
            $enhanced_conversion["address"]["first_name"] = esc_js($billing_first_name);
          }
          $billing_last_name = $order->get_billing_last_name();
          if ($billing_last_name != "") {
            $enhanced_conversion["address"]["last_name"] = esc_js($billing_last_name);
          }
          $billing_address_1 = $order->get_billing_address_1();
          if ($billing_address_1 != "") {
            $enhanced_conversion["address"]["street"] = esc_js($billing_address_1);
          }
          $billing_city = $order->get_billing_city();
          if ($billing_city != "") {
            $enhanced_conversion["address"]["city"] = esc_js($billing_city);
          }
          $billing_state = $order->get_billing_state();
          if ($billing_state != "") {
            $enhanced_conversion["address"]["region"] = esc_js($billing_state);
          }
          $billing_postcode = $order->get_billing_postcode();
          if ($billing_postcode != "") {
            $enhanced_conversion["address"]["postal_code"] = esc_js($billing_postcode);
          }
          $billing_country = $order->get_billing_country();
          if ($billing_country != "") {
            $enhanced_conversion["address"]["country"] = esc_js($billing_country);
          }
        }
      }
      $this->user_data = $enhanced_conversion;
    } // end woocommerce only

    // google ads
    if (!empty($this->gads_conversions)) {
      map_deep($this->gads_conversions, "esc_js");
      $dataLayer["cov_gads_conversions"] = $this->gads_conversions;
    }

    /*end user tracking*/
    $conversio_send_to = array();
    if ($this->conversio_send_to != "") {
      $conversio_send_to = explode("/", $this->conversio_send_to);
    }

    if ($this->ga_id != "") {
      $dataLayer["cov_ga3_propety_id"] = esc_js($this->ga_id);
    }
    if ($this->gm_id != "") {
      $dataLayer["cov_ga4_measurment_id"] = esc_js($this->gm_id);
    }
    if ($this->remarketing_snippet_id != "") {
      $dataLayer["cov_remarketing_conversion_id"] = esc_js($this->remarketing_snippet_id);
    }
    $dataLayer["cov_remarketing"] = $this->ads_ert;
    if ($this->fb_pixel_id != "") {
      $dataLayer["cov_fb_pixel_id"] = esc_js($this->fb_pixel_id);
    }
    if ($this->microsoft_ads_pixel_id != "") {
      $dataLayer["cov_microsoft_uetq_id"] = esc_js($this->microsoft_ads_pixel_id);
      if (CONV_IS_WC) {
        if ($this->msbing_conversion != "" && $this->msbing_conversion == "1") {
          $dataLayer["cov_msbing_conversion"] = esc_js($this->msbing_conversion);
        }
      }
    }
    if ($this->twitter_ads_pixel_id != "") {
      $dataLayer["cov_twitter_pixel_id"] = esc_js($this->twitter_ads_pixel_id);
    }

    if ($this->twitter_ads_form_submit_event_id != "") {
      $dataLayer["cov_twitter_ads_form_submit_event_id"] = esc_js($this->twitter_ads_form_submit_event_id);
    }

    if ($this->twitter_ads_email_click_event_id != "") {
      $dataLayer["cov_twitter_ads_email_click_event_id"] = esc_js($this->twitter_ads_email_click_event_id);
    }

    if ($this->twitter_ads_phone_click_event_id != "") {
      $dataLayer["cov_twitter_ads_phone_click_event_id"] = esc_js($this->twitter_ads_phone_click_event_id);
    }

    if ($this->twitter_ads_address_click_event_id != "") {
      $dataLayer["cov_twitter_ads_address_click_event_id"] = esc_js($this->twitter_ads_address_click_event_id);
    }

    if ($this->twitter_ads_add_to_cart_event_id != "") {
      $dataLayer["cov_twitter_ads_add_to_cart_event_id"] = esc_js($this->twitter_ads_add_to_cart_event_id);
    }
    if ($this->twitter_ads_checkout_initiated_event_id != "") {
      $dataLayer["cov_twitter_ads_checkout_initiated_event_id"] = esc_js($this->twitter_ads_checkout_initiated_event_id);
    }
    if ($this->twitter_ads_payment_info_event_id != "") {
      $dataLayer["cov_twitter_ads_payment_info_event_id"] = esc_js($this->twitter_ads_payment_info_event_id);
    }
    if ($this->twitter_ads_purchase_event_id != "") {
      $dataLayer["cov_twitter_ads_purchase_event_id"] = esc_js($this->twitter_ads_purchase_event_id);
    }

    if ($this->pinterest_ads_pixel_id != "") {
      $dataLayer["cov_pintrest_pixel_id"] = esc_js($this->pinterest_ads_pixel_id);
    }
    if ($this->snapchat_ads_pixel_id != "") {
      $dataLayer["cov_snapchat_pixel_id"] = esc_js($this->snapchat_ads_pixel_id);
    }
    if ($this->tiKtok_ads_pixel_id != "") {
      $dataLayer["cov_tiktok_sdkid"] = esc_js($this->tiKtok_ads_pixel_id);
    }

    if (!empty($enhanced_conversion)) {
      $dataLayer = array_merge($dataLayer, $enhanced_conversion);
    }

    if (!empty($conversio_send_to) && $this->conversio_send_to && $this->google_ads_conversion_tracking == 1) {
      $dataLayer["cov_gads_conversion_id"] = isset($conversio_send_to[0]) ? $conversio_send_to[0] : null;
      $dataLayer["cov_gads_conversion_label"] = isset($conversio_send_to[1]) ? $conversio_send_to[1] : "";
    }
    
    if ($this->hotjar_pixel_id != "") {
      $dataLayer["cov_hotjar_pixel_id"] = esc_js($this->hotjar_pixel_id);
    }
    if ($this->crazyegg_pixel_id != "") {
      $dataLayer["cov_crazyegg_pixel_id"] = esc_js($this->crazyegg_pixel_id);
    }
    if ($this->msclarity_pixel_id != "") {
      $dataLayer["cov_msclarity_pixel_id"] = esc_js($this->msclarity_pixel_id);
    }
    if ($this->google_ads_currency != "") {
      $dataLayer["conv_gads_currency"] = esc_js($this->google_ads_currency);
    }

    if (!$this->disable_tracking($this->ga_eeT, "email_click")) {
      $dataLayer["conv_track_email"] = "1";
    }

    if (!$this->disable_tracking($this->ga_eeT, "phone_click")) {
      $dataLayer["conv_track_phone"] = "1";
    }

    if (!$this->disable_tracking($this->ga_eeT, "address_click")) {
      $dataLayer["conv_track_address"] = "1";
    }

    $this->add_gtm_begin_datalayer_js($dataLayer);    
  }

  /** 
   * dataLayer for setting and GTM global tag
   **/
  public function add_gtm_begin_datalayer_js($data_layer)
  {
    $gtm_id = "GTM-K7X94DG";
    $has_html5_support = current_theme_supports('html5');
    echo '<script data-cfasync="false" data-pagespeed-no-defer' . ($has_html5_support ? ' type="text/javascript"' : '') . '>
      window.dataLayer = window.dataLayer || [];
      dataLayer.push(' . wp_json_encode($data_layer) . ');
    </script>';
  ?>
    <!-- Google Tag Manager by Conversios-->
    <script>
      (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
          'gtm.start': new Date().getTime(),
          event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
          j = d.createElement(s),
          dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
          'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer', '<?php echo esc_js($gtm_id); ?>');
    </script>
    <!-- End Google Tag Manager -->
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_js($gtm_id); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
  }

  /** 
   * DataLayer to JS
   **/
  public function add_gtm_datalayer_js($data_layer)
  {
    $has_html5_support = current_theme_supports('html5');
    echo '<script data-cfasync="false" data-pagespeed-no-defer' . ($has_html5_support ? ' type="text/javascript"' : '') . '>
      window.dataLayer = window.dataLayer || [];
      dataLayer.push(' . wp_json_encode($data_layer) . ');
    </script>';
  }
  
  /**
   * Formidable plugin form: formSubmit tracking without ajax
   */
  public function track_formidable_plugin_submission_post() {

    $has_html5_support = current_theme_supports('html5');
    ?>
    <script data-cfasync="false" data-pagespeed-no-defer <?php echo $has_html5_support ? ' type="text/javascript"' : '' ?> >
      // Formidable - FormSubmit event
      if (typeof conv_form_lead_submit !== 'undefined') {
          var datalayer = conv_form_lead_submit;
          window.dataLayer = window.dataLayer || [];
          window.dataLayer.push(datalayer);
      }
    </script><?php
  }
  /**
   * Gravity plugin form: formSubmit tracking
   */
  public function track_gravity_plugin_submission() {

    $has_html5_support = current_theme_supports('html5');
    ?>
    <script data-cfasync="false" data-pagespeed-no-defer <?php echo $has_html5_support ? ' type="text/javascript"' : '' ?> >
                
      // Gravity - FormSubmit event

      // when ajax method
      jQuery(document).on('gform_confirmation_loaded', function(event, formId) {
          //var form = window['gform'].forms[formId];
          var datalayer = {
              event: 'form_lead_submit',
              cov_form_type: "Gravity Form Plugin",
              cov_form_id: formId,
              cov_form_name: jQuery(this).data('title') || jQuery('.gform_title').text() || 'Form id:' + formId,
          };
          window.dataLayer = window.dataLayer || [];
          window.dataLayer.push(datalayer);
      });

      // when no ajax
      jQuery(document).on('gform_post_render', function(event, formId) {
        jQuery('#gform_' + formId).on('submit', function() {
              var datalayer = {
                  event: 'form_lead_submit',
                  cov_form_type: "Gravity Form Plugin",
                  cov_form_id: formId,
                  cov_form_name: jQuery(this).data('title') || jQuery('.gform_title').text() || 'Form id-' + formId,
              };
              window.dataLayer = window.dataLayer || [];
              window.dataLayer.push(datalayer);
          });
      });
    </script><?php
  }

  /**
   * WpForm plugin form: formSubmit tracking
   */
  public function track_wpform_plugin_submission($fields, $entry, $form_data, $entry_id)
  {

    $title = isset($form_data['settings']['form_title']) ? $form_data['settings']['form_title'] : '';
    $id = $form_data['id'] ?? '';

    $dataLayer = array();
    $dataLayer["event"] = "form_lead_submit";
    $dataLayer['cov_form_name'] = $title;
    $dataLayer["cov_form_type"] = "WpForm Plugin";
    $dataLayer['cov_form_id'] = $id;

    if ( !wp_doing_ajax() ) {
      // when no ajax method using by wpform
      $this->add_gtm_datalayer_js($dataLayer);
    } // else we will push datalayer via global ajax request
  }

  /**
   * Formidable form plugin: Form submit tracking
   *
   * Note: even entry is disabled it will call/work.
   */
  public function track_formidable_plugin_submission($entry_id, $form_id)
  {
    $form = FrmForm::getOne($form_id);
    $title = isset($form->name) ? $form->name : '';
    $id = isset($form_id) ? $form_id : '';

    $dataLayer = array();
    $dataLayer["event"] = "form_lead_submit";
    $dataLayer["cov_form_name"] = $title;
    $dataLayer["cov_form_type"] = "Formidable Plugin";
    $dataLayer["cov_form_id"] = $id;

    if ( !wp_doing_ajax() ) {
      // when no ajax method using

      /*
       * this code will use when page being redirect on submit.
       */
      //$this->begin_datalayer();
      //$this->add_gtm_datalayer_js($dataLayer); //<= we are not using this one because begin_datalayer() run after this hook

      $has_html5_support = current_theme_supports('html5');
      echo '<script data-cfasync="false" data-pagespeed-no-defer' . ($has_html5_support ? ' type="text/javascript"' : '') . '>';
        echo "conv_form_lead_submit=". wp_json_encode($dataLayer);
      echo '</script>';

    }// else we will push datalayer via global ajax request
  }

  public function enqueue_scripts()
  {
    wp_enqueue_script(esc_js($this->plugin_name), esc_url(ENHANCAD_PLUGIN_URL . '/public/js/con-gtm-google-analytics.js'), array('jquery'), esc_js($this->version), false);
    $nonce = wp_create_nonce('conv_aio_nonce');
    wp_localize_script(esc_js($this->plugin_name), 'ConvAioGlobal', array('nonce' => $nonce));
  }

  /**
   * Creat DataLyer object for create JS data layer
   **/
  public function add_gtm_data_layer_wp()
  {

    if ($this->disable_tracking($this->ga_eeT)) {
      return;
    }

    /**
     * Form submit event tracking
     **/
    if (!$this->disable_tracking($this->ga_eeT, "form_submit")) { ?>
      <script data-cfasync="false" data-no-optimize="1" data-pagespeed-no-defer>
        tvc_js = new TVC_GTM_Enhanced(<?php echo wp_json_encode($this->tvc_options); ?>);
        <?php if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) : ?>

          /*
           * Contact form 7 - formSubmit event
           */
          var wpcf7Elm = document.querySelector('.wpcf7');
          if (wpcf7Elm) {
            wpcf7Elm.addEventListener('wpcf7submit', function(event) {
              if (event.detail.status == 'mail_sent') {
                tvc_js.formsubmit_cf7_tracking(event);
              }
            }, false);
          }

        <?php endif; ?>

        <?php if (is_plugin_active('ninja-forms/ninja-forms.php')) : ?>

          /*
           * Ninja form - formSubmit event
           */
          jQuery(document).on('nfFormSubmitResponse', function(event, response, id) {
            tvc_js.formsubmit_ninja_tracking(event, response, id);
          });

        <?php endif; ?>

        <?php if ((is_plugin_active('wpforms-lite/wpforms.php') || is_plugin_active('wpforms/wpforms.php')) ||
          is_plugin_active('formidable/formidable.php')
        ) { ?>

          /*
           * Global - jQuery event handler that is triggered when an AJAX request completes successfully.
           */
          jQuery(document).ajaxSuccess(function(event, xhr, settings) {

            <?php if (is_plugin_active('wpforms-lite/wpforms.php') || is_plugin_active('wpforms/wpforms.php')) { ?>

              // WpForm - formSubmit event
              if (settings.data instanceof FormData) {
                var formdata = [];
                for (var pair of settings.data.entries()) {

                  if( 'form_id' in formdata && 'action' in formdata )
                    break;

                  if( pair[0] == 'wpforms[id]' ) 
                    formdata['form_id'] = pair[1];

                  if( pair[0] == 'action' && pair[1] == 'wpforms_submit' ) 
                    formdata['action'] = pair[1];

                }
                if ( formdata['action'] == 'wpforms_submit' && settings.data != 'action=datalayer_push') {
                  var data = [];
                  tvc_js.formsubmit_ajax_tracking(formdata);
                  return;
                }
              }
            <?php } ?>

            <?php if (is_plugin_active('formidable/formidable.php')) { ?>

              // Formidable - formSubmit event
              if (!(settings.data instanceof FormData)) {
                if (settings.hasOwnProperty('data')) {
                  settings.data.split('&').forEach(function(pair) {
                    if (pair == 'action=frm_entries_create') {
                      tvc_js.formsubmit_ajax_tracking(settings.data, 'Formidable');
                      return;
                    }
                  });
                }
              }
            <?php } ?>

          });
        <?php } // if end : is any one plugin active from formidable, wpform ?>
      </script>
      <?php
    } // END: if disable_tracking form_submit global.


    /**
     * on view page event
     **/
    /*if(empty($variable)){
      $variable=array(); //define empty array so if empty
    }else{
      $dataLayer = array();
      $dataLayer["event"] = "view_item";
      $dataLayer["ecommerce"]["items"][] = 
      array(
        "item_id" => isset($con_view_item["id"])?esc_js($con_view_item["id"]):"",
        "item_name" => isset($con_view_item["name"])?esc_js($con_view_item["name"]):"",
        "affiliation" => $affiliation,
        "currency" =>$this->ga_LC,
        "item_category" =>isset($con_view_item["category"])?esc_js($con_view_item["category"]):"",
        "price" =>isset($con_view_item["price"])?esc_js($con_view_item["price"]):"",
        "quantity" => 1
      );
      $this->add_gtm_datalayer_js($dataLayer);
    }*/
  } // End add_gtm_data_layer();

} // End Class Con_GTM_WP_Tracking()
