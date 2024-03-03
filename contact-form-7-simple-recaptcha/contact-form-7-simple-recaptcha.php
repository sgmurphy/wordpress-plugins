<?php
/*
Plugin Name: Contact Form 7 Captcha
Description: Add No CAPTCHA reCAPTCHA to Contact Form 7 using [cf7sr-simple-recaptcha] shortcode
Version: 0.1.3
Author: 247wd
Text Domain: cf7sr-free
Domain Path: /languages
*/

function cf7sr_pro_load_textdomain() {
    load_plugin_textdomain( 'cf7sr-free', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    if ( isset( $_GET['cf7sr-notice'] ) ) {
        update_option( 'cf7sr_notice', 1 );
    }
}
add_action( 'init', 'cf7sr_pro_load_textdomain' );

function cf7sr_activation_notice() {
    $cf7sr_notice = get_option('cf7sr_notice');
    if (empty($cf7sr_notice)) { ?>
        <div class="notice notice-success" style="position: relative">
            <p>Contact Form 7 Captcha - <?php echo __( 'Trusted by more than 100,000 businesses worldwide. The Pro version is even better!', 'cf7sr-free' ); ?></p>
            <p>
                <a href="<?php echo admin_url( 'options-general.php?page=cf7sr_edit' ); ?>&cf7sr-notice=0#features"><?php echo __( 'Check out the cool new features.', 'cf7sr-free' ); ?></a>
                <a style="text-decoration: none" href="<?php admin_url() ?>?cf7sr-notice=0" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></a>
            </p>
        </div>
    <?php
    }
}
add_action( 'admin_notices', 'cf7sr_activation_notice' );

$cf7sr_key = get_option('cf7sr_key');
$cf7sr_secret = get_option( 'cf7sr_secret' );
if (!empty($cf7sr_key) && !empty($cf7sr_secret)) {
    function enqueue_cf7sr_script() {
        global $cf7sr;
        if (!$cf7sr) {
            return;
        }
        $cf7sr_script_url = 'https://www.google.com/recaptcha/api.js?onload=cf7srLoadCallback&render=explicit';
        $cf7sr_key = get_option( 'cf7sr_key' );
        ?>
        <script type="text/javascript">
            var widgetIds = [];
            var cf7srLoadCallback = function() {
                var cf7srWidgets = document.querySelectorAll('.cf7sr-g-recaptcha');
                for (var i = 0; i < cf7srWidgets.length; ++i) {
                    var cf7srWidget = cf7srWidgets[i];
                    var widgetId = grecaptcha.render(cf7srWidget.id, {
                        'sitekey' : <?php echo wp_json_encode($cf7sr_key); ?>
                    });
                    widgetIds.push(widgetId);
                }
            };

            function cf7srResetRecaptcha() {
                for (var i = 0; i < widgetIds.length; i++) {
                    grecaptcha.reset(widgetIds[i]);
                }
            }

            document.querySelectorAll('.wpcf7').forEach(function(element) {
                element.addEventListener('wpcf7invalid', cf7srResetRecaptcha);
                element.addEventListener('wpcf7mailsent', cf7srResetRecaptcha);
                element.addEventListener('invalid.wpcf7', cf7srResetRecaptcha);
                element.addEventListener('mailsent.wpcf7', cf7srResetRecaptcha);
            });
        </script>
        <script src="<?php echo esc_url($cf7sr_script_url); ?>" async defer></script>
        <?php
    }
    add_action('wp_footer', 'enqueue_cf7sr_script');

    function cf7sr_wpcf7_form_elements($form) {
        $form = do_shortcode($form);
        return $form;
    }
    add_filter('wpcf7_form_elements', 'cf7sr_wpcf7_form_elements');

    function cf7sr_shortcode($atts) {
        global $cf7sr;
        $cf7sr = true;
        $cf7sr_key = get_option('cf7sr_key');
        return '<div id="cf7sr-' . uniqid() . '" class="cf7sr-g-recaptcha" data-sitekey="' . esc_attr($cf7sr_key)
            . '"></div><span class="wpcf7-form-control-wrap cf7sr-recaptcha" data-name="cf7sr-recaptcha"><input type="hidden" name="cf7sr-recaptcha" value="" class="wpcf7-form-control"></span>';
    }
    add_shortcode('cf7sr-simple-recaptcha', 'cf7sr_shortcode');

    function cf7sr_verify_recaptcha($result) {
        if (! class_exists('WPCF7_Submission')) {
            return $result;
        }

        $_wpcf7 = ! empty($_POST['_wpcf7']) ? absint($_POST['_wpcf7']) : 0;
        if (empty($_wpcf7)) {
            return $result;
        }

        $submission = WPCF7_Submission::get_instance();
        $data = $submission->get_posted_data();

        $cf7_text = do_shortcode( '[contact-form-7 id="' . $_wpcf7 . '"]' );
        $cf7sr_key = get_option( 'cf7sr_key' );
        if (false === strpos($cf7_text, $cf7sr_key)) {
            return $result;
        }

        $message = get_option('cf7sr_message');
        if (empty($message)) {
            $message = 'Invalid captcha';
        }

        if (empty($data['g-recaptcha-response'])) {
            $result->invalidate(array('type' => 'captcha', 'name' => 'cf7sr-recaptcha'), $message);
            return $result;
        }

        $cf7sr_secret = get_option('cf7sr_secret');
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $cf7sr_secret . '&response=' . $data['g-recaptcha-response'];
        $request = wp_remote_get($url);
        $body = wp_remote_retrieve_body($request);
        $response = json_decode($body);
        if (!(isset ($response->success) && 1 == $response->success)) {
            $result->invalidate(array('type' => 'captcha', 'name' => 'cf7sr-recaptcha'), $message);
        }

        return $result;
    }
    add_filter('wpcf7_validate', 'cf7sr_verify_recaptcha', 20, 2);
}

function cf7sr_add_action_links($links) {
    array_unshift($links , '<a href="' . admin_url( 'options-general.php?page=cf7sr_edit' ) . '">Settings</a>');
    array_unshift($links , '<a target="_blank" style="color: #019c29; font-weight: 700;" href="https://lukasapps.de/wordpress/plugins/cf7-captcha-pro/">Get Captcha Pro</a>');
    return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'cf7sr_add_action_links', 10, 2 );

function cf7sr_adminhtml() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    if (! class_exists('WPCF7_Submission')) {
        echo '<p>To use <strong>Contact Form 7 Captcha</strong> please update <strong>Contact Form 7</strong> plugin as current version is not supported.</p>';
        return;
    }
    if (
        ! empty ($_POST['update'])
        && ! empty($_POST['cf7sr_nonce'])
        && wp_verify_nonce($_POST['cf7sr_nonce'],'cf7sr_update_settings' )
    ) {
        $cf7sr_key = ! empty ($_POST['cf7sr_key']) ? sanitize_text_field($_POST['cf7sr_key']) : '';
        update_option('cf7sr_key', $cf7sr_key);

        $cf7sr_secret = ! empty ($_POST['cf7sr_secret']) ? sanitize_text_field($_POST['cf7sr_secret']) : '';
        update_option('cf7sr_secret', $cf7sr_secret);

        $cf7sr_message = ! empty ($_POST['cf7sr_message']) ? sanitize_text_field($_POST['cf7sr_message']) : '';
        update_option('cf7sr_message', $cf7sr_message);

        $updated = 1;
    } else {
        $cf7sr_key = get_option('cf7sr_key');
        $cf7sr_secret = get_option('cf7sr_secret');
        $cf7sr_message = get_option('cf7sr_message');
    }
    ?>
    <style>
        .cf7sr-content * {box-sizing: border-box;}
        .cf7sr-section {background: #fff;border: 1px solid #e5e5e5;margin-bottom: 20px;padding: 20px }
        .cf7sr-section h3 {color: #444;margin-top: 0;font-size: 16px;font-weight: 700;}
        .cf7sr-section p {color: #444;font-size: 14px;margin-bottom: 20px;}
        .cf7sr-section .cf7sr-msg, .cf7sr-section .cf7sr-title {padding: 0.75rem 1.25rem;margin-top: 1rem;border: 1px solid transparent;border-radius: 0.25rem;}
        .cf7sr-section .cf7sr-info-msg {color: #0c5460;background-color: #d1ecf1;border-color: #bee5eb;}
        .cf7sr-section .cf7sr-success-msg {color: #155724;background-color: #d4edda;border-color: #c3e6cb;}
        .cf7sr-section .cf7sr-warning-msg {color: #856404;background-color: #fff3cd;border-color: #ffeeba;}
        .cf7sr-section .cf7sr-danger-msg {color: #721c24;background-color: #f8d7da;border-color: #f5c6cb;}
        .cf7sr-section input[type="text"] {max-width: 500px; width: 100%;}
        .cf7sr-section .cf7sr-row {margin-bottom: 20px;}.cf7sr-section .cf7sr-row label {display: block;margin-bottom: 5px;font-weight: bold;}
        .cf7sr-section ul li {margin: 0;padding: 0 0 5px 15px;font-size: 14px;position: relative;}
        .cf7sr-section ul li:before {content: "+";position: absolute;top: -1px;left: 0;}
        .cf7sr-section .cf7sr-go-pro {margin-bottom: 0}
        .cf7sr-section .cf7sr-go-pro a {color: #df7128;}
    </style>
    <div class="wrap cf7sr-content">
        <div class="cf7sr-section">
            <h3><?php echo __( 'Settings', 'cf7sr-free' ); ?></h3>
            <p>
                <?php echo __( 'This plugin adds <strong>I am not a robot</strong> checkbox to Contact Form 7, extending its functionality (not affiliated with the Contact Form 7 plugin).', 'cf7sr-free' ); ?>
            </p>

            <p class="cf7sr-title cf7sr-info-msg"><?php echo __( 'To add Captcha to Contact Form 7 form, add <strong>[cf7sr-simple-recaptcha]</strong> in your form ( preferable above submit button )', 'cf7sr-free' ); ?></p>

            <?php if (empty($cf7sr_key) || empty($cf7sr_key)) { ?>
                <p class="cf7sr-title cf7sr-danger-msg"><?php echo __( 'The plugin will not work unless you set up the configuration below', 'cf7sr-free' ); ?></p>
            <?php } ?>

            <form action="<?php echo admin_url( 'options-general.php?page=cf7sr_edit' ); ?>" method="POST">
                <input type="hidden" value="1" name="update">
                <?php wp_nonce_field( 'cf7sr_update_settings', 'cf7sr_nonce' ); ?>
                <div class="cf7sr-row">
                    <label>Site key</label>
                    <input type="text" value="<?php echo esc_attr( $cf7sr_key ); ?>" name="cf7sr_key">
                </div>

                <div class="cf7sr-row">
                    <label>Secret key</label>
                    <input type="text" value="<?php echo esc_attr( $cf7sr_secret ); ?>" name="cf7sr_secret">
                </div>

                <div class="cf7sr-row">
                    <label><?php echo __( 'Invalid captcha error message', 'cf7sr-free' ); ?></label>
                    <input type="text" placeholder="Invalid captcha" value="<?php echo esc_attr( $cf7sr_message ); ?>" name="cf7sr_message">
                </div>

                <input type="submit" class="button-primary" value="<?php echo __( 'Save Settings', 'cf7sr-free' ); ?>">
            </form>

            <?php if ( ! empty( $updated ) ) { ?>
                <p class="cf7sr-msg cf7sr-success-msg"><?php echo __( 'Updated successfully!', 'cf7sr-free' ); ?></p>
            <?php } ?>
        </div>
        <div class="cf7sr-section" id="features">
            <h3><?php echo __( 'Get Captcha Pro and Unlock all the Powerful Features', 'cf7sr-free' ); ?></h3>
            <p><?php echo __( 'Trusted by more than 100,000 businesses worldwide. The Pro version is even better!', 'cf7sr-free' ); ?> <?php echo __( 'Check out the cool new features.', 'cf7sr-free' ); ?></p>
            <p><strong><?php echo __( 'PRO features.', 'cf7sr-free' ); ?></strong></p>
            <ul>
                <li><?php echo __( 'WPML and POLYLANG language integration', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Render captcha widget in a specific language, choose from 70 languages.', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Switch between the color theme of the widget, light or dark.', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Switch between the type of the widget, image or audio.', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Switch between the size of the widget, normal or compact.', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Redirect users to any url after mail sent successfully.', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Integrate powerful honeypot protection into your forms for stronger security.', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Define a list of restricted words. Messages containing restricted words will not be sent.', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Get IP Blocker access to block messages from malicious IP addresses.', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Use rate limiting to manage how often forms can be submitted and prevent abuse.', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Enable automatic saving of Contact Form 7 messages to your database.', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Use Twilio SMS to receive new form submission notifications directly to your phone.', 'cf7sr-free' ); ?></li>
                <li><?php echo __( 'Transfer data from contact form submissions directly into your Mailchimp list.', 'cf7sr-free' ); ?></li>
            </ul>
            <p class="cf7sr-go-pro"><a target="_blank" href="https://lukasapps.de/wordpress/plugins/cf7-captcha-pro/"><?php echo __( 'Get Captcha Pro and Unlock all the Powerful Features', 'cf7sr-free' ); ?> &raquo;</a></p>
        </div>
        <div class="cf7sr-section">
            <p class="cf7sr-title cf7sr-info-msg">
                <?php echo __( 'Use this link to generate', 'cf7sr-free' ); ?>  <i>Site key</i> and <i>Secret key</i>: <a target="_blank" href="https://www.google.com/recaptcha/admin">https://www.google.com/recaptcha/admin</a><br>
                <?php echo __( 'Choose', 'cf7sr-free' ); ?>  Challenge (v2) -> "I'm not a robot" Checkbox
            </p>
            <p><a target="_blank" href="https://www.google.com/recaptcha/admin"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>captcha.jpg" width="400" alt="captcha" /></a></p>
        </div>
    </div>
    <script>
        var cf7srMsg = document.querySelector('.cf7sr-msg');
        if (cf7srMsg) {
            setTimeout(function() {
                cf7srMsg.remove();
            }, 3000);
        }
    </script>
    <?php
}

function cf7sr_addmenu() {
    add_submenu_page (
        'options-general.php',
        'CF7 Simple Recaptcha',
        'CF7 Simple Recaptcha',
        'manage_options',
        'cf7sr_edit',
        'cf7sr_adminhtml'
    );
}
add_action('admin_menu', 'cf7sr_addmenu');
