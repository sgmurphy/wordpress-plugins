<div class="sumome-plugin-dashboard-widget-inner">
    <?php
    $is_connected = !is_null(get_option('sumome_site_id'));
    $is_authed = (isset($_COOKIE['__smUser']) && !is_null($_COOKIE['__smUser']));
    $sumomeStatus = $is_authed
        ? 'status-logged-in'
        : 'status-logged-out';

    if (!isset($noClose)) {
        print '<div class="sumome-plugin-dashboard-widget-close-button"><div></div></div>';
    }
    ?>
    <!-- Header -->
    <div class="header-banner"></div>

    <div class="sumome-plugin-dashboard-widget-header">
        <div class="forms">

            <!-- site has been connected -->
            <?php if ($is_connected) : ?>
                <div class="sumome-wp-dash-logged-in">
                    <div class="sumome-plugin-dashboard-widget-header-title">Sumo is <span class="highlight">Connected!</span></div>
                    <div class="sumome-plugin-dashboard-widget-header-button">
                        <?php if ($is_authed) : ?>
                            <button type="submit" class="button green dashboard-button" onclick="document.location.href='<?php echo esc_url(admin_url('options-general.php?page=sumo')) ?>'">
                                DASHBOARD
                            </button>
                        <?php else : ?>
                            <button type="submit" class="button green connect-button" id="connectFormButton">Log In</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- site has not been connected -->
            <?php if (!$is_connected) : ?>
                <div class="sumome-wp-dash-logged-out>">
                    <div class="sumome-popup-forms"></div>
                    <div class="sumome-plugin-dashboard-widget-header-title">Connect Now to <span class="highlight">Unlock Greatness</span></div>
                    <div class="sumome-plugin-dashboard-widget-header-desc">You're one click away from seamlessly capturing attention and driving conversions with high-quality, on-brand pop-ups and forms. Manage all your sites efficiently from one dashboard and watch your engagement soar.
                    </div>
                    <div class="sumome-plugin-dashboard-widget-header-button">
                        <button type="submit" class="button green connect-button" id="connectFormButton">Connect</button>
                    </div>
                    <div class="flex-container">
                        <div class="flex-item"><span>30,000+</span>active installs</div>
                        <div class="flex-item"><span>14-Day</span>money back guarantee</div>
                        <div class="flex-item"><span>$0</span>free to get started</div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <div class="sumome-plugin-dashboard-widget-container wash-bg">
        <div class="">
            <!-- Top widget container -->
            <div class="sumome-plugin-dashboard-widget-top-note-container flex-container">
                <div class="flex-item">
                    <div class="icon-circle">
                        <img src="<?php echo esc_url(plugins_url('images/Bolt-Outline-Green.png', dirname(__FILE__))) ?>" alt="Bolt Outline Green">
                    </div>
                    <span>Connect Your Account</span>
                    Click the button above and log into your BDOW! account to get started.
                </div>
                <div class="flex-item">
                    <div class="icon-circle">
                        <img src="<?php echo esc_url(plugins_url('images/Mark-Green.png', dirname(__FILE__))) ?>" alt="Mark Green">
                    </div>
                    <span>Build Your Pop-Up or Form</span>
                    Design your custom pop-up effortlessly with our intuitive designer software.
                </div>
                <div class="flex-item">
                    <div class="icon-circle">
                        <img src="<?php echo esc_url(plugins_url('images/Rocket-Green.png', dirname(__FILE__))) ?>" alt="Rocket Green">
                    </div>
                    <span>Start Capturing Leads</span>
                    Launch your marketing efforts into orbit with our powerful, cutting-edge tools.
                </div>
            </div>

            <!-- new widget row: create an account -->
            <div class="plugin-content-wrapper">
                <div class="sumome-plugin-dashboard-widget-row flex-container sumome-wp-dash-logged-out <?php echo esc_attr($sumomeStatus) ?>">
                    <div class="flex-item flex-item-half">
                        <div class="sumome-plugin-dashboard-widget-header-title">
                            The pop-up and form tool that
                            <span class="highlight">designers</span> and
                            <span class="highlight">agencies</span> love to use.
                        </div>
                        Create high-converting, on-brand forms and pop-ups that look just as good as your website.
                        And manage all of your sites from one dashboard.
                        <div>
                            <a href="https://sumome.com/register" type="submit" class="button button-outline">Create Account</a>
                        </div>
                    </div>
                    <div class="flex-item flex-item-half wash-bg">
                        <img src="<?php echo esc_url(plugins_url('images/example-popup.png', dirname(__FILE__))) ?>" alt="example popup">
                    </div>
                </div>

            </div>

            <!-- new widget row: powered by bdow -->
            <div class="sumome-plugin-dashboard-widget-top-note-container powered-by-bdow">
                <div class="scrunch-wrapper">
                    <div class="sumome-plugin-dashboard-widget-header-title">
                        Integrate with Your Favorite Tools
                    </div>
                    <div>Supercharge your workflow by integrating <br>your favorite tools.</div>
                </div>

                <div class="sumome-plugin-dashboard-widget-middle-note-clients">
                    <img src="<?php echo esc_url(plugins_url('images/powered-wordpress.png', dirname(__FILE__))) ?>">
                    <img src="<?php echo esc_url(plugins_url('images/powered-shopify.png', dirname(__FILE__))) ?>">
                    <img src="<?php echo esc_url(plugins_url('images/powered-mailchimp.png', dirname(__FILE__))) ?>">
                    <img src="<?php echo esc_url(plugins_url('images/powered-salesforce.png', dirname(__FILE__))) ?>">
                    <img src="<?php echo esc_url(plugins_url('images/powered-zapier.png', dirname(__FILE__))) ?>">
                    <img src="<?php echo esc_url(plugins_url('images/powered-convertkit.png', dirname(__FILE__))) ?>">
                    <img src="<?php echo esc_url(plugins_url('images/powered-showit.png', dirname(__FILE__))) ?>">
                    <img src="<?php echo esc_url(plugins_url('images/powered-keap.png', dirname(__FILE__))) ?>">
                    <img src="<?php echo esc_url(plugins_url('images/powered-active_campaign.png', dirname(__FILE__))) ?>">
                    <img src="<?php echo esc_url(plugins_url('images/powered-klaviyo.png', dirname(__FILE__))) ?>">
                    <img src="<?php echo esc_url(plugins_url('images/powered-hubspot.png', dirname(__FILE__))) ?>">
                </div>

                <div class="scrunch-wrapper">
                    <a href="https://bdow.com/features#connect" target="_blank" class="button button-black">View all integrations</a>
                </div>
                <br><br>
            </div>
        </div>

        <!-- new widget row: restore link -->
        <div class="sumome-plugin-dashboard-widget-row <?php echo esc_attr($sumomeStatus) ?>">
            <div class="sumome-plugin-center">Need to restore an existing account?
                <?php
                if (substr_count($_SERVER['REQUEST_URI'], 'dashboard') > 0) {
                ?>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=sumo-siteID')) ?>">Click here</a>
                <?php
                } else {
                ?>
                    <div class="sumome-plugin-linkalike sumome-link-button sumome-tile-advanced-settings item-tile" data-name="sumome-control-advanced-settings" data-title="">Click here
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>


<script>
    <?php
    if (wp_is_mobile()) {
    ?>
        jQuery('.sumome-plugin-dashboard-widget').addClass('minimized');
    <?php
    }
    ?>
    jQuery(document).on('click', '.sumome-plugin-dashboard-widget div.sumome-plugin-dashboard-widget-close-button', function() {
        jQuery('.sumome-plugin-dashboard-widget').addClass('minimized');
        jQuery.post(ajaxurl, {
            action: 'sumome_hide_dashboard_overlay'
        }, function(data) {

        });
    });
</script>
