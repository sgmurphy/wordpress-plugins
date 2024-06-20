<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="">
    <form id="gtmsettings_form">
        <div class="py-2 convwiz_border card mw-100">
            <label class="form-check-label h6 mb-0">
                <?php esc_html_e("V2 Consent", "enhanced-e-commerce-for-woocommerce-store"); ?>
                <span class="conv-link-blue ms-2 fw-bold-500 upgradetopro_badge" data-bs-toggle="modal" data-bs-target="#upgradetopromodal">
                    <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/upgrade_badge.png'); ?>" />
                    <?php esc_html_e("Available In Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </span>
            </label>
            <small><strong style="color:#0AB17B"><?php esc_html_e("Recommended:", "enhanced-e-commerce-for-woocommerce-store"); ?></strong>&nbsp; 
                <?php esc_html_e("Conversios support Google V2 Consent & is compatible with", "enhanced-e-commerce-for-woocommerce-store"); ?>&nbsp;
                <a class="conv-link-blue" href="https://www.conversios.io/docs/how-to-set-up-real-cookie-banner-with-conversios-plugin/" target="_black">Real Cookie Banner,</a>
                <a class="conv-link-blue" href="https://www.conversios.io/docs/how-to-set-up-gdpr-cookie-compliance-with-conversios-plugin/" target="_black">GDPR Cookie Compliance,</a>
                <a class="conv-link-blue" href="https://www.conversios.io/docs/how-to-set-up-cookiebot-consent-with-conversios-plugin/" target="_black">CookieBot</a> and
                <a class="conv-link-blue" href="https://www.conversios.io/docs/how-to-set-up-cookieyes-consent-with-conversios-plugin/" target="_black">CookieYes.</a>
            </small>
        </div>
        <div class="convpixsetting-inner-box mt-4">
            <div class="d-flex align-items-center mb-2">
                <img class="me-2" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/gtm_logo.png'); ?>" width="32px" height="32px">
                <h3 class="mb-0" style="font-weight:500">
                    <?php esc_html_e("Select Google Tag Manager Container ID:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </h3>
            </div>
            <?php
            $disabledsection = "disabledsection";
            $tracking_method = (isset($ee_options['tracking_method']) && $ee_options['tracking_method'] != "") ? $ee_options['tracking_method'] : "";
            $want_to_use_your_gtm = "";
            if ($tracking_method == "gtm") {
                $want_to_use_your_gtm = (isset($ee_options['want_to_use_your_gtm']) && $ee_options['want_to_use_your_gtm'] != "") ? $ee_options['want_to_use_your_gtm'] : "0";
            }
            if ((isset($_GET['wizard_channel']) && sanitize_text_field($_GET['wizard_channel']) == "gtmsettings")) {
                $want_to_use_your_gtm = "1";
            }
            $use_your_gtm_id = isset($ee_options['use_your_gtm_id']) ? $ee_options['use_your_gtm_id'] : "";
            ?>
            <div class="px-2">
                <div class="py-1">
                    <input class="align-top" type="radio" checked="checked" name="want_to_use_your_gtm" id="want_to_use_your_gtm_default" value="0">
                    <label class="form-check-label h6 mb-0 ps-2" for="want_to_use_your_gtm_default">
                        <?php esc_html_e("Default (Conversios Container - GTM-K7X94DG)", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </label>
                    <small><?php esc_html_e("By default, the Conversios GTM container is set for tracking purposes, and access to this container will not be available to you.", "enhanced-e-commerce-for-woocommerce-store"); ?></small>
                </div>

                <div class="py-1 pt-2" data-bs-toggle="modal" data-bs-target="#upgradetopromodal">
                    <input class="align-top" type="radio" value="1" disabled readonly>
                    <label class="form-check-label h6 mb-0 ps-2">
                        <?php esc_html_e("Connnect your own GTM container", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        <span class="conv-link-blue ms-2 fw-bold-500 upgradetopro_badge">
                            <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/upgrade_badge.png'); ?>" />
                            <?php esc_html_e("Available In Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </span>
                    </label>
                    <small><strong style="color:#0AB17B"><?php esc_html_e("Recommended:", "enhanced-e-commerce-for-woocommerce-store"); ?></strong>&nbsp; <?php esc_html_e("Choose this option to automatically configure your GTM container with all essential tags, triggers, and variables.", "enhanced-e-commerce-for-woocommerce-store"); ?></small>
                </div>

            </div>

            <!-- global settings -->
            <div class="event-setting-div py-3 border-top mt-3">
                <div class="row">
                    <h5><?php esc_html_e("Plugin Configurations", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>

                    <?php //if ($plan_id != 1) { ?>

                        <div class="py-2 conv_global_configs" style="display:none;">
                            <h5 class="fw-normal mb-1">
                                <?php esc_html_e("Select User Roles to Disable Tracking:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </h5>
                            <select class="form-select mb-3 selecttwo w-100" id="conv_disabled_users" name="conv_disabled_users[]" multiple="multiple" data-placeholder="Select role">
                                <?php foreach ($TVC_Admin_Helper->conv_get_user_roles() as $slug => $name) {
                                    $is_selected = "";
                                    if (!empty($ee_options['conv_disabled_users'])) {
                                        $is_selected = in_array($slug, $ee_options['conv_disabled_users']) ? "selected" : "";
                                    }
                                ?>
                                    <option value="<?php echo esc_attr($slug); ?>" <?php echo esc_html($is_selected); ?>><?php echo esc_attr($name); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- WC events -->
                        <div class="py-2 conv_global_configs">
                            <h5 class="fw-normal mb-1">
                                <?php esc_html_e("Ecommerce Events to Track:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </h5>
                            <?php if (!CONV_IS_WC) : ?>
                                <small><?php esc_html_e("To utilize these events, you'll need WooCommerce", "enhanced-e-commerce-for-woocommerce-store") ?></small>
                            <?php endif; ?>
                            <div style="<?php echo !CONV_IS_WC ? 'opacity:0.5' : ''; ?>">
                                <select class="form-select mb-3 selecttwo_configs w-100" id="ga_selected_events_ecomm" name="conv_selected_events[ga][]" multiple="multiple" required data-placeholder="Select event" <?php echo CONV_IS_WC ? '' : 'disabled' ?>>
                                    <?php
                                    $conv_selected_events = unserialize(get_option('conv_selected_events'));
                                    $conv_all_pixel_event = $TVC_Admin_Helper->conv_all_pixel_event();
                                    foreach ($conv_all_pixel_event['ecommerce'] as $slug => $name) {
                                        $is_selected = empty($conv_selected_events) ? "selected" : "";
                                        if (!empty($conv_selected_events['ga'])) {
                                            $is_selected =  in_array($slug, $conv_selected_events['ga']) ? "selected" : "";
                                        }
                                    ?>
                                        <option value="<?php echo esc_attr($slug); ?>" <?php echo esc_html($is_selected); ?>><?php echo esc_attr($name); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- Revenue settings -->
                        <div class="py-3 net_revenue_setting_box">
                            <div class="d-flex">
                                <h5 class="fw-normal mb-1">
                                    <?php esc_html_e("Revenue Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </h5>
                                <span class="material-symbols-outlined text-secondary md-18 ps-2 align-self-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Select metrics from below that will be calculated for revenue tracking on the purchase event. For Example, if you select Product subtotal and Shipping then order revenue = product subtotal + shipping.">
                                    info
                                </span>
                            </div>
                            <?php if (!CONV_IS_WC) : ?>
                                <small><?php esc_html_e("To utilize these tracking, you'll need WooCommerce", "enhanced-e-commerce-for-woocommerce-store") ?></small>
                            <?php endif; ?>
                            <div style="<?php echo !CONV_IS_WC ? 'opacity:0.5' : ''; ?>">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input conv_revnue_checkinput" type="checkbox" id="conv_revnue_subtotal" value="subtotal" <?php echo isset($ee_options['net_revenue_setting']) ? 'checked onclick="return false" style="opacity:0.5"' : ''; ?>>
                                    <label class="form-check-label ps-1" for="conv_revnue_subtotal">
                                        <?php esc_html_e("Product subtotal (Sum of Product prices)", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input conv_revnue_checkinput" type="checkbox" id="conv_revnue_shipping" value="shipping" <?php echo isset($ee_options['net_revenue_setting']) && in_array('shipping', $ee_options['net_revenue_setting']) ? "checked" : "" ?>>
                                    <label class="form-check-label ps-1" for="conv_revnue_shipping">
                                        <?php esc_html_e("Include Shipping", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input conv_revnue_checkinput" type="checkbox" id="conv_revnue_tax" value="tax" <?php echo isset($ee_options['net_revenue_setting']) && in_array('tax', $ee_options['net_revenue_setting']) ? "checked" : "" ?>>
                                    <label class="form-check-label ps-1" for="conv_revnue_tax">
                                        <?php esc_html_e("Include Tax", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- None WC events -->
                        <div class="py-2 conv_global_configs">
                            <h5 class="fw-normal mb-1">
                                <?php esc_html_e("Lead Generation Events to Track:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </h5>
                            <small><?php esc_html_e("Track form submit event for Contact Form 7, WpForm, Ninja Form, Gravity form, Formidable form and many more.", "enhanced-e-commerce-for-woocommerce-store") ?></small>
                            <select class="form-select mb-3 selecttwo_configs w-100" id="ga_selected_events_leadgen" name="conv_selected_events[ga][]" multiple="multiple" required data-placeholder="Select event">
                                <?php
                                $conv_selected_events = unserialize(get_option('conv_selected_events'));
                                $conv_all_pixel_event = $TVC_Admin_Helper->conv_all_pixel_event();
                                foreach ($conv_all_pixel_event['lead_generation'] as $slug => $name) {
                                    $is_selected = empty($conv_selected_events) ? "selected" : "";
                                    if (!empty($conv_selected_events['ga'])) {
                                        $is_selected =  in_array($slug, $conv_selected_events['ga']) ? "selected" : "";
                                    }
                                ?>
                                    <option value="<?php echo esc_attr($slug); ?>" <?php echo esc_html($is_selected); ?>><?php echo esc_attr($name); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    <?php //} ?>
                </div>
            </div><!-- global settings -->

            <input type="hidden" name="tracking_method" id="tracking_method" value="gtm">
        </div>
    </form>




    <!-- Tab bottom buttons -->
    <div class="tab_bottom_buttons d-flex justify-content-end pt-4">
        <!-- <a class="btn btn-outline-primary px-5 me-3" href="<?php echo esc_url('admin.php?page=conversios'); ?>">
            <?php esc_html_e('Go Back', "enhanced-e-commerce-for-woocommerce-store"); ?>
        </a> -->
        <button type="button" class="btn btn-primary px-5 ms-3" id="save_gtm_settings">
            <span class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <?php esc_html_e('Next', "enhanced-e-commerce-for-woocommerce-store"); ?>
        </button>
    </div>
</div>

<?php
// When user visiting this one screen by landing from new feature popup
if( isset($_GET['onboarding']) ) {
    update_option('conv_popup_newfeature', 'yes');
}
?>

<script>
    var store_id = '<?php echo esc_html($store_id); ?>';
    // set static width to container dropdown to avoid lenght issue when there is no account.
    // jQuery('#gtm_account_container_list').siblings('.select2:first').attr('style', 'width: 312px');
    jQuery('#gtm_account_container_list').select2();
    jQuery(".selecttwo_configs").select2();
    let automation_status = "<?php echo esc_html($automation_status); ?>";
    let plan_id = "<?php echo esc_html($plan_id); ?>";
    let gtm_account_id = "<?php echo esc_html($gtm_account_id); ?>";
    let gtm_container_id = "<?php echo esc_js($gtm_container_id); ?>";
    let gtm_container_public_id = "<?php echo esc_js($gtm_container_publicId); ?>";
    let gtm_account_container_name = "<?php echo esc_js($gtm_account_container_name); ?>";
    let subscription_id = "<?php echo esc_html($tvc_data['subscription_id']); ?>"; //subscription_id  
    let selectedOption = gtm_account_id + '_' + gtm_container_id + '_' + gtm_container_public_id;

    let is_gtm_automatic_process = false;
    let is_gtm_automatic_process_check = "<?php echo esc_html($is_gtm_automatic_process); ?>"
    let gtm_gmail = "<?php echo esc_url($g_gtm_email); ?>";
    if (is_gtm_automatic_process_check == true || is_gtm_automatic_process_check == 'true') {
        jQuery('#nav-automatic-tab').click()
    } else {
        if (jQuery('#use_your_gtm_id').val() != '') {
            <?php if ((isset($_GET['wizard_channel']) && sanitize_text_field($_GET['wizard_channel']) == "gtmsettings")) { ?>
                jQuery('#nav-automatic-tab').click()
            <?php } else { ?>
                jQuery('#nav-manual-tab').click()
            <?php } ?>
        }
    }

    // Conversios JS
    jQuery('input[type=radio][name=want_to_use_your_gtm]').change(function() {
        if (this.value == '0') {
            jQuery("#use_your_gtm_id_box").hide();
            jQuery("#use_your_gtm_id_box").addClass('d-none');
            jQuery('.container-section').hide().addClass('d-none');
            jQuery(".event-setting-row").addClass("convdisabledbox");
        } else if (this.value == '1') {
            jQuery("#use_your_gtm_id_box").show();
            jQuery("#use_your_gtm_id_box").removeClass('d-none');
            jQuery('.container-section').show().removeClass('d-none');
            jQuery(".event-setting-row").removeClass("convdisabledbox");
            jQuery('#nav-automatic-tab').click()
        }
    });

    jQuery(document).on("click", "#save_gtm_settings", function() {
        jQuery(this).find(".spinner-border").removeClass("d-none");
        jQuery(this).addClass('disabledsection');
        save_gtm_settings();
    });

    function save_gtm_settings() {
        var use_your_gtm_id = jQuery('#use_your_gtm_id').val();

        var ga_selected_events_pre = jQuery("#ga_selected_events_ecomm").val();
        jQuery.merge(ga_selected_events_pre, jQuery("#ga_selected_events_leadgen").val())
        var conv_selected_events_arr = {
            ga: ga_selected_events_pre
        };
        var conv_selected_events = conv_selected_events_arr;

        var net_revenue_setting = [];
        jQuery(".conv_revnue_checkinput").each(function() {
            if (jQuery(this).is(":checked")) {
                net_revenue_setting.push(jQuery(this).val());
            }
        });

        data = {
            action: "conv_save_pixel_data",
            pix_sav_nonce: "<?php echo esc_html(wp_create_nonce('pix_sav_nonce_val')); ?>",
            conv_options_data: {
                want_to_use_your_gtm: 0,
                use_your_gtm_id: use_your_gtm_id,
                conv_selected_events: conv_selected_events,
                tracking_method: "gtm",
                net_revenue_setting: net_revenue_setting,
                subscription_id: "<?php echo esc_html($tvc_data['subscription_id']); ?>",
            },
            conv_options_type: ["eeoptions", "eeapidata", "middleware","eeselectedevents"],
        };

        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: data,
            beforeSend: function() {
                jQuery(".conv-btn-connect-enabled-google").text("Saving...");
            },
            success: function(response) {
                jQuery(".loadershow-content .overlaycontentbox").html('<p>Connected Successfully</p>');
                openOverlayLoader('openshow', 'Connected with Conversios GTM Container');
                setTimeout(function() {
                    changeTabBox("webpixbox-tab");
                    openOverlayLoader('close');
                }, 2000);
                changeseekbar();
            }
        });
    };


    function getAlertMessage(type = 'Success', title = 'Success', message = '', icon = 'success', buttonText = 'Ok, Done', buttonColor = '#1085F1', iconImageTag = '') {

        Swal.fire({
            type: type,
            icon: icon,
            title: title,
            confirmButtonText: buttonText,
            confirmButtonColor: buttonColor,
            text: message,
        })
        let swalContainer = Swal.getContainer();
        jQuery(swalContainer).find('.swal2-icon-show').removeClass('swal2-' + icon).removeClass('swal2-icon')
        jQuery('.swal2-icon-show').html(iconImageTag)

    }

    jQuery('#conv_save_automation_success_modal_btn').on('click', function() {
        jQuery('#conv-modal-redirect-btn').click();
    })
</script>