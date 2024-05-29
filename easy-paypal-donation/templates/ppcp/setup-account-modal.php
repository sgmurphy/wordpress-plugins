<div id="wpedon-ppcp-setup-account-modal" class="wpedon-ppcp-modal wpedon-ppcp-modal">
    <div class="wpedon-ppcp-setup-account">
        <h3>Setup PayPal Account</h3>

        <div class="wpedon-ppcp-field">
            <label for="wpedon-ppcp-country">
                Select your country
            </label>
            <select id="wpedon-ppcp-country">
                <option value="US">United States</option>
                <option value="AU">Australia</option>
                <option value="CA">Canada</option>
                <option value="UK">United Kingdom</option>
                <option value="DE">Germany</option>
                <option value="FR">France</option>
                <option value="IT">Italy</option>
                <option value="ES">Spain</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="wpedon-ppcp-field wpedon-ppcp-checkbox-field">
            <label class="wpedon-ppcp-readonly">
                <input type="checkbox" id="wpedon-ppcp-accept-paypal" checked disabled/> <span class="wpedon-ppcp-cb-view"></span>
                <img src="<?php echo $args['url']; ?>assets/images/paypal-logo.png" alt="paypal-accept-paypal"/>
                Accept PayPal
            </label>
        </div>

        <div class="wpedon-ppcp-field wpedon-ppcp-checkbox-field">
            <label data-title="PayPal does not currently support PayPal Advanced Card Payments in your country.">
                <input type="checkbox" id="wpedon-ppcp-accept-cards"/> <span class="wpedon-ppcp-cb-view"></span>
                <img src="<?php echo $args['url']; ?>assets/images/paypal-advanced.png" alt="paypal-accept-cards"/>
                Accept Credit and Debit Card Payments with PayPal
            </label>
            <div class="wpedon-ppcp-checkbox-note">* Direct Credit Card option will require a PayPal Business account and additional vetting.</div>
        </div>

        <div class="wpedon-ppcp-field wpedon-ppcp-checkbox-field">
            <label>
                <input type="checkbox" id="wpedon-ppcp-sandbox"/> <span class="wpedon-ppcp-cb-view"></span> Sandbox
            </label>
        </div>

        <div class="wpedon-ppcp-buttons">
            <script>
              (function (d, s, id) {
                var js, ref = d.getElementsByTagName(s)[0]
                if (!d.getElementById(id)) {
                  js = d.createElement(s)
                  js.id = id
                  js.async = true
                  js.src =
                    'https://www.paypal.com/webapps/merchantboarding/js/lib/lightbox/partner.js'
                  ref.parentNode.insertBefore(js, ref)
                }
              }(document, 'script', 'paypal-js'))
            </script>
            <a
                    id="wpedon-ppcp-onboarding-start-btn"
                    class="wpedon-ppcp-button"
                    data-paypal-button="true"
                    href="<?php
                            echo add_query_arg(
                                [
                                    'action' => 'wpedon-ppcp-onboarding-start',
                                    'nonce' => wp_create_nonce('wpedon-ppcp-onboarding-start'),
                                    'country' => 'US',
                                    'button-id' => $args['button_id']
                                ],
                                admin_url('admin-ajax.php')
                            ); ?>"
                    target="PPFrame">Connect</a>
            <button id="wpedon-ppcp-setup-account-close-btn" class="wpedon-ppcp-button wpedon-ppcp-button-white">Cancel</button>
        </div>
    </div>
</div>