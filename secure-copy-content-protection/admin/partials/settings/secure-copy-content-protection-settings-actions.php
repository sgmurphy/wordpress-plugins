<?php
class Sccp_Settings_Actions {
    private $plugin_name;

    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
        // $this->check_setting_mailchimp();
    }

    public function store_data($data){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ays_sccp_settings";
        if( isset($data["settings_action"]) && wp_verify_nonce( $data["settings_action"], 'settings_action' ) ){
            $success = 0;            
            $mailchimp_username = isset($data['ays_mailchimp_username']) ? esc_attr(stripslashes($data['ays_mailchimp_username'])) : '';
            $mailchimp_api_key = isset($data['ays_mailchimp_api_key']) ? esc_attr(stripslashes($data['ays_mailchimp_api_key'])) : '';
            $mailchimp = array(
                'username' => $mailchimp_username,
                'apiKey' => $mailchimp_api_key
            );
            // WP Editor height
            $sccp_wp_editor_height = (isset($data['ays_sccp_wp_editor_height']) && $data['ays_sccp_wp_editor_height'] != '') ? absint( sanitize_text_field($data['ays_sccp_wp_editor_height']) ) : 150 ;

            $sccp_disable_user_ip = (isset( $data['ays_sccp_disable_user_ip'] ) && sanitize_text_field( $data['ays_sccp_disable_user_ip'] ) == 'on') ? 'on' : 'off';

            $options = array(
                "sccp_wp_editor_height" => $sccp_wp_editor_height,
                "sccp_disable_user_ip" => $sccp_disable_user_ip,
            );

            // Subscribe box width
            $ays_sccp_sub_width = (isset($data['ays_sccp_sub_width']) && $data['ays_sccp_sub_width'] != '') ? absint( sanitize_text_field($data['ays_sccp_sub_width']) ) : '';

            // Subscribe input width
            $ays_sccp_sub_input_width = (isset($data['ays_sccp_sub_input_width']) && $data['ays_sccp_sub_input_width'] != '') ? absint( sanitize_text_field($data['ays_sccp_sub_input_width']) ) : '';

            // Subscribe box title size
            $ays_sccp_sub_title_size = (isset($data['ays_sccp_sub_title_size']) && $data['ays_sccp_sub_title_size'] != '') ? absint( sanitize_text_field($data['ays_sccp_sub_title_size']) ) : 18;

            // Subscribe box description size
            $ays_sccp_sub_desc_size = (isset($data['ays_sccp_sub_desc_size']) && $data['ays_sccp_sub_desc_size'] != '') ? absint( sanitize_text_field($data['ays_sccp_sub_desc_size']) ) : 18;

            // Subscribe box text color
            $sub_text_color = (isset($data['sub_text_color']) && $data['sub_text_color'] != '') ? stripslashes( esc_attr($data['sub_text_color']) ) : '#000';

            // Subscribe description text color
            $sub_desc_text_color = (isset($data['sub_desc_text_color']) && $data['sub_desc_text_color'] != '') ? stripslashes( esc_attr($data['sub_desc_text_color']) ) : '#000';

            // Subscribe box background color
            $sub_bg_color = (isset($data['sub_bg_color']) && $data['sub_bg_color'] != '') ? stripslashes( esc_attr($data['sub_bg_color']) ) : '#fff';
            
            // Subscribe box title transformation
            $sub_title_transformation = (isset($data['ays_sub_title_transformation']) && sanitize_text_field( $data['ays_sub_title_transformation'] ) != "") ? sanitize_text_field( $data['ays_sub_title_transformation'] ) : 'none';

            // Subscribe box button text
            $ays_sub_button_text = (isset($data['ays_sccp_sub_button_text']) && $data['ays_sccp_sub_button_text'] != '') ? stripslashes( esc_attr($data['ays_sccp_sub_button_text']) ) : 'Subscribe';

            // Subscribe box Add Icon
            $ays_sub_icon_img = (isset($data['ays_sccp_sub_icon_image']) && $data['ays_sccp_sub_icon_image'] != '') ? $data['ays_sccp_sub_icon_image'] : '';

            // Subscribe box Add BG Image
            $ays_sub_bg_img = (isset($data['ays_sccp_sub_bg_image']) && $data['ays_sccp_sub_bg_image'] != '') ? $data['ays_sccp_sub_bg_image'] : '';

            // Subscribe box email placeholder text
            $ays_sub_email_place_text = (isset($data['ays_sccp_sub_email_place_text']) && $data['ays_sccp_sub_email_place_text'] != '') ? stripslashes( esc_attr($data['ays_sccp_sub_email_place_text']) ) : 'Type your email address';

            // Subscribe box name placeholder text
            $ays_sub_name_place_text = (isset($data['ays_sccp_sub_name_place_text']) && $data['ays_sccp_sub_name_place_text'] != '') ? stripslashes( esc_attr($data['ays_sccp_sub_name_place_text']) ) : 'Type your name';

            //Subscribe button style
            $enable_sub_btn_style = (isset($data['ays_sccp_enable_sub_btn_style']) && $data['ays_sccp_enable_sub_btn_style'] != '') ? 'on' : 'off';

            $sub_btn_color = (isset($data['ays_sccp_sub_btn_color']) && $data['ays_sccp_sub_btn_color'] != '') ? sanitize_text_field($data['ays_sccp_sub_btn_color']) : 'rgba(255,255,255,0)';

            $sub_btn_text_color = (isset($data['ays_sccp_sub_btn_text_color']) && $data['ays_sccp_sub_btn_text_color'] != '') ? sanitize_text_field($data['ays_sccp_sub_btn_text_color']) : '#000000';

            $sub_btn_border_color = (isset($data['ays_sccp_sub_btn_border_color']) && $data['ays_sccp_sub_btn_border_color'] != '') ? sanitize_text_field($data['ays_sccp_sub_btn_border_color']) : '#000000';

            $sub_cont_border_color = (isset($data['ays_sccp_sub_cont_border_color']) && $data['ays_sccp_sub_cont_border_color'] != '') ? sanitize_text_field($data['ays_sccp_sub_cont_border_color']) : '#000000';

            $sub_btn_size = (isset($data['ays_sccp_sub_btn_size']) && $data['ays_sccp_sub_btn_size'] != '') ? sanitize_text_field($data['ays_sccp_sub_btn_size']) : '14';

            $sub_mobile_btn_size = (isset($data['ays_sccp_sub_mobile_btn_size']) && $data['ays_sccp_sub_mobile_btn_size'] != '') ? sanitize_text_field($data['ays_sccp_sub_mobile_btn_size']) : '14';

            $sub_btn_radius = (isset($data['ays_sccp_sub_btn_radius']) && sanitize_text_field( $data['ays_sccp_sub_btn_radius'] ) != "") ? sanitize_text_field( $data['ays_sccp_sub_btn_radius'] ) : '3';

            // Buttons border width
            $sub_btn_border_width = (isset($data['ays_sccp_sub_btn_border_width']) && sanitize_text_field( $data['ays_sccp_sub_btn_border_width'] ) != "") ? sanitize_text_field( $data['ays_sccp_sub_btn_border_width'] ) : '1';

            // Container border width
            $sub_cont_border_width = (isset($data['ays_sccp_sub_cont_border_width']) && sanitize_text_field( $data['ays_sccp_sub_cont_border_width'] ) != "") ? sanitize_text_field( $data['ays_sccp_sub_cont_border_width'] ) : '1';

            // Buttons border style
            $sub_btn_border_style = (isset($data['ays_sccp_sub_btn_border_style']) && $data['ays_sccp_sub_btn_border_style'] != '') ? sanitize_text_field( $data['ays_sccp_sub_btn_border_style'] ) : 'solid';

            // Container border style
            $sub_cont_border_style = (isset($data['ays_sccp_sub_cont_border_style']) && $data['ays_sccp_sub_cont_border_style'] != '') ? sanitize_text_field( $data['ays_sccp_sub_cont_border_style'] ) : 'solid';

            // Buttons Left / Right padding
            $buttons_left_right_padding = (isset($data['ays_sub_btn_left_right_padding']) && $data['ays_sub_btn_left_right_padding'] != "") ? $data['ays_sub_btn_left_right_padding'] : '20';

            // Buttons Top / Bottom padding
            $buttons_top_bottom_padding = (isset($data['ays_sub_btn_top_bottom_padding']) && $data['ays_sub_btn_top_bottom_padding'] != "") ? $data['ays_sub_btn_top_bottom_padding'] : '10';

            // Subscribe box text alignment
            $sccp_sub_text_alignment = (isset($data['ays_sccp_sub_text_alignment']) && sanitize_text_field( $data['ays_sccp_sub_text_alignment']) != '') ? sanitize_text_field( $data['ays_sccp_sub_text_alignment'] ) : 'center';

            // Subscribe box Width by percentage or pixels
            $sccp_sub_width_by_percentage_px = (isset($data['ays_sccp_sub_width_by_percentage_px']) && $data['ays_sccp_sub_width_by_percentage_px'] != '') ? sanitize_text_field( $data['ays_sccp_sub_width_by_percentage_px'] ) : 'pixels';

            // Subscribe Bg image positioning
            $sub_bg_image_position = (isset($data['ays_sub_bg_image_position']) && $data['ays_sub_bg_image_position'] != "") ? $data['ays_sub_bg_image_position'] : 'center center';

            $subscribe = array(
                "sccp_sub_width"                    => $ays_sccp_sub_width,
                "sub_cont_input_width"              => $ays_sccp_sub_input_width,
                "sccp_sub_text_color"               => $sub_text_color,
                "sccp_sub_desc_text_color"          => $sub_desc_text_color,
                "sccp_sub_bg_color"                 => $sub_bg_color,
                "sub_title_transformation"          => $sub_title_transformation,
                "sccp_sub_button_text"              => $ays_sub_button_text,
                "sub_icon_image"                    => $ays_sub_icon_img,
                "sub_bg_image"                      => $ays_sub_bg_img,
                "sub_bg_image_position"             => $sub_bg_image_position,
                "sccp_sub_email_place_text"         => $ays_sub_email_place_text,
                "sccp_sub_name_place_text"          => $ays_sub_name_place_text,
                "sccp_sub_title_size"               => $ays_sccp_sub_title_size,
                "sccp_sub_desc_size"                => $ays_sccp_sub_desc_size,
                "enable_sub_btn_style"              => $enable_sub_btn_style,
                "sub_btn_color"                     => $sub_btn_color,
                "sub_btn_text_color"                => $sub_btn_text_color,
                "sub_btn_border_color"              => $sub_btn_border_color,
                "sub_cont_border_color"             => $sub_cont_border_color,
                "sub_btn_size"                      => $sub_btn_size,
                "sub_mobile_btn_size"               => $sub_mobile_btn_size,
                "sub_btn_radius"                    => $sub_btn_radius,
                "sub_btn_border_width"              => $sub_btn_border_width,
                "sub_cont_border_width"             => $sub_cont_border_width,
                "sub_btn_border_style"              => $sub_btn_border_style,
                "sub_cont_border_style"             => $sub_cont_border_style,
                "sub_btn_left_right_padding"        => $buttons_left_right_padding,
                "sub_btn_top_bottom_padding"        => $buttons_top_bottom_padding,
                "sccp_sub_text_alignment"           => $sccp_sub_text_alignment,
                "sccp_sub_width_by_percentage_px"   => $sccp_sub_width_by_percentage_px                

            );            

             // Block content box width
            $ays_sccp_bc_width = (isset($data['ays_sccp_bc_width']) && $data['ays_sccp_bc_width'] != '') ? absint( sanitize_text_field($data['ays_sccp_bc_width']) ) : '';

            // Block content box Width by percentage or pixels
            $sccp_bc_width_by_percentage_px = (isset($data['ays_sccp_bc_width_by_percentage_px']) && $data['ays_sccp_bc_width_by_percentage_px'] != '') ? sanitize_text_field( $data['ays_sccp_bc_width_by_percentage_px'] ) : 'pixels';

            // Block content box text color
            $bc_text_color = (isset($data['bc_text_color']) && $data['bc_text_color'] != '') ? stripslashes( esc_attr($data['bc_text_color']) ) : '#000';

            // Block content box background color
            $bc_bg_color = (isset($data['bc_bg_color']) && $data['bc_bg_color'] != '') ? stripslashes( esc_attr($data['bc_bg_color']) ) : '#fff';

            // Block content box Add BG Image
            $ays_bc_bg_img = (isset($data['ays_sccp_bc_bg_image']) && $data['ays_sccp_bc_bg_image'] != '') ? $data['ays_sccp_bc_bg_image'] : '';

            // Block content Bg image positioning
            $bc_bg_image_position = (isset($data['ays_bc_bg_image_position']) && $data['ays_bc_bg_image_position'] != "") ? $data['ays_bc_bg_image_position'] : 'center center';

            // Block content box button text
            $ays_bc_button_text = (isset($data['ays_sccp_bc_button_text']) && $data['ays_sccp_bc_button_text'] != '') ? stripslashes( esc_attr($data['ays_sccp_bc_button_text']) ) : 'Submit';

            // Block content box password placeholder text
            $ays_bc_psw_place_text = (isset($data['ays_sccp_bc_psw_place_text']) && $data['ays_sccp_bc_psw_place_text'] != '') ? stripslashes( esc_attr($data['ays_sccp_bc_psw_place_text']) ) : 'Password';

            // Block content Container border style
            $bc_cont_border_style = (isset($data['ays_sccp_bc_cont_border_style']) && $data['ays_sccp_bc_cont_border_style'] != '') ? sanitize_text_field( $data['ays_sccp_bc_cont_border_style'] ) : 'double';

            // Block content Container border color
            $bc_cont_border_color = (isset($data['ays_sccp_bc_cont_border_color']) && $data['ays_sccp_bc_cont_border_color'] != '') ? sanitize_text_field($data['ays_sccp_bc_cont_border_color']) : '#c5c5c5';

            // Block content Container border width
            $bc_cont_border_width = (isset($data['ays_sccp_bc_cont_border_width']) && sanitize_text_field( $data['ays_sccp_bc_cont_border_width'] ) != "") ? sanitize_text_field( $data['ays_sccp_bc_cont_border_width'] ) : '4';

            // Block content box Add Icon
            $ays_bc_icon_img = (isset($data['ays_sccp_bc_icon_image']) && $data['ays_sccp_bc_icon_image'] != '') ? $data['ays_sccp_bc_icon_image'] : '';

            // Block content input width
            $ays_sccp_bc_input_width = (isset($data['ays_sccp_bc_input_width']) && $data['ays_sccp_bc_input_width'] != '') ? absint( sanitize_text_field($data['ays_sccp_bc_input_width']) ) : '';

            // Block content box text alignment
            $sccp_bc_text_alignment = (isset($data['ays_sccp_bc_text_alignment']) && sanitize_text_field( $data['ays_sccp_bc_text_alignment']) != '') ? sanitize_text_field( $data['ays_sccp_bc_text_alignment'] ) : 'center';

            //Block content button style
            $enable_bc_btn_style = (isset($data['ays_sccp_enable_bc_btn_style']) && $data['ays_sccp_enable_bc_btn_style'] != '') ? 'on' : 'off';

            $bc_btn_color = (isset($data['ays_sccp_bc_btn_color']) && $data['ays_sccp_bc_btn_color'] != '') ? sanitize_text_field($data['ays_sccp_bc_btn_color']) : 'rgba(255,255,255,0)';

            $bc_btn_text_color = (isset($data['ays_sccp_bc_btn_text_color']) && $data['ays_sccp_bc_btn_text_color'] != '') ? sanitize_text_field($data['ays_sccp_bc_btn_text_color']) : '#000000';

            $bc_btn_size = (isset($data['ays_sccp_bc_btn_size']) && $data['ays_sccp_bc_btn_size'] != '') ? sanitize_text_field($data['ays_sccp_bc_btn_size']) : '14';

            $bc_mobile_btn_size = (isset($data['ays_sccp_bc_mobile_btn_size']) && $data['ays_sccp_bc_mobile_btn_size'] != '') ? sanitize_text_field($data['ays_sccp_bc_mobile_btn_size']) : '14';

            $bc_btn_radius = (isset($data['ays_sccp_bc_btn_radius']) && sanitize_text_field( $data['ays_sccp_bc_btn_radius'] ) != "") ? sanitize_text_field( $data['ays_sccp_bc_btn_radius'] ) : '3';

            // Block content Buttons border width
            $bc_btn_border_width = (isset($data['ays_sccp_bc_btn_border_width']) && sanitize_text_field( $data['ays_sccp_bc_btn_border_width'] ) != "") ? sanitize_text_field( $data['ays_sccp_bc_btn_border_width'] ) : '1';

            // Block content Buttons border style
            $bc_btn_border_style = (isset($data['ays_sccp_bc_btn_border_style']) && $data['ays_sccp_bc_btn_border_style'] != '') ? sanitize_text_field( $data['ays_sccp_bc_btn_border_style'] ) : 'solid';

            // Block content Buttons border color
            $bc_btn_border_color = (isset($data['ays_sccp_bc_btn_border_color']) && $data['ays_sccp_bc_btn_border_color'] != '') ? sanitize_text_field($data['ays_sccp_bc_btn_border_color']) : '#c5c5c5';

            // Block content Buttons Left / Right padding
            $bc_buttons_left_right_padding = (isset($data['ays_bc_btn_left_right_padding']) && $data['ays_bc_btn_left_right_padding'] != "") ? $data['ays_bc_btn_left_right_padding'] : '10';

            // Block content Buttons Top / Bottom padding
            $bc_buttons_top_bottom_padding = (isset($data['ays_bc_btn_top_bottom_padding']) && $data['ays_bc_btn_top_bottom_padding'] != "") ? $data['ays_bc_btn_top_bottom_padding'] : '10';

            $block_content = array(
                "sccp_bc_width"                  => $ays_sccp_bc_width,
                "sccp_bc_width_by_percentage_px" => $sccp_bc_width_by_percentage_px,
                "sccp_bc_text_color"             => $bc_text_color,
                "sccp_bc_bg_color"               => $bc_bg_color,
                "bc_bg_image"                    => $ays_bc_bg_img,
                "bc_bg_image_position"           => $bc_bg_image_position,
                "sccp_bc_button_text"            => $ays_bc_button_text,
                "sccp_bc_psw_place_text"         => $ays_bc_psw_place_text,
                "bc_cont_border_style"           => $bc_cont_border_style,
                "bc_cont_border_color"           => $bc_cont_border_color,
                "bc_cont_border_width"           => $bc_cont_border_width,
                "bc_icon_image"                  => $ays_bc_icon_img,
                "bc_cont_input_width"            => $ays_sccp_bc_input_width,
                "bc_text_alignment"              => $sccp_bc_text_alignment,
                "enable_bc_btn_style"            => $enable_bc_btn_style,
                "bc_btn_color"                   => $bc_btn_color,
                "bc_btn_text_color"              => $bc_btn_text_color,
                "bc_btn_size"                    => $bc_btn_size,
                "bc_mobile_btn_size"             => $bc_mobile_btn_size,
                "bc_btn_radius"                  => $bc_btn_radius,
                "bc_btn_border_width"            => $bc_btn_border_width,
                "bc_btn_border_style"            => $bc_btn_border_style,
                "bc_btn_border_color"            => $bc_btn_border_color,
                "bc_btn_left_right_padding"      => $bc_buttons_left_right_padding,
                "bc_btn_top_bottom_padding"      => $bc_buttons_top_bottom_padding,
            );

            $result = $this->ays_update_setting('mailchimp', json_encode($mailchimp));
            if ($result) {
                $success++;
            }
            $result = $this->ays_update_setting('options', json_encode($options));
            if ($result) {
                $success++;
            }
            
            $result = $this->ays_update_setting('subscribe', json_encode( $subscribe, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ));
            if ($result) {
                $success++;
            }

            $result = $this->ays_update_setting('block_content', json_encode( $block_content, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ));
            if ($result) {
                $success++;
            }

            $message = "saved";
            if($success > 0){
                $tab = "";
                if(isset($data['ays_sccp_tab'])){
                    $tab = "&ays_sccp_tab=".$data['ays_sccp_tab'];
                }
                $url = admin_url('admin.php') . "?page=secure-copy-content-protection-settings" . $tab . '&status=' . $message;
                wp_redirect( $url );
            }
        }

    }

    public function get_db_data(){
        global $wpdb;
        $settings_table = esc_sql($wpdb->prefix . "ays_sccp_settings");
        $sql = "SELECT * FROM ".$settings_table;
        
        $results = $wpdb->get_results($sql, 'ARRAY_A');
        if(count($results) > 0){
            return $results;
        }else{
            return array();
        }
    }

    public function check_setting_mailchimp(){
        global $wpdb;
        $settings_table = esc_sql($wpdb->prefix . "ays_sccp_settings");
        $mailchimp = esc_sql('mailchimp');
        $sql = "SELECT COUNT(*) FROM ".$settings_table." WHERE meta_key = %s";

        $result = $wpdb->get_var(
                    $wpdb->prepare( $sql, $mailchimp)
                  );

        if(intval($result) == 0){
            $this->ays_add_setting("mailchimp", "", "", "");
        }
        return false;
    }

    public function ays_get_setting($meta_key){
        global $wpdb;
        $settings_table = esc_sql($wpdb->prefix . "ays_sccp_settings");
        $key_meta = esc_sql($meta_key);

        $sql = "SELECT meta_value FROM ".$settings_table." WHERE meta_key = %s";

        $result = $wpdb->get_var(
                    $wpdb->prepare( $sql, $key_meta)
                  );

        if($result != ""){
            return $result;
        }
        return false;
    }

    public function ays_add_setting($meta_key, $meta_value, $note = "", $options = ""){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ays_sccp_settings";
        $result = $wpdb->insert(
            $settings_table,
            array(
                'meta_key'    => $meta_key,
                'meta_value'  => $meta_value,
                'note'        => $note,
                'options'     => $options
            ),
            array( '%s', '%s', '%s', '%s' )
        );
        if($result >= 0){
            return true;
        }
        return false;
    }

    public function ays_update_setting($meta_key, $meta_value, $note = null, $options = null){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ays_sccp_settings";
        $value = array(
            'meta_value'  => $meta_value,
        );
        $value_s = array( '%s' );
        if($note != null){
            $value['note'] = $note;
            $value_s[] = '%s';
        }
        if($options != null){
            $value['options'] = $options;
            $value_s[] = '%s';
        }
        $result = $wpdb->update(
            $settings_table,
            $value,
            array( 'meta_key' => $meta_key, ),
            $value_s,
            array( '%s' )
        );
        if($result >= 0){
            return true;
        }
        return false;
    }

    public function ays_delete_setting($meta_key){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ays_sccp_settings";
        $wpdb->delete(
            $settings_table,
            array( 'meta_key' => $meta_key ),
            array( '%s' )
        );
    }

    public function sccp_settings_notices($status){

        if ( empty( $status ) )
            return;

        if ( 'saved' == $status )
            $updated_message = esc_html( __( 'Changes saved.', $this->plugin_name ) );
        elseif ( 'updated' == $status )
            $updated_message = esc_html( __( 'SCCP attribute .', $this->plugin_name ) );
        elseif ( 'deleted' == $status )
            $updated_message = esc_html( __( 'SCCP attribute deleted.', $this->plugin_name ) );

        if ( empty( $updated_message ) )
            return;

        ?>
        <div class="notice notice-success is-dismissible">
            <p> <?php echo $updated_message; ?> </p>
        </div>
        <?php
    }

}