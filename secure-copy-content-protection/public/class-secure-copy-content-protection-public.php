<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Secure_Copy_Content_Protection
 * @subpackage Secure_Copy_Content_Protection/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Secure_Copy_Content_Protection
 * @subpackage Secure_Copy_Content_Protection/public
 * @author     Security Team <info@ays-pro.com>
 */
class Secure_Copy_Content_Protection_Public {
	/**
	 * The settings of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sccp_Settings_Actions object $settings The current settings of this plugin.
	 */
	protected $settings;
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->settings = new Sccp_Settings_Actions($this->plugin_name);
		add_shortcode( 'ays_block', array( $this, 'sccp_blockcont_generate_shortcode' ) );
		add_shortcode( 'ays_block_subscribe', array( $this, 'sccp_blocksubscribe_generate_shortcode' ) );		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		//Elementor plugin conflict solution
		if (isset($_GET['action']) && $_GET['action'] == 'elementor') {
			return false;
		}

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Secure_Copy_Content_Protection_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Secure_Copy_Content_Protection_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ($this->check_enable_sccp()) {
			wp_enqueue_style($this->plugin_name.'-public', plugin_dir_url(__FILE__) . 'css/secure-copy-content-protection-public.css', array(), $this->version, 'all');
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		//Elementor plugin conflict solution
		if (isset($_GET['action']) && $_GET['action'] == 'elementor') {
			return false;
		}
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Secure_Copy_Content_Protection_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Secure_Copy_Content_Protection_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ($this->check_enable_sccp()) {
			wp_enqueue_script('jquery');			
		}
	}

	public function sccp_blocksubscribe_generate_shortcode( $atts, $content ) {
		wp_enqueue_style($this->plugin_name.'-block-subscribe', plugin_dir_url(__FILE__) . 'css/block_subscribe_public.css', array(), $this->version, 'all');
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/secure-copy-content-protection-public.js', array('jquery'), $this->version, false);
		global $wpdb;
	 	$sccp_settings = $this->settings;

		$id = (isset($atts['id']) && $atts['id'] != '') ? absint(intval(esc_sql($atts['id']))) : null;
		if (is_null($id)) {
            return '<p>' .$content. '</p>';
        }
		$subsql = "SELECT * FROM ".$wpdb->prefix."ays_sccp_block_subscribe WHERE id=".$id;
		$get_sub_res = $wpdb->get_results($subsql , "ARRAY_A"); 
		if(empty($get_sub_res)){
			return '<p>' .$content. '</p>';
		}
		$report_table = esc_sql($wpdb->prefix."ays_sccp_reports");

		$ays_sccp_table = esc_sql(SCCP_TABLE);
		$ays_sccp_result = $wpdb->get_row("SELECT * FROM " . $ays_sccp_table . " WHERE id = 1", ARRAY_A);
		$ays_sccp_data   = json_decode($ays_sccp_result["options"], true);

		// General Setting's Subscribe       
        $general_settings_subscribe = ($sccp_settings->ays_get_setting('subscribe') === false) ? json_encode(array()) : $sccp_settings->ays_get_setting('subscribe');
        $subscribe_settings = json_decode(stripcslashes($general_settings_subscribe), true);

        // Subscribe box width
        if(isset($subscribe_settings['sccp_sub_width']) && $subscribe_settings['sccp_sub_width'] != '' && absint( $subscribe_settings['sccp_sub_width'] ) > 0){
            if (isset($subscribe_settings['sccp_sub_width_by_percentage_px']) && $subscribe_settings['sccp_sub_width_by_percentage_px'] == 'percentage') {
                if (absint(intval($subscribe_settings['sccp_sub_width'])) > 100 ) {
                    $sub_width = 'max-width: 100%;';
                }else{
                    $sub_width = 'max-width: '. $subscribe_settings['sccp_sub_width'] . '%;';
                }
            }else{
                $sub_width = 'max-width: '. $subscribe_settings['sccp_sub_width'] . 'px;';
            }
        }else{
            $sub_width = 'max-width: fit-content;';
        }

        // Subscribe box text color
		$sub_text_color = (isset($subscribe_settings['sccp_sub_text_color']) && $subscribe_settings['sccp_sub_text_color'] != '') ? 'color:'.stripslashes( esc_attr($subscribe_settings['sccp_sub_text_color']) ).';' : 'color: #000;';

        // Subscribe description text color
		$sub_desc_text_color = (isset($subscribe_settings['sccp_sub_desc_text_color']) && $subscribe_settings['sccp_sub_desc_text_color'] != '') ? 'color:'.stripslashes( esc_attr($subscribe_settings['sccp_sub_desc_text_color']) ).';' : 'color: #000;';

        // Subscribe box background color
		$sub_bg_color = (isset($subscribe_settings['sccp_sub_bg_color']) && $subscribe_settings['sccp_sub_bg_color'] != '') ? 'background-color:'.stripslashes( esc_attr($subscribe_settings['sccp_sub_bg_color']) ).';' : 'background-color: #fff;';

		// Subscribe box title transformation
        $sub_title_transformation = (isset($subscribe_settings['sub_title_transformation']) && sanitize_text_field( $subscribe_settings['sub_title_transformation'] ) != "") ? sanitize_text_field( $subscribe_settings['sub_title_transformation'] ) : 'none';

		// Subscribe box title font size		
		$sub_title_size = isset($subscribe_settings['sccp_sub_title_size']) && $subscribe_settings['sccp_sub_title_size'] != '' && $subscribe_settings['sccp_sub_title_size'] != 0 ? 'font-size: '. absint( sanitize_text_field($subscribe_settings['sccp_sub_title_size']) ). 'px;' : '';

		// Subscribe box description font size		
		$sub_desc_size = isset($subscribe_settings['sccp_sub_desc_size']) && $subscribe_settings['sccp_sub_desc_size'] != '' && $subscribe_settings['sccp_sub_desc_size'] != 0 ? 'font-size: '. absint( sanitize_text_field($subscribe_settings['sccp_sub_desc_size']) ). 'px;' : '';
		

        // Subscribe button text
		$sub_button_text = (isset($subscribe_settings['sccp_sub_button_text']) && $subscribe_settings['sccp_sub_button_text'] != '') ? stripslashes( esc_attr($subscribe_settings['sccp_sub_button_text']) ) : __('Subscribe', $this->plugin_name);

		// Subscribe Add Icon image
		$sccp_sub_icon_image = isset($subscribe_settings["sub_icon_image"]) && !empty($subscribe_settings["sub_icon_image"]) ? $subscribe_settings["sub_icon_image"] : SCCP_PUBLIC_URL.'/images/email.png';

		// Subscribe Add BG image
		$sccp_sub_bg_image = isset($subscribe_settings["sub_bg_image"]) && !empty($subscribe_settings["sub_bg_image"]) ? 'background-image: url('.$subscribe_settings["sub_bg_image"].');' : '';

		// Subscribe Bg image positioning
		$sccp_sub_bg_image_position = (isset($subscribe_settings["sub_bg_image_position"]) && $subscribe_settings["sub_bg_image_position"] != '') ? 'background-position:'. $subscribe_settings["sub_bg_image_position"] .';' : "background-position:center center;";
		
		// Subscribe button style
		$subscribe_settings['enable_sub_btn_style'] = (isset($subscribe_settings['enable_sub_btn_style']) && $subscribe_settings['enable_sub_btn_style'] == 'on') ? 'on' : 'off'; 
		$ays_sccp_enable_sub_btn_style = (isset($subscribe_settings['enable_sub_btn_style']) && $subscribe_settings['enable_sub_btn_style'] == 'on') ? true : false;
		$ays_sccp_sub_btn_color = (isset($subscribe_settings['sub_btn_color']) && $subscribe_settings['sub_btn_color'] != '') ? stripslashes( esc_attr( $subscribe_settings['sub_btn_color'] ) ) : 'rgba(255,255,255,0)';
		$ays_sccp_sub_btn_text_color = (isset($subscribe_settings['sub_btn_text_color']) && $subscribe_settings['sub_btn_text_color'] != '') ? stripslashes( esc_attr( $subscribe_settings['sub_btn_text_color'] ) ) : '#000000';
		$sccp_sub_btn_color = $ays_sccp_enable_sub_btn_style ? 'background-color:'.$ays_sccp_sub_btn_color.';' : '';
		$sccp_sub_btn_text_color = $ays_sccp_enable_sub_btn_style ? 'color:'.$ays_sccp_sub_btn_text_color.';' : '';

		$ays_sccp_sub_btn_size = (isset($subscribe_settings['sub_btn_size']) && $subscribe_settings['sub_btn_size'] != '') ? stripslashes( esc_attr( $subscribe_settings['sub_btn_size'] ) ) : '14';
		$sccp_sub_btn_size = $ays_sccp_enable_sub_btn_style ? 'font-size:'.$ays_sccp_sub_btn_size.'px;' : '';

		$sub_mobile_btn_size = (isset($subscribe_settings['sub_mobile_btn_size']) && $subscribe_settings['sub_mobile_btn_size'] != '') ? stripslashes( esc_attr( $subscribe_settings['sub_mobile_btn_size'] ) ) : '14';
		$sccp_sub_mobile_btn_size = $ays_sccp_enable_sub_btn_style ? 'font-size:'.$sub_mobile_btn_size.'px !important;' : '';

		$ays_sccp_sub_btn_radius = (isset($subscribe_settings['sub_btn_radius']) && $subscribe_settings['sub_btn_radius'] != '') ? $subscribe_settings['sub_btn_radius'] : '3';

		$sccp_sub_btn_radius = $ays_sccp_enable_sub_btn_style ? 'border-radius:'.$ays_sccp_sub_btn_radius.'px;' : '';

		// Buttons border width
		$ays_sccp_sub_btn_border_width = (isset($subscribe_settings['sub_btn_border_width']) && $subscribe_settings['sub_btn_border_width'] != '') ? $subscribe_settings['sub_btn_border_width'] : '1';		

		$sccp_sub_btn_border_width = $ays_sccp_enable_sub_btn_style ? 'border-width:'.$ays_sccp_sub_btn_border_width.'px;' : '';

		// Buttons border style
		$ays_sccp_sub_btn_border_style = (isset($subscribe_settings['sub_btn_border_style']) && $subscribe_settings['sub_btn_border_style'] != '') ? $subscribe_settings['sub_btn_border_style'] : 'solid';

		// Container border style
		$sub_cont_border_style = (isset($subscribe_settings['sub_cont_border_style']) && $subscribe_settings['sub_cont_border_style'] != '') ? 'border-style: '. $subscribe_settings['sub_cont_border_style'] .';' : 'border-style: solid;';

		// Container border width
		$sub_cont_border_width = (isset($subscribe_settings['sub_cont_border_width']) && $subscribe_settings['sub_cont_border_width'] != '') ? 'border-width: '. $subscribe_settings['sub_cont_border_width'] .'px;': '';

		// Container input width
		$sub_cont_input_width = (isset($subscribe_settings['sub_cont_input_width']) && $subscribe_settings['sub_cont_input_width'] != '' && $subscribe_settings['sub_cont_input_width'] != 0) ? 'max-width: '. $subscribe_settings['sub_cont_input_width'] .'px;': '';

		$sccp_sub_btn_border_style = $ays_sccp_enable_sub_btn_style ? 'border-style:'.$ays_sccp_sub_btn_border_style : '';

		// Buttons border color
		$ays_sccp_sub_btn_border_color = (isset($subscribe_settings['sub_btn_border_color']) && $subscribe_settings['sub_btn_border_color'] != '') ? stripslashes( esc_attr( $subscribe_settings['sub_btn_border_color'] ) ) : '#000000';

		// Container border color
		$ays_sccp_sub_cont_border_color = (isset($subscribe_settings['sub_cont_border_color']) && $subscribe_settings['sub_cont_border_color'] != '') ? stripslashes( esc_attr( $subscribe_settings['sub_cont_border_color'] ) ) : '#000000';

		$sccp_sub_btn_border_color = $ays_sccp_enable_sub_btn_style ? 'border-color:'.$ays_sccp_sub_btn_border_color.';' : '';

		$sccp_sub_cont_border_color = 'border-color:'.$ays_sccp_sub_cont_border_color.';';

		// Buttons Left / Right padding
        $sccp_sub_btn_left_right_padding = '20px';
        if(isset($subscribe_settings['sub_btn_left_right_padding']) && $subscribe_settings['sub_btn_left_right_padding'] != ''){
            $sccp_sub_btn_left_right_padding = $subscribe_settings['sub_btn_left_right_padding'] . 'px';
        }

        // Buttons Top / Bottom padding
        $sccp_sub_btn_top_bottom_padding = '10px';
        if(isset($subscribe_settings['sub_btn_top_bottom_padding']) && $subscribe_settings['sub_btn_top_bottom_padding'] != ''){
            $sccp_sub_btn_top_bottom_padding = $subscribe_settings['sub_btn_top_bottom_padding'] . 'px';
        }

        $sccp_sub_btn_padding = $ays_sccp_enable_sub_btn_style ? 'padding:'.$sccp_sub_btn_top_bottom_padding.' '.$sccp_sub_btn_left_right_padding.';' : '';


        // Subscribe email placeholder text
		$sub_email_place_text = (isset($subscribe_settings['sccp_sub_email_place_text']) && $subscribe_settings['sccp_sub_email_place_text'] != '') ? stripslashes( esc_attr($subscribe_settings['sccp_sub_email_place_text']) ) : __('Type your email address', $this->plugin_name);

        // Subscribe name placeholder text
		$sub_name_place_text = (isset($subscribe_settings['sccp_sub_name_place_text']) && $subscribe_settings['sccp_sub_name_place_text'] != '') ? stripslashes( esc_attr($subscribe_settings['sccp_sub_name_place_text']) ) : __('Type your name', $this->plugin_name);

		// Subscribe box text alignment
        $sccp_sub_text_alignment = (isset($subscribe_settings['sccp_sub_text_alignment']) && sanitize_text_field( $subscribe_settings['sccp_sub_text_alignment'] ) != '') ? sanitize_text_field( $subscribe_settings['sccp_sub_text_alignment'] ) : 'center';

		$consub_div = 'style="'.$sub_width.' '.$sub_text_color.' '.$sub_bg_color.' '.$sub_cont_border_style.' '.$sub_cont_border_width.' '.$sccp_sub_cont_border_color.' '.$sccp_sub_bg_image.' '.$sccp_sub_bg_image_position.'"';

		$subs_to_view_header_text = isset($ays_sccp_data["subs_to_view_header_text"]) && !empty($ays_sccp_data["subs_to_view_header_text"]) ? stripslashes($ays_sccp_data["subs_to_view_header_text"]) : __('Subscribe', $this->plugin_name);

		$sub_block_button_position = isset($ays_sccp_data["sccp_sub_block_button_position"]) && $ays_sccp_data["sccp_sub_block_button_position"] != '' ? $ays_sccp_data["sccp_sub_block_button_position"] : 'next-to';

		if($sub_block_button_position == 'next-to'){
			$sub_block_button_style = 'display:flex; justify-content:center;';
			$sub_block_input_style = 'width:100%;';
		}else{
			$sub_block_button_style = 'display:block;';
			$sub_block_input_style = '';
		}

		foreach ( $get_sub_res as $key => $blocsubscribe ) { 
                $block_options = isset($blocsubscribe['options']) ? json_decode($blocsubscribe['options'], true) : array();
             
                $enable_block_sub_name_field = isset($block_options['enable_name_field']) && $block_options['enable_name_field'] == 'on' ? 'checked' : '';
             
                $enable_block_sub_desc_field = isset($block_options['enable_desc_field']) && $block_options['enable_desc_field'] == 'on' ? 'checked' : '';

                $enable_block_sub_desc_textarea = isset($block_options['enable_desc_textarea']) ? stripslashes( esc_attr( $block_options['enable_desc_textarea'] ) ) : '';
        }

        $block_sub_desc_field = '';
        if($enable_block_sub_desc_field == "checked"){
        	$block_sub_desc_field = '<p class="consub_para" style="text-align:'.$sccp_sub_text_alignment.';'.$sub_desc_text_color.' '.$sub_desc_size.'">'.$enable_block_sub_desc_textarea.'</p>';
        }

        $block_sub_name_field = '';
        if($enable_block_sub_name_field == "checked"){
        	$block_sub_name_field = '<div class="subscribe_form_email">
				<input type="text" class="ays_sccp_sb_name ays_sccp_sb_field" name="ays_sb_name_field_'.$id.'" placeholder="'.$sub_name_place_text.'" style="'.$sub_block_input_style.'">
			</div>';
        }            

        // General Setting's Options       
        $general_settings_options = ($sccp_settings->ays_get_setting('options') === false) ? json_encode(array()) : $sccp_settings->ays_get_setting('options');
        $settings_options = json_decode(stripcslashes($general_settings_options), true);

      	// Do not store IP adressess 
        $sccp_disable_user_ip = (isset($settings_options['sccp_disable_user_ip']) && $settings_options['sccp_disable_user_ip'] == 'on') ? true : false;
        
        if($sccp_disable_user_ip){
            $user_ip = '';
        }else{
            $user_ip = $this->sccp_get_user_ip();
        }
        
		$cookie_sub_val = '';
		$cookie_sub_name = '';

		$other_info = array();
		$con ='
			<style>
				@media screen and (max-width: 768px){
					.subscribe_form input[type="submit"]{
					    '.$sccp_sub_mobile_btn_size.'
					}
				}

				input.ays_sccp_sb_email.ays_sccp_sb_field[type="email"], 
				input.ays_sccp_sb_name.ays_sccp_sb_field[type="text"]{
					'.$sub_cont_input_width.'
				}

			</style>
			<div class="consub_div" id="consub_div_id" '. $consub_div .'>
				<p class="consub_para" style="text-transform:'.$sub_title_transformation.'; '.$sub_title_size.' text-align:'.$sccp_sub_text_alignment.';"> ' . $subs_to_view_header_text . '</p>
				<div class="consub_icon" style="justify-content:'.$sccp_sub_text_alignment.';">
					<img src="'.$sccp_sub_icon_image.'" class="ays_sccp_lock_sub" alt="Lock">
				</div>
				'. $block_sub_desc_field .'
				<form action="" class="ays_sb_form" method="post">
					<div class="subscribe_form" style="'.$sub_block_button_style.'">
					'.$block_sub_name_field . '
					<div class="subscribe_form_email">
						<input type="email" class="ays_sccp_sb_email ays_sccp_sb_field" required name="ays_sb_email_form_'.$id.'" placeholder="'.$sub_email_place_text.'" style="'.$sub_block_input_style.'">
					</div>
					<div class="subscribe_form_email">
						<input type="submit" style="'.$sccp_sub_btn_color.' '.$sccp_sub_btn_text_color.' '.$sccp_sub_btn_size.' '.$sccp_sub_btn_radius.' '.$sccp_sub_btn_padding.' '. $sccp_sub_btn_border_width.' '.$sccp_sub_btn_border_color.' '.$sccp_sub_btn_border_style.'" class="ays_sccp_sb_sbm ays_sccp_sb_field" name="subscribe_sub_'.$id.'" value="'.$sub_button_text.'">
					</div>
					</div>
				</form>
			</div>';

		$ays_sb_email = isset( $_POST['ays_sb_email_form_'.$id] ) && $_POST['ays_sb_email_form_'.$id] != '' ? esc_sql( sanitize_email( $_POST['ays_sb_email_form_'.$id] ) ) : '';
		
		$cookie_sub_name = 'bs_email_'.$id;
		if (!isset($_COOKIE[$cookie_sub_name]) && isset($_POST['subscribe_sub_'.$id])) {
			$c_ip = file_get_contents("https://api.db-ip.com/v2/free/".$user_ip);
            $c_data = json_decode($c_ip,true);
            $sub_city = isset($c_data["city"]) && !empty($c_data["city"]) ? $c_data["city"].", " : '';
            $sub_country_name = isset($c_data["countryName"]) && !empty($c_data["countryName"]) ? $c_data["countryName"] : '';
            $sub_country = $sub_city.$sub_country_name;

			$cookie_sub_val = $ays_sb_email;
			setcookie($cookie_sub_name, $cookie_sub_val, time()+(86400*365),"/");
			if(isset($_POST['ays_sb_email_form_'.$id])) {
				
				$check_email = $wpdb->get_row("SELECT * FROM " . $report_table . " WHERE subscribe_email = '".$ays_sb_email."' " , ARRAY_A);
				
				if ( $check_email === null ) {
				
					$sub_email = $ays_sb_email;
					$sub_name = isset($_POST['ays_sb_name_field_'.$id]) ? esc_sql($_POST['ays_sb_name_field_'.$id]) : '';
					$wpdb->insert(
						$report_table,
						array(
							'subscribe_id'  	=> $id,
							'subscribe_email'  	=> $sub_email,
							'user_name'			=> $sub_name,
							'user_ip'    		=> $user_ip,
							'user_id'    		=> is_user_logged_in() ? wp_get_current_user()->ID : 0,
							'vote_date'  		=> current_time('Y-m-d G:i:s'),
							'other_info' 		=> json_encode($other_info),
							'user_address' 		=> $sub_country
						),
						array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
					);

				}

				// MailChimp
				$styles_sql = "SELECT styles FROM ".$wpdb->prefix."ays_sccp WHERE id=1";
				$option = $wpdb->get_var($styles_sql);
				$options = json_decode($option, true);
				
				if (isset($options['enable_mailchimp']) && $options['enable_mailchimp'] == 'on') {
                    if (isset($options['mailchimp_list']) && $options['mailchimp_list'] != "") {

                        $sccp_settings = $this->settings;
                        $mailchimp_res = ($sccp_settings->ays_get_setting('mailchimp') === false) ? json_encode(array()) : $sccp_settings->ays_get_setting('mailchimp');
                        $mailchimp = json_decode($mailchimp_res, true);
                        $mailchimp_username = isset($mailchimp['username']) ? $mailchimp['username'] : '';
                        $mailchimp_api_key = isset($mailchimp['apiKey']) ? $mailchimp['apiKey'] : '';
                        $mailchimp_list = (isset($options['mailchimp_list'])) ? $options['mailchimp_list'] : '';				
                        $mailchimp_email = $sub_email;
						$enable_double_opt_in = (isset($options['sccp_enable_mailchimp_optin']) && $options['sccp_enable_mailchimp_optin'] == 'on') ? true : false;
                        $user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
                        $mailchimp_fname = $user_id != 0 ? get_userdata($user_id)->data->display_name : "Guest";                        
                        if ($mailchimp_username != "" && $mailchimp_api_key != "") {
                            $args = array(
                                "email" => $mailchimp_email,
                                "fname" => $mailchimp_fname,
								"double_optin" => $enable_double_opt_in
                            );
                            $mresult = $this->ays_add_mailchimp_transaction($mailchimp_username, $mailchimp_api_key, $mailchimp_list, $args);
                        }
                    }
                }
				
				return do_shortcode('<p>' .$content . '</p>');
			}else{
				return do_shortcode($con);
			}
		}elseif(isset($_COOKIE[$cookie_sub_name])){
            return do_shortcode('<p>' .$content . '</p>');
        }
		return do_shortcode($con);
	}

	public function sccp_blockcont_generate_shortcode( $atts, $content ) {
		wp_enqueue_style($this->plugin_name.'-block-content', plugin_dir_url(__FILE__) . 'css/block_content_public.css', array(), $this->version, 'all');
		global $wpdb;
		$sccp_settings = $this->settings;
		$id = esc_sql($atts['id']);
		$bc_table = esc_sql(SCCP_BLOCK_CONTENT);

		$sccp_result = $wpdb->get_row(
					    $wpdb->prepare( 'SELECT * FROM '. $bc_table .' WHERE id = %d',
					        $id
					    )
					);		
		$result = (array) $sccp_result;

		$sccp_wpdb_id = isset($result['id']) && $result['id'] != null ? absint( intval($result['id'])) : null;
		
		if ( !session_id() ) {
			session_start();
		}

		if ($result == null) {				
			return do_shortcode($content);
		}

		$options = json_decode($result['options'], true);
		$bc_schedule_from = isset($options['bc_schedule_from']) && !empty($options['bc_schedule_from']) ? strtotime($options['bc_schedule_from']) : false;
		$bc_schedule_to	  = isset($options['bc_schedule_to']) && !empty($options['bc_schedule_to']) ? strtotime($options['bc_schedule_to']) : false;
		$pass_count = isset($options['pass_count']) ? intval($options['pass_count']) : 0;
		$pass_limit = isset($options['pass_limit']) && ($options['pass_limit'] != 0 ) ? intval($options['pass_limit']) : 0;
		$pass_count = intval($pass_count);
		$pass_limit = intval($pass_limit);
		$not_expired = true;
		$current_time = strtotime(current_time( "Y:m:d H:i:s" ));

		// General Setting's Block content       
        $general_settings_block_content = ($sccp_settings->ays_get_setting('block_content') === false) ? json_encode(array()) : $sccp_settings->ays_get_setting('block_content');
        $block_content_settings = json_decode(stripcslashes($general_settings_block_content), true);

        // Block content box width
        if(isset($block_content_settings['sccp_bc_width']) && $block_content_settings['sccp_bc_width'] != '' && absint( $block_content_settings['sccp_bc_width'] ) > 0){
            if (isset($block_content_settings['sccp_bc_width_by_percentage_px']) && $block_content_settings['sccp_bc_width_by_percentage_px'] == 'percentage') {
                if (absint(intval($block_content_settings['sccp_bc_width'])) > 100 ) {
                    $bc_width = 'max-width: 100%;';
                }else{
                    $bc_width = 'max-width: '. $block_content_settings['sccp_bc_width'] . '%;';
                }
            }else{
                $bc_width = 'max-width: '. $block_content_settings['sccp_bc_width'] . 'px;';
            }
        }else{
            $bc_width = 'max-width: fit-content;';
        }

        // Block content box text color
		$bc_text_color = (isset($block_content_settings['sccp_bc_text_color']) && $block_content_settings['sccp_bc_text_color'] != '') ? 'color:'.stripslashes( esc_attr($block_content_settings['sccp_bc_text_color']) ).';' : 'color: #000;';

		// Block content box background color
		$bc_bg_color = (isset($block_content_settings['sccp_bc_bg_color']) && $block_content_settings['sccp_bc_bg_color'] != '') ? 'background-color:'.stripslashes( esc_attr($block_content_settings['sccp_bc_bg_color']) ).';' : 'background-color: #fff;';

		// Block content Add BG image
		$sccp_bc_bg_image = isset($block_content_settings["bc_bg_image"]) && !empty($block_content_settings["bc_bg_image"]) ? 'background-image: url('.$block_content_settings["bc_bg_image"].');' : '';

		// Block content Bg image positioning
		$sccp_bc_bg_image_position = (isset($block_content_settings["bc_bg_image_position"]) && $block_content_settings["bc_bg_image_position"] != '') ? 'background-position:'. $block_content_settings["bc_bg_image_position"] .';' : "background-position:center center;";

		// Block content button text
		$bc_button_text = (isset($block_content_settings['sccp_bc_button_text']) && $block_content_settings['sccp_bc_button_text'] != '') ? stripslashes( esc_attr($block_content_settings['sccp_bc_button_text']) ) : __('Submit', $this->plugin_name);

		// Block content paswword placeholder text
		$bc_psw_place_text = (isset($block_content_settings['sccp_bc_psw_place_text']) && $block_content_settings['sccp_bc_psw_place_text'] != '') ? stripslashes( esc_attr($block_content_settings['sccp_bc_psw_place_text']) ) : __('Password', $this->plugin_name);

		// Block content Container border style
		$bc_cont_border_style = (isset($block_content_settings['bc_cont_border_style']) && $block_content_settings['bc_cont_border_style'] != '') ? $block_content_settings['bc_cont_border_style'] : 'double';

		// Block content Container border width
		$bc_cont_border_width = (isset($block_content_settings['bc_cont_border_width']) && $block_content_settings['bc_cont_border_width'] != '') ? $block_content_settings['bc_cont_border_width'] : '4';

		// Block content Container border color
		$ays_sccp_bc_cont_border_color = (isset($block_content_settings['bc_cont_border_color']) && $block_content_settings['bc_cont_border_color'] != '') ? stripslashes( esc_attr( $block_content_settings['bc_cont_border_color'] ) ) : '#c5c5c5';

		// Block content Add Icon image
		$sccp_bc_icon_image = isset($block_content_settings["bc_icon_image"]) && !empty($block_content_settings["bc_icon_image"]) ? $block_content_settings["bc_icon_image"] : SCCP_PUBLIC_URL.'/images/lock.png';

		// Block content input width
		$bc_cont_input_width = (isset($block_content_settings['bc_cont_input_width']) && $block_content_settings['bc_cont_input_width'] != '' && $block_content_settings['bc_cont_input_width'] != 0) ? 'max-width: '. $block_content_settings['bc_cont_input_width'] .'px;': '';

		// Block content box text alignment
        $sccp_bc_text_alignment = (isset($block_content_settings['bc_text_alignment']) && sanitize_text_field( $block_content_settings['bc_text_alignment'] ) != '') ? sanitize_text_field( $block_content_settings['bc_text_alignment'] ) : 'center';

        // Block content button style
		$block_content_settings['enable_bc_btn_style'] = (isset($block_content_settings['enable_bc_btn_style']) && $block_content_settings['enable_bc_btn_style'] == 'on') ? 'on' : 'off'; 

		$ays_sccp_enable_bc_btn_style = (isset($block_content_settings['enable_bc_btn_style']) && $block_content_settings['enable_bc_btn_style'] == 'on') ? true : false;

		$ays_sccp_bc_btn_color = (isset($block_content_settings['bc_btn_color']) && $block_content_settings['bc_btn_color'] != '') ? stripslashes( esc_attr( $block_content_settings['bc_btn_color'] ) ) : 'rgba(255,255,255,0)';

		$ays_sccp_bc_btn_text_color = (isset($block_content_settings['bc_btn_text_color']) && $block_content_settings['bc_btn_text_color'] != '') ? stripslashes( esc_attr( $block_content_settings['bc_btn_text_color'] ) ) : '#000000';

		$sccp_bc_btn_color = $ays_sccp_enable_bc_btn_style ? 'background-color:'.$ays_sccp_bc_btn_color.';' : '';

		$sccp_bc_btn_text_color = $ays_sccp_enable_bc_btn_style ? 'color:'.$ays_sccp_bc_btn_text_color.';' : '';

		$ays_sccp_bc_cont_border_styles = 'border: '.$bc_cont_border_width.'px '.$bc_cont_border_style.' '.$ays_sccp_bc_cont_border_color.';';

 		// Block content button font size
		$ays_sccp_bc_btn_size = (isset($block_content_settings['bc_btn_size']) && $block_content_settings['bc_btn_size'] != '') ? stripslashes( esc_attr( $block_content_settings['bc_btn_size'] ) ) : '14';
		$sccp_bc_btn_size = $ays_sccp_enable_bc_btn_style ? 'font-size:'.$ays_sccp_bc_btn_size.'px;' : '';

		$bc_mobile_btn_size = (isset($block_content_settings['bc_mobile_btn_size']) && $block_content_settings['bc_mobile_btn_size'] != '') ? stripslashes( esc_attr( $block_content_settings['bc_mobile_btn_size'] ) ) : '14';
		$sccp_bc_mobile_btn_size = $ays_sccp_enable_bc_btn_style ? 'font-size:'.$bc_mobile_btn_size.'px !important;' : '';

		$ays_sccp_bc_btn_radius = (isset($block_content_settings['bc_btn_radius']) && $block_content_settings['bc_btn_radius'] != '') ? $block_content_settings['bc_btn_radius'] : '3';

		$sccp_bc_btn_radius = $ays_sccp_enable_bc_btn_style ? 'border-radius:'.$ays_sccp_bc_btn_radius.'px;' : '';

		$ays_sccp_bc_btn_border_width = (isset($block_content_settings['bc_btn_border_width']) && $block_content_settings['bc_btn_border_width'] != '') ? $block_content_settings['bc_btn_border_width'] : '1';

		$sccp_bc_btn_border_width = $ays_sccp_enable_bc_btn_style ? 'border-width:'.$ays_sccp_bc_btn_border_width.'px;' : '';

		$ays_sccp_bc_btn_border_style = (isset($block_content_settings['bc_btn_border_style']) && $block_content_settings['bc_btn_border_style'] != '') ? $block_content_settings['bc_btn_border_style'] : 'solid';

		$sccp_bc_btn_border_style = $ays_sccp_enable_bc_btn_style ? 'border-style:'.$ays_sccp_bc_btn_border_style.';' : '';

		$ays_sccp_bc_btn_border_color = (isset($block_content_settings['bc_btn_border_color']) && $block_content_settings['bc_btn_border_color'] != '') ? stripslashes( esc_attr( $block_content_settings['bc_btn_border_color'] ) ) : '#c5c5c5';

		$sccp_bc_btn_border_color = $ays_sccp_enable_bc_btn_style ? 'border-color:'.$ays_sccp_bc_btn_border_color.';' : '';

        $cont_bc_div = 'style="'.$bc_width.' '.$bc_text_color.' '.$bc_bg_color.' '.$sccp_bc_bg_image.' '.$sccp_bc_bg_image_position.' '.$ays_sccp_bc_cont_border_styles.'"';

        // Block content Buttons Left / Right padding
        $sccp_bc_btn_left_right_padding = '10px';
        if(isset($block_content_settings['bc_btn_left_right_padding']) && $block_content_settings['bc_btn_left_right_padding'] != ''){
            $sccp_bc_btn_left_right_padding = $block_content_settings['bc_btn_left_right_padding'] . 'px';
        }

        // Block content Buttons Top / Bottom padding
        $sccp_bc_btn_top_bottom_padding = '10px';
        if(isset($block_content_settings['bc_btn_top_bottom_padding']) && $block_content_settings['bc_btn_top_bottom_padding'] != ''){
            $sccp_bc_btn_top_bottom_padding = $block_content_settings['bc_btn_top_bottom_padding'] . 'px';
        }

        $sccp_bc_btn_padding = $ays_sccp_enable_bc_btn_style ? 'padding:'.$sccp_bc_btn_top_bottom_padding.' '.$sccp_bc_btn_left_right_padding.';' : '';

		if ($bc_schedule_from && $bc_schedule_to) {
			if ($bc_schedule_from < $current_time && $bc_schedule_to > $current_time) {
				$not_expired = true;
			}else{
				$not_expired = false;
			}
		}
		$check_session_id = isset($_SESSION['ays_bc_user'][$id]) ? $_SESSION['ays_bc_user'][$id] : false;

		if ($pass_count >= $pass_limit && $pass_limit != 0 && $check_session_id != true){				    
			return '';
		}else{
			if ($not_expired) {
				if (isset($options['user_role']) && !empty($options['user_role'])) {
					$role_check = true;
					$pass_check = false;
				}else{
					$pass_check = isset($result['password']) && !empty($result['password']) ? true : false;
					$role_check = false;
				}
				if ($role_check) {
					$user = wp_get_current_user();
					$user_role = isset($user->roles[0]) && !empty($user->roles[0]) ? $user->roles[0] : '';
					if (!is_user_logged_in() && $user_role == '') {
						$user_role = 'guest';
					}
					
					if (isset($options['user_role']) && !empty($options['user_role'])) {
						$check_role = $options['user_role'];

						if(in_array($user_role, $check_role)){
							$role_check = true;
						}else{
							$role_check = false;
						}	
					}

					if ($role_check == false) {				
						$con = '';
						return $con;
					}else{
						// ---------AV User role count-----------
						$bc_result_options = json_decode($result['options'], true);
						$user_role_count = isset($bc_result_options['user_role_count']) ? intval($bc_result_options['user_role_count']) : 0;
						$user_role_count = intval($user_role_count);
						$user_role_count++;

						$bc_options = array(
							'user_role'	 		 =>  $bc_result_options['user_role'],
							'pass_count'		 =>  $bc_result_options['pass_count'],
							'user_role_count'	 =>  $user_role_count,
							'pass_limit'		 =>  isset($bc_result_options['pass_limit']) ? $bc_result_options['pass_limit'] : 0,
							'bc_schedule_from'	 =>  $bc_result_options['bc_schedule_from'],
							'bc_schedule_to'	 =>  $bc_result_options['bc_schedule_to']
						);
						$bc_options = json_encode($bc_options);
						$table = esc_sql(SCCP_BLOCK_CONTENT);

						if ($sccp_wpdb_id != $id) {
							$wpdb->insert( $table,
						        array(
						            'options' 	=> $bc_options
						        ),
							    array( '%s' )
							);
						}else{
							$wpdb->update( $table,
						        array(
						            'options' 	=> $bc_options
						        ),
						        array( 'id' => $id ),
							    array( '%s' ),
							    array( '%d' )
							);
						}					

						return '<div>' . do_shortcode($content) . '</div>';
					}

				}elseif($pass_check){
					if ( !session_id() ) {
						session_start();
					}

					global $wpdb;
					$sccp_table = esc_sql(SCCP_TABLE);
					$sccp_result = $wpdb->get_row("SELECT * FROM " . $sccp_table . " WHERE id = 1", ARRAY_A);
					$sccp_data   = json_decode($sccp_result["options"], true);

					$bc_header_text = isset($sccp_data["bc_header_text"]) && !empty($sccp_data["bc_header_text"]) ? stripslashes($sccp_data["bc_header_text"]) : __('You need to Enter right password', $this->plugin_name);

					$bc_button_position = isset($sccp_data["sccp_bc_button_position"]) && $sccp_data["sccp_bc_button_position"] != '' ? $sccp_data["sccp_bc_button_position"] : 'next-to';

			        if (!isset($_SESSION['ays_bc_user'])) {
			        	$_SESSION['ays_bc_user'] = array();
			        }

			        if($bc_button_position == 'next-to'){
			        	$bc_button_style = 'display:flex; justify-content:center;';
			        }else{
			        	$bc_button_style = 'display:block;';
			        }

					$con = do_shortcode('
						<style>
							@media screen and (max-width: 768px){
	                        	.conblock_div input[type="submit"] {
	                        		'.$sccp_bc_mobile_btn_size.'
	                        	}
	                        	
	                        }
						</style>
						<div class="conblock_div" id="conblock_div_id" '.$cont_bc_div.'>
							<div class="conblock_block_para" style="justify-content:'.$sccp_bc_text_alignment.';">' . $bc_header_text . '</div>
							<div class="conblock_icon" style="justify-content:'.$sccp_bc_text_alignment.';">
								<img src="'.$sccp_bc_icon_image.'" class="ays_sccp_lock" alt="Lock">
							</div>
							<form action="" method="post" class="conblock_block_form" style="'.$bc_button_style.'">
								<div class="ays_sccp_bc_form_fields">
									<input type="password" required name="pass_form" placeholder="'.$bc_psw_place_text.'" style="'.$bc_cont_input_width.'">
								</div>
								<div class="ays_sccp_bc_form_fields">
								<input type="submit" name="sub_form_'.$id.'" value="'.$bc_button_text.'" style="'.$sccp_bc_btn_color.' '.$sccp_bc_btn_text_color.' '.$sccp_bc_btn_size.' '.$sccp_bc_btn_radius.' '.$sccp_bc_btn_border_width.' '.$sccp_bc_btn_border_style.' '.$sccp_bc_btn_border_color.' '.$sccp_bc_btn_padding.'">
								</div>
							</form>
						</div>');
					if(isset($_SESSION['ays_bc_user'][$id]) && $_SESSION['ays_bc_user'][$id] == true) {
					    $con = '<div>' . do_shortcode($content) . '</div>';
					    return $con;
				    }

					$pass = $result['password'];
					if (isset($_POST['sub_form_'.$id.''])) {
						$check_pass = isset($_POST['pass_form']) && $_POST['pass_form'] == $pass ? true : false ;
						if ($check_pass) {
						// ---------AV Password count-----------					
							$bc_result_options = json_decode($result['options'], true);
							$pass_count++;
							$bc_options = array(
								'user_role'	 		 =>  $bc_result_options['user_role'],
								'pass_count'		 =>  $pass_count,
								'pass_limit'		 =>  isset($bc_result_options['pass_limit']) ? $bc_result_options['pass_limit'] : 0,
								'user_role_count'	 =>  $bc_result_options['user_role_count'],
								'bc_schedule_from'	 =>  $bc_result_options['bc_schedule_from'],
								'bc_schedule_to'	 =>  $bc_result_options['bc_schedule_to']
							);
							$bc_options = json_encode($bc_options);
							$table = esc_sql(SCCP_BLOCK_CONTENT);
							
							if ($sccp_wpdb_id != $id) {
								$wpdb->insert( $table,
							        array(
							            'options' 	=> $bc_options
							        ),
								    array( '%s' )
								);
							}else{
								$wpdb->update( $table,
							        array(
							            'options' 	=> $bc_options
							        ),
							        array( 'id' => $id ),
								    array( '%s' ),
								    array( '%d' )
								);
							}

							$_SESSION['ays_bc_user'][$id] = true;
						}else{
							$_SESSION['ays_bc_user'][$id] = false;
						}

						if ($_SESSION['ays_bc_user'][$id]) {
					        $con = '<div>' . do_shortcode($content) . '</div>';
				        }
					}

					return $con;

				}else{			
					return '<div>' . do_shortcode($content) . '</div>';
				}
			}else{
				return '';
			}
		}	
	}

	public function check_enable_sccp() {
		global $wpdb;
		global $user_ID;
		$sccp_table = esc_sql(SCCP_TABLE);
		$sql = "SELECT COUNT(*) FROM ".$sccp_table;
		$count = $wpdb->get_var($sql);
		if ($count == 0) {
			$enable_protection = 0;
			$disable_sup_admin = true;
			$except_types      = array();
		} else {
			$sccp_table = esc_sql(SCCP_TABLE);
			$sql = "SELECT * FROM " . $sccp_table . " WHERE id = 1";
			$data = $wpdb->get_row($sql, ARRAY_A);
			$options = json_decode($data['options'], true);			
			$disable_sup_admin = is_user_logged_in() && is_super_admin( $user_ID ) && isset($options['disable_sup_admin']) && $options['disable_sup_admin'] == 'checked' ? false : true;
			$enable_protection = (isset($data['protection_status']) && $data['protection_status'] == 1) ? 1 : 0;
			$except_types      = (isset($data['except_post_types']) && !empty($data['except_post_types'])) ? json_decode($data['except_post_types'], true) : array();
		}
		
		$woo = in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')));

		if (is_front_page()) {
			$this_post_type = "page";
		} else {
			if ($woo) {
				//For woocommerce shop page 
				if(is_shop()){
					$this_post_type = "page";
				}else{
					$this_post_type = get_post_type();
				}
			}else{
				$this_post_type = get_post_type();
			}
		}

		if ($enable_protection == 1 && !in_array($this_post_type, $except_types) && $disable_sup_admin) {
			return true;
		}
		
		return false;
	}

	public function ays_get_notification_text( $text_only = false ) {
		global $wpdb;
		$sccp_settings = $this->settings;
		$sccp_table = esc_sql(SCCP_TABLE);
		$sql = "SELECT COUNT(*) FROM ".$sccp_table;
		$count = $wpdb->get_var($sql);
		if ($count == 0) {
			$enable_protection = 0;
			$except_types      = array();
			$styles            = array(
				"bg_color"         => "#ffffff",
				"bg_image"         => "",
				"tooltip_opacity"  => "1",
				"bg_blur"  		   => "0",
				"text_color"       => "#ff0000",
				"font_size"        => "12",
				"mobile_font_size" => "12",
				"border_color"     => "#b7b7b7",
				"boxshadow_color"  => "rgba(0,0,0,0)",
				'sccp_box_shadow_x_offset' => 0,
			    'sccp_box_shadow_y_offset' => 0,
			    'sccp_box_shadow_z_offset' => 15,
				'sccp_text_shadow_x_offset' => 2,
			    'sccp_text_shadow_y_offset' => 2,
			    'sccp_text_shadow_z_offset' => 3,
				"border_width"     => "1",
				"border_radius"    => "3",
				"border_style"     => "solid",
				"tooltip_position" => "mouse",
				"tooltip_padding"  => "5",
				"tooltip_bg_image_position" => "center center",
				"tooltip_bg_image_object_fit" => "cover",
			);
			$notf_text         = __('You cannot copy content of this page', $this->plugin_name);
			$audio             = '';
		} else {
			$sccp_table = esc_sql(SCCP_TABLE);
			$sql = "SELECT * FROM " . $sccp_table . " WHERE id = 1";
			$data = $wpdb->get_row($sql, ARRAY_A);
			$notf_text         = $this->ays_autoembed($data['protection_text']);
			$style             = json_decode($data["styles"], true);
			$options           = json_decode($data["options"], true);
			$styles            = array(
				"bg_color"         		=> isset($style['bg_color']) ? $style['bg_color'] : "#ffffff",
				"bg_image"         		=> isset($style['bg_image']) ? $style['bg_image'] : "",
				"tooltip_opacity"  		=> isset( $style['tooltip_opacity']) ? $style['tooltip_opacity'] : "",
				"bg_blur"  				=> isset( $style['bg_blur']) ? $style['bg_blur'] : "0",
				"text_color"       		=> isset($style['text_color']) ? $style['text_color'] : "#ff0000",
				"font_size"        		=> isset($style['font_size']) ? $style['font_size'] : "12",
				"mobile_font_size"      => isset($style['mobile_font_size']) ? $style['mobile_font_size'] : "12",
				"border_color"     		=> isset($style['border_color']) ? $style['border_color'] : "#b7b7b7",
				"boxshadow_color"     	=> isset($style['boxshadow_color']) ? $style['boxshadow_color'] : "rgba(0,0,0,0)",
				"sccp_box_shadow_x_offset"  	=> isset($style['sccp_box_shadow_x_offset']) ? $style['sccp_box_shadow_x_offset'] : 0,
				"sccp_box_shadow_y_offset"  	=> isset($style['sccp_box_shadow_y_offset']) ? $style['sccp_box_shadow_y_offset'] : 0,
				"sccp_box_shadow_z_offset"  	=> isset($style['sccp_box_shadow_z_offset']) ? $style['sccp_box_shadow_z_offset'] : 15,
				"sccp_text_shadow_x_offset"  	=> isset($style['sccp_text_shadow_x_offset']) ? $style['sccp_text_shadow_x_offset'] : 2,
				"sccp_text_shadow_y_offset"  	=> isset($style['sccp_text_shadow_y_offset']) ? $style['sccp_text_shadow_y_offset'] : 2,
				"sccp_text_shadow_z_offset"  	=> isset($style['sccp_text_shadow_z_offset']) ? $style['sccp_text_shadow_z_offset'] : 3,

				"border_width"     		=> isset($style['border_width']) ? $style['border_width'] : "1",
				"border_radius"    		=> isset($style['border_radius']) ? $style['border_radius'] : "3",
				"border_style"     		=> isset($style['border_style']) ? $style['border_style'] : "solid",
				"tooltip_position" 		=> isset($style['tooltip_position']) ? $style['tooltip_position'] : "mouse",
				"tooltip_padding"  		=> isset($style['tooltip_padding']) ? $style['tooltip_padding'] : "5",
				"ays_sccp_custom_class" => isset($style['ays_sccp_custom_class']) ? $style['ays_sccp_custom_class'] : "",
				"tooltip_bg_image_position" => (isset($style['tooltip_bg_image_position']) && $style['tooltip_bg_image_position'] != "") ? $style['tooltip_bg_image_position'] : "center center",
				"custom_css"       		=> isset($style['custom_css']) ? wp_unslash( stripslashes( htmlspecialchars_decode( $style['custom_css'] ) ) ) : "",
				"tooltip_bg_image_object_fit" => (isset($style["tooltip_bg_image_object_fit"]) && $style["tooltip_bg_image_object_fit"] != '') ? $style["tooltip_bg_image_object_fit"] : "cover",
			);
			$audio          = $data['audio'];
			$custom_class 	= isset($style['ays_sccp_custom_class']) && !empty($style['ays_sccp_custom_class']) ? "class='".$style['ays_sccp_custom_class']."'" : "";
		}

		if ($text_only) {
			return $notf_text;
		}

		// Checking exists background gradient option
        $style['enable_background_gradient'] = (!isset($style['enable_background_gradient'])) ? "off" : $style['enable_background_gradient'];
        
        if(isset($style['background_gradient_color_1']) && $style['background_gradient_color_1'] != ''){
            $background_gradient_color_1 = $style['background_gradient_color_1'];
        }else{
            $background_gradient_color_1 = "#000";
        }

        if(isset($style['background_gradient_color_2']) && $style['background_gradient_color_2'] != ''){
            $background_gradient_color_2 = $style['background_gradient_color_2'];
        }else{
            $background_gradient_color_2 = "#fff";
        }

        if(isset($style['sccp_gradient_direction']) && $style['sccp_gradient_direction'] != ''){
            $sccp_gradient_direction = $style['sccp_gradient_direction'];
        }else{
            $sccp_gradient_direction = 'vertical';
        }
        switch($sccp_gradient_direction) {
            case "horizontal":
                $sccp_gradient_direction = "to right";
                break;
            case "diagonal_left_to_right":
                $sccp_gradient_direction = "to bottom right";
                break;
            case "diagonal_right_to_left":
                $sccp_gradient_direction = "to bottom left";
                break;
            default:
                $sccp_gradient_direction = "to bottom";
        }

        // tooltip container background gradient enabled/disabled        
        if(isset($style['enable_background_gradient']) && $style['enable_background_gradient'] == "on"){
            $enable_background_gradient = true;
        }else{
            $enable_background_gradient = false;
        }

        // General Setting's Options       
        $general_settings_options = ($sccp_settings->ays_get_setting('options') === false) ? json_encode(array()) : $sccp_settings->ays_get_setting('options');
        $settings_options = json_decode(stripcslashes($general_settings_options), true);

		if ($this->check_enable_sccp()) {

			if (!empty($audio)) {
				echo "<audio id='sccp_public_audio'>
                  <source src=" . $audio . " type='audio/mpeg'>
                </audio>";
			}

			$av_bg_image = '';
			if (isset($styles["bg_image"]) && !empty($styles["bg_image"])) {
				$av_bg_image = 'background-image: url('.$styles["bg_image"].');';	
			}elseif ($enable_background_gradient) {
				$av_bg_image = "background-image: linear-gradient($sccp_gradient_direction, $background_gradient_color_1, $background_gradient_color_2);";
			}

			// Title text shadow
			$style['enable_sccp_title_text_shadow'] = (isset($style['enable_sccp_title_text_shadow']) && $style['enable_sccp_title_text_shadow'] == 'on') ? 'on' : 'off'; 
			$enable_sccp_title_text_shadow = (isset($style['enable_sccp_title_text_shadow']) && $style['enable_sccp_title_text_shadow'] == 'on') ? true : false; 
			$sccp_title_text_shadow = (isset($style['sccp_title_text_shadow']) && $style['sccp_title_text_shadow'] != '') ? stripslashes( esc_attr( $style['sccp_title_text_shadow'] ) ) : 'rgba(255,255,255,0)';
			if($enable_sccp_title_text_shadow){

				$text_shadow_x = isset($style['sccp_text_shadow_x_offset']) ? $style['sccp_text_shadow_x_offset'] : '2';
				$text_shadow_y = isset($style['sccp_text_shadow_y_offset']) ? $style['sccp_text_shadow_y_offset'] : '2';
				$text_shadow_z = isset($style['sccp_text_shadow_z_offset']) ? $style['sccp_text_shadow_z_offset'] : '3';
				$text_shadow = $text_shadow_x .'px '. $text_shadow_y .'px '. $text_shadow_z.'px ';

				$tooltip_title_shadow = 'text-shadow: '.$text_shadow.' '.$sccp_title_text_shadow;
			}else{
				$tooltip_title_shadow = '';
			}

			// Tooltip text transformation
			$tooltip_text_transformation = (isset($style['tooltip_text_transformation']) && sanitize_text_field( $style['tooltip_text_transformation'] ) != "") ? sanitize_text_field( $style['tooltip_text_transformation'] ) : 'none';

			// Do not store IP adressess 
        	$sccp_disable_user_ip = (isset($settings_options['sccp_disable_user_ip']) && $settings_options['sccp_disable_user_ip'] == 'on') ? true : false;

			$user_first_name 		= '';
	        $user_last_name  		= '';
	        $user_display_name  	= '';
	        $user_nickname 			= '';
	        $user_email 	 		= '';
	        $user_wordpress_roles   = '';
	        $user_id = get_current_user_id();
	        $current_date = date_i18n( 'M d, Y', current_time('timestamp') );
	        if($user_id != 0){
	            $usermeta  = get_user_meta( $user_id );	            
	        	
	            if($usermeta !== null){
	                $user_first_name = (isset($usermeta['first_name'][0]) && sanitize_text_field( $usermeta['first_name'][0] != '') ) ? sanitize_text_field( $usermeta['first_name'][0] ) : '';
	                $user_last_name  = (isset($usermeta['last_name'][0]) && sanitize_text_field( $usermeta['last_name'][0] != '') ) ? sanitize_text_field( $usermeta['last_name'][0] ) : '';
	                $user_nickname   = (isset($usermeta['nickname'][0]) && sanitize_text_field( $usermeta['nickname'][0] != '') ) ? sanitize_text_field( $usermeta['nickname'][0] ) : '';
	            }

	            $current_user_data = get_userdata( $user_id );
	            if ( ! is_null( $current_user_data ) && $current_user_data ) {
	                $user_display_name = ( isset( $current_user_data->data->display_name ) && $current_user_data->data->display_name != '' ) ? sanitize_text_field( $current_user_data->data->display_name ) : "";
	                $user_email = ( isset( $current_user_data->data->user_email ) && $current_user_data->data->user_email != '' ) ? sanitize_text_field( $current_user_data->data->user_email ) : "";

	                $user_wordpress_roles = ( isset( $current_user_data->roles ) && ! empty( $current_user_data->roles ) ) ? $current_user_data->roles : "";

	                if ( !empty( $user_wordpress_roles ) && $user_wordpress_roles != "" ) {
	                    if ( is_array( $user_wordpress_roles ) ) {
	                        $user_wordpress_roles = implode(",", $user_wordpress_roles);
	                    }
	                }
	            }
	    	}else{
	    		$user_id = '';
	    	}
	    	
	    	if($sccp_disable_user_ip){
            	$user_ip = '';
	        }else{
	            $user_ip = $this->sccp_get_user_ip();
	        }

	        $current_user_ip = $user_ip;
	        $super_admin_email = get_option('admin_email');

        	$current_page_title = get_the_title();
        	$author_id = get_the_author_meta('ID');
        	$post_author_nickname = get_the_author_meta( 'nickname', $author_id );
        	$post_author_display_name = get_the_author_meta( 'display_name', $author_id );
        	$post_author_email = get_the_author_meta( 'email', $author_id );
        	$current_post_id = get_the_ID();
        	$get_site_title = get_bloginfo('name');
	        
			$message_data = array(                    
                'user_first_name' 			=> $user_first_name,
                'user_last_name' 			=> $user_last_name,                   
                'user_wordpress_email' 		=> $user_email,                  
                'user_display_name' 		=> $user_display_name,
                'user_nickname'     		=> $user_nickname,
                'user_wordpress_roles' 		=> $user_wordpress_roles,
                'current_user_ip'       	=> $current_user_ip,
                'admin_email'       		=> $super_admin_email,
                'post_author_nickname'  	=> $post_author_nickname,
                'post_author_email'			=> $post_author_email,
                'post_author_display_name'	=> $post_author_display_name,
                'user_id'              		=> $user_id,
                'current_date'          	=> $current_date,
                'current_page_title'		=> $current_page_title,
                'site_title'				=> $get_site_title,
                'post_id'					=> $current_post_id,
            );

			$notf_text = $this->sccp_replace_message_variables($notf_text, $message_data);

			$box_shadow_offsets = $styles["sccp_box_shadow_x_offset"] . 'px ' . $styles["sccp_box_shadow_y_offset"] . 'px ' . $styles["sccp_box_shadow_z_offset"] . 'px ';

			echo '<div id="ays_tooltip" '.$custom_class.'><div id="ays_tooltip_block">' . $notf_text . '</div></div>
                    <style>
                        #ays_tooltip,.ays_tooltip_class {
                    		display: none;
                    		position: absolute;
    						z-index: 999999999;
                            background-color: ' . $styles["bg_color"] . ';
                            '.$av_bg_image.'
                            background-repeat: no-repeat;
                            background-position: ' . $styles["tooltip_bg_image_position"] . ';
                            background-size: ' . $styles["tooltip_bg_image_object_fit"] . ';
                            opacity:' . $styles["tooltip_opacity"] . ';
                            border: ' . $styles["border_width"] . 'px ' . $styles["border_style"] . ' ' . $styles["border_color"] . ';
                            border-radius: ' . $styles["border_radius"] . 'px;
                            box-shadow: ' . $styles["boxshadow_color"] . ' ' . $box_shadow_offsets .' 1px;
                            color: ' . $styles["text_color"] . ';
                            padding: ' . $styles["tooltip_padding"] . 'px;
                            text-transform: ' . $tooltip_text_transformation . ';
							'.$tooltip_title_shadow.';
                        }
                        
                        #ays_tooltip > *, .ays_tooltip_class > * {
                            color: ' . $styles["text_color"] . ';
                            font-size: ' . (isset($styles["font_size"]) ? $styles["font_size"] : "12") . 'px;
                        }

                        #ays_tooltip_block {
                            font-size: ' . (isset($styles["font_size"]) ? $styles["font_size"] : "12") . 'px;
                            backdrop-filter: blur('. $styles["bg_blur"] .'px);
                        }

                        @media screen and (max-width: 768px){
                        	#ays_tooltip,.ays_tooltip_class {
                        		font-size: ' . (isset($styles["mobile_font_size"]) ? $styles["mobile_font_size"] : "12") . 'px;
                        	}
                        	#ays_tooltip > *, .ays_tooltip_class > * {	                            
	                            font-size: ' . (isset($styles["mobile_font_size"]) ? $styles["mobile_font_size"] : "12") . 'px;
	                        }
                        }
                        
                       ' . (isset($styles["custom_css"]) ? wp_unslash( stripslashes( htmlspecialchars_decode( $styles["custom_css"] ) ) ) : "") . '
                    </style>
            ';
			include_once('partials/secure-copy-content-protection-public-display.php');
		}

		if (isset($options['disable_js']) && $options['disable_js'] == 'checked') {

			$disable_js_msg = isset($options["disable_js_msg"]) && !empty($options["disable_js_msg"]) ? stripslashes($options["disable_js_msg"]) : __('Javascript not detected. Javascript required for this site to function. Please enable it in your browser settings and refresh this page.', $this->plugin_name);

			echo '<div id="ays_noscript" style="display:none;">
					<p>'.$disable_js_msg.'</p>
			  	  </div>
			  	  <noscript> 
			  	 	<style>
			  	 		#ays_noscript{
			  	 			display:flex !important;
		  	 			}
		  	 			html{
	 				        pointer-events: none;
	    					user-select: none;
		  	 			}
	  	 			</style>
	  	 		  </noscript>';
		}

	}

	public function sccp_replace_message_variables($content, $data){
        foreach($data as $variable => $value){
            $content = str_replace("%%".$variable."%%", $value, $content);
        }
        return $content;
    }

	public function hex2rgba( $color, $opacity = false ) {

		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if (empty($color)) {
			return $default;
		}

		//Sanitize $color if "#" is provided
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}

		//Check if color has 6 or 3 characters and get values
		if (strlen($color) == 6) {
			$hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
		} elseif (strlen($color) == 3) {
			$hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
		} else {
			return $default;
		}

		//Convert hexadec to rgb
		$rgb = array_map('hexdec', $hex);

		//Check if opacity is set(rgba or rgb)
		if ($opacity) {
			if (abs($opacity) > 1) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode(",", $rgb) . ')';
		}

		//Return rgb(a) color string
		return $output;
	}	

	public static function isMobileDevice(  ) {
		$aMobileDevs = array(
			'/iphone/i' => 'iPhone',
			'/ipod/i' => 'iPod',
			'/ipad/i' => 'iPad',
			'/android/i' => 'Android',
			'/blackberry/i' => 'BlackBerry',
			'/webos/i' => 'Mobile'
		);

		//Return true if Mobile User Agent is detected
		foreach($aMobileDevs as $sMobileKey => $sMobileOS){
			if(isset($_SERVER["HTTP_USER_AGENT"]) && preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
				return true;
			}
		}
		//Otherwise return false..
		return false;
	}

	private function sccp_get_user_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP')) {
			$ipaddress = getenv('HTTP_CLIENT_IP');
		} else if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		} else if (getenv('HTTP_X_FORWARDED')) {
			$ipaddress = getenv('HTTP_X_FORWARDED');
		} else if (getenv('HTTP_FORWARDED_FOR')) {
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		} else if (getenv('HTTP_FORWARDED')) {
			$ipaddress = getenv('HTTP_FORWARDED');
		} else if (getenv('REMOTE_ADDR')) {
			$ipaddress = getenv('REMOTE_ADDR');
		} else {
			$ipaddress = 'UNKNOWN';
		}

		return $ipaddress;
	}

	public function ays_add_mailchimp_transaction( $username, $api_key, $list_id, $args ) {

		$email = isset($args['email']) ? $args['email'] : null;
		$fname = isset($args['fname']) ? $args['fname'] : "";
		$lname = isset($args['lname']) ? $args['lname'] : "";
		$double_optin = isset( $args['double_optin'] ) ? $args['double_optin'] : false;
		$contact_status = "subscribed";
        if( $double_optin ){
            $contact_status = "pending";
        }
		$api_prefix = explode("-", $api_key)[1];

		$fields = array(
			"email_address" => $email,
			"status"        => $contact_status,
			"merge_fields"  => array(
				"FNAME" => $fname,
				"LNAME" => $lname
			)
		);
		$curl   = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL            => "https://" . $api_prefix . ".api.mailchimp.com/3.0/lists/" . $list_id . "/members/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_USERPWD        => "$username:$api_key",
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => json_encode($fields),
			CURLOPT_HTTPHEADER     => array(
				"Content-Type: application/json",
				"cache-control: no-cache"
			),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return "cURL Error #: " . $err;
		} else {
			return $response;
		}
	}

	// All Page block
	// public function ays_block_all_page(){
	// 	if( is_admin()) {
	// 		return;
	// 	}
	// 	$is_login_page = $this->is_login_page();

	// 	$ayc_sccp = $this->ays_get_sccp();
	// 	$ayc_sccp_optons = isset($ayc_sccp["options"]) && $ayc_sccp["options"] != "" ? json_decode($ayc_sccp["options"] , true) : array();
	// 	$ays_sccp_password_check = isset($ayc_sccp_optons['sccp_web_password_check']) && $ayc_sccp_optons['sccp_web_password_check'] == "on" ? true : false;
	// 	$ays_sccp_password = isset($ayc_sccp_optons['sccp_web_password']) && $ayc_sccp_optons['sccp_web_password'] != "" ? esc_attr($ayc_sccp_optons['sccp_web_password']) : "";
	// 	$message = "";
	// 	if($ays_sccp_password_check && !$is_login_page){
	// 		session_start();
	// 		$current_pass = isset($_SESSION['ays_sccp_web_passowrd']) ? $_SESSION['ays_sccp_web_passowrd'] : "";
	// 		$check_pass_once = isset($_SESSION['ays_sccp_web_passowrd_once']) ? $_SESSION['ays_sccp_web_passowrd_once'] : false;
	// 		if(isset($_POST['ays_sccp_password_submit'])){
	// 			if($ays_sccp_password == $_POST['ays_sccp_password_field']){
	// 				$_SESSION['ays_sccp_web_passowrd_once'] = true;
	// 				if(!isset($_SESSION['ays_sccp_web_passowrd'])){
	// 					$_SESSION['ays_sccp_web_passowrd'] = $ays_sccp_password;
	// 					$current_pass = $_SESSION['ays_sccp_web_passowrd'];
	// 				}
	// 			}
	// 			else{
	// 				$message = "<div class='ays_sccp_pass_box'><span style='color: red;'>Wrong Password</span></div>";
	// 			}
		
	// 		}
	// 		$content = "<style>
	// 						div#ays_sccp_website_password{
	// 							height: 100%;
	// 							display: flex;
	// 							justify-content: center;
	// 							align-items: center;
	// 						}
	// 						div.ays_sccp_pass_box{
	// 							text-align: center;
	// 						}
	// 						div.ays_sccp_pass_box input[type='password']{
	// 							width: 100%;
	// 							padding: 10px 7px;
	// 							font-size: 18px;
	// 						}
	// 						div.ays_sccp_pass_box{
	// 							margin-top: 15px;
	// 						}
	// 						div.ays_sccp_pass_box input[name='ays_sccp_password_submit']{
	// 							background-color: #0073aa;
	// 							padding: 10px;
	// 							border: 0;
	// 							outline: none;
	// 							border-radius: 4px;
	// 							color: white;
	// 							font-size: 17px;
	// 							cursor: pointer;
	// 						}
	// 						label[for='ays_sccp_password_field']{
	// 							font-size: 20px;
	// 						}
	// 					</style>";
	// 			if($current_pass != $ays_sccp_password && !$check_pass_once){
	// 				$content .= "<div id='ays_sccp_website_password'>
	// 								<form method='post'>
	// 									<div class='ays_sccp_pass_box'>
	// 										<label for='ays_sccp_password_field'>You need to Enter right password</label>					
	// 									</div>";
	// 						$content .= $message;
	// 						$content .= "<div class='conblock_icon ays_sccp_pass_box'>
	// 										<img src='".SCCP_PUBLIC_URL."/images/lock.png' class='ays_sccp_lock' alt='Lock'>
	// 									</div>
	// 									<div class='ays_sccp_pass_box'>
	// 										<input type='password' name='ays_sccp_password_field'>					
	// 									</div>
	// 									<div class='ays_sccp_pass_box'>
	// 										<input type='submit' name='ays_sccp_password_submit'>
	// 									</div>
	// 								</form>
	// 							</div>";
	// 					echo $content;
	// 				die();
	// 		}
	// 	}
	// }

	public static function ays_autoembed( $content ) {
        global $wp_embed;

        if ( is_null( $content ) ) {
            return $content;
        }

        $content = stripslashes( wpautop( $content ) );
        $content = $wp_embed->autoembed( $content );
        if ( strpos( $content, '[embed]' ) !== false ) {
            $content = $wp_embed->run_shortcode( $content );
        }
        $content = do_shortcode( $content );
        return $content;
    }

	public function ays_get_sccp(){
		global $wpdb;
		$ays_sccp_table = $wpdb->prefix."ays_sccp";
		$sql = "SELECT * FROM ".$ays_sccp_table;
		$results = $wpdb->get_results($sql , "ARRAY_A");
		$result = array();
		if(!empty($results)){
			$result = isset($results[0]) && !empty($results[0]) ? $results[0] : array();
		}
		return $result;
	}

	public function is_login_page() {
		if(in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))){
			$check_page = true;
		}
		else{
			$check_page = false;
		}
		return $check_page;
	}
}
