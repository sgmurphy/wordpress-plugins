<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class TVC_Pricings
{
    protected $TVC_Admin_Helper = "";
    protected $url = "";
    protected $subscriptionId = "";
    protected $google_detail;
    protected $customApiObj;
    protected $pro_plan_site;
    protected $convositeurl;

    public function __construct()
    {
        $this->TVC_Admin_Helper = new TVC_Admin_Helper();
        $this->customApiObj = new CustomApi();
        $this->subscriptionId = $this->TVC_Admin_Helper->get_subscriptionId();
        $this->google_detail = $this->TVC_Admin_Helper->get_ee_options_data();
        $this->TVC_Admin_Helper->add_spinner_html();
        $this->pro_plan_site = $this->TVC_Admin_Helper->get_pro_plan_site();
        $this->convositeurl = "http://conversios.io";
        $this->create_form();
    }

    public function create_form()
    {
        $close_icon = esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/close.png');
        $check_icon = esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/check.png');
        $conversios_site_url = "https://www.conversios.io";
?>


        <!-- Pricing page WP AIO-->
        <div class="convo-global">
            <div class="convo-pricingpage">
                <!-- pricing timer -->
                <div class="pricing-timer d-none">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="timer-box">
                                            <div id="time"> <span id="min">00</span>:<span id="sec">00</span></div>
                                        </div>
                                        <h5 class="card-title">Wait! Get 10% Off</h5>
                                        <p class="card-text">Purchase any yearly plan in next 10 minutes with coupon code
                                            <strong>FIRSTBUY10</strong> and get additional 10% off.
                                        </p>
                                        <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout?pid=planD_1_y"); ?>">
                                            Get It Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- business area -->
                <div class="business-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="title-text">
                                    <h4>Get <mark> 15 days money back guarantee </mark> on any plan you choose.</h4>
                                    <h2>WooCommerce for Marketing & Analytics</h2>
                                    <h3>Find the perfect plan to supercharge your WooCommerce store.</h3>
                                </div>
                            </div>
                        </div>
                        <div class="myplan-wholebox">
                            <div class="row align-items-end">
                                <div class="col-auto me-auto">
                                    <div class="myplan-box">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" checked type="checkbox" role="switch" id="yearmonth_checkbox">
                                        </div>
                                        <p>Monthly | <span>Yearly</span> Get Flat 50% off on all yearly plans. </p>
                                    </div>
                                </div>
                                <div class="col-auto ">
                                    <div class="domain-box">
                                        <p>Select Number Of Domains</p>
                                        <div class="choose-domainbox">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" checked>
                                                <label class="form-check-label" for="inlineRadio1">1</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="5">
                                                <label class="form-check-label" for="inlineRadio2">3</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="10">
                                                <label class="form-check-label" for="inlineRadio3">5</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pricingcard-wholebox wp-aio">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Enterprise</h5>

                                            <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly" boxdomain="1">
                                                <p class="card-text">1 Active Website</p>
                                                <div class="card-price">$499.00/ <span>year</span></div>
                                                <div class="slash-price">Regular Price: <span>$998.00/year</span></div>
                                                <div class="offer-price">50% Off</div>
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_EY1"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly" boxdomain="5">
                                                <p class="card-text">3 Active Websites</p>
                                                <div class="card-price">$XXX/ <span>year</span></div>
                                                <div class="slash-price">Regular Price: <span>$XXXX/year</span></div>
                                                <div class="offer-price">50% Off</div>
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly" boxdomain="10">
                                                <p class="card-text">5 Active Websites</p>
                                                <div class="card-price">$XXXX/ <span>year</span></div>
                                                <div class="slash-price">Regular Price: <span>$XXXX/year</span></div>
                                                <div class="offer-price">50% Off</div>
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly" boxdomain="10+">
                                                <p class="card-text contactus">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                        Contact Us
                                                    </button>
                                                </p>
                                            </div>



                                            <ul class="feature-listing custom-scrollbar">
                                                <h5>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                            Everything in Professional
                                                        </button>
                                                    </div>
                                                </h5>
                                                <span>&#43;</span>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Complete automation of server side tagging setup. No coding, no expertise needed.">
                                                            End to end Server-Side Tagging automation
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Powerful Google Cloud hosting for 100% uptime and security.">
                                                            Google cloud hosting
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Allows unlimited hits.">
                                                            Unlimited hits
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Quick & One click automation of server and web GTM container and datalayer for mentioned channels.">
                                                            sGTM automation for

                                                        </button>
                                                        <ul class="sub-list">
                                                            <li>- GA4</li>
                                                            <li>- Google Ads Tracking</li>
                                                            <li>- Facebook pixel and conversions API</li>
                                                            <li>- TikTok pixel and events API</li>
                                                            <li>- Snapchat pixel and conversions API</li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Add your own sub domain to make tagging first party compliant.">
                                                            Custom GTM Loader

                                                        </button>

                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                            Free setup and audit
                                                        </button>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="features-link">
                                                <a href="#seeallfeatures">Compare All Features</a>
                                            </div>
                                            <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly" boxdomain="1">
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_EY1"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly" boxdomain="5">
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly" boxdomain="10">
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly" boxdomain="10+">
                                                <p class="card-text contactus">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                        Contact Us
                                                    </button>
                                                </p>
                                            </div>
                                            <div class="popular-plan">
                                                <p>Most Popular</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                    <div class="card active">
                                        <div class="card-body">
                                            <h5 class="card-title">Professional </h5>

                                            <div class="dynamicprice_box" plan_cat="professional01" boxperiod="yearly" boxdomain="1">
                                                <p class="card-text">1 Active Website</p>
                                                <div class="card-price">$199.00/ <span>year</span></div>
                                                <div class="slash-price">Regular Price: <span>$398.00/year</span></div>
                                                <div class="offer-price">50% Off</div>
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY1"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dynamicprice_box d-none" plan_cat="professional03" boxperiod="yearly" boxdomain="5">
                                                <p class="card-text">3 Active Websites</p>
                                                <div class="card-price">$299.00/ <span>year</span></div>
                                                <div class="slash-price">Regular Price: <span>$598.00/year</span></div>
                                                <div class="offer-price">50% Off</div>
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY3"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dynamicprice_box d-none" plan_cat="professional05" boxperiod="yearly" boxdomain="10">
                                                <p class="card-text">5 Active Websites</p>
                                                <div class="card-price">$399.00/ <span>year</span></div>
                                                <div class="slash-price">Regular Price: <span>$798.00/year</span></div>
                                                <div class="offer-price">50% Off</div>
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY5"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dynamicprice_box d-none" plan_cat="professional05+" boxperiod="yearly" boxdomain="10+">
                                                <p class="card-text contactus">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                        Contact Us
                                                    </button>
                                                </p>
                                            </div>



                                            <ul class="feature-listing custom-scrollbar">
                                                <h5>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                            Everything in Starter
                                                        </button>
                                                    </div>
                                                </h5>
                                                <span>&#43;</span>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Facebook Conversions API integration for all the e-commerce events and conversions. Enhances accurate audience building, campaign tracking and performance.">
                                                            Facebook Conversions API
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="TikTok Events API integration for all the e-commerce events and conversions. Enhances accurate audience building, campaign tracking and performance.">
                                                            TikTok Events API
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Snapchat Conversions API integration for all the e-commerce events and conversions. Enhances accurate audience building, campaign tracking and performance.">
                                                            Snapchat Conversions API
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Builds dynamic remarketing audiences in ad channels like Google Ads, Meta, Snapchat, Tiktok, Pinterest, Microsoft Ads & more. Build and grow audiences based on the visitor browsing. ">
                                                            Dynamic Audience building (8+ Ads Channels)
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Reach out to our professional team for custom events tracking like form tracking, conversion tracking for different goals.">
                                                            Custom events tracking
                                                        </button>
                                                    </div>
                                                </li>
                                                <span>&#43;</span>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Allows unlimited products sync.">
                                                            Unlimited number of products sync
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Compatible with 50+ plugins so that you can sync any attribute you want. Reach out if you don't find specific attributes.">
                                                            50+ plugins compatibility
                                                        </button>
                                                    </div>
                                                </li>
                                                <span>&#43;</span>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="A dedicated customer success manager ensures that everything is set up accurately and helps you solve any issue that you may face.">
                                                            Dedicated Customer Success Manager
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                            Priority support
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Analytics and Ads management becomes complicated some time. Our team of expert helps you in set up everything and performs audit so that you focus on the things that matter for your business.">
                                                            Free setup and audit
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Worrying about lower ROAS or how to get started? Our team helps you define the right strategy for your business.">
                                                            Free consultation for campaign management
                                                        </button>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="features-link">
                                                <a href="#seeallfeatures">Compare All Features</a>
                                            </div>

                                            <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY1"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY3"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY5"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                <p class="card-text contactus">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                        Contact Us
                                                    </button>
                                                </p>
                                            </div>
                                            <div class="popular-plan">
                                                <p>Most Popular</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="starter_box" class="col-xl-4 col-lg-4 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Starter</h5>

                                            <div class="dynamicprice_box" plan_cat="starter01" boxperiod="yearly" boxdomain="1">
                                                <p class="card-text">1 Active Website</p>
                                                <div class="card-price">$99.00/ <span>year</span></div>
                                                <div class="slash-price">Regular Price: <span>$198.00/year</span></div>
                                                <div class="offer-price">50% Off</div>
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY1"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dynamicprice_box d-none" plan_cat="starter03" boxperiod="yearly" boxdomain="5">
                                                <p class="card-text">3 Active Websites</p>
                                                <div class="card-price">$199.00/ <span>year</span></div>
                                                <div class="slash-price">Regular Price: <span>$398.00/year</span></div>
                                                <div class="offer-price">50% Off</div>
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY3"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="dynamicprice_box d-none" plan_cat="starter05" boxperiod="yearly" boxdomain="10">
                                                <p class="card-text">5 Active Websites</p>
                                                <div class="card-price">$299.00/ <span>year</span></div>
                                                <div class="slash-price">Regular Price: <span>$598.00/year</span></div>
                                                <div class="offer-price">50% Off</div>
                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY5"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dynamicprice_box d-none" plan_cat="starter05+" boxperiod="yearly" boxdomain="10+">
                                                <p class="card-text contactus">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                        Contact Us
                                                    </button>
                                                </p>
                                            </div>

                                            <ul class="feature-listing custom-scrollbar">
                                                <h5>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                            Everything in Free
                                                        </button>
                                                    </div>
                                                </h5>
                                                <span>&#43;</span>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="One click automation of your own GTM container for faster page speed and flexibility. Create tags, triggers & variables based on your needs.">
                                                            Automation of GTM container
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Automates complete e-commerce datalayer for your Wordpress or WooCommerce stores. Single unified datalayer automation that can be used with all the analytics and Ads tracking.">
                                                            E-Commerce datalayer automation
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Email Click, Phone Click, Address Click and Form Submit event tracking in GA4, Google Ads, Facebook and others.">
                                                            Lead generation event tracking.
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Automates complete GA4 e-commerce tracking. The most accurate and efficient GA4 solution in the market.">
                                                            GA4 E-Commerce Tracking
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Enables conversion tracking for Ads channels like Google Ads, Meta (Facebook + Instagram), Snapchat, Tiktok, Pinterest, Microsoft Ads, Twitter & More. Measures and optimizes your campaign performance. ">
                                                            Conversion tracking for 8+ Ads Tracking
                                                        </button>
                                                    </div>
                                                </li>
                                                <span>&#43;</span>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Set up high quality product feed for Ad Channels like Google, Facebook and Tiktok.">
                                                            Product feed for 3 Ad Channels
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Allows upto 500 product sync.">
                                                            Upto 500 products sync limit
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Keep your product details up to date in Google Merchant Center, Facebook Catalog and TikTok Catalog. Set time interval for auto product sync.">
                                                            Schedule product sync
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Create and manage campaigns based on feeds directly in Google Ads.">
                                                            Feed based Campaign Management
                                                        </button>
                                                    </div>
                                                </li>
                                                <span>&#43;</span>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Know about e-commerce funnel, product, source and order performance reports from wordpress admin. Enables data driven decision making to increase conversion %.">
                                                            E-Commerce reporting
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Enables you to measure the campaign performance in Google Ads.">
                                                            Ads reporting
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="ChatGPT powered insights on your analytics and campaigns data.">
                                                            AI powered Insights
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Schedule daily, weekly or monthly reports straight into your inbox.">
                                                            Schedule email reports
                                                        </button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tooltip-box">
                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Create and manage Google Ads performance max campaigns and increase ROAS.">
                                                            Product Ads Campaign Management
                                                        </button>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="features-link">
                                                <a href="#seeallfeatures">Compare All Features</a>
                                            </div>

                                            <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">

                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY1"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">

                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY3"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">

                                                <div class="getstarted-btn">
                                                    <a class="btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY5"); ?>">
                                                        GET STARTED
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                <p class="card-text contactus">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                        Contact Us
                                                    </button>
                                                </p>
                                            </div>
                                            <div class="popular-plan">
                                                <p>Most Popular</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>

                </div>
              
               
                <!-- Compare feature -->
                <div class="comparefeature-wholebox" id="seeallfeatures">
                    <div class="comparefeature-area space">
                        <div class="container-full">
                            <div class="row">
                                <div class="col-12">
                                    <div class="title-text">
                                        <h2> <strong>Comprehensive Feature</strong> Comparison</h2>
                                        <h3>Delve into the details of all our feature</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="comparetable-box">
                                <form action="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive custom-scrollbar">
                                                <table id="sticky-header-tbody-id" class="feature-table table ">
                                                    <thead id="con_stick_this">
                                                        <tr>
                                                            <th scope="col" class="th-data">
                                                                <div class="feature-box">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="card-icon">
                                                                                <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL.'/admin/images/pricing-privacy.png'); ?>" alt="" class="img-fluid">
                                                                            </div>
                                                                            <h5 class="card-title">100% No Risk <br>
                                                                                Moneyback Guarantee</h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <th scope="col" class="thd-data">
                                                                <div class="feature-box">
                                                                    <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly" boxdomain="1">
                                                                        <div class="title card-title">Enterprise</div>
                                                                        <p class="sub-title card-text">1 Active Website</p>
                                                                        <div class="strike-price">Regular Price: <span>
                                                                                $998.00</span></div>
                                                                        <div class="price">$499.00/ <span>year</span></div>
                                                                        <div class="offer-price">Flat 50% Off Applied </div>
                                                                        <div class="getstarted-btn get-it-now">
                                                                            <a class="label btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_EY1"); ?>">
                                                                                Get It Now
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly" boxdomain="5">
                                                                        <div class="title card-title">Enterprise</div>
                                                                        <p class="sub-title card-text">3 Active Websites</p>
                                                                        <div class="strike-price">Regular Price: <span>
                                                                                $XXXX</span></div>
                                                                        <div class="price">$XXX/ <span>year</span></div>
                                                                        <div class="offer-price">Flat 50% Off Applied </div>
                                                                        <div class="getstarted-btn get-it-now">
                                                                            <a class="label btn btn-secondary common-btn">
                                                                                Get It Now
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly" boxdomain="10">
                                                                        <div class="title card-title">Enterprise</div>
                                                                        <p class="sub-title card-text">5 Active Websites</p>
                                                                        <div class="strike-price">Regular Price: <span>
                                                                                $XXXX</span></div>
                                                                        <div class="price">$XXXX/ <span>year</span></div>
                                                                        <div class="offer-price">Flat 50% Off Applied </div>
                                                                        <div class="getstarted-btn get-it-now">
                                                                            <a class="label btn btn-secondary common-btn">
                                                                                Get It Now
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly" boxdomain="10+">
                                                                        <div class="title card-title">Enterprise</div>
                                                                        <p class="card-text contactus">
                                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                                                Contact Us
                                                                            </button>
                                                                        </p>

                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <th scope="col" class="thd-data">
                                                                <div class="feature-box">
                                                                    <div class="dynamicprice_box" plan_cat="professional01" boxperiod="yearly" boxdomain="1">
                                                                        <div class="title card-title">Professional</div>
                                                                        <p class="sub-title card-text">1 Active Website</p>
                                                                        <div class="strike-price">Regular Price: <span>
                                                                                $398.00</span></div>
                                                                        <div class="price">$199.00/ <span>year</span></div>
                                                                        <div class="offer-price">Flat 50% Off Applied </div>
                                                                        <div class="getstarted-btn get-it-now">
                                                                            <a class="label btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY1"); ?>">
                                                                                Get It Now
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dynamicprice_box d-none" plan_cat="professional03" boxperiod="yearly" boxdomain="5">
                                                                        <div class="title card-title">Professional</div>
                                                                        <p class="sub-title card-text">3 Active Websites</p>
                                                                        <div class="strike-price">Regular Price: <span>
                                                                                $598.00</span></div>
                                                                        <div class="price">$299.00/ <span>year</span></div>
                                                                        <div class="offer-price">Flat 50% Off Applied </div>
                                                                        <div class="getstarted-btn get-it-now">
                                                                            <a class="label btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY3"); ?>">
                                                                                Get It Now
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dynamicprice_box d-none" plan_cat="professional05" boxperiod="yearly" boxdomain="10">
                                                                        <div class="title card-title">Professional</div>
                                                                        <p class="sub-title card-text">5 Active Websites</p>
                                                                        <div class="strike-price">Regular Price: <span>
                                                                                $798.00</span></div>
                                                                        <div class="price">$399.00/ <span>year</span></div>
                                                                        <div class="offer-price">Flat 50% Off Applied </div>
                                                                        <div class="getstarted-btn get-it-now">
                                                                            <a class="label btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY5"); ?>">
                                                                                Get It Now
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dynamicprice_box d-none" plan_cat="professional05+" boxperiod="yearly" boxdomain="10+">
                                                                        <div class="title card-title">Professional</div>
                                                                        <p class="card-text contactus">
                                                                            <!-- Button trigger modal -->
                                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                                                Contact Us
                                                                            </button>
                                                                        </p>

                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <th scope="col" class="thd-data">
                                                                <div class="feature-box">
                                                                    <div class="dynamicprice_box" plan_cat="starter01" boxperiod="yearly" boxdomain="1">
                                                                        <div class="title card-title">Starter</div>
                                                                        <p class="sub-title card-text">1 Active Website</p>
                                                                        <div class="strike-price">Regular Price: <span>
                                                                                $198.00</span></div>
                                                                        <div class="price">$99.00/ <span>year</span></div>
                                                                        <div class="offer-price">Flat 50% Off Applied </div>
                                                                        <div class="getstarted-btn get-it-now">
                                                                            <a class="label btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY1"); ?>">
                                                                                Get It Now
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dynamicprice_box d-none" plan_cat="starter03" boxperiod="yearly" boxdomain="5">
                                                                        <div class="title card-title">Starter</div>
                                                                        <p class="sub-title card-text">3 Active Websites</p>
                                                                        <div class="strike-price">Regular Price: <span>
                                                                                $398.00</span></div>
                                                                        <div class="price">$199.00/ <span>year</span></div>
                                                                        <div class="offer-price">Flat 50% Off Applied </div>
                                                                        <div class="getstarted-btn get-it-now">
                                                                            <a class="label btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY3"); ?>">
                                                                                Get It Now
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dynamicprice_box d-none" plan_cat="starter05" boxperiod="yearly" boxdomain="10">
                                                                        <div class="title card-title">Starter</div>
                                                                        <p class="sub-title card-text">5 Active Websites</p>
                                                                        <div class="strike-price">Regular Price: <span>
                                                                                $598.00</span></div>
                                                                        <div class="price">$299.00/ <span>year</span></div>
                                                                        <div class="offer-price">Flat 50% Off Applied </div>
                                                                        <div class="getstarted-btn get-it-now">
                                                                            <a class="label btn btn-secondary common-btn" href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY5"); ?>">
                                                                                Get It Now
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dynamicprice_box d-none" plan_cat="starter05+" boxperiod="yearly" boxdomain="10+">
                                                                        <div class="title card-title">Starter</div>
                                                                        <p class="card-text contactus">
                                                                            <!-- Button trigger modal -->
                                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                                                Contact Us
                                                                            </button>
                                                                        </p>

                                                                    </div>
                                                                </div>
                                            </div>
                                            </th>
                                            <th scope="col" class="thd-data">
                                                <div class="feature-box">
                                                    <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                        <div class="title card-title">Free</div>
                                                        <p class="sub-title card-text">1 Active Website</p>
                                                        <div class="strike-price">Regular Price: <span>
                                                                $00.00</span></div>
                                                        <div class="price">$00.00/ <span>year</span></div>
                                                        <div class="offer-price" style="opacity: 0; visibility: hidden;">Flat
                                                            50% Off Applied </div>
                                                        <div class="getstarted-btn get-it-now">
                                                            <a class="label btn btn-secondary common-btn" target="_blank" href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">
                                                                Get It Now
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                        <div class="title card-title">Free</div>
                                                        <p class="sub-title card-text">3 Active Websites</p>
                                                        <div class="strike-price">Regular Price: <span>
                                                                $00.00</span></div>
                                                        <div class="price">$00.00/ <span>year</span></div>
                                                        <div class="offer-price" style="opacity: 0; visibility: hidden;">Flat
                                                            50% Off Applied </div>
                                                        <div class="getstarted-btn get-it-now">
                                                            <a class="label btn btn-secondary common-btn" href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">
                                                                Get It Now
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                        <div class="title card-title">Free</div>
                                                        <p class="sub-title card-text">5 Active Websites</p>
                                                        <div class="strike-price">Regular Price: <span>
                                                                $00.00</span></div>
                                                        <div class="price">$00.00/ <span>year</span></div>
                                                        <div class="offer-price" style="opacity: 0; visibility: hidden;">Flat
                                                            50% Off Applied </div>
                                                        <div class="getstarted-btn get-it-now">
                                                            <a class="label btn btn-secondary common-btn" href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">
                                                                Get It Now
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                        <div class="title card-title">Free</div>
                                                        <p class="card-text contactus">
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="opacity: 0; visibility: hidden;">
                                                                Contact Us
                                                            </button>
                                                        </p>

                                                    </div>
                                                </div>
                                            </th>




                                            </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Accessibility Features -->
                                                <!-- 0 -->
                                                <tr class="title-row" data-title="Accessibility Features">
                                                    <td colspan="5" class="data">
                                                        <div class="feature-title">
                                                            Accessibility Features
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- 1 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="A dedicated customer success manager ensures that everything is set up accurately and helps you solve any issue that you may face.">
                                                                Dedicated Customer Success Manager
                                                            </button>
                                                        </div>

                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 2 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                Priority Support
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 3 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Analytics and Ads management becomes complicated some time. Our team of expert helps you in set up everything and performs audit so that you focus on the things that matter for your business.">
                                                                Free Setup and Audit
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 4 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Free consultation for campaign management and conversion rate optimization tips.">
                                                                Free Consultation for Campaign Management & CRO
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>


                                                <!-- GTM for Google Analytics and Pixels -->
                                                <!-- 0 -->
                                                <tr class="title-row">
                                                    <td colspan="5" class="data">
                                                        <div class="feature-title">
                                                            GTM & Datalayer Automation
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- 1 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="By default your website will interact with Conversios GTM container.">
                                                                Conversios GTM container
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 2 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="One click automation of your own GTM container for faster page speed and flexibility. Create tags, triggers & variables based on your needs.">
                                                                Automate your GTM container
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 3 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Automates complete e-commerce datalayer for your Wordpress or WooCommerce stores. Single unified datalayer automation that can be used with all the analytics and Ads tracking.">
                                                                E-Commerce Datalayer
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- GA4, Ads Conversion Tracking & Audience Building -->
                                                <!-- 0 -->
                                                <tr class="title-row" data-title="Accessibility Features">
                                                    <td colspan="5" class="data">
                                                        <div class="feature-title">
                                                            GA4, Ads Conversion Tracking & Audience Building
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- 1 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                <b>GA4 E-commerce tracking</b>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 2 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Tracking of all the web pages.">
                                                                page_view
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 3 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Tracking of all the web pages.">
                                                                purchase
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 4 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="GA4 tracking when user views products on any product listing page. ie. Home page, product listing page, category page, similar products block etc.">
                                                                view_item_list
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 5 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="GA4 tracking when user views any specific product's details page">
                                                                view_item
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 6 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="GA4 tracking when user selects/clicks on any specific product.">
                                                                select_item
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 7 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="GA4 tracking when user add product in the cart.">
                                                                add_to_cart
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 8 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="GA4 tracking when user removes product from the cart.">
                                                                remove_from_cart
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 9 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="GA4 tracking when user views cart page.">
                                                                view_cart
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 10 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="GA4 tracking when user initiated checkout.">
                                                                begin_checkout
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 11 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="GA4 tracking when user selects payment method in checkout.">
                                                                add_payment_info
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 12 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="GA4 tracking when user selects shipping method in checkout.">
                                                                add_shipping_info
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- 13 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Form submission tracking in GA4.">
                                                                form field tracking
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 14 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                <b>Google Ads Tracking</b>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 15 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Google Ads conversion tracking for purchase event.">
                                                                Conversion Tracking for purchase
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 16 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Google Ads conversion tracking for add to cart event.">
                                                                Conversion Tracking for add to cart
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 17 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Google Ads conversion tracking for begin checkout event.">
                                                                Conversion Tracking for begin checkout
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 18 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Google Ads enhanced conversion tracking for accurate and efficient conversion recording.">
                                                                Enhanced Conversion tracking
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 18 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Google Ads dynamic remarketing audience building based on user browsing behavior. 5 audience lists creation in Google Ads.">
                                                                Dynamic Audience building
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 19 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                <b>Facebook Ads Tracking</b>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 20 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Facebook Ads conversion tracking for purchase event.">
                                                                Conversion tracking (purchase)
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 21 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Facebook dynamic remarketing audience building based on user browsing behavior. ">
                                                                Audience building based on e-commerce events
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 22 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Enable this feature to improve the event quality score in business management account. ">
                                                                Advanced Matching
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 23 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Server-Side Tagging   for FB events in order to increase accurate and efficient events tracking.">
                                                                Facebook Conversions API
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 24 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                <b>TikTok Ads Tracking</b>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 25 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="TikTok Ads conversion tracking for purchase event.">
                                                                Conversion tracking (purchase)
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 26 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="TikTok dynamic remarketing audience building based on user browsing behavior. ">
                                                                Audience building based on e-commerce events
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 27 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Enable this feature to improve the event quality score in business management account.">
                                                                Advanced Matching
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 28 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Server-Side Tagging of e-commerce events for accurate and efficient events tracking for TikTok Ads.">
                                                                TikTok Events API
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>


                                                <!-- 29 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                <b>Snapchat Ads Tracking</b>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 30 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Snapchat Ads conversion tracking for purchase event.">
                                                                Conversion tracking (purchase)
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 31 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Snapchat dynamic remarketing audience building based on user browsing behavior. ">
                                                                Audience building based on e-commerce events
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 32 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Server-Side Tagging of e-commerce events for accurate and efficient events tracking for Snapchat Ads.">
                                                                Snapchat Conversions API
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 33 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                <b>Pinterest Ads Tracking</b>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 34 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Pinterest Ads conversion tracking for purchase event.">
                                                                Conversion tracking (purchase)
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 35 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Pinterest dynamic remarketing audience building based on user browsing behavior. ">
                                                                Audience building based on e-commerce events
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 36 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                <b>Microsoft Ads Tracking</b>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 37 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Microsoft Ads conversion tracking for purchase event.">
                                                                Conversion tracking (purchase)
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 38 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Microsoft Ads dynamic remarketing audience building based on user browsing behavior.">
                                                                Audience building based on e-commerce events
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 39 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                <b>Microsoft Clarity Integration</b>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 40 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                <b>Hotjar Integration</b>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 41 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                <b>Crazy Egg Integration</b>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 42 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                <b>Twitter Ads Tracking</b>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!-- Server-Side Tagging  -->
                                                <!-- 0 -->
                                                <tr class="title-row" data-title="hello">
                                                    <td colspan="5" class="data">
                                                        <div class="feature-title">
                                                            Server-Side Tagging
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- 1 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="One click automation of server GTM container for e-commerce events and ad channels.">
                                                                Automation of Server GTM
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>
                                                <!-- 2 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="One click automation of web GTM container for e-commerce events and ad channels.">
                                                                Automation of Web GTM
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>
                                                <!-- 3 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="One click provisioning of powerful google cloud server hosting for 100% uptime, scalability and security.">
                                                                Google cloud hosting for sGTM
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>
                                                <!-- 4 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="No code automation for server e-commerce events datalayer.">
                                                                Server e-commerce datalayer automation
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>
                                                <!-- 5 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Add your own sub domain to make tagging first party compliant.">
                                                                Custom GTM Loader
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>
                                                <!-- 6 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Unlimited number of hits on the server.">
                                                                Unlimited hits
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>
                                                <!-- 7 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Complete e-commerce tracking.">
                                                                Server-Side Tagging for GA4
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>
                                                <!-- 8 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Complete conversion tracking and audience building in Google Ads.">
                                                                Server-Side Tagging for Google Ads
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>
                                                <!-- 9 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Complete conversion tracking and audience building in Facebook.">
                                                                Server-Side Tagging for FB Ads and CAPI
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>
                                                <!-- 10 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Complete conversion tracking and audience building in Snapchat.">
                                                                Server-Side Tagging for Snapchat Ads and CAPI
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>

                                                <!-- 11 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Complete conversion tracking and audience building in TikTok.">
                                                                Server-Side Tagging for TikTok Events API
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>


                                                <!-- Product Feed Manager  -->
                                                <!-- 0 -->
                                                <tr class="title-row" data-title="hello">
                                                    <td colspan="5" class="data">
                                                        <div class="feature-title">
                                                            Product Feed Manager
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- 1 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Total number of WooCommerce product sync limit.">
                                                                Number of products
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items"><b>Unlimited</b></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items"><b>Unlimited</b></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items"><b>Upto 500</b></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items"><b>Upto 100</b></div>
                                                        </div>
                                                    </td>




                                                </tr>

                                                <!-- 2 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                Google Shopping Feed
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 3 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                Facebook Catalog Feed
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 4 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                TikTok Catalog Feed
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 5 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Auto schedule product updates in ad channels.">
                                                                Schedule auto product sync
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>



                                                <!-- 7 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Filter your WooCommerce product to create feed.">
                                                                Advanced filters
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 8-->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Sync handpicked products from the product grid.">
                                                                Select specific WooCommerce products
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!--9-->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Sync product attributes from 50+ product plugins.">
                                                                Compatibility with 50+ product plugins
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- Reporting & Campaign Management  -->
                                                <!-- 0 -->
                                                <tr class="title-row" data-title="hello">
                                                    <td colspan="5" class="data">
                                                        <div class="feature-title">
                                                            Reporting & Campaign Management
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- 1 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Know about e-commerce funnel, product, source and order performance reports from wordpress admin. Enables data driven decision making to increase conversion %.">
                                                                E-Commerce reporting
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 2 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Enables you to measure the campaign performance in Google Ads.">
                                                                Ads reporting
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 3 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="ChatGPT powered insights on your analytics and campaigns data.">
                                                                AI powered Insights
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                Unlimited
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                Unlimited
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                Upto 50
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                Upto 10
                                                            </div>
                                                        </div>
                                                    </td>




                                                </tr>

                                                <!-- 4 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Schedule daily, weekly or monthly reports straight into your inbox.">
                                                                Schedule smart email reports
                                                            </button>
                                                        </div>
                                                    </th>

                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span class="cross">&#10539;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 5 -->
                                                <tr>
                                                    <th class="th-data" scope="row">
                                                        <div class="tooltip-box">
                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Create and manage Google Ads performance max campaigns and increase ROAS. Create and manage campaigns based on feeds.">
                                                                Product Ads Campaign Management
                                                            </button>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="feature-data">
                                                            <div class="items">
                                                                <span>&#10003;</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <!-- 18 buttons -->
                                                <tr>
                                                    <th class="th-data" scope="row" style="border: 0px;"></th>
                                                    <td style="border: 0px;">
                                                        <div class="feature-data">

                                                            <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly" boxdomain="1">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='1' href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_EY1"); ?>">Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly" boxdomain="5">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='1'>Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly" boxdomain="10">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='1'>Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly" boxdomain="10+">
                                                                <div class="getnow-btn">
                                                                    <button type="button" class="btn btn-primary getnow" data-bs-toggle="modal" data-bs-target="#staticBackdrop" index='1'>CONTACT US</button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </td>
                                                    <td style="border: 0px;">
                                                        <div class="feature-data">
                                                            <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='2' href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY1"); ?>">Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='2' href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY3"); ?>">Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='2' href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY5"); ?>">Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                <div class="getnow-btn">
                                                                    <button type="button" class="btn btn-primary getnow" data-bs-toggle="modal" data-bs-target="#staticBackdrop" index='1'>CONTACT US</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="border: 0px;">
                                                        <div class="feature-data">
                                                            <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='3' href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY1"); ?>">Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='3' href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY3"); ?>">Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='3' href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY5"); ?>">Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                <div class="getnow-btn">
                                                                    <button type="button" class="btn btn-primary getnow" data-bs-toggle="modal" data-bs-target="#staticBackdrop" index='1'>CONTACT US</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="border: 0px;">
                                                        <div class="feature-data">
                                                            <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='4' target="_blank" href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='4' target="_blank" href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                                <div class="getnow-btn">
                                                                    <a class="btn btn-secondary getnow" index='4' target="_blank" href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">Get It Now</a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                <div class="getnow-btn">
                                                                    <button type="button" class="btn btn-primary getnow" data-bs-toggle="modal" data-bs-target="#staticBackdrop" index='1' style="opacity: 0; visibility: hidden;">CONTACT
                                                                        US</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <script>
            function checkperiod_domain() {

                jQuery(".dynamicprice_box").addClass("d-none");

                var yearmonth_checkbox = "monthly";
                if (jQuery("#yearmonth_checkbox").is(":checked")) {
                    yearmonth_checkbox = "yearly"
                }
                var domain_num = jQuery('input[name=inlineRadioOptions]:checked').val()
                jQuery(".dynamicprice_box").each(function() {
                    var boxperiod = jQuery(this).attr("boxperiod");
                    var boxdomain = jQuery(this).attr("boxdomain");

                    if (boxperiod == yearmonth_checkbox && boxdomain == domain_num) {
                        jQuery(this).removeClass("d-none");
                    }
                });
            }

            jQuery(function() {
                jQuery("#yearmonth_checkbox").click(function() {
                    checkperiod_domain();
                });

                jQuery("input[name=inlineRadioOptions]").change(function() {
                    checkperiod_domain();
                });

                var distance = jQuery('#con_stick_this').offset().top;
                var convpwindow = jQuery(window);
                convpwindow.scroll(function() {
                    if (convpwindow.scrollTop() >= 2040 && convpwindow.scrollTop() <= 3650) {

                        jQuery("#con_stick_this").addClass("sticky-header");
                        jQuery("#sticky-header-tbody-id").addClass("sticky-header-tbody");
                    } else {
                        jQuery("#con_stick_this").removeClass("sticky-header");
                        jQuery("#sticky-header-tbody-id").removeClass("sticky-header-tbody");
                    }
                });
            });
        </script>

        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>
        <script>
            function checkperiod_domain() {

                jQuery(".dynamicprice_box").addClass("d-none");

                var yearmonth_checkbox = "monthly";
                if (jQuery("#yearmonth_checkbox").is(":checked")) {
                    yearmonth_checkbox = "yearly"
                }

                var domain_num = jQuery('input[name=inlineRadioOptions]:checked').val()
                // console.log(domain_num);
                // console.log(yearmonth_checkbox);

                jQuery(".dynamicprice_box").each(function() {
                    var boxperiod = jQuery(this).attr("boxperiod");
                    var boxdomain = jQuery(this).attr("boxdomain");
                    var plan_cat = jQuery(this).attr("plan_cat");
                    if (plan_cat == "enterprise03" || plan_cat == "enterprise05") {
                        jQuery(this).addClass("conv_dim_box");
                    } else {
                        jQuery(this).removeClass("conv_dim_box");
                    }
                    if (boxperiod == yearmonth_checkbox && boxdomain == domain_num) {
                        jQuery(this).removeClass("d-none");
                    }
                });
            }

            jQuery(function() {
                jQuery("#yearmonth_checkbox").click(function() {
                    checkperiod_domain();
                });

                jQuery("input[name=inlineRadioOptions]").change(function() {
                    checkperiod_domain();
                });
            });
        </script>
<?php
    }
}
?>