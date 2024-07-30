<?php
namespace H5VP\Model;
use H5VP\Helper\Functions as Utils;


class AjaxCall{

    protected static $_instance = null;

    public function __construct(){
        add_action('wp_ajax_h5vp_export_data', [$this, 'h5vp_export_data']);

        // save video password
        add_action('wp_ajax_save_password', [$this, 'save_password']);
    }

    function save_password(){
        $nonce = sanitize_text_field( $_POST['nonce'] );
        if(!wp_verify_nonce($nonce, 'wp_ajax')){
            wp_send_json_error('invalid request');
        }

        if(!is_user_logged_in()){
            wp_send_json_error('not logged in');
        }

        $key = sanitize_text_field($_POST['key']);

        $data = [
            'key' => $key,
            'pass' => md5(sanitize_text_field($_POST['password'])),
            'quality' => Utils::sanitize_array($_POST['quality']),
            'source' => esc_url($_POST['source'])
        ];
        

        update_option($key, $data);

        wp_send_json_error([$key => $data]);
    }

  
    public static function instance(){
        if(self::$_instance === null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function user_has_role($user_id, $role_name)
    {
        $user_meta = get_userdata($user_id);
        $user_roles = $user_meta->roles;
        return in_array($role_name, $user_roles);
    }
    

    public function h5vp_export_data(){
        $nonce = sanitize_text_field( $_POST['nonce'] );

        if(!wp_verify_nonce($nonce, 'wp_ajax')){
            wp_send_json_error('invalid request');
        }

        $id = sanitize_text_field( $_POST['id'] );
        $output['id'] = $id;
        if(!$id) die();

        $is_administrator = $this->user_has_role(get_current_user_id(), 'administrator');

        if(!$is_administrator){
            echo wp_json_encode('you are not capable to export data');
            wp_die();
        }

        $post_type = get_post_type( $id );

        if(in_array($post_type, ['videoplayer', 'h5vpplaylist'])){
            $meta = get_post_meta($id);
            $post = get_post($id);
            unset($meta['_edit_last']);
            unset($meta['_edit_lock']);
            unset($meta['h5vp_total_views']);

            foreach($meta as $key => $value){
                $output[$key] = maybe_unserialize( $value[0] );
            }
            $output['body'] = $post->post_content;
            echo wp_json_encode($output);
        }

        die();

    }
}

AjaxCall::instance();