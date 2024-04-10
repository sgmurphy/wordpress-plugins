<?php

namespace cnb\admin\settings;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\api\CnbAppRemote;
use cnb\admin\domain\CnbDomain;
use cnb\admin\domain\CnbDomainViewEdit;
use cnb\admin\legacy\CnbLegacyEdit;
use cnb\admin\models\CnbUser;
use cnb\utils\CnbAdminFunctions;
use cnb\notices\CnbAdminNotices;
use cnb\utils\CnbUtils;
use WP_Error;

class CnbSettingsViewEdit {
    function header() {
        echo 'Settings';
    }

    private function create_tab_url( $tabName, $tabGroup ) {
        $url = admin_url( 'admin.php' );

        return add_query_arg(
            array(
                'page' => 'call-now-button-settings',
                'tabName'  => $tabName,
                'tabGroup' => $tabGroup,
            ),
            $url );
    }

    /**
     * This is only rendered on the /legacy/ version of the Plugin
     *
     * @return void
     */
    private function render_legacy_options_tracking() {
        $view = new CnbLegacyEdit();
        $view->render_tracking();
        $view->render_conversions();
    }

    /**
     * This is only rendered on the /legacy/ version of the Plugin
     *
     * @return void
     */
    private function render_legacy_options_display() {
        $view = new CnbLegacyEdit();        
        $view->render_zoom();
        $view->render_zindex();
    }

    private function render_error_reporting_options() {
        $cnb_utils = new CnbUtils();
        ?>
            <div class="cnb-input-item">
                <div class="cnb-flex cnb-flex-gap cnb-flex-align-center">
                    <label>Share errors and usage data</label>
                    <input type="hidden" name="cnb[error_reporting]" value="0"/>
                    <input id="cnb-error-reporting" class="cnb_toggle_checkbox" type="checkbox"
                        name="cnb[error_reporting]"
                        value="1" <?php checked( $cnb_utils->is_reporting_enabled() ); ?> />
                    <label for="cnb-error-reporting" class="cnb_toggle_label">Toggle</label>
                </div>
                <p class="description">Allows us to capture anonymous error reports and usage statistics to help us
                    improve the product.</p>
            </div>
        <?php
    }

    private function render_basic_options( $status, $cloud_successful, $domain ) {
        ?>
        <section data-tab-name="basic_options" data-tab-group="settings" class="form-table">
		    <?php
		    $this->render_topic_start( 'NowButtons.com' );
		    $this->render_premium_option( $cloud_successful, $domain );
		    if ( $status !== 'cloud' ) {
			    $this->render_topic_end();
			    $this->render_topic_start( 'Tracking' );
			    $this->render_legacy_options_tracking();
			    $this->render_topic_end();
			    $this->render_topic_start( 'Display options' );
			    $this->render_legacy_options_display();
		    }

		    if ( $cloud_successful ) {
			    $domain_edit = new CnbDomainViewEdit();
			    $domain_edit->render_form_plan_details( $domain );
			    $this->render_topic_end();
			    $this->render_topic_start( 'Tracking' );
			    $domain_edit->render_form_tracking( $domain );
			    $this->render_topic_end();
			    $this->render_topic_start( 'Button display' );
			    $domain_edit->render_form_button_display( $domain );
		    }
		    $this->render_topic_end();

		    $this->render_topic_start( 'Miscellaneous' );
		    $this->render_error_reporting_options();
		    $this->render_topic_end();
		    ?>
        </section>
            <?php
    }

    /**
     * @param $cnb_user CnbUser|WP_Error
     *
     * @return void
     */
    private function render_account_options( $cnb_user ) {
        $cnb_options             = get_option( 'cnb' );
        $show_advanced_view_only = CnbSettingsController::is_advanced_view();
        $cnb_utils               = new CnbUtils();
        ?>
        <section data-tab-name="account_options" data-tab-group="settings" class="form-table">
            <?php if ( $cnb_user !== null && ! is_wp_error( $cnb_user ) ) { ?>
                <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                    <div class="cnb-section-info cnb-top-spacing">
                        <h3 class="top-0">Your NowButtons.com account</h3>
                    </div>
                    <div class="cnb-section-data cnb-top-spacing">                        
                        
                        <div class="cnb-input-item">
                            <label>Details</label>
                            <p>
                                <span class="sr-only">Login </span>
                                <?php echo esc_html( $cnb_user->email );?>
                                
                            </p>
                            <p class="description" id="cnb_user_id"><span class="sr-only">Account ID</span> <?php echo esc_html( $cnb_user->id ) ?></p>
                        </div>

                <?php if ( is_wp_error( $cnb_user ) || $show_advanced_view_only ) { ?>
                        <div class="cnb-input-item">
                            <label>API Key</label>
                            <label>
                                <input type="text" class="regular-text" name="cnb[api_key]"
                                    id="cnb_api_key"
                                    placeholder="e.g. b52c3f83-38dc-4493-bc90-642da5be7e39"/>
                            </label>
                            <p class="description">Get your API key at <a
                                        href="<?php echo esc_url( $cnb_utils->get_website_url( '', 'settings-account', 'get-api-key' ) ) ?>"><?php echo esc_html( CNB_WEBSITE ) ?></a>
                            </p>
                        </div>
                <?php } ?>
                <?php if ( is_wp_error( $cnb_user ) && ! empty( $cnb_options['api_key'] ) ) { ?>
                        <div class="cnb-input-item">
                            <label>API Key</label>
                            <p><span class="dashicons dashicons-warning"></span> There is an API key,
                                but it seems to be invalid or outdated.</p>
                            <p class="description">Clicking "Disconnect account" will drop the API key and disconnect the
                                plugin from your NowButtons.com account. You will lose access to your buttons and all cloud functionality
                                until you reconnect with a NowButtons.com account.
                                <br>
                                <input type="button" name="cnb_api_key_delete" id="cnb_api_key_delete"
                                    class="button button-link"
                                    value="<?php esc_attr_e( 'Disconnect account' ) ?>"
                                    onclick="return cnb_delete_apikey();">
                            </p>
                        </div>
                <?php } ?>
                        <div class="cnb-input-item">
                            <label>Billing</label>
                            <a href="#" onclick="return cnb_goto_billing_portal()">Invoices 
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="heroicon w-4 h-4">
                                    <path d="M6.22 8.72a.75.75 0 0 0 1.06 1.06l5.22-5.22v1.69a.75.75 0 0 0 1.5 0v-3.5a.75.75 0 0 0-.75-.75h-3.5a.75.75 0 0 0 0 1.5h1.69L6.22 8.72Z" />
                                    <path d="M3.5 6.75c0-.69.56-1.25 1.25-1.25H7A.75.75 0 0 0 7 4H4.75A2.75 2.75 0 0 0 2 6.75v4.5A2.75 2.75 0 0 0 4.75 14h4.5A2.75 2.75 0 0 0 12 11.25V9a.75.75 0 0 0-1.5 0v2.25c0 .69-.56 1.25-1.25 1.25h-4.5c-.69 0-1.25-.56-1.25-1.25v-4.5Z" />
                                </svg>

                            </a>
                        </div>

                        <div class="cnb-input-item">
                            <div class="cnb-flex cnb-flex-gap cnb-flex-align-center">
                                <label>Send product updates</label>
                                <input type="hidden" name="cnb[user_marketing_email_opt_in]" value="0"/>
                                <input id="cnb_user_marketing_email_opt_in" class="cnb_toggle_checkbox"
                                    name="cnb[user_marketing_email_opt_in]"
                                    type="checkbox"
                                    value="1" <?php checked( $cnb_user->marketingData->emailOptIn ); ?> />
                                <label for="cnb_user_marketing_email_opt_in" class="cnb_toggle_label">Receive e-mail</label>                                                              
                            </div>
                            <p class="description">A few times per year we'll send a product update to your email.</p>
                        </div>
                        <div class="cnb-input-item">
                            <?php if ( ! is_wp_error( $cnb_user ) && isset( $cnb_options['api_key'] ) ) { ?>
                                <p>
                                    <span class="sr-only">NowButtons API key </span>
                                    <input type="button" name="cnb_api_key_delete" id="cnb_api_key_delete"
                                        class="button button-link cnb-disconnect"
                                        value="<?php esc_attr_e( 'Disconnect' ) ?>"
                                        onclick="return cnb_delete_apikey();">                                
                                    <input type="hidden" name="cnb[api_key]" id="cnb_api_key" value="delete_me" disabled="disabled"/>
                                </p>
                            <?php } ?>
                        </div>
                    </div><!-- END .cnb-section-data -->
                </div><!-- END .cnb-flex -->
            <?php } ?>
        </section>
        <?php
    }

	/**
	 * @param $cnb_domain CnbDomain|WP_Error
	 * @param $cnb_user CnbUser|WP_Error
	 *
	 * @return void
	 */
    private function render_advanced_options( $cnb_domain, $cnb_user ) {
        $cnb_options = get_option( 'cnb' );
        global $cnb_domains;
        /** @var $cnb_settings UrlSettings */
	    global $cnb_settings;

        $cnbAppRemote       = new CnbAppRemote();
        $cnb_clean_site_url = $cnbAppRemote->cnb_clean_site_url();
        $status             = CnbSettingsController::getStatus( $cnb_options );

        $user_nonce = wp_create_nonce( 'cnb-user' );
        $switch = $cnb_settings->get_storage_type() === 'R2' ? 'GCS' : 'R2';
        ?>
        <section data-tab-name="advanced_options" data-tab-group="settings" class="form-table">
            <?php if ( isset( $cnb_domain ) && ! is_wp_error( $cnb_domain ) && $status === 'cloud' ) { ?>
                <input type="hidden" id="cnb_domain_id" value="<?php echo esc_attr( $cnb_domain->id ) ?>">
                <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                    <div class="cnb-section-info cnb-top-spacing">
                        <h3 class="top-0">Domain settings</h3>
                    </div>
                    <div class="cnb-section-data cnb-top-spacing">

                        <?php ( new CnbDomainViewEdit() )->render_form_advanced( $cnb_domain, false ); ?>
                        
                    </div><!-- END .cnb-section-data -->
                </div><!-- END .cnb-flex -->
            <?php } ?>
            <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap when-cloud-enabled cnb_advanced_view">
                <div class="cnb-section-info cnb-top-spacing">
                    <h3 class="top-0">For power users</h3>
                </div>
                <div class="cnb-section-data cnb-top-spacing">

                    <div class="cnb-input-item when-cloud-enabled cnb_advanced_view">
                        <div class="cnb-flex cnb-flex-gap cnb-flex-align-center">
                            <label for="cnb-advanced-view">Advanced view</label>
                            <input type="hidden" name="cnb[advanced_view]" value="0"/>
                            <input id="cnb-advanced-view" class="cnb_toggle_checkbox" type="checkbox"
                                name="cnb[advanced_view]"
                                value="1" <?php checked( '1', $cnb_options['advanced_view'] ); ?> />
                            <label for="cnb-advanced-view" class="cnb_toggle_label">Toggle</label>
                        </div>
                        <p class="description">For power users only.</p>
                    </div>

            
            <?php if ( $status === 'cloud' ) { ?>
                <div class="cnb-input-item cnb_advanced_view">
                    <div class="cnb-flex cnb-flex-gap cnb-flex-align-center">
                        <label for="cnb-show-traces">Show traces</label>
                        <input type="hidden" name="cnb[footer_show_traces]" value="0"/>
                        <input id="cnb-show-traces" class="cnb_toggle_checkbox" type="checkbox"
                               name="cnb[footer_show_traces]"
                               value="1" <?php checked( '1', $cnb_options['footer_show_traces'] ); ?> />
                        <label for="cnb-show-traces" class="cnb_toggle_label">Toggle</label>
                    </div>
                    <p class="description">Display API calls and timings in the footer.</p>
                </div>

                <?php if ( ! is_wp_error( $cnb_user ) && isset( $cnb_domain ) ) { ?>
                <div class="cnb-input-item when-cloud-enabled">
                    <label for="cnb[cloud_use_id]">JavaScript snippet</label>
                    <div>
                        <?php if ( $cnb_domain instanceof WP_Error ) {
                            CnbAdminNotices::get_instance()->warning( 'Almost there! Create your domain using the button at the top of this page.' )
                            ?>
                        <?php } ?>
                        <?php if ( isset( $cnb_options['cloud_use_id'] ) ) { ?>
                            <label><select name="cnb[cloud_use_id]" id="cnb[cloud_use_id]">


                                    <option
                                            value="<?php echo esc_attr( $cnb_user->id ) ?>"
                                        <?php selected( $cnb_user->id, $cnb_options['cloud_use_id'] ) ?>
                                    >
                                        Full account (all domains)
                                    </option>

                                    <?php
                                    $loop_domains = array_filter( $cnb_domains, function ( $domain ) use ( $cnb_options, $cnb_clean_site_url ) {
                                        if ( CnbSettingsController::is_advanced_view() ) {
                                            return true;
                                        } // In case of advanced mode, show all
                                        if ( $domain->name === $cnb_clean_site_url ) {
                                            return true;
                                        } // Always show the current domain
                                        if ( $domain->id === $cnb_options['cloud_use_id'] ) {
                                            return true;
                                        } // If a previous weird option was selected, allow it

                                        return false;
                                    } );
                                    foreach ( $loop_domains as $domain ) { ?>
                                        <option
                                                value="<?php echo esc_attr( $domain->id ) ?>"
                                            <?php selected( $domain->id, $cnb_options['cloud_use_id'] ) ?>
                                        >
                                            <?php echo esc_html( $domain->name ) ?>
                                            (single domain)
                                        </option>
                                    <?php } ?>

                                </select></label>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>

                <div class="cnb-input-item when-cloud-enabled cnb_advanced_view">
                    <div class="cnb-flex cnb-flex-gap cnb-flex-align-center">
                        <label for="cnb-all-domains">Show all buttons</label>
                        <input type="hidden" name="cnb[show_all_buttons_for_domain]" value="0"/>
                        <input id="cnb-all-domains" class="cnb_toggle_checkbox" type="checkbox"
                               name="cnb[show_all_buttons_for_domain]"
                               value="1" <?php checked( '1', $cnb_options['show_all_buttons_for_domain'] ); ?> />
                        <label for="cnb-all-domains" class="cnb_toggle_label">Toggle</label>
                    </div>
                    <p class="description">When checked, the "All Buttons" overview shows all
                            buttons for this account, not just for the current domain.</p>
                </div>

                <div class="cnb-input-item when-cloud-enabled cnb_advanced_view">
                    <label for="cnb[api_base]">API endpoint</label>
                    <input type="text" id="cnb[api_base]" name="cnb[api_base]"
                        class="regular-text"
                        value="<?php echo esc_attr( CnbAppRemote::cnb_get_api_base() ) ?>"/>
                    <p class="description">The API endpoint to use to communicate with the
                        CallNowButton Cloud service.<br/>
                        <strong>Do not change this unless you know what you're doing!</strong>
                    </p>
                </div>

                <div class="cnb-input-item cnb_advanced_view">
                    <div class="cnb-flex cnb-flex-gap cnb-flex-align-center">
                        <label for="cnb-api-caching">API caching</label>
                        <input type="hidden" name="cnb[api_caching]" value="0"/>
                        <input id="cnb-api-caching" class="cnb_toggle_checkbox" type="checkbox"
                               name="cnb[api_caching]"
                               value="1" <?php checked( '1', $cnb_options['api_caching'] ); ?> />
                        <label for="cnb-api-caching" class="cnb_toggle_label">Toggle</label>
                    </div>
                    <p class="description">Cache API requests (using WordPress transients)</p>
                </div>


                <div class="cnb-input-item cnb_advanced_view">
                    <label for="cnb-storage_type">Storage type</label>
                    <p>Storage type: <code><?php echo esc_html($cnb_settings->get_storage_type())?></code></p>
                    <p class="description">What storage backend is NowButtons using?</p>

                    <p>
                        JS Location: <code><?php echo esc_html($cnb_settings->get_js_location())?></code><br />
                        CSS Location: <code><?php echo esc_html($cnb_settings->get_css_location())?></code><br />
                        Static Root: <code><?php echo esc_html($cnb_settings->get_static_root())?></code>
                    </p>
                    <p class="description">Snippet locations</p>

                    <p>
                        User Root: <code><?php echo esc_html($cnb_settings->get_user_root())?></code>
                    </p>
                    <p class="description">Root for the User files</p>
                    <div>
                        <input
                                class="cnb-switch-storage-type button button-secondary"
                                type="button"
                                data-storage-type="<?php echo esc_attr($switch) ?>"
                                data-wpnonce="<?php echo esc_attr($user_nonce) ?>"
                                value="Switch to <?php echo esc_attr($switch) ?>"
                        />
                        <div class="notice inline hidden cnb-switch-storage-type-result"></div>
                    </div>
                </div>
            <?php } // end of cloud check ?>
            </div><!-- END .cnb-section-data -->
        </div><!-- END .cnb-flex -->
    </section>
        <?php
    }

	/**
     * @param $title string
     *
     * @return void
     */
    private function render_topic_start( $title ) { ?>
        <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
            <div class="cnb-section-info cnb-top-spacing">
                <h3 class="top-0"><?php echo esc_html($title); ?></h3>
            </div>
            <div class="cnb-section-data cnb-top-spacing">
        <?php
    }

    /**
     * @return void
     */
    private function render_topic_end() { ?>
            </div><!-- END .cnb-section-data -->
        </div><!-- END .cnb-flex -->
    <?php
    }

    /**
     * @param $cloud_successful boolean
     * @param $cnb_domain CnbDomain
     *
     * @return void
     */
    private function render_premium_option( $cloud_successful, $cnb_domain ) {
        $cnb_options = get_option( 'cnb' );
        $cnb_utils = new CnbUtils();
        ?>

                <div class="cnb-input-item">
                    <div class="cnb-flex cnb-flex-gap cnb-flex-align-center">
                        <label for="cnb_cloud_enabled">Connection
                            <?php if ( $cnb_options['cloud_enabled'] == 0 ) { ?>
                                <a href="<?php echo esc_url( ( new CnbAdminFunctions() )->cnb_legacy_upgrade_page() ) ?>"
                                class="cnb-nounderscore">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </a>
                            <?php } ?>
                        </label>
                        <input type="hidden" name="cnb[cloud_enabled]" value="0"/>
                        <input id="cnb_cloud_enabled" class="cnb_toggle_checkbox" name="cnb[cloud_enabled]"
                            type="checkbox"
                            value="1" <?php checked( '1', $cnb_options['cloud_enabled'] ); ?> />
                        <label for="cnb_cloud_enabled" class="cnb_toggle_label">Enable Cloud</label>
                    </div>
                    <?php if ( $cnb_options['cloud_enabled'] == 0 ) { ?>
                        <p class="description"><a
                                    href="<?php echo esc_url( ( new CnbAdminFunctions() )->cnb_legacy_upgrade_page() ) ?>">Sign
                                up</a> (free) to add extra functionality.
                            <a href="<?php echo esc_url( ( new CnbAdminFunctions() )->cnb_legacy_upgrade_page() ) ?>">Learn
                                more</a>
                        </p>
                    <?php } ?>

                    <?php if ( $cnb_options['cloud_enabled'] == 1 && $cloud_successful && $cnb_domain->type !== 'PRO' ) { ?>
                        <p class="description">Additional premium features available.
                            <a href="<?php echo esc_url( ( new CnbUtils() )->get_cnb_domain_upgrade() ) ?>">Try it 14 days free</a>
                        </p>
                    <?php } ?>

                    <?php if ( $cnb_options['cloud_enabled'] == 1 && $cloud_successful ) {
                    $friends_image = plugins_url('resources/images/coworkers.png', CNB_PLUGINS_URL_BASE ); ?>
                        <div id="cnb_not_working_tips" class="cnb_inpage_notice">
                            <div>
                                <img src="<?php echo esc_url( $friends_image ) ?>" alt="Friends offering help">
                            </div>
                            <p><strong>Is it not working?</strong><br>
                            The NowButtons.com integration works on 99.9% of all websites. Let's fix the issue for you! <a class="button button-primary button-green" target="_blank" href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress/implementation/not-working-fix/', 'turning-off-cloud', 'not-working-fix' ) ) ?>"><strong>Fix it!</strong></a></p>
                        </div>
                    <?php } ?>
                </div>

        <?php
    }

    function render() {
        global $cnb_user, $cnb_domain;
        $cnb_options = get_option( 'cnb' );

	    wp_enqueue_style( CNB_SLUG . '-settings' );
        wp_enqueue_script( CNB_SLUG . '-settings' );
        wp_enqueue_script( CNB_SLUG . '-premium-activation' );
        wp_enqueue_script( CNB_SLUG . '-timezone-picker-fix' );
	    wp_enqueue_script( CNB_SLUG . '-tally' );
	    wp_enqueue_script( CNB_SLUG . '-domain-upgrade' );
	    wp_enqueue_script( CNB_SLUG . '-billing-portal' );

        add_action( 'cnb_header_name', array( $this, 'header' ) );

        $use_cloud        = ( new CnbUtils() )->is_use_cloud( $cnb_options );
        $status           = CnbSettingsController::getStatus( $cnb_options );

        if ( $use_cloud ) {
            CnbDomain::setSaneDefault( $cnb_domain );
        }

        $cloud_successful = $status === 'cloud' && isset( $cnb_domain ) && ! ( $cnb_domain instanceof WP_Error );
        $is_pro_domain = $cloud_successful && $cnb_domain->type === 'PRO';

	    do_action( 'cnb_header' );

	    if ( $cloud_successful ) { ?>
            <script>
                let cnb_domain = <?php echo wp_json_encode( $cnb_domain ) ?>;
            </script>
	    <?php } ?>

        <div class="cnb-body-content">
            <nav class="nav-tab-wrapper">
                <div class="cnb-nav-main">
                    <a data-tab-name="basic_options" data-tab-group="settings"
                        href="<?php echo esc_url( $this->create_tab_url( 'basic_options', 'settings' ) ) ?>"
                        class="nav-tab">General</a>
                    <?php if ( $use_cloud ) { ?>
                        <a data-tab-name="account_options" data-tab-group="settings"
                            href="<?php echo esc_url( $this->create_tab_url( 'account_options', 'settings' ) ) ?>"
                            class="nav-tab">Account</a>
                        <a data-tab-name="advanced_options" data-tab-group="settings"
                            href="<?php echo esc_url( $this->create_tab_url( 'advanced_options', 'settings' ) ) ?>"
                            class="nav-tab">Advanced</a>
                    <?php } ?>
                </div>
                <div class="cnb-nav-aside">
                    <?php if (!$is_pro_domain) { ?>
                    <a href="#" class="cnb-aside-tab cnb-aside-tab-active" data-tab-name="more" data-tab-group="settings-aside">More features</a>
                    <?php } ?>
                    <a href="#" class="cnb-aside-tab<?php if ($is_pro_domain) { echo ' cnb-aside-tab-active'; } ?>" data-tab-name="support" data-tab-group="settings-aside">Support</a>
                </div>
            </nav>
            <div class="cnb-plugin-content-wrapper">
                <main>
                    <form method="post" action="<?php echo esc_url( admin_url( 'options.php' ) ) ?>" class="cnb-container">
                        <?php
                        settings_fields( 'cnb_options' );
                        $this->render_basic_options( $status, $cloud_successful, $cnb_domain );
                        if ( $status === 'cloud' ) {
                            $this->render_account_options( $cnb_user );
                            $this->render_advanced_options( $cnb_domain, $cnb_user );
                        }
                        submit_button();
                        ?>
                    </form>
                </main>
                <aside>
                    <?php $this->render_aside( $is_pro_domain, $cloud_successful ); ?>
                </aside>
            </div><!-- END .cnb-plugin-content-wrapper -->
        </div>
        <?php
        do_action( 'cnb_footer' );
    }

    private function render_aside( $is_pro_domain, $cloud_successful) {
        ?>
        <div class="cnb-aside-body-wrapper">
            <div class="cnb-aside-body">
                <div class="cnb-content-aside-more<?php if (!$is_pro_domain) { echo ' cnb-content-aside-active'; } ?>">
                    <?php if(!$cloud_successful) {
                        ( new CnbAdminFunctions() )->cnb_promobox(
                            'purple',
                            'More actions',
                            '<div class="cnb-actions-container cnb-flex cnb-relative cnb-flex-align-center">
                                <div class="cnb-big-number cnb-center-number cnb-absolute">15</div>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:0;"><i>call</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:1;"><i>whatsapp</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:2;"><i>email</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:3;"><i>directions</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:4;"><i>link2</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:5;"><i>anchor</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:6;"><i>facebook_messenger</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:7;"><i>telegram</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:8;"><i>signal</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:9;"><i>sms</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:10;"><i>zalo</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:11;"><i>skype</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:12;"><i>line</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:13;"><i>wechat</i></span>
                                <span class="cnb-benefit-number cnb-font-icon" style="--i:14;"><i>viber</i></span>
                            </div>',
                            '',
                            'Enable WhatsApp, SMS and More',
                            ( new CnbAdminFunctions() )->cnb_legacy_upgrade_page()
                        );
                        ( new CnbAdminFunctions() )->cnb_promobox(
                            'green',
                            'More buttons',
                            '<div class="cnb-buttons-container">
                                <div class="cnb-big-number cnb-absolute">5</div>                        
                                <div class="cnb-big-text cnb-absolute">Buttons</div>
                                <div class="cnb-smaller-text cnb-absolute">instead&nbsp;of&nbsp;one</div>
                            </div>',
                            '',
                            'Grab 4 Extra Buttons',
                            ( new CnbAdminFunctions() )->cnb_legacy_upgrade_page()
                        );
                        ( new CnbAdminFunctions() )->cnb_promobox(
                            'blue',
                            'NowButtons.com',
                            '<p>Enable extra features by signing up for a <u>free NowButtons account</u>.</p>
                            <h4>Free and paid options available</h4>
                            <p>Super-charge the Call Now Button plugin by enabling additional functionality with you NowButtons account.</p>',
                            '',
                            'Activate Now',
                            ( new CnbAdminFunctions() )->cnb_legacy_upgrade_page()
                        );
                    } else { // When successfully connected to a CNB account
                        $promoboxes = range( 1, 3 );
                        shuffle( $promoboxes );
                        $promoItem             = array_rand( $promoboxes );
                        $schedule_illustration = plugins_url('resources/images/scheduler.png', CNB_PLUGINS_URL_BASE );
                        $custom_image          = plugins_url('resources/images/custom-image.jpg', CNB_PLUGINS_URL_BASE );
                        $upgrade_url = ( new CnbUtils() )->get_cnb_domain_upgrade();
                        if ( $promoItem == 1 ) {
                            ( new CnbAdminFunctions() )->cnb_promobox(
                                'green',
                                '',
                                '<h4 class="cnb-center">Show a call button during office hours</h4>' .
                                '<div class="cnb-center" style="padding: 10px 30px"><img src="' . esc_url( $schedule_illustration ) . '" alt="Upgrade your domain to PRO with an extra discount" style="max-width:300px; width:100%; height:auto;" /></div>' .
                                '<h4 class="cnb-center">A mail button when you\'re off.</h4>',
                                'Try the <strong>scheduler</strong> 14 days free',
                                'Start Trial',
                                $upgrade_url
                            );
                        } elseif ( $promoItem == 2 ) {
                            ( new CnbAdminFunctions() )->cnb_promobox(
                                'green',
                                'PRO includes:',
                                '<p>
                                    <span class="dashicons dashicons-yes cnb-green"></span> Button scheduler<br>
                                    <span class="dashicons dashicons-yes cnb-green"></span> Multi-action buttons<br>
                                    <span class="dashicons dashicons-yes cnb-green"></span> Icon picker & custom images<br>
                                    <span class="dashicons dashicons-yes cnb-green"></span> Advanced display rules<br>
                                    <span class="dashicons dashicons-yes cnb-green"></span> Geo targeting<br>
                                    <span class="dashicons dashicons-yes cnb-green"></span> Set scroll height for buttons to appear<br>
                                    <span class="dashicons dashicons-yes cnb-green"></span> Slide-in content windows<br>
                                    <span class="dashicons dashicons-yes cnb-green"></span> Integrate your Intercom chat</p><h3>And much more!</h3>',
                                '<strong>Try it 14 days free!</strong>',
                                'Start Free Trial',
                                $upgrade_url
                            );
                        } else {
                            ( new CnbAdminFunctions() )->cnb_promobox(
                                'green',
                                '',
                                '<h4>Unlock more icons...</h4>' .
                                '<p>Upgrade to Pro to enable an icon picker for your actions.</p>' .
                                '<h4>...or personalize with Custom Images</h4>' .
                                '<div class="cnb-center" style="padding: 0 34px"><img src="' . esc_url( $custom_image ) . '" alt="Custom button images" style="max-width:246px; width:100%; height:auto;" /></div>' .
                                '<p>With custom images you can add your own image to your buttons. For example a headshot on a contact button.</p>',
                                '<strong>Try it 14 days free!</strong>',
                                'Start Free Trial',
                                $upgrade_url
                            );
                        }
                    }
                    ?>
                </div>
                <div class="cnb-content-aside-support<?php if ($is_pro_domain) { echo ' cnb-content-aside-active'; } ?>">
                    <?php
                        ( new CnbAdminFunctions() )->cnb_promobox(
                            'blue',
                            'Quick help',
                            '<h4>Connection</h4>
                            <p>The NowButtons connection will enable a large set of additional features such as more buttons and more actions such as WhatsApp.</p>
                            <h4>Tracking</h4>
                            <p>You can keep track of the number of <strong>visitors that are clicking on your button(s)</strong> through Google Analytics. Just flick the toggle and sit back!</p>                                            
                            <p>If you have the Event Snippet installed on your pages, this toggle will enable <strong>conversion tracking</strong> (assuming you have the conversion set up in your Ads account).</p>
                            <h4>Button Display</h4>
                            <p>You can change the size of your buttons or adjust where it sits in the order of elements (technically called the z-index). If you have a cookie consent message that needs to be on top of the button, you can reduce the value to bring the button more backward.</p>',
                            '',
                            'Help Center',
                            ( new CnbAdminFunctions() )->cnb_legacy_upgrade_page()
                        );
                    ?>
                </div>
            </div>
        </div><!-- END .cnb-aside-body-wrapper -->
        <?php
    }
}
