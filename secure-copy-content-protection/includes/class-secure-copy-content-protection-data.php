<?php

class Ays_Sccp_Data {
    /*
    ==========================================
        Sale Banner | Start
    ==========================================
    */

    public static function ays_sccp_sale_baner(){

        if(isset($_POST['ays_sccp_sale_btn']) && (isset( $_POST['secure-copy-content-protection-sale-banner'] ) && wp_verify_nonce( $_POST['secure-copy-content-protection-sale-banner'], 'secure-copy-content-protection-sale-banner' )) &&
              current_user_can( 'manage_options' )){

            update_option('ays_sccp_sale_btn', 1);
            update_option('ays_sccp_sale_date', current_time( 'mysql' ));
        }      

        if(isset($_POST['ays_sccp_sale_btn_for_two_months'])){
            update_option('ays_sccp_sale_btn_for_two_months', 1);
            update_option('ays_sccp_sale_date', current_time( 'mysql' ));
        }

        $ays_sccp_sale_date = get_option('ays_sccp_sale_date');
        $ays_sccp_sale_two_months = get_option('ays_sccp_sale_btn_for_two_months');

        $val = 60*60*24*5;
        if($ays_sccp_sale_two_months == 1){
            $val = 60*60*24*61;
        }

        $current_date = current_time( 'mysql' );
        $date_diff = strtotime($current_date) -  intval(strtotime($ays_sccp_sale_date)) ;
        // $val = 60*60*24*5;
        $days_diff = $date_diff / $val;

        if(intval($days_diff) > 0 ){
            update_option('ays_sccp_sale_btn', 0);
            update_option('ays_sccp_sale_btn_for_two_months', 0);
        }

        $ays_sccp_ishmar = intval(get_option('ays_sccp_sale_btn'));
        $ays_sccp_ishmar += intval(get_option('ays_sccp_sale_btn_for_two_months'));
        if($ays_sccp_ishmar == 0 ){
            if (isset($_GET['page']) && strpos($_GET['page'], SCCP_NAME) !== false) {
                
                // self::ays_sccp_sale_message2($ays_sccp_ishmar);
                // self::ays_sccp_helloween_message($ays_sccp_ishmar);
                // self::ays_sccp_black_friday_message($ays_sccp_ishmar);
                // self::ays_sccp_new_mega_bundle_message_2024( $ays_sccp_ishmar );
                self::ays_sccp_new_mega_bundle_message($ays_sccp_ishmar);
            }
        }
    } 

    // Chart Builder
    public static function ays_sccp_chart_banner($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-sccp-dicount-month-main" class="notice notice-success is-dismissible ays_sccp_dicount_info ays_sccp_chart_bulider_container">';
                $content[] = '<div id="ays-sccp-dicount-month" class="ays_sccp_dicount_month ays_sccp_chart_bulider_box">';
                    $content[] = '<a href="https://wordpress.org/plugins/chart-builder/" target="_blank" class="ays-sccp-sale-banner-link"></a>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box">';

                        $content[] = '<strong style="font-weight: bold;">';
                            $content[] = __( "<span><a href='https://wordpress.org/plugins/chart-builder/' target='_blank' style='color:#98FBA6; text-decoration: underline;'>Chart Builder</a></span> Plugin is launched", SCCP_NAME );
                        $content[] = '</strong>';
                        $content[] = '<br>';
                        $content[] = __( "Chartify plugin allows you to create beautiful charts and graphs easily and quickly.", SCCP_NAME );

                        $content[] = '<br>';

                        $content[] = '<div style="position: absolute;right: 10px;bottom: 1px;" class="ays-sccp-dismiss-buttons-container-for-form">';

                            $content[] = '<form action="" method="POST">';
                                $content[] = '<div id="ays-sccp-dismiss-buttons-content">';
                                    $content[] = '<button class="btn btn-link ays-button" name="ays_sccp_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0;">Dismiss ad</button>';
                                $content[] = '</div>';
                            $content[] = '</form>';
                            
                        $content[] = '</div>';

                    $content[] = '</div>';

                    $content[] = '<a href="https://wordpress.org/plugins/chart-builder/" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank" >' . __( 'Install Now !', SCCP_NAME ) . '</a>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );
            echo $content;
        }
    }

    // New Mega Bundle 2024
    public static function ays_sccp_new_mega_bundle_message_2024( $ishmar ){
        if($ishmar == 0 ){
            $content = array();
            $content[] = '<div id="ays-sccp-new-mega-bundle-dicount-month-main-2024" class="notice notice-success is-dismissible ays_sccp_dicount_info">';
                $content[] = '<div id="ays-sccp-dicount-month" class="ays_sccp_dicount_month">';

                    $content[] = '<div class="ays-sccp-discount-box-sale-image"></div>';
                    $content[] = '<div class="ays-sccp-dicount-wrap-box ays-sccp-dicount-wrap-text-box">';

                        $content[] = '<div class="ays-sccp-dicount-wrap-text-box-texts">';
                            $content[] = '<div>
                                            <a href="https://ays-pro.com/wordpress/secure-copy-content-protection?utm_source=dashboard-sccp&utm_medium=free-sccp&utm_campaign=sale-banner-sccp" target="_blank" style="color:#30499B;">
                                            <span class="ays-sccp-new-mega-bundle-limited-text">Limited</span> Offer for </a> <br> 
                                            
                                            <span style="font-size: 19px;">Secure Copy Content Protection</span>
                                          </div>';
                        $content[] = '</div>';

                        $content[] = '<div style="font-size: 17px;">';
                            $content[] = '<img style="width: 24px;height: 24px;" src="' . esc_attr(SCCP_ADMIN_URL) . '/images/icons/guarantee-new.png">';
                            $content[] = '<span style="padding-left: 4px; font-size: 14px; font-weight: 600;"> 30 Day Money Back Guarantee</span>';
                            
                        $content[] = '</div>';

                       

                        $content[] = '<div style="position: absolute;right: 10px;bottom: 1px;" class="ays-sccp-dismiss-buttons-container-for-form">';

                            $content[] = '<form action="" method="POST">';
                                $content[] = '<div id="ays-sccp-dismiss-buttons-content">';
                                    if( current_user_can( 'manage_options' ) ){
                                        $content[] = '<button class="btn btn-link ays-button" name="ays_sccp_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0; color: #30499B;
                                        ">Dismiss ad</button>';
                                        $content[] = wp_nonce_field( SCCP_NAME . '-sale-banner' , SCCP_NAME . '-sale-banner' );
                                    }
                                $content[] = '</div>';
                            $content[] = '</form>';
                            
                        $content[] = '</div>';

                    $content[] = '</div>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box ays-sccp-dicount-wrap-countdown-box">';

                        $content[] = '<div id="ays-sccp-countdown-main-container">';
                            $content[] = '<div class="ays-sccp-countdown-container">';

                                $content[] = '<div id="ays-sccp-countdown">';

                                    $content[] = '<div style="font-weight: 500;">';
                                        $content[] = __( "Offer ends in:", SCCP_NAME );
                                    $content[] = '</div>';

                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-sccp-countdown-days"></span>days</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-hours"></span>Hours</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-minutes"></span>Minutes</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-seconds"></span>Seconds</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-sccp-countdown-content" class="emoji">';
                                    $content[] = '<span>🚀</span>';
                                    $content[] = '<span>⌛</span>';
                                    $content[] = '<span>🔥</span>';
                                    $content[] = '<span>💣</span>';
                                $content[] = '</div>';

                            $content[] = '</div>';
                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box ays-sccp-dicount-wrap-button-box">';
                        $content[] = '<a href="https://ays-pro.com/wordpress/secure-copy-content-protection?utm_source=dashboard-sccp&utm_medium=free-sccp&utm_campaign=sale-banner-sccp" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank">' . __( 'Buy Now !', SCCP_NAME ) . '</a>';
                        $content[] = '<span >' . __( 'One-time payment', SCCP_NAME ) . '</span>';
                    $content[] = '</div>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );
            echo html_entity_decode(esc_html( $content ));
        }        
    }

    // New Mega Bundle
    public static function ays_sccp_new_mega_bundle_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-sccp-new-mega-bundle-dicount-month-main" class="notice notice-success is-dismissible ays_sccp_dicount_info">';
                $content[] = '<div id="ays-sccp-dicount-month" class="ays_sccp_dicount_month">';
                    $content[] = '<div class="ays-sccp-dicount-wrap-box ays-sccp-dicount-wrap-text-box">';
                        $content[] = '<div class="ays-sccp-dicount-wrap-box ays-sccp-dicount-wrap-text-boxes">';
                        $content[] = '<div>';
                            $content[] = '<span class="ays-sccp-new-mega-bundle-title">';
                                $content[] = __( "<span><a href='https://ays-pro.com/wordpress/secure-copy-content-protection?utm_source=dashboard-sccp&utm_medium=free-sccp&utm_campaign=sale-banner-sccp' target='_blank' style='color:#ffffff; text-decoration: underline;'>Secure Copy Content Protection</a></span>", SCCP_NAME );
                            $content[] = '</span>';                                
                        $content[] = '</div>';
                        $content[] = '<div>';
                            $content[] = '<img src="' . SCCP_ADMIN_URL . '/images/ays-sccp-banner-sale-30.svg" style="width: 70px;">';
                        $content[] = '</div>';
                        
                        $content[] = '</div>'; 
                        $content[] = '<div>';
                                $content[] = '<img class="ays-sccp-new-mega-bundle-guaranteeicon" src="' . SCCP_ADMIN_URL . '/images/sccp-guaranteeicon.webp" style="width: 30px;">';
                                $content[] = '<span class="ays-sccp-new-mega-bundle-desc">';
                                    $content[] = __( "30 Days Money Back Guarantee", SCCP_NAME );
                                $content[] = '</span>';
                            $content[] = '</div>';                     

                        $content[] = '<div style="position: absolute;right: 10px;bottom: 1px;" class="ays-sccp-dismiss-buttons-container-for-form">';

                            $content[] = '<form action="" method="POST">';
                                $content[] = '<div id="ays-sccp-dismiss-buttons-content">';
                                if( current_user_can( 'manage_options' ) ){
                                    $content[] = '<button class="btn btn-link ays-button" name="ays_sccp_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0">Dismiss ad</button>';
                                    $content[] = wp_nonce_field( 'secure-copy-content-protection-sale-banner' ,  'secure-copy-content-protection-sale-banner' );
                                }
                                $content[] = '</div>';
                            $content[] = '</form>';
                            
                        $content[] = '</div>';

                    $content[] = '</div>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box ays-sccp-dicount-wrap-countdown-box">';

                        $content[] = '<div id="ays-sccp-countdown-main-container">';
                            $content[] = '<div class="ays-sccp-countdown-container">';

                                $content[] = '<div id="ays-sccp-countdown">';

                                    $content[] = '<div>';
                                        $content[] = __( "Offer ends in:", SCCP_NAME );
                                    $content[] = '</div>';

                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-sccp-countdown-days"></span>days</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-hours"></span>Hours</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-minutes"></span>Minutes</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-seconds"></span>Seconds</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-sccp-countdown-content" class="emoji">';
                                    $content[] = '<span>🚀</span>';
                                    $content[] = '<span>⌛</span>';
                                    $content[] = '<span>🔥</span>';
                                    $content[] = '<span>💣</span>';
                                $content[] = '</div>';

                            $content[] = '</div>';
                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box ays-sccp-dicount-wrap-button-box">';
                        $content[] = '<a href="https://ays-pro.com/wordpress/secure-copy-content-protection?utm_source=dashboard-sccp&utm_medium=free-sccp&utm_campaign=sale-banner-sccp" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank">' . __( 'Buy Now', SCCP_NAME ) . '</a>';
                        $content[] = '<span class="ays-sccp-dicount-one-time-text">';
                            $content[] = __( "One-time payment", SCCP_NAME );
                        $content[] = '</span>';
                    $content[] = '</div>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );
            echo $content;
        }
    }

    public static function ays_sccp_sale_message2($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-sccp-dicount-month-main" class="notice notice-success is-dismissible ays_sccp_dicount_info">';
                $content[] = '<div id="ays-sccp-dicount-month" class="ays_sccp_dicount_month">';
                    $content[] = '<a href="https://ays-pro.com/school-bundle?utm_source=dashboard-school&utm_medium=free-school&utm_campaign=sccp-school" target="_blank" class="ays-sccp-sale-banner-link"><img src="' . SCCP_ADMIN_URL . '/images/school bundle.png"></a>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box">';

                        $content[] = '<strong style="font-weight: bold;">';
                            $content[] = __( "Limited Time <span class='ays-sccp-dicount-wrap-color'>50%</span> SALE on <br><span><a href='https://ays-pro.com/school-bundle?utm_source=dashboard-school&utm_medium=free-school&utm_campaign=sccp-school' target='_blank' class='ays-sccp-dicount-wrap-color ays-sccp-dicount-wrap-text-decoration' style='display:block;'>School Bundle</a></span> (Quiz + Copy + Poll + Personal Dictionary)!", SCCP_NAME );
                        $content[] = '</strong>';
                        $content[] = '<br>';
                        $content[] = '<strong>';
                                $content[] = __( "Hurry up! <a href='https://ays-pro.com/school-bundle?utm_source=dashboard-school&utm_medium=free-school&utm_campaign=sccp-school' target='_blank'>Check it out!</a>", SCCP_NAME );
                        $content[] = '</strong>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box">';

                        $content[] = '<div id="ays-sccp-countdown-main-container">';
                            $content[] = '<div class="ays-sccp-countdown-container">';

                                $content[] = '<div id="ays-sccp-countdown">';
                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-sccp-countdown-days"></span>days</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-hours"></span>Hours</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-minutes"></span>Minutes</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-seconds"></span>Seconds</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-sccp-countdown-content" class="emoji">';
                                    $content[] = '<span>🚀</span>';
                                    $content[] = '<span>⌛</span>';
                                    $content[] = '<span>🔥</span>';
                                    $content[] = '<span>💣</span>';
                                $content[] = '</div>';

                            $content[] = '</div>';

                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box ays-buy-now-button-box">';
                        $content[] = '<a href="https://ays-pro.com/school-bundle?utm_source=dashboard-school&utm_medium=free-school&utm_campaign=sccp-school" class="button button-primary ays-buy-now-button" id="ays-button-top-buy-now" target="_blank" style="" >' . __( 'Buy Now !', SCCP_NAME ) . '</a>';
                    $content[] = '</div>';

                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 10px;bottom: 1px;" class="ays-sccp-dismiss-buttons-container-for-form">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-sccp-dismiss-buttons-content">';
                            $content[] = '<button class="btn btn-link ays-button" name="ays_sccp_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0">Dismiss ad</button>';                            
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>';

            $content[] = '</div>';

            $content = implode( '', $content );
            echo $content;
        }
    }

    public static function ays_sccp_spring_bundle_message($ishmar){
        if($ishmar == 0 ){
            $content = array();         

            $content[] = '<div id="ays-sccp-dicount-month-main" class="notice notice-success is-dismissible ays_sccp_dicount_info">';
                $content[] = '<div id="ays-sccp-dicount-month" class="ays_sccp_dicount_month">';
                    $content[] = '<a href="https://ays-pro.com/spring-bundle" target="_blank" class="ays-sccp-sale-banner-link"><img src="' . SCCP_ADMIN_URL . '/images/spring_bundle_logo_box.png"></a>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box">';
                        $content[] = '<p>';
                            $content[] = '<strong>';
                                $content[] = __( "Spring is here! <span class='ays-sccp-dicount-wrap-color'>50%</span> SALE on <span><a href='https://ays-pro.com/spring-bundle' target='_blank' class='ays-sccp-dicount-wrap-color ays-sccp-dicount-wrap-text-decoration'>Spring Bundle</a></span><span style='display: block;'>Quiz + Popup + Copy</span>", SCCP_NAME );
                            $content[] = '</strong>';
                        $content[] = '</p>';
                    $content[] = '</div>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box">';

                        $content[] = '<div id="ays-sccp-countdown-main-container">';

                            $content[] = '<form action="" method="POST" class="ays-sccp-btn-form">';
                                $content[] = '<button class="btn btn-link ays-button" name="ays_sccp_sale_spring_btn" style="height: 32px; margin-left: 0;padding-left: 0">Dismiss ad</button>';
                                $content[] = '<button class="btn btn-link ays-button" name="ays_sccp_sale_spring_btn_for_two_months" style="height: 32px; padding-left: 0">Dismiss ad for 2 months</button>';
                            $content[] = '</form>';

                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<a href="https://ays-pro.com/spring-bundle" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank">' . __( 'Buy Now !', SCCP_NAME ) . '</a>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );
            echo $content;
        }
    }

    public static function ays_sccp_sale_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-sccp-dicount-month-main" class="notice notice-success is-dismissible ays_sccp_dicount_info">';
                $content[] = '<div id="ays-sccp-dicount-month" class="ays_sccp_dicount_month">';                    
                    $content[] = '<a href="https://ays-pro.com/huge-bundle/" target="_blank" class="ays-sccp-sale-banner-link"><img src="' . SCCP_ADMIN_URL . '/images/huge_bundle_logo_box.png"></a>';
                    $content[] = '<div class="ays-sccp-dicount-wrap-box">';

                        $content[] = '<strong style="font-weight: bold;">';
                            $content[] = __( "Limited Time <span class='ays-sccp-dicount-wrap-color'>60%</span> SALE on <br><span><a href='https://ays-pro.com/huge-bundle/' target='_blank' class='ays-sccp-dicount-wrap-color ays-sccp-dicount-wrap-text-decoration'>Huge Bundle</a></span> (All Plugins)", SCCP_NAME );
                        $content[] = '</strong>';

                        $content[] = '<br>';

                        $content[] = '<strong>';
                                $content[] = __( "Hurry up! <a href='https://ays-pro.com/huge-bundle/' target='_blank'>Check it out!</a>", SCCP_NAME );
                        $content[] = '</strong>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box">';

                        $content[] = '<div id="ays-sccp-countdown-main-container">';
                            $content[] = '<div class="ays-sccp-countdown-container">';

                                $content[] = '<div id="ays-sccp-countdown">';
                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-sccp-countdown-days"></span>days</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-hours"></span>Hours</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-minutes"></span>Minutes</li>';
                                        $content[] = '<li><span id="ays-sccp-countdown-seconds"></span>Seconds</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-sccp-countdown-content" class="emoji">';
                                    $content[] = '<span>🚀</span>';
                                    $content[] = '<span>⌛</span>';
                                    $content[] = '<span>🔥</span>';
                                    $content[] = '<span>💣</span>';
                                $content[] = '</div>';

                            $content[] = '</div>';                           

                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-sccp-dicount-wrap-box ays-buy-now-button-box">';
                        $content[] = '<a href="https://ays-pro.com/huge-bundle/" class="button button-primary ays-buy-now-button" id="ays-button-top-buy-now" target="_blank" style="" >' . __( 'Buy Now !', SCCP_NAME ) . '</a>';
                    $content[] = '</div>';              

                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 0;bottom: 1px;" class="ays-sccp-dismiss-buttons-container-for-form">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-sccp-dismiss-buttons-content">';                         
                            $content[] = '<button class="btn btn-link ays-button" name="ays_sccp_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0; color: #979797;">Dismiss ad</button>';
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>';

            $content[] = '</div>';

            $content = implode( '', $content );
            echo $content;
        }
    }

    public static function ays_sccp_helloween_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-sccp-dicount-month-main-helloween" class="notice notice-success is-dismissible ays_sccp_dicount_info">';
                $content[] = '<div id="ays-sccp-dicount-month-helloween" class="ays_sccp_dicount_month_helloween">';
                    $content[] = '<div class="ays-sccp-dicount-wrap-box-helloween-limited">';

                        $content[] = '<p>';
                            $content[] = __( "Limited Time 
                            <span class='ays-sccp-dicount-wrap-color-helloween' style='color:#b2ff00;'>20%</span> 
                            <span>
                                SALE on
                            </span> 
                            <br>
                            <span style='' class='ays-sccp-helloween-bundle'>
                                <a href='https://ays-pro.com/wordpress/secure-copy-content-protection?utm_source=dashboard-sccp&utm_medium=free-sccp&utm_campaign=sale-banner-sccp' target='_blank' class='ays-sccp-dicount-wrap-color-helloween ays-sccp-dicount-wrap-text-decoration-helloween' style='display:block; color:#b2ff00;margin-right:6px;'>
                                    Secure Copy Content Protection
                                </a>
                            </span>", SCCP_NAME );
                        $content[] = '</p>';
                        $content[] = '<p>';
                                $content[] = __( "Hurry up! 
                                                <a href='https://ays-pro.com/wordpress/secure-copy-content-protection?utm_source=dashboard-sccp&utm_medium=free-sccp&utm_campaign=sale-banner-sccp' target='_blank' style='color:#ffc700;'>
                                                    Check it out!
                                                </a>", SCCP_NAME );
                        $content[] = '</p>';
                            
                    $content[] = '</div>';

                    
                    $content[] = '<div class="ays-sccp-helloween-bundle-buy-now-timer">';
                        $content[] = '<div class="ays-sccp-dicount-wrap-box-helloween-timer">';
                            $content[] = '<div id="ays-sccp-countdown-main-container" class="ays-sccp-countdown-main-container-helloween">';
                                $content[] = '<div class="ays-sccp-countdown-container-helloween">';
                                    $content[] = '<div id="ays-sccp-countdown">';
                                        $content[] = '<ul>';
                                            $content[] = '<li><p><span id="ays-sccp-countdown-days"></span><span>days</span></p></li>';
                                            $content[] = '<li><p><span id="ays-sccp-countdown-hours"></span><span>Hours</span></p></li>';
                                            $content[] = '<li><p><span id="ays-sccp-countdown-minutes"></span><span>Mins</span></p></li>';
                                            $content[] = '<li><p><span id="ays-sccp-countdown-seconds"></span><span>Secs</span></p></li>';
                                        $content[] = '</ul>';
                                    $content[] = '</div>';

                                    $content[] = '<div id="ays-sccp-countdown-content" class="emoji">';
                                        $content[] = '<span>🚀</span>';
                                        $content[] = '<span>⌛</span>';
                                        $content[] = '<span>🔥</span>';
                                        $content[] = '<span>💣</span>';
                                    $content[] = '</div>';

                                $content[] = '</div>';

                            $content[] = '</div>';
                                
                        $content[] = '</div>';
                        $content[] = '<div class="ays-sccp-dicount-wrap-box ays-buy-now-button-box-helloween">';
                            $content[] = '<a href="https://ays-pro.com/wordpress/secure-copy-content-protection?utm_source=dashboard-sccp&utm_medium=free-sccp&utm_campaign=sale-banner-sccp" class="button button-primary ays-buy-now-button-helloween" id="ays-button-top-buy-now-helloween" target="_blank" style="" >' . __( 'Buy Now !', SCCP_NAME ) . '</a>';
                        $content[] = '</div>';
                    $content[] = '</div>';

                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 0;bottom: 1px;"  class="ays-sccp-dismiss-buttons-container-for-form-helloween">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-sccp-dismiss-buttons-content-helloween">';
                            if( current_user_can( 'manage_options' ) ){
                                $content[] = '<button class="btn btn-link ays-button-helloween" name="ays_sccp_sale_btn" style="">Dismiss ad</button>';
                                $content[] = wp_nonce_field( 'secure-copy-content-protection-sale-banner' ,  'secure-copy-content-protection-sale-banner' );
                            }                            
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );

            echo $content;
        }
    }

    // Black Friday
    public static function ays_sccp_black_friday_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-sccp-dicount-black-friday-month-main" class="notice notice-success is-dismissible ays_sccp_dicount_info">';
                $content[] = '<div id="ays-sccp-dicount-black-friday-month" class="ays_sccp_dicount_month">';
                    $content[] = '<div class="ays-sccp-dicount-black-friday-box">';
                        $content[] = '<div class="ays-sccp-dicount-black-friday-wrap-box ays-sccp-dicount-black-friday-wrap-box-80" style="width: 70%;">';
                            $content[] = '<div class="ays-sccp-dicount-black-friday-title-row">' . __( 'Limited Time', SCCP_NAME ) .' '. '<a href="https://ays-pro.com/wordpress/secure-copy-content-protection?utm_source=dashboard&utm_medium=sccp-free&utm_campaign=black-friday-sale-banner" class="ays-sccp-dicount-black-friday-button-sale" target="_blank">' . __( 'Sale', SCCP_NAME ) . '</a>' . '</div>';
                            $content[] = '<div class="ays-sccp-dicount-black-friday-title-row">' . __( 'Secure Copy Content Protection', SCCP_NAME ) . '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-sccp-dicount-black-friday-wrap-box ays-sccp-dicount-black-friday-wrap-text-box">';
                            $content[] = '<div class="ays-sccp-dicount-black-friday-text-row">' . __( '20% off', SCCP_NAME ) . '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-sccp-dicount-black-friday-wrap-box" style="width: 25%;">';
                            $content[] = '<div id="ays-sccp-countdown-main-container">';
                                $content[] = '<div class="ays-sccp-countdown-container">';
                                    $content[] = '<div id="ays-sccp-countdown" style="display: block;">';
                                        $content[] = '<ul>';
                                            $content[] = '<li><span id="ays-sccp-countdown-days">0</span>' . __( 'Days', SCCP_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-sccp-countdown-hours">0</span>' . __( 'Hours', SCCP_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-sccp-countdown-minutes">0</span>' . __( 'Minutes', SCCP_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-sccp-countdown-seconds">0</span>' . __( 'Seconds', SCCP_NAME ) . '</li>';
                                        $content[] = '</ul>';
                                    $content[] = '</div>';
                                    $content[] = '<div id="ays-sccp-countdown-content" class="emoji" style="display: none;">';
                                        $content[] = '<span>🚀</span>';
                                        $content[] = '<span>⌛</span>';
                                        $content[] = '<span>🔥</span>';
                                        $content[] = '<span>💣</span>';
                                    $content[] = '</div>';
                                $content[] = '</div>';
                            $content[] = '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-sccp-dicount-black-friday-wrap-box" style="width: 25%;">';
                            $content[] = '<a href="https://ays-pro.com/wordpress/secure-copy-content-protection?utm_source=dashboard&utm_medium=sccp-free&utm_campaign=black-friday-sale-banner" class="ays-sccp-dicount-black-friday-button-buy-now" target="_blank">' . __( 'Get Your Deal', SCCP_NAME ) . '</a>';
                        $content[] = '</div>';
                    $content[] = '</div>';
                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 0;bottom: 1px;"  class="ays-sccp-dismiss-buttons-container-for-form-black-friday">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-sccp-dismiss-buttons-content-black-friday">';
                            if( current_user_can( 'manage_options' ) ){
                                $content[] = '<button class="btn btn-link ays-button-black-friday" name="ays_sccp_sale_btn" style="">Dismiss ad</button>';
                                $content[] = wp_nonce_field( 'secure-copy-content-protection-sale-banner' ,  'secure-copy-content-protection-sale-banner' );
                            }                            
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>'; 
            $content[] = '</div>';

            $content = implode( '', $content );

            echo $content;
        }
    }

     // Christmas banner
    public static function ays_sccp_christmas_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-sccp-dicount-christmas-month-main" class="notice notice-success is-dismissible ays_sccp_dicount_info">';
                $content[] = '<div id="ays-sccp-dicount-christmas-month" class="ays_sccp_dicount_month">';
                    $content[] = '<div class="ays-sccp-dicount-christmas-box">';
                        $content[] = '<div class="ays-sccp-dicount-christmas-wrap-box ays-sccp-dicount-christmas-wrap-box-80">';
                            $content[] = '<div class="ays-sccp-dicount-christmas-title-row">' . __( 'Limited Time', SCCP_NAME ) .' '. '<a href="https://ays-pro.com/wordpress/secure-copy-content-protection" class="ays-sccp-dicount-christmas-button-sale" target="_blank">' . __( '20%', SCCP_NAME ) . '</a>' . ' SALE</div>';
                            $content[] = '<div class="ays-sccp-dicount-christmas-title-row">' . __( 'Secure Copy Content Protection', SCCP_NAME ) . '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-sccp-dicount-christmas-wrap-box" style="width: 25%;">';
                            $content[] = '<div id="ays-sccp-countdown-main-container">';
                                $content[] = '<div class="ays-sccp-countdown-container">';
                                    $content[] = '<div id="ays-sccp-countdown" style="display: block;">';
                                        $content[] = '<ul>';
                                            $content[] = '<li><span id="ays-sccp-countdown-days"></span>' . __( 'Days', SCCP_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-sccp-countdown-hours"></span>' . __( 'Hours', SCCP_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-sccp-countdown-minutes"></span>' . __( 'Minutes', SCCP_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-sccp-countdown-seconds"></span>' . __( 'Seconds', SCCP_NAME ) . '</li>';
                                        $content[] = '</ul>';
                                    $content[] = '</div>';
                                    $content[] = '<div id="ays-sccp-countdown-content" class="emoji" style="display: none;">';
                                        $content[] = '<span>🚀</span>';
                                        $content[] = '<span>⌛</span>';
                                        $content[] = '<span>🔥</span>';
                                        $content[] = '<span>💣</span>';
                                    $content[] = '</div>';
                                $content[] = '</div>';
                            $content[] = '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-sccp-dicount-christmas-wrap-box" style="width: 25%;">';
                            $content[] = '<a href="https://ays-pro.com/wordpress/secure-copy-content-protection" class="ays-sccp-dicount-christmas-button-buy-now" target="_blank">' . __( 'BUY NOW!', SCCP_NAME ) . '</a>';
                        $content[] = '</div>';
                    $content[] = '</div>';
                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 0;bottom: 1px;"  class="ays-sccp-dismiss-buttons-container-for-form-christmas">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-sccp-dismiss-buttons-content-christmas">';
                            $content[] = '<button class="btn btn-link ays-button-christmas" name="ays_sccp_sale_btn" style="">' . __( 'Dismiss ad', SCCP_NAME ) . '</button>';
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );

            echo $content;
        }
    }

    /*
    ==========================================
        Sale Banner | End
    ==========================================
    */
}
