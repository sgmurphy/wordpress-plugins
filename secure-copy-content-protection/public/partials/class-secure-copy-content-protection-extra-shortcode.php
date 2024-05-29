<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ays-pro.com/
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
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Ays_Sccp_Extra_Shortcodes_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    protected $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    private $html_class_prefix = 'ays-sccp-extra-shortcodes-';
    private $html_name_prefix = 'ays-sccp-';
    private $name_prefix = 'ays_sccp_';
    private $unique_id;
    private $unique_id_in_class;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version){

        $this->plugin_name = $plugin_name;
        $this->version = $version;        
        
        add_shortcode('ays_sccp_subscribers_count', array($this, 'ays_generate_subscribers_count_method'));
        add_shortcode('ays_sccp_user_first_name', array($this, 'ays_generate_user_first_name_method'));
        add_shortcode('ays_sccp_user_last_name', array($this, 'ays_generate_user_last_name_method'));
        add_shortcode('ays_sccp_user_email', array($this, 'ays_generate_user_email_method'));
        add_shortcode('ays_sccp_user_roles', array($this, 'ays_generate_user_roles_method'));
        add_shortcode('ays_sccp_user_display_name', array($this, 'ays_generate_user_display_name_method'));
        add_shortcode('ays_sccp_user_nickname', array($this, 'ays_generate_user_nickname_method'));
    }  

    /*
    ==========================================
        Subscribe users count | Start
    ==========================================
    */

    public function ays_generate_subscribers_count_method( $attr ){

        $id = (isset($attr['id']) && $attr['id'] != '') ? absint( sanitize_text_field($attr['id']) ) : null;

        if (is_null($id) || $id == 0 ) {
            $passed_users_count_html = "<p class='wrong_shortcode_text' style='color:red;'>" . __('Wrong shortcode initialized', $this->plugin_name) . "</p>";
            return str_replace(array("\r\n", "\n", "\r"), "\n", $passed_users_count_html);
        }

        $unique_id = uniqid();
        $this->unique_id = $unique_id;
        $this->unique_id_in_class = $id . "-" . $unique_id;


        $passed_users_count_html = $this->ays_sccp_subscribers_count_html( $id );
        return str_replace(array("\r\n", "\n", "\r"), "\n", $passed_users_count_html);
    }

    public function get_sccp_subscribers_count_by_id($id){
        global $wpdb;

        $reports_table = esc_sql( $wpdb->prefix . "ays_sccp_reports" );

        if (is_null($id) || $id == 0 ) {
            return null;
        }

        $sql = "SELECT COUNT(*) AS res_count
                FROM {$reports_table}
                WHERE `subscribe_id`=" . $id;

        $sccp = $wpdb->get_row($sql, 'ARRAY_A');

        return $sccp;
    }

    public function ays_sccp_subscribers_count_html( $id ){

        $results = $this->get_sccp_subscribers_count_by_id( $id );

        $content_html = array();

        if($results === null){
            $content_html = "<p style='text-align: center;font-style:italic;'>" . __( "There are no results yet.", $this->plugin_name ) . "</p>";
            return $content_html;
        }

        $subscribers_count_count = (isset( $results['res_count'] ) && $results['res_count'] != '') ? sanitize_text_field( $results['res_count'] ) : 0;

        $content_html[] = "<span class='". $this->html_name_prefix ."subscribe-users-count-box' id='". $this->html_name_prefix ."subscribe-users-count-box-". $this->unique_id_in_class ."' data-id='". $this->unique_id ."'>";
            $content_html[] = $subscribers_count_count;
        $content_html[] = "</span>";

        $content_html = implode( '' , $content_html);

        return $content_html;
    }

    /*
    ==========================================
        Subscribe users count | End
    ==========================================
    */

    /*
    ==========================================
        Show User First Name | Start
    ==========================================
    */

    public function get_user_profile_data(){

        /*
         * SCCP message variables for Start Page
         */

        $user_first_name        = '';
        $user_last_name         = '';
        $user_nickname          = '';
        $user_display_name      = '';
        $user_email             = '';
        $user_wordpress_roles   = '';

        $user_id = get_current_user_id();
        if($user_id != 0){
            $usermeta = get_user_meta( $user_id );
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
        }

        $message_data = array(
            'user_first_name'       => $user_first_name,
            'user_last_name'        => $user_last_name,
            'user_nickname'         => $user_nickname,
            'user_display_name'     => $user_display_name,
            'user_email'            => $user_email,
            'user_wordpress_roles'  => $user_wordpress_roles,
        );

        return $message_data;
    }

    public function ays_generate_user_first_name_method(){

        $unique_id = uniqid();
        $this->unique_id = $unique_id;
        $this->unique_id_in_class = $unique_id;

        $user_first_name_html = "";
        if(is_user_logged_in()){
            $user_first_name_html = $this->ays_generate_user_first_name_html();
        }
        return str_replace(array("\r\n", "\n", "\r"), "\n", $user_first_name_html);
    }

    public function ays_generate_user_first_name_html(){

        $results = $this->get_user_profile_data();

        $content_html = array();
        
        if( is_null( $results ) || $results == 0 ){
            $content_html = "";
            return $content_html;
        }

        $user_first_name = (isset( $results['user_first_name'] ) && sanitize_text_field( $results['user_first_name'] ) != "") ? sanitize_text_field( $results['user_first_name'] ) : '';

        $content_html[] = "<span class='". $this->html_name_prefix ."user-first-name' id='". $this->html_name_prefix ."user-first-name-". $this->unique_id_in_class ."' data-id='". $this->unique_id ."'>";
            $content_html[] = $user_first_name;
        $content_html[] = "</span>";

        $content_html = implode( '' , $content_html);

        return $content_html;
    }

    /*
    ==========================================
        Show User First Name | End
    ==========================================
    */

     /*
    ==========================================
        Show User Last Name | Start
    ==========================================
    */

    public function ays_generate_user_last_name_method(){

        $unique_id = uniqid();
        $this->unique_id = $unique_id;
        $this->unique_id_in_class = $unique_id;

        $user_last_name_html = "";
        if(is_user_logged_in()){
            $user_last_name_html = $this->ays_generate_user_last_name_html();
        }
        return str_replace(array("\r\n", "\n", "\r"), "\n", $user_last_name_html);
    }

    public function ays_generate_user_last_name_html(){

        $results = $this->get_user_profile_data();

        $content_html = array();
        
        if( is_null( $results ) || $results == 0 ){
            $content_html = "";
            return $content_html;
        }

        $user_last_name = (isset( $results['user_last_name'] ) && sanitize_text_field( $results['user_last_name'] ) != "") ? sanitize_text_field( $results['user_last_name'] ) : '';

        $content_html[] = "<span class='". $this->html_name_prefix ."user-last-name' id='". $this->html_name_prefix ."user-last-name-". $this->unique_id_in_class ."' data-id='". $this->unique_id ."'>";
            $content_html[] = $user_last_name;
        $content_html[] = "</span>";

        $content_html = implode( '' , $content_html);

        return $content_html;
    }

    /*
    ==========================================
        Show User Last Name | End
    ==========================================
    */

    /*
    ==========================================
        Show User Email | Start
    ==========================================
    */

    public function ays_generate_user_email_method(){

        $unique_id = uniqid();
        $this->unique_id = $unique_id;
        $this->unique_id_in_class = $unique_id;

        $user_email_html = "";
        if(is_user_logged_in()){
            $user_email_html = $this->ays_generate_user_email_html();
        }
        return str_replace(array("\r\n", "\n", "\r"), "\n", $user_email_html);
    }

    public function ays_generate_user_email_html(){

        $results = $this->get_user_profile_data();

        $content_html = array();
        
        if( is_null( $results ) || $results == 0 ){
            $content_html = "";
            return $content_html;
        }

        $user_email = (isset( $results['user_email'] ) && sanitize_text_field( $results['user_email'] ) != "") ? sanitize_text_field( $results['user_email'] ) : '';

        $content_html[] = "<span class='". $this->html_name_prefix ."user-email' id='". $this->html_name_prefix ."user-email-". $this->unique_id_in_class ."' data-id='". $this->unique_id ."'>";
            $content_html[] = $user_email;
        $content_html[] = "</span>";

        $content_html = implode( '' , $content_html);

        return $content_html;
    }

    /*
    ==========================================
        Show User Email | End
    ==========================================
    */

      /*
    ==========================================
        Show User Roles | Start
    ==========================================
    */

    public function ays_generate_user_roles_method(){

        $unique_id = uniqid();
        $this->unique_id = $unique_id;
        $this->unique_id_in_class = $unique_id;

        $user_email_html = "";
        if(is_user_logged_in()){
            $user_email_html = $this->ays_generate_user_roles_html();
        }
        return str_replace(array("\r\n", "\n", "\r"), "\n", $user_email_html);
    }

    public function ays_generate_user_roles_html(){

        $results = $this->get_user_profile_data();

        $content_html = array();
        
        if( is_null( $results ) || $results == 0 ){
            $content_html = "";
            return $content_html;
        }

        $user_wordpress_roles = (isset( $results['user_wordpress_roles'] ) && sanitize_text_field( $results['user_wordpress_roles'] ) != "") ? sanitize_text_field( $results['user_wordpress_roles'] ) : '';

        $content_html[] = "<span class='". $this->html_name_prefix ."user-wordpress-roles' id='". $this->html_name_prefix ."user-wordpress-roles-". $this->unique_id_in_class ."' data-id='". $this->unique_id ."'>";
            $content_html[] = $user_wordpress_roles;
        $content_html[] = "</span>";

        $content_html = implode( '' , $content_html);

        return $content_html;
    }

    /*
    ==========================================
        Show User Roles | End
    ==========================================
    */

    /*
    ==========================================
        Show User Display name | Start
    ==========================================
    */

    public function ays_generate_user_display_name_method(){

        $unique_id = uniqid();
        $this->unique_id = $unique_id;
        $this->unique_id_in_class = $unique_id;

        $user_display_name_html = "";
        if(is_user_logged_in()){
            $user_display_name_html = $this->ays_generate_user_display_name_html();
        }
        return str_replace(array("\r\n", "\n", "\r"), "\n", $user_display_name_html);
    }

    public function ays_generate_user_display_name_html(){

        $results = $this->get_user_profile_data();

        $content_html = array();
        
        if( is_null( $results ) || $results == 0 ){
            $content_html = "";
            return $content_html;
        }

        $user_display_name = (isset( $results['user_display_name'] ) && sanitize_text_field( $results['user_display_name'] ) != "") ? sanitize_text_field( $results['user_display_name'] ) : '';

        $content_html[] = "<span class='". $this->html_name_prefix ."user-display-name' id='". $this->html_name_prefix ."user-display-name-". $this->unique_id_in_class ."' data-id='". $this->unique_id ."'>";
            $content_html[] = $user_display_name;
        $content_html[] = "</span>";

        $content_html = implode( '' , $content_html);

        return $content_html;
    }

    /*
    ==========================================
        Show User Display name | End
    ==========================================
    */

    /*
    ==========================================
        Show User Nickname | Start
    ==========================================
    */

    public function ays_generate_user_nickname_method(){

        $unique_id = uniqid();
        $this->unique_id = $unique_id;
        $this->unique_id_in_class = $unique_id;

        $user_nickname_html = "";
        if(is_user_logged_in()){
            $user_nickname_html = $this->ays_generate_user_nickname_html();
        }
        return str_replace(array("\r\n", "\n", "\r"), "\n", $user_nickname_html);
    }

    public function ays_generate_user_nickname_html(){

        $results = $this->get_user_profile_data();

        $content_html = array();
        
        if( is_null( $results ) || $results == 0 ){
            $content_html = "";
            return $content_html;
        }

        $user_nickname = (isset( $results['user_nickname'] ) && sanitize_text_field( $results['user_nickname'] ) != "") ? sanitize_text_field( $results['user_nickname'] ) : '';

        $content_html[] = "<span class='". $this->html_name_prefix ."user-nickname' id='". $this->html_name_prefix ."user-nickname-". $this->unique_id_in_class ."' data-id='". $this->unique_id ."'>";
            $content_html[] = $user_nickname;
        $content_html[] = "</span>";

        $content_html = implode( '' , $content_html);

        return $content_html;
    }

    /*
    ==========================================
        Show User Nickname | End
    ==========================================
    */
}
