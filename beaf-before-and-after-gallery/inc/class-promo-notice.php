<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class bafg_PROMO_NOTICE {

    // private $api_url = 'http://bafg-api.test/';
    private $api_url = 'https://api.themefic.com/';
    private $args = array();
    private $responsed = false; 
    private $bafg_promo_option = false; 
    private $error_message = ''; 

    private $months = ['January', 'June', 'November', 'December'];
    private $plugins_existes = ['uacf7', 'tf', 'ins', 'ebef'];

    public function __construct() {

        $bafg_pro_activated = get_option( 'bafg_pro_activated');
        
        if(in_array(gmdate('F'), $this->months) &&  $bafg_pro_activated != 'true' ){   
            add_filter('cron_schedules', array($this, 'bafg_custom_cron_interval'));
             
            if (!wp_next_scheduled('bafg_promo__schudle')) {
                wp_schedule_event(time(), 'bafg_every_day', 'bafg_promo__schudle');
            }
            
            add_action('bafg_promo__schudle', array($this, 'bafg_promo__schudle_callback'));
          

            if(get_option( 'bafg_promo__schudle_option' )){
                $this->bafg_promo_option = get_option( 'bafg_promo__schudle_option' );
            } 
 
            // Admin Notice 
            $tf_existes = get_option( 'tf_promo_notice_exists' );
            if( ! in_array($tf_existes, $this->plugins_existes) && is_array($this->bafg_promo_option) && strtotime($this->bafg_promo_option['end_date']) > time() && strtotime($this->bafg_promo_option['start_date']) < time()){
                add_action( 'admin_notices', array( $this, 'tf_black_friday_2023_admin_notice' ) );
                add_action( 'wp_ajax_tf_black_friday_notice_dismiss_callback', array($this, 'tf_black_friday_notice_dismiss_callback') );
            }

            // side Notice Woo Product Meta Box Notice 
            $tf_woo_existes = get_option( 'tf_promo_notice_woo_exists' );
             if( is_array($this->bafg_promo_option) && strtotime($this->bafg_promo_option['end_date']) > time() && strtotime($this->bafg_promo_option['start_date']) < time()){   
                add_action( 'add_meta_boxes', array($this, 'tf_black_friday_2023_woo_product') );
                
	            add_filter( 'get_user_option_meta-box-order_bafg', array($this, 'metabox_order') );
                add_action( 'wp_ajax_bafg_black_friday_notice_bafg_dismiss_callback', array($this, 'bafg_black_friday_notice_bafg_dismiss_callback') ); 
           
            } 
            
			
            register_deactivation_hook( BAFG_PLUGIN_PATH . 'before-and-after-gallery.php', array($this, 'bafg_promo_notice_deactivation_hook') );
             
            
        }

        
       
    }

    public function bafg_get_api_response(){
        $query_params = array(
            'plugin' => 'bafg', 
        );
        $response = wp_remote_post($this->api_url, array(
            'body'    => json_encode($query_params),
            'headers' => array('Content-Type' => 'application/json'),
        )); 
        if (is_wp_error($response)) {
            // Handle API request error
            $this->responsed = false;
            $this->error_message = esc_html__($response->get_error_message(), 'bafg');
 
        } else {
            // API request successful, handle the response content
            $data = wp_remote_retrieve_body($response);
           
            $this->responsed = json_decode($data, true); 

            $bafg_promo__schudle_option = get_option( 'bafg_promo__schudle_option' ); 
            if(!empty($bafg_promo__schudle_option) && $bafg_promo__schudle_option['notice_name'] != $this->responsed['notice_name']){ 
                // Unset the cookie variable in the current script
                update_option( 'tf_dismiss_admin_notice', 1);
                update_option( 'bafg_dismiss_post_notice', 1); 
            }
            update_option( 'bafg_promo__schudle_option', $this->responsed);
            
        } 
    }

    // Define the custom interval
    public function bafg_custom_cron_interval($schedules) {
        $schedules['bafg_every_day'] = array(
            'interval' => 86400, // Every 24 hours
            // 'interval' => 5, // Every 24 hours
            'display' => __('Every 24 hours')
        );
        return $schedules;
    }

    public function bafg_promo__schudle_callback() {  

        $this->bafg_get_api_response();

    }
 

    /**
     * Black Friday Deals 2023
     */
    
    public function tf_black_friday_2023_admin_notice(){ 
        
        $image_url = isset($this->bafg_promo_option['dasboard_url']) ? esc_url($this->bafg_promo_option['dasboard_url']) : '';
        $deal_link = isset($this->bafg_promo_option['promo_url']) ? esc_url($this->bafg_promo_option['promo_url']) : ''; 

        $tf_dismiss_admin_notice = get_option( 'tf_dismiss_admin_notice' );
        $get_current_screen = get_current_screen();  
        if(($tf_dismiss_admin_notice == 1  || time() >  $tf_dismiss_admin_notice ) && $get_current_screen->base == 'dashboard'   ){ 
            // if very fist time then set the dismiss for our other plugbafg
            update_option( 'tf_promo_notice_exists', 'bafg' );
            ?>
            <style> 
                .tf_black_friday_20222_admin_notice a:focus {
                    box-shadow: none;
                } 
                .tf_black_friday_20222_admin_notice {
                    padding: 7px;
                    position: relative;
                    z-index: 10;
                    max-width: 825px;
                } 
                .tf_black_friday_20222_admin_notice button:before {
                    color: #fff !important;
                }
                .tf_black_friday_20222_admin_notice button:hover::before {
                    color: #d63638 !important;
                }
                
            </style>
            <div class="notice notice-success tf_black_friday_20222_admin_notice"> 
                <a href="<?php echo esc_attr( $deal_link ); ?>" style="display: block; line-height: 0;" target="_blank" >
                    <img  style="width: 100%;" src="<?php echo esc_attr($image_url) ?>" alt="">
                </a> 
                <?php if( isset($this->bafg_promo_option['dasboard_dismiss']) && $this->bafg_promo_option['dasboard_dismiss'] == true): ?>
                <button type="button" class="notice-dismiss tf_black_friday_notice_dismiss"><span class="screen-reader-text"><?php echo esc_html(__('Dismiss this notice.', 'bafg' )) ?></span></button>
                <?php  endif; ?>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $(document).on('click', '.tf_black_friday_notice_dismiss', function( event ) {
                        jQuery('.tf_black_friday_20222_admin_notice').css('display', 'none')
                        data = {
                            action : 'tf_black_friday_notice_dismiss_callback',
                        };

                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: data,
                            success: function (data) { ;
                            },
                            error: function (data) { 
                            }
                        });
                    });
                });
            </script>
        
        <?php 
        }
        
    } 


    public function tf_black_friday_notice_dismiss_callback() {  

        $bafg_promo_option = get_option( 'bafg_promo__schudle_option' );
        $restart = isset($bafg_promo_option['dasboard_restart']) && $bafg_promo_option['dasboard_restart'] != false ? $bafg_promo_option['dasboard_restart'] : false; 
        if($restart == false){
            update_option( 'tf_dismiss_admin_notice', strtotime($bafg_promo_option['end_date']) ); 
        }else{
            update_option( 'tf_dismiss_admin_notice', time() + (86400 * $restart) );  
        } 
		wp_die();
	}


    /**
     * Black Friday Deals 2023 woo product
     */ 

    public function tf_black_friday_2023_woo_product() { 
        $bafg_dismiss_post_notice = get_option( 'bafg_dismiss_post_notice' ); 
        if($bafg_dismiss_post_notice == 1  || time() >  $bafg_dismiss_post_notice ): 
            add_meta_box( 'tf_black_friday_annous', ' ', array($this, 'tf_black_friday_2023_callback_woo_product'), 'bafg', 'side', 'high' );
        endif;
   
    }
    public function tf_black_friday_2023_callback_woo_product() {
        $image_url = isset($this->bafg_promo_option['side_url']) ? esc_url($this->bafg_promo_option['side_url']) : '';
        $deal_link = isset($this->bafg_promo_option['promo_url']) ? esc_url($this->bafg_promo_option['promo_url']) : ''; 
      ?>
        <style>
            #tf_black_friday_annous{
                border: 0px solid;
                box-shadow: none;
                background: transparent;
            }
            .back_friday_2023_preview a:focus {
                box-shadow: none;
            }

            .back_friday_2023_preview a {
                display: inline-block;
            }

            #tf_black_friday_annous .bafgide {
                padding: 0;
                margin-top: 0;
            }

            #tf_black_friday_annous .postbox-header {
                display: none;
                visibility: hidden;
            }
            #tf_black_friday_annous .inside{
                padding: 0px !important;
            }
        </style> 
     
        <div class="back_friday_2023_preview bafg-bf-preview" style="text-align: center; overflow: hidden;">
            <a href="<?php echo esc_attr($deal_link); ?>" target="_blank" >
                <img  style="width: 100%;" src="<?php echo esc_attr($image_url); ?>" alt="">
            </a>  
            <?php if( isset($this->bafg_promo_option['side_dismiss']) && $this->bafg_promo_option['side_dismiss'] == true): ?>
                <button type="button" class="notice-dismiss bafg_friday_notice_dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
            <?php  endif; ?>
          
        </div>
        <script> 
            jQuery(document).ready(function($) {
                $(document).on('click', '.bafg_friday_notice_dismiss', function( event ) { 
                    jQuery('.bafg-bf-preview').css('display', 'none');
                    data = {
                        action : 'bafg_black_friday_notice_bafg_dismiss_callback', 
                    };

                    $.ajax({
                        url: ajaxurl,
                        type: 'post',
                        data: data,
                        success: function (data) { ;
                        },
                        error: function (data) { 
                        }
                    });
                });
            });
        </script>
        <?php 
    }

    public function metabox_order( $order ) {
		return array(
			'side' => join( 
				",", 
				array(       // vvv  Arrange here as you desire
					'submitdiv',
					'tf_black_friday_annous',
				)
			),
		);
	}

    public  function bafg_black_friday_notice_bafg_dismiss_callback() {   
        $bafg_promo_option = get_option( 'bafg_promo__schudle_option' );
        $start_date = isset($bafg_promo_option['start_date']) ? strtotime($bafg_promo_option['start_date']) : time();
        $restart = isset($bafg_promo_option['side_restart']) && $bafg_promo_option['side_restart'] != false ? $bafg_promo_option['side_restart'] : 5;
        update_option( 'bafg_dismiss_post_notice', time() + (86400 * $restart) );  
        wp_die();
    }

    // Deactivation Hook
    public function bafg_promo_notice_deactivation_hook() {
        wp_clear_scheduled_hook('bafg_promo__schudle'); 

        delete_option('bafg_promo__schudle_option');
        delete_option('tf_dismiss_admin_notice');
        delete_option('bafg_dismiss_post_notice');
        delete_option('tf_promo_notice_exists');
    }
 
}

new bafg_PROMO_NOTICE();
