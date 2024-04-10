<?php

namespace cnb\admin\legacy;

use cnb\utils\CnbAdminFunctions;
use cnb\utils\CnbUtils;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

class CnbLegacyEdit {
    public function render() {
        do_action( 'cnb_init', __METHOD__ );

	    wp_enqueue_style( CNB_SLUG . '-legacy-edit' );
	    wp_enqueue_script( CNB_SLUG . '-legacy-edit' );

        add_action( 'cnb_header_name', array( $this, 'header' ) );

        do_action( 'cnb_header' );
        $this->render_form();
        do_action( 'cnb_footer' );
        do_action( 'cnb_finish' );
    }

    private function create_tab_url( $tabName, $tabGroup ) {
        $url = admin_url( 'admin.php' );

        return add_query_arg(
            array(
                'page'   => 'call-now-button',
                'action' => 'edit',
                'tabName'    => $tabName,
                'tabGroup'  => $tabGroup,
            ),
            $url );
    }

    public function render_tracking() {
        $cnb_options = get_option( 'cnb' );
        $cnb_utils   = new CnbUtils();
        ?>
        <div class="cnb-input-item">
            <label>Click tracking <a
                        href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress-free/settings/click-tracking/', 'legacy-settings-question-mark', 'click-tracking', 'legacy' ) ) ?>"
                        target="_blank" class="cnb-nounderscore">
                    <span class="dashicons dashicons-editor-help"></span>
                </a></label>
            <div>
                <div class="cnb-radio-item cnb-flex cnb-flex-gap cnb-flex-align-center">
                    <input id="tracking3" type="radio" name="cnb[tracking]"
                           value="0" <?php checked( '0', $cnb_options['tracking'] ); ?> />
                    <label for="tracking3">Disabled</label>
                </div>
                <div class="cnb-radio-item cnb-flex cnb-flex-gap cnb-flex-align-center">
                    <input id="tracking4" type="radio" name="cnb[tracking]"
                           value="3" <?php checked( '3', $cnb_options['tracking'] ); ?> />
                    <label for="tracking4">Latest Google Analytics (gtag.js)</label>
                </div>
                <div class="cnb-radio-item cnb-flex cnb-flex-gap cnb-flex-align-center">
                    <input id="tracking1" type="radio" name="cnb[tracking]"
                           value="2" <?php checked( '2', $cnb_options['tracking'] ); ?> />
                    <label for="tracking1">Google Universal Analytics (analytics.js)</label>
                </div>
                <div class="cnb-radio-item cnb-flex cnb-flex-gap cnb-flex-align-center">
                    <input id="tracking2" type="radio" name="cnb[tracking]"
                           value="1" <?php checked( '1', $cnb_options['tracking'] ); ?> />
                    <label for="tracking2">Classic Google Analytics (ga.js)</label>
                </div>
                <p class="description">Using Google Tag Manager? Set up click tracking in GTM. <a
                            href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress-free/settings/google-tag-manager-event-tracking/', 'legacy-settings-description', 'google-tag-manager-event-tracking', 'legacy' ) ) ?>"
                            target="_blank">Learn how to do this...</a></p>
            </div>
        </div>
        <?php
    }

    public function render_conversions() {
        $cnb_options = get_option( 'cnb' );
        $cnb_utils   = new CnbUtils();
        ?>
        <div class="cnb-input-item">
            <label>Google Ads <a
                        href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress-free/settings/google-ads/', 'legacy-settings-question-mark', 'google-ads', 'legacy' ) ) ?>"
                        target="_blank" class="cnb-nounderscore">
                    <span class="dashicons dashicons-editor-help"></span>
                </a>
            </label>
            <div>
                <div class="cnb-radio-item cnb-flex cnb-flex-gap cnb-flex-align-center">
                    <input id="cnb_conversions_0" name="cnb[conversions]" type="radio"
                           value="0" <?php checked( '0', $cnb_options['conversions'] ); ?> /> <label
                            for="cnb_conversions_0">Off </label>
                </div>
                <div class="cnb-radio-item cnb-flex cnb-flex-gap cnb-flex-align-center">
                    <input id="cnb_conversions_1" name="cnb[conversions]" type="radio"
                           value="1" <?php checked( '1', $cnb_options['conversions'] ); ?> /> <label
                            for="cnb_conversions_1">Conversion Tracking using Google's global site tag </label>
                </div>
                <div class="cnb-radio-item cnb-flex cnb-flex-gap cnb-flex-align-center">
                    <input id="cnb_conversions_2" name="cnb[conversions]" type="radio"
                           value="2" <?php checked( '2', $cnb_options['conversions'] ); ?> /> <label
                            for="cnb_conversions_2">Conversion Tracking using JavaScript</label>
                </div>
                <p class="description">Select this option if you want to track clicks on the button as Google Ads
                    conversions. This option requires the Event snippet to be present on the page. <a
                    href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress-free/settings/google-ads/', 'legacy-settings-description', 'google-ads', 'legacy' ) ) ?>"
                    target="_blank">Learn more...</a></p>
            </div>
        </div>
        <?php
    }

    public function render_zoom() {
        $cnb_options = get_option( 'cnb' );
        ?>
        <div class="cnb-input-item">
            <label for="cnb_slider">Button size</label>    
            <div class=" cnb-flex cnb-flex-gap cnb-flex-align-center">
                        
                <input type="range" min="0.7" max="1.3" name="cnb[zoom]"
                       value="<?php echo esc_attr( $cnb_options['zoom'] ) ?>" class="slider" id="cnb_slider" step="0.1">
                <span id="cnb_slider_value"></span>
            </div>
        </div>
        <?php
    }

    public function render_zindex() {
        $cnb_options = get_option( 'cnb' );
        $cnb_utils   = new CnbUtils();
        ?>
        <div class="cnb-input-item">
            <label for="cnb_order_slider">Order</label> 
            <div class=" cnb-flex cnb-flex-gap cnb-flex-align-center">            
                <input type="range" min="1" max="10" name="cnb[z-index]"
                       value="<?php echo esc_attr( $cnb_options['z-index'] ) ?>" class="slider2" id="cnb_order_slider"
                       step="1">
                (<span id="cnb_order_value"></span>)
            </div>
            <p class="description">The default (and recommended) value is all the way to the front so the button
                sits on top of everything else. In case you have a specific usecase where you want something else to
                sit in front of the Call Now Button (e.g. a chat window or a cookie notice) you can move this
                backwards one step at a time to adapt it to your situation.</p>
        </div>
        <?php
    }

    public function header() {
        echo esc_html( CNB_NAME ) . ' <span class="cnb-version">v' . esc_html( CNB_VERSION ) . '</span>';
    }

    private function render_form() {
        $cnb_options    = get_option( 'cnb' );
        $adminFunctions = new CnbAdminFunctions();
        $cnb_utils      = new CnbUtils();

	    $display_mode = isset( $cnb_options['displaymode'] ) ? $cnb_options['displaymode'] : 'MOBILE_ONLY';

        ?>
            <div class="cnb-body-content">
                <nav class="nav-tab-wrapper">
                    <div class="cnb-nav-main">
                        <a href="<?php echo esc_url( $this->create_tab_url( 'basic_options', 'legacy' ) ) ?>"
                            class="nav-tab"
                            data-tab-name="basic_options" data-tab-group="legacy">Basics</a>
                        <a href="<?php echo esc_url( $this->create_tab_url( 'extra_options', 'legacy' ) ) ?>"
                            class="nav-tab"
                            data-tab-name="extra_options" data-tab-group="legacy">Presentation</a>
                        <a href="<?php echo esc_url( $this->create_tab_url( 'scheduler', 'legacy' ) ) ?>"
                            class="nav-tab cnb_disabled_feature"
                            data-tab-name="scheduler" data-tab-group="legacy"><span class="dashicons dashicons-lock"></span> Scheduler</a>
                    </div>
                    <div class="cnb-nav-aside">
                        <a href="#" class="cnb-aside-tab cnb-aside-tab-active" data-tab-name="more" data-tab-group="legacy-aside">More features</a>
                        <a href="#" class="cnb-aside-tab" data-tab-name="support" data-tab-group="legacy-aside">Support</a>
                    </div>
                </nav>
                <div class="cnb-plugin-content-wrapper">
                    <main>
                        <form method="post" action="<?php echo esc_url( admin_url( 'options.php' ) ) ?>"
                            class="cnb-container">
                            <?php settings_fields( 'cnb_options' ); ?>
                            <section class="form-table" data-tab-name="basic_options" data-tab-group="legacy">
                                <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                                    <div class="cnb-section-info cnb-top-spacing">
                                        <h3 class="top-0">Button settings</h3>
                                        
                                    </div>
                                    <div class="cnb-section-data cnb-top-spacing">

                                        <div class="cnb-input-item cnb-flex cnb-flex-gap">                                        
                                            <label for="cnb-active">Button status</label>
                                            <input type="hidden" name="cnb[active]" value="0"/>
                                            <input id="cnb-active" class="cnb_toggle_checkbox" type="checkbox" name="cnb[active]"
                                                value="1" <?php checked( '1', $cnb_options['active'] ); ?> />
                                            <label for="cnb-active" class="cnb_toggle_label">Toggle</label>                                        
                                        </div>

                                        <div class="cnb-input-item">
                                            <label for="cnb_action_type">Button action</label>
                                            <select>
                                                <option selected="selected">Phone</option>
                                                <option disabled>* Email</option>
                                                <option disabled>* SMS/Text</option>
                                                <option disabled>* WhatsApp</option>
                                                <option disabled>* Messenger</option>
                                                <option disabled>* Signal</option>
                                                <option disabled>* Telegram</option>
                                                <option disabled>* Link</option>
                                                <option disabled>* Location</option>
                                                <option disabled>* Scroll to point</option>
                                                <option disabled>* Skype</option>
                                                <option disabled>* Line</option>
                                                <option disabled>* Viber</option>
                                                <option disabled>* WeChat</option>
                                                <option disabled>* Content Window</option>
                                                <option disabled>* Tally form window</option>
                                            </select>
                                        </div>

                                        <div class="cnb-input-item">
                                            <label for="cnb-number">Phone number <a
                                                    href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress-free/basics/phone-number/', 'legacy-basics-question-mark', 'phone-number', 'legacy' ) ) ?>"
                                                    target="_blank" class="cnb-nounderscore">
                                                    <span class="dashicons dashicons-editor-help"></span>
                                                </a>
                                            </label>
                                            <input type="text" id="cnb-number" name="cnb[number]"
                                            value="<?php echo esc_attr( $cnb_options['number'] ) ?>"/>
                                        </div>
                                        
                                        
                                        <div class="cnb-input-item">
                                            <label for="buttonTextField">Button text <a
                                                        href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress-free/basics/using-text-buttons/', 'legacy-basics-question-mark', 'using-text-buttons', 'legacy' ) ) ?>"
                                                        target="_blank" class="cnb-nounderscore">
                                                    <span class="dashicons dashicons-editor-help"></span>
                                                </a>
                                            </label>
                                            <input id="buttonTextField" type="text" name="cnb[text]"
                                            value="<?php echo esc_attr( $cnb_options['text'] ) ?>" maxlength="30" placeholder="Optional"/>
                                            <p class="description">Leave this field empty to only show an icon.</p>
                                        </div>
                                    </div><!-- END .cnb-section-data -->
                                </div><!-- END .cnb-flex -->
                            </section>

                            <section class="form-table" data-tab-name="extra_options" data-tab-group="legacy">
                                <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                                        <div class="cnb-section-info cnb-top-spacing">
                                            <h3 class="top-0">Presentation settings</h3>
                                        </div>
                                        <div class="cnb-section-data cnb-top-spacing">

                                            <div class="cnb-input-item">
                                                <label for="cnb-color">Button color</label>
                                                <input id="cnb-color" name="cnb[color]" type="text"
                                                    value="<?php echo esc_attr( $cnb_options['color'] ) ?>"
                                                    class="cnb-color-field" data-default-color="#009900"/>
                                            </div>

                                            <div class="cnb-input-item">
                                                <label for="cnb-icon-color">Icon color</label>
                                                <input id="cnb-icon-color" name="cnb[iconcolor]" type="text"
                                                    value="<?php echo esc_attr( $cnb_options['iconcolor'] ) ?>"
                                                    class="cnb-color-field" data-default-color="#ffffff"/>
                                            </div>

                                            <div class="cnb-input-item">
                                                <label>Position & style</label>
                                                <div class="appearance-options">
                                                    <div class="cnb-positions  cnb-flex cnb-flex-gap">                                                    
                                                    
                                                        <div class="cnb-buttons cnb-small-screen cnb-block-radius cnb-block-shade">
                                                            <label for="appearance8" class="cnb-radio-item">
                                                                <input type="radio" id="appearance8" name="cnb[appearance]"
                                                                value="tleft" <?php checked( 'tleft', $cnb_options['appearance'] ); ?>>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        
                                                            <label for="appearance9" class="cnb-radio-item">
                                                                <input type="radio" id="appearance9" name="cnb[appearance]"
                                                                value="tmiddle" <?php checked( 'tmiddle', $cnb_options['appearance'] ); ?>>
                                                                <span class="checkmark"></span>
                                                            </label>

                                                            <label for="appearance7" for="appearance5" class="cnb-radio-item">
                                                                <input type="radio" id="appearance7" name="cnb[appearance]"
                                                                value="tright" <?php checked( 'tright', $cnb_options['appearance'] ); ?>>
                                                                <span class="checkmark"></span>
                                                            </label>

                                                            <label for="appearance6" class="cnb-middle-position cnb-radio-item">
                                                                <input type="radio" id="appearance6" name="cnb[appearance]"
                                                                    value="mleft" <?php checked( 'mleft', $cnb_options['appearance'] ); ?>>
                                                                <span class="checkmark"></span>
                                                            </label>

                                                            <span class="cnb-middle-position cnb-radio-item"></span>

                                                            <label for="appearance5" class="cnb-middle-position cnb-radio-item">
                                                                <input type="radio" id="appearance5" name="cnb[appearance]"
                                                                    value="mright" <?php checked( 'mright', $cnb_options['appearance'] ); ?>>
                                                                <span class="checkmark"></span>
                                                            </label>                                          

                                                            <label for="appearance2" class="cnb-radio-item">
                                                                <input type="radio" id="appearance2" name="cnb[appearance]"
                                                                    value="left" <?php checked( 'left', $cnb_options['appearance'] ); ?>>
                                                                <span class="checkmark"></span>
                                                            </label>        

                                                            <label for="appearance3" class="cnb-radio-item">
                                                                <input type="radio" id="appearance3" name="cnb[appearance]"
                                                                value="middle" <?php checked( 'middle', $cnb_options['appearance'] ); ?>>
                                                                <span class="checkmark"></span>
                                                            </label>

                                                            <label for="appearance1" class="cnb-radio-item">
                                                                <input type="radio" id="appearance1" name="cnb[appearance]"
                                                                    value="right" <?php checked( 'right', $cnb_options['appearance'] ); ?>>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <div class="cnb-buttonbar cnb-small-screen cnb-block-radius cnb-block-shade">                            
                                                            <label for="appearance11" class="cnb-radio-item">
                                                                <input type="radio" id="appearance11" name="cnb[appearance]"
                                                                    value="tfull" <?php checked( 'tfull', $cnb_options['appearance'] ); ?>>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                                                        
                                                            <label for="appearance12" class="cnb-radio-item">
                                                                <input type="radio" id="appearance12" name="cnb[appearance]"
                                                                    value="full" <?php checked( 'full', $cnb_options['appearance'] ); ?>>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="hideIconTR">
                                                    <br>
                                                    <input type="hidden" name="cnb[hideIcon]" value="0"/>
                                                    <input id="hide_icon" type="checkbox" name="cnb[hideIcon]"
                                                        value="1" <?php checked( '1', $cnb_options['hideIcon'] ); ?>>
                                                    <label title="right" for="hide_icon">Remove icon</label>
                                                </div>                                        
                                            </div>

                                            <div class="cnb-input-item">
                                                <label for="button_options_displaymode">Display on </label>
                                                <select name="cnb[displaymode]" id="button_options_displaymode">
                                                    <option value="MOBILE_ONLY"<?php selected( 'MOBILE_ONLY', $display_mode ) ?>>
                                                        Mobile only
                                                    </option>
                                                    <option value="DESKTOP_ONLY"<?php selected( 'DESKTOP_ONLY', $display_mode ) ?>>
                                                        Desktop only
                                                    </option>
                                                    <option value="ALWAYS"<?php selected( 'ALWAYS', $display_mode ) ?>>
                                                        All screens
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="cnb-input-item">
                                                <label for="cnb-show">Limit appearance <a
                                                            href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress-free/presentation/limit-appearance/', 'legacy-presentation-question-mark', 'limit-appearance', 'legacy' ) ) ?>"
                                                            target="_blank" class="cnb-nounderscore">
                                                        <span class="dashicons dashicons-editor-help"></span>
                                                    </a>
                                                </label>
                                                <input type="text" id="cnb-show" name="cnb[show]"
                                                    value="<?php echo esc_attr( $cnb_options['show'] ) ?>"
                                                    placeholder="E.g. 14, 345"/>
                                                <p class="description">Enter IDs of the posts &amp; pages, separated by commas
                                                    (leave blank for all). <a
                                                            href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress-free/presentation/limit-appearance/', 'legacy-presentation-description', 'limit-appearance', 'legacy' ) ) ?>"
                                                            target="_blank">Learn more...</a></p>
                                                <div class="cnb-radio-item cnb-flex cnb-flex-gap cnb-flex-align-center">
                                                    <input id="limit1" type="radio" name="cnb[limit]"
                                                        value="include" <?php checked( 'include', $cnb_options['limit'] ); ?> />
                                                    <label for="limit1">Limit to these posts and pages.</label>
                                                </div>
                                                <div class="cnb-radio-item cnb-flex cnb-flex-gap cnb-flex-align-center">
                                                    <input id="limit2" type="radio" name="cnb[limit]"
                                                        value="exclude" <?php checked( 'exclude', $cnb_options['limit'] ); ?> />
                                                    <label for="limit2">Exclude these posts and pages.</label>
                                                </div>
                                                <p class="description">Display Rules give you more control. <a href="<?php echo esc_url(( new CnbAdminFunctions() )->cnb_legacy_upgrade_page()); ?>">Sign up now</a> (it's free).</p>
                                            </div>
                                            
                                            <div class="cnb-input-item cnb-flex cnb-flex-gap cnb-flex-align-center">
                                                <label for="cnb-show-fp">Show button on front page</label>
                                                <input type="hidden" name="cnb[frontpage]" value="1"/>
                                                <input id="cnb-show-fp" class="cnb_toggle_checkbox" type="checkbox" name="cnb[frontpage]"
                                                    value="0" <?php checked( '0', $cnb_options['frontpage'] ); ?> />
                                                <label for="cnb-show-fp" class="cnb_toggle_label">Toggle</label>
                                            </div>
                                        </div><!-- END .cnb-section-data -->
                                    </div><!-- END .cnb-flex -->
                                </section>
                                

                            <section class="form-table" data-tab-name="scheduler" data-tab-group="legacy">
                                <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                                    <div class="cnb-section-info cnb-top-spacing">
                                        <h3 class="top-0">Scheduler</h3>
                                    </div>
                                    <div class="cnb-section-data cnb-top-spacing">

                                        <div class="cnb-input-item">
                                            <a href="<?php echo esc_url(( new CnbAdminFunctions() )->cnb_legacy_upgrade_page()); ?>">Upgrade</a> to enable the scheduler.
                                        </div>
                            
                                        <div class="cnb-input-item cnb_disabled_feature cnb-flex cnb-flex-gap cnb-flex-align-center">
                                            <label>Show at all times</label>
                                            <input class="cnb_toggle_checkbox" type="checkbox" checked="checked" disabled>
                                            <label for="actions_schedule_show_always" class="cnb_toggle_label" style="background-color:#b3afaf">Toggle</label>
                                            
                                        </div>

                                        <div class="cnb-input-item cnb_disabled_feature">
                                            <label>Set days</label>
                                            <div class="cnb-flex">
                                                <input disabled class="cnb_day_selector" id="cnb_weekday_0" type="checkbox">
                                                <label title="Monday" class="cnb_day_selector" for="cnb_weekday_0">Mon</label>

                                                <input disabled class="cnb_day_selector" id="cnb_weekday_1" type="checkbox">
                                                <label title="Tuesday" class="cnb_day_selector" for="cnb_weekday_1">Tue</label>

                                                <input disabled class="cnb_day_selector" id="cnb_weekday_2" type="checkbox">
                                                <label title="Wednesday" class="cnb_day_selector" for="cnb_weekday_2">Wed</label>

                                                <input disabled class="cnb_day_selector" id="cnb_weekday_3" type="checkbox">
                                                <label title="Thursday" class="cnb_day_selector" for="cnb_weekday_3">Thu</label>

                                                <input disabled class="cnb_day_selector" id="cnb_weekday_4" type="checkbox">
                                                <label title="Friday" class="cnb_day_selector" for="cnb_weekday_4">Fri</label>

                                                <input disabled class="cnb_day_selector" id="cnb_weekday_5" type="checkbox">
                                                <label title="Saturday" class="cnb_day_selector" for="cnb_weekday_5">Sat</label>

                                                <input disabled class="cnb_day_selector" id="cnb_weekday_6" type="checkbox">
                                                <label title="Sunday" class="cnb_day_selector" for="cnb_weekday_6">Sun</label>
                                            </div>
                                        </div>                         

                                        <div class="cnb-input-item cnb_disabled_feature cnb-flex cnb-flex-gap cnb-flex-align-center">
                                            <label for="actions_schedule_outside_hours">After hours</label>
                                            <input id="actions_schedule_outside_hours" disabled class="cnb_toggle_checkbox" type="checkbox">
                                            <label for="actions_schedule_outside_hours" class="cnb_toggle_label">Toggle</label>
                                        </div>

                                        <div class="cnb-input-item cnb_disabled_feature">
                                            <label>Set times</label>
                                            <div class="cnb-scheduler-slider">
                                                <p id="cnb-schedule-range-text">From <strong>8:00 am</strong> till <strong>5:00 pm</strong></p>
                                            </div>
                                        </div>
                                    </div><!-- END .cnb-section-data -->
                                </div><!-- END .cnb-flex -->
                            </section>

                            <section class="form-table <?php echo esc_attr( $adminFunctions->is_active_tab( 'advanced_options' ) ) ?>">
                                <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                                    <div class="cnb-section-info cnb-top-spacing">
                                        <h3 class="top-0">Advanced Settings</h3>
                                    </div>
                                    <div class="cnb-section-data cnb-top-spacing">

                                    <?php
                                        $this->render_tracking();
                                        $this->render_conversions();
                                        $this->render_zoom();
                                        $this->render_zindex();
                                        ?>
                                        
                                    </div><!-- END .cnb-section-data -->
                                </div><!-- END .cnb-flex -->
                            </section>
                            <?php submit_button(); ?>
                            <div class="description">* <a href="<?php echo esc_url(( new CnbAdminFunctions() )->cnb_legacy_upgrade_page()); ?>">Create an account</a> to enable extra button actions.</div>
                        </form>

                    </main>
                    <aside>
                        <div class="cnb-aside-body-wrapper">
                            <div class="cnb-aside-body">
                                <div class="cnb-content-aside-more cnb-content-aside-active">
                                    <?php
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
                                    ?>
                                </div>
                                <div class="cnb-content-aside-support">
                                    <?php
                                        ( new CnbAdminFunctions() )->cnb_promobox(
	                                        'blue',
	                                        'Quick help',
	                                        '<h4>Button status</h4>
                                            <p>Enabled (toggle to right) means that the button is live on your website.</p>
                                            <h4>Button action</h4>
                                            <p>Phone is the standard button action. The pulldown shows an overview of all the actions you can pick from when you connect to a free NowButtons.com account.</p>
                                            <h4>Phone Number</h4>
                                            <p>We recommend using the international phone number notation to make sure the button works for everyone. This is not a requirement, but our recommendation. <a href="https://callnowbutton.com/support/wordpress-free/basics/phone-number/?utm_source=wp-plugin_CallNowButton_1.4.3&utm_medium=referral&utm_campaign=legacy-basics-question-mark&utm_term=phone-number">Learn more</a></p>',
	                                        '',
	                                        'Help Center',
	                                        ( new CnbAdminFunctions() )->cnb_legacy_upgrade_page()
                                        );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </aside>
                    
                </div><!-- END .cnb-plugin-content-wrapper -->                    
            </div><!-- END cnb-body-content -->            
        <?php
    }

}
