<?php

namespace cnb\admin\legacy;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\CnbHeaderNotices;

class CnbLegacyUpgrade {
    function header() {
        echo 'Unlock more features';
    }

    private function feature_comparison_free_promobox() {
        ?>
        <div class="signup-block ">
          <h3>Sign up (it's free)</h3>
          <div class="cnb-signup-block">
            
            <div class="benefits-section-signup">
              <?php echo CnbHeaderNotices::cnb_settings_email_activation_input() // phpcs:ignore WordPress.Security ?>
            </div>
          </div>
        </div>
        <h3 class="top-50">More features</h3>
        <div class="benefit-section">
          <div class="benefit-box">
            <span class="benefit-number">15</span>
            <span class="benefit-name">Actions</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number">5</span>
            <span class="benefit-name">Buttons</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><span class="dashicons dashicons-clipboard"></span></span>
            <span class="benefit-name">Rules</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><span class="dashicons dashicons-visibility"></span></span>
            <span class="benefit-name">Preview</span>
          </div>
        </div>
        <h3>More actions</h3>
        <p style="margin-bottom: 0">NowButtons brings you a full suite of actions to boost the overall conversion rate of your website. Sign up now to enable the following actions:</p>
        <div class="benefit-section">
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>call</i></span>
            <span class="benefit-name">Call</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>whatsapp</i></span>
            <span class="benefit-name">WhatsApp</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>email</i></span>
            <span class="benefit-name">Email</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>directions</i></span>
            <span class="benefit-name">Maps</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>link2</i></span>
            <span class="benefit-name">Links</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>anchor</i></span>
            <span class="benefit-name">Scrolls</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>facebook_messenger</i></span>
            <span class="benefit-name">Messenger</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>telegram</i></span>
            <span class="benefit-name">Telegram</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>signal</i></span>
            <span class="benefit-name">Signal</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>sms</i></span>
            <span class="benefit-name">SMS/Text</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>zalo</i></span>
            <span class="benefit-name">Zalo</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>skype</i></span>
            <span class="benefit-name">Skype</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>line</i></span>
            <span class="benefit-name">Line</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>wechat</i></span>
            <span class="benefit-name">WeChat</span>
          </div>
          <div class="benefit-box">
            <span class="benefit-number cnb-font-icon"><i>viber</i></span>
            <span class="benefit-name">Viber</span>
          </div>
        </div>
        <div class="signup-block top-50">
          <h3>Sign up now</h3>
          <div class="cnb-signup-block">
            <p class="cnb-not-on-mobile"><strong>Enter your email below</strong> and hit <em>Create account</em> to activate NowButtons:</p>
            <div class="benefits-section-signup">
              <?php echo CnbHeaderNotices::cnb_settings_email_activation_input() // phpcs:ignore WordPress.Security ?>
            </div>
          </div>
        </div>
        
        <div class="cnb-body-column top-50">
          
          <h2>Feature comparison</h2>
          <table class="cnb-nb-plans">
            <thead>
              <tr>
                <td></td>
                <th class="cnb-prod-cnb" style="border-radius:5px 5px 0 0;"><h3>No account<br><span class="cnb-not-on-mobile" style="font-weight:normal;">(Currently active)</span></h3></th>
                <th class="cnb-prod-nb" style="border-radius:5px 5px 0 0;"><h3>With account<br><span style="font-weight:normal;">(NowButtons.com)</span></h3></th>
              </tr>
              <tr class="font-18">
                <th style="border-radius: 5px 0 0 5px;"></th>
                <th><h4>Free</h4></th>
                <th><h4>Free</h4></th>
              </tr>
            </thead>
            <tbody>
              <tr class="line"><td>&nbsp;</td><td></td><td></td></tr>
              <tr>
                <th>No. of buttons</th>
                <td class="value">1</td>
                <td class="value">5</td>
              </tr>
              <tr>
                <th>Single button</th>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Buttonbar (full width)</th>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
              </tr>
              <tr class="line"><td>&nbsp;</td><td></td><td></td></tr>
              <tr>
                <th>Phone</th>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>SMS/Text</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Maps</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>URLs</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Scroll to point</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>WhatsApp</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Messenger</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Telegram</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Signal</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Skype</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Viber</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Line</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Zalo</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>WeChat</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>

              <tr class="line"><td>&nbsp;</td><td></td><td></td></tr>
              <tr>
                <th>Mobile</th>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Desktop</th>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Limit appearance</th>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Display rules</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Click tracking in GA</th>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Google Ads conversion tracking</th>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
              </tr>
              <tr>
                <th>Live preview</th>
                <td>𐄂</td>
                <td class="yes">✓</td>
              </tr>
              <tr class="line"><td>&nbsp;</td><td></td><td></td></tr>
            </tbody>
          </table>
          
          <div class="signup-block">
            <h3>Sign up now!</h3>
            <div class="cnb-signup-block">
              <p class="cnb-not-on-mobile"><strong>Enter your email below</strong> and hit <em>Create account</em> to activate NowButtons:</p>
              <div class="benefits-section-signup">
                <?php echo CnbHeaderNotices::cnb_settings_email_activation_input() // phpcs:ignore WordPress.Security ?>
              </div>
            </div>
          </div>
        </div>
    <?php }

    function upgrade_faq() {
        ?>
        <div class="cnb-faq-section">
            <h1>FAQ</h1>
            <h3>Is a NowButtons.com account really free?</h3>
            <p>Yes. NowButtons has a paid plan as well, however the features described above are all part of the Starter plan which is free. Enter your email above and click <b>Create account</b> to sign up and enable the extra features.</p>
            <h3>Is there a PRO plan?</h3>
            <p>Yes, NowButtons offers a PRO plan with many advanced feature for even more buttons and more control.</p>
            <h3>What's included in PRO?</h3>
            <p>PRO turns your website into a conversion machine. It adds a big collection of premium features such as scheduling, multi-action buttons, animations, WhatsApp Chat window, and much much more. Checkout <a href="<?php echo esc_url(CNB_WEBSITE . 'pricing/') ?>" target="_blank"><?php echo esc_html(CNB_WEBSITE) ?>pricing/</a> for a full features overview.</p>
            <h3>Why do I have to sign up for <?php echo esc_html(CNB_CLOUD_NAME); ?>?</h3>
            <p>NowButtons is a cloud service and can be added to any website. Even those that do not have a WordPress powered website. Once you've signed up, you can continue to manage your buttons from your WordPress instance, but you could also do this via the web app found at <a href="<?php echo esc_url(CNB_APP) ?>" target="_blank"><?php echo esc_html(CNB_APP) ?></a>.</p><p>And should you ever move to a different CMS, your button(s) will just move with you.</p>
        </div>
    <?php }

    public function render() {
        do_action( 'cnb_init', __METHOD__ );

	    wp_enqueue_style( CNB_SLUG . '-promos' );
        wp_enqueue_script( CNB_SLUG . '-settings' );
	    wp_enqueue_script( CNB_SLUG . '-premium-activation' );

        add_action( 'cnb_header_name', array( $this, 'header' ) );
        do_action( 'cnb_header' );
        ?>

        <div class="cnb-one-column-section">
            <div class="cnb-body-content">
                <div class="cnb-compare-features">
                    <?php $this->feature_comparison_free_promobox() ?>
                    <hr style="margin:50px 0">
                    <?php $this->upgrade_faq() ?>
                </div>
            </div>
        </div>
        <hr>
        <?php
        do_action( 'cnb_footer' );
        do_action( 'cnb_finish' );
    }
}
