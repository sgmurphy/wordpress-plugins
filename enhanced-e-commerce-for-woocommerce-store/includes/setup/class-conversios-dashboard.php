<?php

/**
 * @since      4.1.4
 * Description: Conversios Onboarding page, It's call while active the plugin
 */
if (class_exists('Conversios_Dashboard') === FALSE) {
    class Conversios_Dashboard
    {

        protected $screen;
        protected $TVC_Admin_Helper;
        protected $TVC_Admin_DB_Helper;
        protected $CustomApi;
        protected $PMax_Helper;
        protected $subscription_id;
        protected $ga_traking_type;
        protected $currency_code;
        protected $currency_symbol;
        protected $ga_currency;
        protected $ga_currency_symbols;
        protected $ga4_measurement_id;
        protected $ga4_analytic_account_id;
        protected $ga4_property_id;
        protected $subscription_data;
        protected $plan_id = 1;
        protected $is_need_to_update_api_data_wp_db = false;
        protected $report_data;
        protected $notice;
        protected $google_ads_id;
        protected $connect_url;
        protected $g_mail;
        protected $is_refresh_token_expire;

        protected $resource_center_data = array();
        protected $ee_options;
        protected $ee_customer_gmail;
        protected $is_channel_connected;
        protected $chkEvenOdd;

        public function __construct()
        {
            $this->TVC_Admin_Helper = new TVC_Admin_Helper();
            $this->TVC_Admin_DB_Helper = new TVC_Admin_DB_Helper();
            $this->CustomApi = new CustomApi();
            $this->PMax_Helper = new Conversios_PMax_Helper();
            $this->connect_url = $this->TVC_Admin_Helper->get_custom_connect_url(admin_url() . 'admin.php?page=conversios');
            $this->subscription_id = $this->TVC_Admin_Helper->get_subscriptionId();
            // update API data to DB while expired token

            $this->ee_options = $this->TVC_Admin_Helper->get_ee_options_settings();
            $this->ee_customer_gmail = get_option("ee_customer_gmail");


            $this->subscription_data = $this->TVC_Admin_Helper->get_user_subscription_data();
            if (isset($this->subscription_data->plan_id) && !in_array($this->subscription_data->plan_id, array("1"))) {
                $this->plan_id = $this->subscription_data->plan_id;
            }
            if (isset($this->subscription_data->google_ads_id) && $this->subscription_data->google_ads_id != "") {
                $this->google_ads_id = $this->subscription_data->google_ads_id;
            }
            if (empty($this->subscription_id)) {
                wp_redirect("admin.php?page=conversios-google-analytics");
                exit;
            }

            // resource center data
            $rcd_postdata = array("app_id" => 1, "platform_id" => 1, "plan_id" => "1", "screen_name" => "dashboard");
            $resource_center_res = $this->CustomApi->get_resource_center_data($rcd_postdata);
            if (!empty($resource_center_res->data)) {
                $this->resource_center_data = $resource_center_res->data;
            }
            $this->currency_symbol = '';
            $currency_code_rs = $this->PMax_Helper->get_campaign_currency_code($this->google_ads_id);
            if ($this->google_ads_id) {
                if (isset($currency_code_rs->data->currencyCode)) {
                    $this->currency_code = $currency_code_rs->data->currencyCode;
                }
                $this->currency_symbol = $this->TVC_Admin_Helper->get_currency_symbols($this->currency_code);
            }


            $this->includes();
            $this->screen = get_current_screen();
            $this->load_html();
        }

        public function includes()
        {
            if (!class_exists('CustomApi.php')) {
                require_once(ENHANCAD_PLUGIN_DIR . 'includes/setup/CustomApi.php');
            }
        }


        public function load_html()
        {
            if (isset($_GET['page']) && $_GET['page'] != "")
                do_action('conversios_start_html_' . sanitize_text_field($_GET['page']));
            $this->current_html();
            $this->current_js_licence_active();
            if (isset($_GET['page']) && $_GET['page'] != "")
                do_action('conversios_end_html_' . sanitize_text_field($_GET['page']));
        }



        public function current_js_licence_active()
        { ?>
            <script>
                jQuery(function() {
                    jQuery("#acvivelicbtn").click(function() {
                        var post_data_lic = {
                            action: "tvc_call_active_licence",
                            licence_key: jQuery("#licencekeyinput").val(),
                            conv_licence_nonce: '<?php echo esc_js(wp_create_nonce("conv_lic_nonce")); ?>',
                        }
                        jQuery.ajax({
                            type: "POST",
                            dataType: "json",
                            url: tvc_ajax_url,
                            data: post_data_lic,
                            beforeSend: function() {
                                jQuery("#acvivelicbtn").find(".spinner-border").removeClass("d-none");
                            },
                            success: function(response) {
                                jQuery("#licencemsg").removeClass();
                                if (response.error === false) {
                                    jQuery("#licencemsg").addClass('text-success').text(response.message);
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    jQuery("#licencemsg").addClass('text-danger').text(response.message);
                                }
                                jQuery('#acvivelicbtn').find(".spinner-border").addClass("d-none");
                            }
                        });
                    });
                });
            </script>
        <?php }
        public function dashboard_licencebox_html()
        { ?>
            <div class="dash-area">
                <div class="dashwhole-box">
                    <div class="card">
                        <div class="card-body">
                            <div class="purchase-box">
                                <h4>
                                    <?php esc_html_e("Already purchased license Key?", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </h4>
                                <div class="form-box">
                                    <input type="email" class="form-control icontrol" readonly id="exampleFormControlInput1" placeholder="Enter your key">
                                </div>
                                <div class="upgrade-btn">
                                    <a target="_blank" href="<?php echo esc_url($this->TVC_Admin_Helper->get_conv_pro_link_adv("licenceinput", "dashboard", "", "linkonly", "")); ?>" class="btn btn-dark common-btn">
                                        <?php esc_html_e("Upgrade to Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        // Sidebar
        public function dashboard_videocardbox_html()
        {
            $gettingstarr = new stdClass;
            $res_data = $this->resource_center_data;
            foreach ($res_data as $value) {
                if ($value->screen_name == "dashboard" && $value->sub_type == "gettingstartedvideo") {
                    $gettingstarr = $value;
                    break;
                }
            }
            if (!empty((array) $gettingstarr)) {
            ?>
                <div class="videocard card">
                    <div class="videoimage">
                        <img class="align-self-center" src="<?php echo esc_url($gettingstarr->thumbnail_url); ?>" />
                    </div>
                    <div class="card-body">
                        <div class="title-dropdown">
                            <div class="title-text">
                                <h3>
                                    <?php
                                    echo esc_html__('Getting Started', 'enhanced-e-commerce-for-woocommerce-store');
                                    ?>
                                </h3>
                            </div>
                        </div>
                        <div class="card-content">
                            <p>
                                <?php
                                echo esc_html__('Thanks for choosing us, Now, it’s time to get started, watch this video on how to successfully set up the plugin.', 'enhanced-e-commerce-for-woocommerce-store')
                                ?>
                            </p>
                            <div class="watch-videobtn">
                                <a target="_blank" href="<?php echo esc_url($gettingstarr->link) ?>" class="btn btn-dark common-btn">
                                    <?php esc_html_e("Watch Video", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            <?php
            }
        }


        // Sidebar
        public function dashboard_convproducts_html()
        { ?>
            <div class="videocard card scaleyourbusiness">
                <div class="card-body">
                    <h2 class="text-white">
                        <?php esc_html_e("Scale Your Business Faster", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </h2>
                    <p class="text-white lh-sm pt-2">
                        <?php esc_html_e("Explore Our Analytics and Marketing Solutions For Shopify, Magento & Shopware", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </p>
                    <ul class="convprolist p-0 pt-3">
                        <li class="bg-white p-2 rounded-3">
                            <a class="d-flex align-items-center" href="<?php echo esc_url("https://www.conversios.io/ga4-fbcapi-pixel-for-shopify/?utm_source=in_app&utm_medium=sidebar&utm_campaign=scale_business"); ?>" target="_blank">
                                <img class="align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_shopify_icon.png'); ?>" />
                                <p class="text-dark lh-sm ps-2">
                                    <?php esc_html_e("All In One Pixel and FBCAPI for Shopify", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </p>
                            </a>
                        </li>

                        <li class="bg-white p-2 rounded-3">
                            <a class="d-flex align-items-center" href="<?php echo esc_url("https://www.conversios.io/google-analytics-4-marketing-pixels-for-magento/?utm_source=in_app&utm_medium=sidebar&utm_campaign=scale_business"); ?>" target="_blank">
                                <img class="align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_magento_icon.png'); ?>" />
                                <p class="text-dark lh-sm ps-2">
                                    <?php esc_html_e("Pixel Manager Extension for Magento 2", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </p>
                            </a>
                        </li>

                        <li class="bg-white p-2 rounded-3">
                            <a class="d-flex align-items-center" href="<?php echo esc_url("https://www.conversios.io/google-analytics-4-and-ads-pixels-for-shopware/?utm_source=in_app&utm_medium=sidebar&utm_campaign=scale_business"); ?>" target="_blank">
                                <img class="align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_shopware_icon.png'); ?>" />
                                <p class="text-dark lh-sm ps-2">
                                    <?php esc_html_e("Google Analytics 4 & Ads Pixels via GTM For Shopware", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        <?php
        }

        public function dashboard_requestfeature_html()
        { ?>
            <div class="videocard card">
                <div class="card-body">
                    <h2>
                        <?php esc_html_e("Request a feature", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </h2>
                    <p class="pt-2">
                        <?php esc_html_e("Did not find what you are looking for? Submit a feature requirement and we will look into it.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </p>
                    <form id="conv_requestafeature_form">
                        <ul class="convprolist pt-3 p-0">
                            <li class="rounded-3">
                                <textarea rows="6" class="col-12" id="conv_requestafeature_message" name="featurereq_message" placeholder="Enter a message"></textarea>
                            </li>

                            <li class="bg-white rounded-3">
                                <button type="button" id="requestfeaturebut" class="btn btn-primary px-4">
                                    <span class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    <?php esc_html_e("Submit", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </button>
                            </li>
                        </ul>
                    </form>

                    <div id="conv_requestafeature_mesasge" class="alert alert-success d-none mt-4" role="alert">
                        <?php esc_html_e("Thank you for submitting new feature request. Our team will review it and contact you soon.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </div>
                </div>
            </div>
            <script>
                jQuery(function() {
                    jQuery("#conv_requestafeature_message").blur(function() {
                        if (jQuery("#conv_requestafeature_message").val() != "") {
                            jQuery("#conv_requestafeature_message").removeClass("border border-danger");
                        } else {
                            jQuery("#conv_requestafeature_message").addClass("border border-danger");
                        }
                    });
                    jQuery('#requestfeaturebut').on('click', function(event, el) {
                        if (jQuery("#conv_requestafeature_message").val() != "") {
                            jQuery('#requestfeaturebut').find(".spinner-border").removeClass("d-none");
                            jQuery('#requestfeaturebut').addClass("disabled");
                            var reqfeatdata = jQuery("#conv_requestafeature_form").serializeArray();
                            console.log(reqfeatdata);
                            jQuery.ajax({
                                type: "POST",
                                dataType: "json",
                                url: tvc_ajax_url,
                                data: {
                                    action: "tvc_call_add_customer_featurereq",
                                    feature_req_nonce: "<?php echo esc_js(wp_create_nonce('feature_req_nonce_val')); ?>",
                                    featurereq_message: jQuery("#conv_requestafeature_message").val(),
                                    subscription_id: "<?php echo esc_js($this->subscription_id); ?>",
                                },
                                success: function(response) {
                                    console.log(response);
                                    jQuery('#conv_requestafeature_form').remove();
                                    jQuery('#conv_requestafeature_mesasge').removeClass("d-none");
                                }
                            });
                        } else {
                            jQuery("#conv_requestafeature_message").addClass("border border-danger");
                        }


                    });
                });
            </script>
        <?php
        }


        // Sidebar
        public function dashboard_recentpostbox_html()
        { ?>
            <div class="videocard recent-post card">
                <div class="card-body p-4 m-2">
                    <div class="">
                        <div class="title-text d-flex justify-content-between">
                            <h2 class="fw-bold">
                                <?php esc_html_e("Help Topics", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </h2>
                            <a target="_blank" class="fs-18 fw-400 ms-auto conv-link-blue fw-bold" href="<?php echo esc_url('https://www.conversios.io/docs-category/woocommerce-2/?utm_source=in_app&utm_medium=top_menu&utm_campaign=help_center'); ?>">
                                <u><?php esc_html_e("Help Center", "enhanced-e-commerce-for-woocommerce-store"); ?></u>
                            </a>
                        </div>
                    </div>
                    <div class="card-content recentpostcard">
                        <?php
                        /*
                        $res_data = $this->resource_center_data;
                        foreach ($res_data as $key => $value) {
                            if ($value->screen_name != "dashboard" && $value->sub_type != "recentposts") {
                                continue;
                            }
                        ?>
                            <a href="<?php echo esc_url($value->link); ?>" target="_blank">
                                <span><?php echo esc_html($value->title); ?></span>
                            </a>
                        <?php } */ ?>

                        <a href="https://www.conversios.io/docs/how-to-install-conversios-plugin/?utm_source=inapp&utm_medium=dashboard&utm_campaign=helptopics" target="_blank">
                            <span><?php esc_html_e("How To Install Conversios Plugin On WordPress?","enhanced-e-commerce-for-woocommerce-store"); ?></span>
                        </a>
                        <a href="https://www.conversios.io/docs/how-to-integrate-google-analytics-4-with-conversios-plugin/?utm_source=inapp&utm_medium=dashboard&utm_campaign=helptopics" target="_blank">
                            <span><?php esc_html_e("How To Integrate Google Analytics 4 With Conversios Plugin?","enhanced-e-commerce-for-woocommerce-store"); ?></span>
                        </a>
                        <a href="https://www.conversios.io/docs/how-to-integrate-google-ads-with-conversios-plugin/?utm_source=inapp&utm_medium=dashboard&utm_campaign=helptopics" target="_blank">
                            <span><?php esc_html_e("How To Integrate Google Ads With Conversios Plugin?","enhanced-e-commerce-for-woocommerce-store"); ?></span>
                        </a>
                        <a href="https://www.conversios.io/docs/how-to-integrate-facebook-meta-pixel-with-conversios-plugin/?utm_source=inapp&utm_medium=dashboard&utm_campaign=helptopics" target="_blank">
                            <span><?php esc_html_e("How To Integrate Facebook Meta Pixel and Conversion API With Conversios Plugin?","enhanced-e-commerce-for-woocommerce-store"); ?></span>
                        </a>
                        <a href="https://www.conversios.io/docs/how-to-integrate-tiktok-pixel-with-conversios-plugin/?utm_source=inapp&utm_medium=dashboard&utm_campaign=helptopics" target="_blank">
                            <span><?php esc_html_e("How To Integrate Tiktok Pixel and Conversion API With Conversios Plugin?","enhanced-e-commerce-for-woocommerce-store"); ?></span>
                        </a>
                        <a href="https://www.conversios.io/docs/how-to-integrate-snapchat-pixel-with-conversios-plugin/?utm_source=inapp&utm_medium=dashboard&utm_campaign=helptopics" target="_blank">
                            <span><?php esc_html_e("How To Integrate Snapchat Pixel and Conversion API With Conversios Plugin?","enhanced-e-commerce-for-woocommerce-store"); ?></span>
                        </a>
                        <a href="https://www.conversios.io/blog/why-conversios-is-the-best-for-product-feed-to-google-merchant-center/?utm_source=inapp&utm_medium=dashboard&utm_campaign=helptopics" target="_blank">
                            <span><?php esc_html_e("Why Conversios Is The Premier Choice For Google Merchant Center Product Feeds?","enhanced-e-commerce-for-woocommerce-store"); ?></span>
                        </a>
                        <a href="https://www.conversios.io/docs/how-you-can-leverage-the-conversios-data-layer-and-customize-tracking-based-on-your-requirements/?utm_source=inapp&utm_medium=dashboard&utm_campaign=helptopics" target="_blank">
                            <span><?php esc_html_e("How To Use Conversios Google Tag Manager Data Layer To Get More Insights Into Your Customers?","enhanced-e-commerce-for-woocommerce-store"); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        <?php
        }

        // Sidebar
        public function dashboard_gethelp_html()
        { ?>
            <div class="commoncard-box get-premium need-help card">
                <div class="card-body">
                    <div class="title-title">
                        <h3>
                            <?php esc_html_e("Need More Help", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h3>
                        <p>
                            <?php esc_html_e("Book your Demo and our Support team will help you in setting up your account.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </p>
                    </div>
                    <div class="card-content">
                        <div class="premium-btn book-demo">
                            <a target="_blank" href="<?php echo esc_url("https://calendly.com/conversios/30min"); ?>" class="btn btn-dark common-btn">
                                <?php esc_html_e("Book Demo", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }


        // Pixel accordion
        public function get_pixel_accordion()
        {
            $pixel_setting = array(
                "gtmsettings" => isset($this->ee_options['tracking_method']) && $this->ee_options['tracking_method'] == 'gtm' ? 'convo-active' : 'gtmnotconnected',
                "gasettings" => (isset($this->ee_options['ga_id']) && $this->ee_options['ga_id'] != '') || (isset($this->ee_options['gm_id']) && $this->ee_options['gm_id'] != '') ? 'convo-active' : '',
                "gadssettings" => isset($this->ee_options['google_ads_id']) && $this->ee_options['google_ads_id'] != '' ? 'convo-active' : '',
                "fbsettings" => isset($this->ee_options['fb_pixel_id']) && $this->ee_options['fb_pixel_id'] != '' ? 'convo-active' : '',
                "bingsettings" => isset($this->ee_options['microsoft_ads_pixel_id']) && $this->ee_options['microsoft_ads_pixel_id'] != '' ? 'convo-active' : '',
                "twittersettings" => isset($this->ee_options['twitter_ads_pixel_id']) && $this->ee_options['twitter_ads_pixel_id'] != '' ? 'convo-active' : '',
                "pintrestsettings" => isset($this->ee_options['pinterest_ads_pixel_id']) && $this->ee_options['pinterest_ads_pixel_id'] != '' ? 'convo-active' : '',
                "snapchatsettings" => isset($this->ee_options['snapchat_ads_pixel_id']) && $this->ee_options['snapchat_ads_pixel_id'] != '' ? 'convo-active' : '',
                "tiktoksettings" => isset($this->ee_options['tiKtok_ads_pixel_id']) && $this->ee_options['tiKtok_ads_pixel_id'] != '' ? 'convo-active' : '',
                "hotjarsettings" => isset($this->ee_options['hotjar_pixel_id']) && $this->ee_options['hotjar_pixel_id'] != '' ? 'convo-active' : '',
                "crazyeggsettings" => isset($this->ee_options['crazyegg_pixel_id']) && $this->ee_options['crazyegg_pixel_id'] != '' ? 'convo-active' : '',
                "claritysettings" => isset($this->ee_options['msclarity_pixel_id']) && $this->ee_options['msclarity_pixel_id'] != '' ? 'convo-active' : ''
            );

            $gtm_status_icon = '<span class="material-symbols-outlined text-warning">history_toggle_off</span>';
            $webtracking_status_icon = '<span class="material-symbols-outlined text-warning">history_toggle_off</span>';
            $adstracking_status_icon = '<span class="material-symbols-outlined text-warning">history_toggle_off</span>';

            $pixelprogressbarclass = [];

            if ($pixel_setting['gtmsettings'] == "convo-active") {
                array_push($pixelprogressbarclass, 33);
                $gtm_status_icon = '<span class="material-symbols-outlined text-success">check_circle</span>';
            }
            if ($pixel_setting['gasettings'] == "convo-active") {
                array_push($pixelprogressbarclass, 33);
                $webtracking_status_icon = '<span class="material-symbols-outlined text-success">check_circle</span>';
            }
            if ($pixel_setting['gadssettings'] == "convo-active" || $pixel_setting['fbsettings'] == "convo-active" || $pixel_setting['snapchatsettings'] == "convo-active" || $pixel_setting['tiktoksettings'] == "convo-active" || $pixel_setting['pintrestsettings'] == "convo-active" || $pixel_setting['bingsettings'] == "convo-active" || $pixel_setting['tiktoksettings'] == "convo-active") {
                array_push($pixelprogressbarclass, 33);
                $adstracking_status_icon = '<span class="material-symbols-outlined text-success">check_circle</span>';
            }

        ?>

            <div class="accordion-item">
                <h2 class="accordion-header d-flex p-2" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        <img class="pe-2" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/conv-accordio-pa.svg'); ?>">
                        <?php esc_html_e("Web and E-commerce Conversion Tracking | Audience Building", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul class="ps-4 ms-2 mb-4">
                            <li class="pt-0 ps-1">
                                <div class="d-flex justify-content-between">
                                    <h3><?php esc_html_e("Step 1: Connect Google Tag Manager to Your Website Using a Plugin", "enhanced-e-commerce-for-woocommerce-store"); ?></h3>
                                    <?php echo wp_kses_post($gtm_status_icon); ?>
                                </div>
                                <p class="mb-3"><?php esc_html_e("Set up a GTM container with a single click. Using GTM for web analytics and ads tracking ensures optimal page speed and flexibility.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                            </li>

                            <li class="pt-0 ps-1">
                                <div class="d-flex justify-content-between">
                                    <h3><?php esc_html_e("Step 2: Set up Web and E-commerce Tracking for GA4, Hotjar, Clarity, and Crazy Egg", "enhanced-e-commerce-for-woocommerce-store"); ?></h3>
                                    <?php echo wp_kses_post($webtracking_status_icon); ?>
                                </div>
                                <p class="mb-3"><?php esc_html_e("Effortlessly set up web and behavioral analytics tools. Track every activity visitors perform on your site and start making data-driven decisions to increase conversions and sales.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                            </li>

                            <li class="pt-0 ps-1">
                                <div class="d-flex justify-content-between">
                                    <h3><?php esc_html_e("step 3: Track Ad Conversions and Build Audiences for Remarketing", "enhanced-e-commerce-for-woocommerce-store"); ?></h3>
                                    <?php echo wp_kses_post($adstracking_status_icon); ?>
                                </div>
                                <p class="mb-3"><?php esc_html_e("Accurately set up conversion tracking and audiences for Google Ads, Meta, TikTok, Snapchat, Pinterest, Microsoft Ads, and more.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                                <ul class="list-styled">
                                    <li><?php esc_html_e("Efficient conversion tracking allows ad channels to further optimize the campaigns and helps you assess the campaign performance.", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                    <li><?php esc_html_e("Remarketing audiences allow you to reach out to non converting site visitors.", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                </ul>
                            </li>

                        </ul>

                        
                        <div class="accbutbox d-flex justify-content-end pt-4">
                            <a class="btn btn-outline-primary ms-3 px-4 align-self-baseline" href="<?php echo esc_url('admin.php?page=conversios-google-analytics'); ?>">
                                <?php esc_html_e("Set Up Manually", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </a>
                            <a class="btn btn-primary ms-3 px-4 align-self-baseline" href="<?php echo esc_url('admin.php?page=conversios&wizard=pixelandanalytics'); ?>">
                                <?php esc_html_e("Launch Wizard", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        <?php
        }
        function evenOdd($number)
        {
            if ($number % 2 == 0) {
                return 0;  //Even
            } else {
                return 1; //Odd
            }
        }
        function getEvenOddAccordion()
        {
            $this->chkEvenOdd = 1;

            if (isset($this->ee_options['google_merchant_center_id']) && $this->ee_options['google_merchant_center_id'] !== '') {
                $this->is_channel_connected = true;
            }
            if (isset($this->ee_options['facebook_setting']) && $this->ee_options['facebook_setting']['fb_business_id'] !== '' && $this->is_channel_connected == false) {
                $this->is_channel_connected = true;
            }
            if (isset($this->ee_options['tiktok_setting']) && $this->ee_options['tiktok_setting']['tiktok_business_id'] !== '' && $this->is_channel_connected == false) {
                $this->is_channel_connected = true;
            }
            $ee_prod_mapped_attrs = get_option("ee_prod_mapped_attrs");
            $ee_prod_mapped_cats = get_option("ee_prod_mapped_cats");
            $feed_data = $this->TVC_Admin_Helper->ee_get_result_limit('ee_product_feed', 2);
            $feed_count = !empty($feed_data) ? count($feed_data) : 0;
            ?>
                <div class="accordion-body">
                    <ul class="ps-4 ms-2 mb-4">
                        <li class="pt-0 ps-1">
                            <div class="d-flex justify-content-between">
                                <h3>
                                    <?php esc_html_e("Step 1: Channel Configuration", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </h3>
                                <span class="material-symbols-outlined <?php echo $this->is_channel_connected ? 'text-success' : 'text-warning' ?>">
                                    <?php echo $this->is_channel_connected ? 'check_circle' : 'history_toggle_off' ?>
                                </span>
                            </div>
                            <p class="mb-3"><?php esc_html_e("Set up Google Merchant Center and TikTok in a single click to boost visibility and enhance ROAS.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                        </li>
                        <li class="pt-0 ps-1">
                            <div class="d-flex justify-content-between">
                                <h3>
                                    <?php esc_html_e("Step 2: Product Category Mapping", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </h3>
                                <span class="material-symbols-outlined product-attribute <?php echo $ee_prod_mapped_cats ? 'text-success' : 'text-warning' ?>">
                                <?php echo $ee_prod_mapped_cats != false ? 'check_circle' : 'history_toggle_off' ?>
                                </span>
                            </div>
                            <p class="mb-3"><?php esc_html_e("Map your product categories accurately to improve product relevance for customers. This leads to higher conversion rates and increased sales by making your products more easily discoverable.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                        </li>
                        <li class="pt-0 ps-1">
                            <div class="d-flex justify-content-between">
                                <h3><?php esc_html_e("Step 3 : Product Attribute Mapping", "enhanced-e-commerce-for-woocommerce-store"); ?></h3>
                                <span class="material-symbols-outlined create-product-feed <?php echo $ee_prod_mapped_attrs ? 'text-success' : 'text-warning' ?>">
                                <?php echo $ee_prod_mapped_attrs != false ? 'check_circle' : 'history_toggle_off' ?>
                                </span>
                            </div>
                            <p class="mb-3"><?php esc_html_e("Map your product attributes to ensure accurate and consistent data integration across shopping channels, enhancing visibility, sales, and customer experience.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                        </li>
                        <li class="pt-0 ps-1">
                            <div class="d-flex justify-content-between">
                                <h3><?php esc_html_e("Step 4 : Manage & Create Product Feed", "enhanced-e-commerce-for-woocommerce-store"); ?></h3>
                                <span class="material-symbols-outlined create-product-feed <?php echo $feed_count ? 'text-success' : 'text-warning' ?>">
                                <?php echo $feed_count != 0 ? 'check_circle' : 'history_toggle_off' ?>
                                </span>
                            </div>
                            <p class="mb-3"><?php esc_html_e("Tailor your product feed with advanced settings and filters to meet specific advertising goals and target audiences through customization options.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                        </li>
                    </ul>
                    <div class="accbutbox d-flex justify-content-end">
                        <a class="btn btn-outline-primary feed-management" href="<?php echo esc_url('admin.php?page=conversios-google-shopping-feed&tab=gaa_config_page'); ?>">
                            <?php esc_html_e("Set Up Manually", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </a>
                        <a class="btn btn-primary ms-3 pf_wizard" href="<?php echo esc_url('admin.php?page=conversios&wizard=productFeedOdd'); ?>">
                            <?php esc_html_e("Launch Wizard", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </a>
                    </div>
                </div> <?php
            // } 
        }
                public function get_pf_accordion()
                { ?>
            <style>
                .draft {
                    background-color: #f5e0aa;
                    color: #dca310;
                }

                .synced {
                    background-color: #c3f6e7;
                    color: #09bd83;
                }

                .failed {
                    background-color: #f8d9dd;
                    color: #f43e56;
                }

                .deleted {
                    background-color: #c8d1cf;
                    color: #5d6261;
                }

                .inprogress {
                    background-color: #c8e3f3;
                    color: #209ee1;
                }

                .badgebox {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    width: 100px;
                    padding: 2px 10px;
                    border-radius: 30px;
                    margin-bottom: 6px;
                    position: relative;
                    height: 22px;
                    font-size: 12px;
                    font-weight: 500;
                    margin: 0 auto;
                    margin-bottom: 10px;
                }
            </style>
            <div class="accordion-item">
                <div id="pf_loader" class="progress-materializecss d-none ps-2 pe-2" style="width:100%;">
                    <div class="indeterminate"></div>
                </div>
                <h2 class="accordion-header d-flex p-2" id="flush-headingTwo">
                    <button class="accordion-button collapsed product-feed-accordian fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        <img class="pe-2" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/product_feed.svg'); ?>">
                        <?php esc_html_e("Product Feed Manager for Google Shopping, Tiktok and Facebook", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <?php $this->getEvenOddAccordion() ?>
                </div>
            </div>
            <script>
                jQuery(document).ready(function() {
                    jQuery('.accordion-button').on('click', function() {
                        jQuery('.accordion-collapse').collapse('toggle');
                    });
                });
            </script>
        <?php }


        // Main function for HTM structure
        public function current_html()
        {
        ?>
            <style>
                .accordion-item {
                    border: 1px solid #CCC !important;
                    border-radius: 2px !important;
                    margin-top: 8px;
                    box-shadow: 0px 0px 5px 0px #00000038;
                }
            </style>
            <section style="max-width: 1200px; margin:auto;">
                <div class="dash-convo">
                    <div class="container">
                        <div class="welcome-wholebox">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 ">
                                    <!-- licence key html call-->
                                    <?php $this->dashboard_licencebox_html(); ?>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="dash-area">
                                                <div class="dashwhole-box">
                                                    <div class="head-title d-flex justify-content-between">
                                                        <h2 class="fw-bold text-dark">
                                                            <?php esc_html_e("Quick Setup", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pixel-setup card">
                                        <div class="card-body">
                                            <div class="accordion accordion-flush" id="convdashacc_box">

                                                <!-- Pixal and analytics accordion -->
                                                <?php $this->get_pixel_accordion(); ?>

                                                <!-- Product Feed accordion --------->
                                                <?php
                                                if (is_plugin_active_for_network('woocommerce/woocommerce.php') || in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                                                    $this->get_pf_accordion();
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                    <?php $this->dashboard_recentpostbox_html(); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Modal SST Pro-->
            <div class="modal fade upgradetosstmodal" id="convSsttoProModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-content">

                        <h2><?php esc_html_e("Unlock The benefits of", "enhanced-e-commerce-for-woocommerce-store"); ?> <br> <span><?php esc_html_e("Server Side Tagging Via GTM", "enhanced-e-commerce-for-woocommerce-store"); ?></span> </h2>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-12">
                                <ul class="listing">
                                    <span><?php esc_html_e("Benefits", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                                    <li><?php esc_html_e("Adopt To First Party Cookies", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                    <li><?php esc_html_e("Improve Data Accuracy & Reduced Ad Blocker Impact", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                    <li><?php esc_html_e("Faster Page Speed", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                    <li><?php esc_html_e("Enhanced Data Privacy & Security", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12">
                                <ul class="listing">
                                    <span><?php esc_html_e("Features", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                                    <li><?php esc_html_e("Server Side Tagging Via GTM", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                    <li><?php esc_html_e("Powerful Google Cloud Servers", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                    <li><?php esc_html_e("Custom Loader & Custom Domain Mapping", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                    <li><?php esc_html_e("Server Side Tagging For Google Analytics 4 (GA4), Google Ads, Facebook CAPI, Tiktok Events API & Snapchat CAPI", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                    <li><?php esc_html_e("Free Setup & Audit By Dedicated Customer Success Manager", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <div class="discount-btn">
                                    <a target="_blank" href="<?php echo esc_url('https://www.conversios.io/wordpress/all-in-one-google-analytics-pixels-and-product-feed-manager-for-woocommerce-pricing/?utm_source=in_app&utm_medium=modal_popup&utm_campaign=sstpopup'); ?>" class="btn btn-dark common-btn">Get Early Bird Discount</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal SST Pro End -->
            <!-- End -->
            <script>
                jQuery(function() {
                    var returnFrom = "<?php echo isset($_GET['returnFrom']) ? esc_js(sanitize_text_field($_GET['returnFrom'])) : '' ?>";
                    if (returnFrom == 'productFeed') {
                        jQuery('[data-bs-target="#flush-collapseTwo"]').trigger('click')
                        jQuery('.product-feed-accordian').trigger('click')
                        jQuery('[data-bs-target="#flush-collapseOne"]').addClass('collapsed')
                        jQuery('#flush-collapseOne').removeClass('show')
                        jQuery('[data-bs-target="#flush-collapseThree"]').addClass('collapsed')
                        jQuery('#flush-collapseThree').removeClass('show')
                        jQuery('[data-bs-target="#flush-collapseFour"]').addClass('collapsed')
                        jQuery('#flush-collapseFour').removeClass('show')
                    } else if (returnFrom == 'campaignManagement') {
                        jQuery('[data-bs-target="#flush-collapseFour"]').trigger('click')
                        jQuery('.camapign-management-accordian').trigger('click')
                        jQuery('[data-bs-target="#flush-collapseOne"]').addClass('collapsed')
                        jQuery('#flush-collapseOne').removeClass('show')
                        jQuery('[data-bs-target="#flush-collapseThree"]').addClass('collapsed')
                        jQuery('#flush-collapseThree').removeClass('show')
                        jQuery('[data-bs-target="#flush-collapseTwo"]').addClass('collapsed')
                        jQuery('#flush-collapseTwo').removeClass('show')
                    }
                });
                /*********************Card Popover Start***********************************************************************/
                jQuery(document).on('mouseover', '.synced', function() {
                    var syncedGmcImg = jQuery(this).next('.syncedGmcImg').val();
                    var syncedTiktokImg = jQuery(this).next('.syncedGmcImg').next('.syncedTiktokImg').val();
                    var syncedfbImg = jQuery(this).next('.syncedGmcImg').next('.syncedTiktokImg').next('.syncedfbImg').val();
                    var content = '<div class="popover-box border-synced">' + syncedGmcImg + '  ' + syncedTiktokImg + ' ' + syncedfbImg + '</div>';
                    jQuery(this).popover({
                        html: true,
                        template: content,
                    });
                    jQuery(this).popover('show');
                })

                jQuery(document).on('mouseover', '.failed', function() {
                    var failedGmcImg = jQuery(this).next('.failedGmcImg').val();
                    var failedTiktokImg = jQuery(this).next('.failedGmcImg').next('.failedTiktokImg').val();
                    var failedfbImg = jQuery(this).next('.failedGmcImg').next('.failedTiktokImg').next('.failedfbImg').val();
                    var content = "<div class='popover-box border-failed'>" + failedGmcImg + "  " + failedTiktokImg + " " + failedfbImg + "</div>";
                    jQuery(this).popover({
                        html: true,
                        template: content,
                    });
                    jQuery(this).popover('show');
                })

                jQuery(document).on('mouseover', '.draft', function() {
                    var draftGmcImg = jQuery(this).next('.draftGmcImg').val();
                    var draftTiktokImg = jQuery(this).next('.draftGmcImg').next('.draftTiktokImg').val();
                    var draftfbImg = jQuery(this).next('.draftGmcImg').next('.draftTiktokImg').next('.draftfbImg').val();
                    var content = '<div class="popover-box border-draft">' + draftGmcImg + '  ' + draftTiktokImg + ' ' + draftfbImg + '</div>';
                    jQuery(this).popover({
                        html: true,
                        template: content,
                    });
                    jQuery(this).popover('show');
                })
                jQuery(document).on('mouseover', '.inprogress', function() {
                    var inprogressGmcImg = jQuery(this).next('.inprogressGmcImg').val();
                    var inprogressTiktokImg = jQuery(this).next('.inprogressGmcImg').next('.inprogressTiktokImg').val();
                    var inprogressfbImg = jQuery(this).next('.inprogressGmcImg').next('.inprogressTiktokImg').next('.inprogressfbImg').val();
                    var content = '<div class="popover-box border-inprogress">' + inprogressGmcImg + '  ' + inprogressTiktokImg + ' ' + inprogressfbImg + '</div>';
                    jQuery(this).popover({
                        html: true,
                        template: content,
                    });
                    jQuery(this).popover('show');
                })
                /*********************Card Popover  End**************************************************************************/
            </script>
<?php
                }
            }
        }
        new Conversios_Dashboard();
