<div style="width:98%;">
    <form method='post'>
		<?php
		$post_id = intval($_GET['product']);
		$post_data = get_post($post_id);
		$title = $post_data->post_title;
		$siteurl = get_site_url();
		?>
        <table width="100%">
            <tr>
                <td valign="bottom" width="85%">
                    <br/>
                    <span style="font-size:20pt;">Edit PayPal & Stripe Donation Button</span>
                </td>
                <td valign="bottom">
                    <input type="submit" class="button-primary" style="font-size: 14px;height: 30px;float: right;"
                           value="Save PayPal & Stripe Donation Button">
                </td>
                <td valign="bottom">
                    <a href="<?= get_admin_url(null, 'admin.php?page=wpedon_buttons'); ?>" class="button-secondary"
                       style="font-size: 14px;height: 30px;float: right;">View All Donation Buttons</a>
                </td>
            </tr>
        </table>

		<?php if (isset($args['error']) && isset($args['message'])): ?>
            <div class='error'><p><?= esc_html($args['message']); ?></p></div>
		<?php endif; ?>
		<?php if (!isset($args['error']) && $args['message']): ?>
            <div class='updated'><p><?= esc_html($args['message']); ?></p></div>
		<?php endif; ?>
        <br/>
        <div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;"><br/>
            <table>
                <tr>
                    <td>
                        <b>Shortcode</b>
                    </td>
                    <td></td>
                    </td></td>
                </tr>
                <tr>
                    <td>
                        Shortcode:
                    </td>
                    <td>
                        <input type="text" readonly value="<?php echo "[wpedon id=$post_id]"; ?>">
                    </td>
                    <td>
                        Put this in a page, post, PayPal widget, or <a target="_blank"
                                                                       href="https://wpplugin.org/documentation/?document=2314">in
                            your theme</a>,
                        to show the PayPal button on your site. <br/>You can also use the button inserter found above
                        the page or post editor.
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><br/></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Main</b></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Purpose / Name:</td>
                    <td>
                        <input type="text" name="wpedon_button_name" value="<?php echo esc_attr($title); ?>">
                    </td>
                    <td> Optional - The purpose of the donation. If blank, customer enters purpose.</td>
                </tr>
	            <?php $price_type = get_post_meta( $post_id, 'wpedon_button_price_type', true ); ?>
                <tr>
                    <td>
                        Donation Amount Type:
                    </td>
                    <td>
                        <label>
                            <input type="radio" name="wpedon_button_price_type" value="fixed" <?= $price_type !== 'manual' ? 'checked' : ''; ?> /> Fixed value
                        </label>

                        <label>
                            <input type="radio" name="wpedon_button_price_type" value="manual" <?= $price_type === 'manual' ? 'checked' : ''; ?> /> Manual entry
                        </label>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Donation Amount<span id="wpedon-amount-label" <?= $price_type === 'manual' ? '' : 'style="display:none;"'; ?>> (default)</span>:</td>
                    <td>
                        <input type="text" name="wpedon_button_price"
                               value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_price', true)); ?>" />
                    </td>
                    <td>Required - Example: 6.99. If using dropdown prices, enter 1. Minimum amount for Stripe is $1.00
                    </td>
                </tr>
                <tr>
                    <td>Donation ID:</td>
                    <td>
                        <input type="text" name="wpedon_button_id"
                               value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_id', true)); ?>">
                    </td>
                    <td> Optional - Example: S12T-Gec-RS.</td>
                </tr>
                <tr>
                    <td></td>
                    <td><br/></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Language & Currency</b></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><br/></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Language:</td>
                    <td>
                        <select name="wpedon_button_language" style="width: 190px">
							<?php $wpedon_button_language = get_post_meta($post_id, 'wpedon_button_language', true); ?>
                            <option <?php if ($wpedon_button_language == "0") {
								echo "SELECTED";
							} ?> value="0">Default Language
                            </option>
                            <option <?php if ($wpedon_button_language == "1") {
								echo "SELECTED";
							} ?> value="1">Danish
                            </option>
                            <option <?php if ($wpedon_button_language == "2") {
								echo "SELECTED";
							} ?> value="2">Dutch
                            </option>
                            <option <?php if ($wpedon_button_language == "3") {
								echo "SELECTED";
							} ?> value="3">English
                            </option>
                            <option <?php if ($wpedon_button_language == "20") {
								echo "SELECTED";
							} ?> value="20">English - UK
                            </option>
                            <option <?php if ($wpedon_button_language == "4") {
								echo "SELECTED";
							} ?> value="4">French
                            </option>
                            <option <?php if ($wpedon_button_language == "5") {
								echo "SELECTED";
							} ?> value="5">German
                            </option>
                            <option <?php if ($wpedon_button_language == "6") {
								echo "SELECTED";
							} ?> value="6">Hebrew
                            </option>
                            <option <?php if ($wpedon_button_language == "7") {
								echo "SELECTED";
							} ?> value="7">Italian
                            </option>
                            <option <?php if ($wpedon_button_language == "8") {
								echo "SELECTED";
							} ?> value="8">Japanese
                            </option>
                            <option <?php if ($wpedon_button_language == "9") {
								echo "SELECTED";
							} ?> value="9">Norwgian
                            </option>
                            <option <?php if ($wpedon_button_language == "10") {
								echo "SELECTED";
							} ?> value="10">Polish
                            </option>
                            <option <?php if ($wpedon_button_language == "11") {
								echo "SELECTED";
							} ?> value="11">Portuguese
                            </option>
                            <option <?php if ($wpedon_button_language == "12") {
								echo "SELECTED";
							} ?> value="12">Russian
                            </option>
                            <option <?php if ($wpedon_button_language == "13") {
								echo "SELECTED";
							} ?> value="13">Spanish
                            </option>
                            <option <?php if ($wpedon_button_language == "14") {
								echo "SELECTED";
							} ?> value="14">Swedish
                            </option>
                            <option <?php if ($wpedon_button_language == "15") {
								echo "SELECTED";
							} ?> value="15">Simplified Chinese -China only
                            </option>
                            <option <?php if ($wpedon_button_language == "16") {
								echo "SELECTED";
							} ?> value="16">Traditional Chinese - Hong Kong only
                            </option>
                            <option <?php if ($wpedon_button_language == "17") {
								echo "SELECTED";
							} ?> value="17">Traditional Chinese - Taiwan only
                            </option>
                            <option <?php if ($wpedon_button_language == "18") {
								echo "SELECTED";
							} ?> value="18">Turkish
                            </option>
                            <option <?php if ($wpedon_button_language == "19") {
								echo "SELECTED";
							} ?> value="19">Thai
                            </option>
                        </select>
                    </td>
                    <td>Optional - Will override setttings page value.</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><br/></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Currency:</td>
                    <td>
                        <select name="wpedon_button_currency" style="width: 190px">
							<?php $wpedon_button_currency = get_post_meta($post_id, 'wpedon_button_currency', true); ?>
                            <option <?php if ($wpedon_button_currency == "0") {
								echo "SELECTED";
							} ?> value="0">Default Currency
                            </option>
                            <option <?php if ($wpedon_button_currency == "1") {
								echo "SELECTED";
							} ?> value="1">Australian Dollar - AUD
                            </option>
                            <option <?php if ($wpedon_button_currency == "2") {
								echo "SELECTED";
							} ?> value="2">Brazilian Real - BRL
                            </option>
                            <option <?php if ($wpedon_button_currency == "3") {
								echo "SELECTED";
							} ?> value="3">Canadian Dollar - CAD
                            </option>
                            <option <?php if ($wpedon_button_currency == "4") {
								echo "SELECTED";
							} ?> value="4">Czech Koruna - CZK
                            </option>
                            <option <?php if ($wpedon_button_currency == "5") {
								echo "SELECTED";
							} ?> value="5">Danish Krone - DKK
                            </option>
                            <option <?php if ($wpedon_button_currency == "6") {
								echo "SELECTED";
							} ?> value="6">Euro - EUR
                            </option>
                            <option <?php if ($wpedon_button_currency == "7") {
								echo "SELECTED";
							} ?> value="7">Hong Kong Dollar - HKD
                            </option>
                            <option <?php if ($wpedon_button_currency == "8") {
								echo "SELECTED";
							} ?> value="8">Hungarian Forint - HUF
                            </option>
                            <option <?php if ($wpedon_button_currency == "9") {
								echo "SELECTED";
							} ?> value="9">Israeli New Sheqel - ILS
                            </option>
                            <option <?php if ($wpedon_button_currency == "10") {
								echo "SELECTED";
							} ?> value="10">Japanese Yen - JPY
                            </option>
                            <option <?php if ($wpedon_button_currency == "11") {
								echo "SELECTED";
							} ?> value="11">Malaysian Ringgit - MYR
                            </option>
                            <option <?php if ($wpedon_button_currency == "12") {
								echo "SELECTED";
							} ?> value="12">Mexican Peso - MXN
                            </option>
                            <option <?php if ($wpedon_button_currency == "13") {
								echo "SELECTED";
							} ?> value="13">Norwegian Krone - NOK
                            </option>
                            <option <?php if ($wpedon_button_currency == "14") {
								echo "SELECTED";
							} ?> value="14">New Zealand Dollar - NZD
                            </option>
                            <option <?php if ($wpedon_button_currency == "15") {
								echo "SELECTED";
							} ?> value="15">Philippine Peso - PHP
                            </option>
                            <option <?php if ($wpedon_button_currency == "16") {
								echo "SELECTED";
							} ?> value="16">Polish Zloty - PLN
                            </option>
                            <option <?php if ($wpedon_button_currency == "17") {
								echo "SELECTED";
							} ?> value="17">Pound Sterling - GBP
                            </option>
                            <option <?php if ($wpedon_button_currency == "18") {
								echo "SELECTED";
							} ?> value="18">Russian Ruble - RUB
                            </option>
                            <option <?php if ($wpedon_button_currency == "19") {
								echo "SELECTED";
							} ?> value="19">Singapore Dollar - SGD
                            </option>
                            <option <?php if ($wpedon_button_currency == "20") {
								echo "SELECTED";
							} ?> value="20">Swedish Krona - SEK
                            </option>
                            <option <?php if ($wpedon_button_currency == "21") {
								echo "SELECTED";
							} ?> value="21">Swiss Franc - CHF
                            </option>
                            <option <?php if ($wpedon_button_currency == "22") {
								echo "SELECTED";
							} ?> value="22">Taiwan New Dollar - TWD
                            </option>
                            <option <?php if ($wpedon_button_currency == "23") {
								echo "SELECTED";
							} ?> value="23">Thai Baht - THB
                            </option>
                            <option <?php if ($wpedon_button_currency == "24") {
								echo "SELECTED";
							} ?> value="24">Turkish Lira - TRY
                            </option>
                            <option <?php if ($wpedon_button_currency == "25") {
								echo "SELECTED";
							} ?> value="25">U.S. Dollar - USD
                            </option>
                        </select>
                    </td>
                    <td>Optional - Will override setttings page value.</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><br/></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>PayPal</b></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="wpedon-product-connection-row">
                    <td>
                        PayPal Account:
                    </td>
                    <td>
						<?php $ppcp = new \WPEasyDonation\Base\PpcpController();
						$ppcp->status_markup($post_id); ?>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <b>PayPal Payments Methods Accepted</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        PayPal:
                    </td>
                    <td>
						<?php $ppcp_funding_paypal = get_post_meta($post_id, 'ppcp_funding_paypal', true); ?>
                        <select name="ppcp_funding_paypal" class="wpedon-button-settings-select">
                            <option value="" <?php echo !in_array($ppcp_funding_paypal, ['0', '1']) ? 'selected' : ''; ?>>
                                Default Value
                            </option>
                            <option value="1" <?php echo $ppcp_funding_paypal == '1' ? 'selected' : ''; ?>>On</option>
                            <option value="0" <?php echo $ppcp_funding_paypal == '0' ? 'selected' : ''; ?>>Off</option>
                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td>
                        PayPal PayLater:
                    </td>
                    <td>
						<?php $ppcp_funding_paylater = get_post_meta($post_id, 'ppcp_funding_paylater', true); ?>
                        <select name="ppcp_funding_paylater" class="wpedon-button-settings-select">
                            <option value="" <?php echo !in_array($ppcp_funding_paylater, ['0', '1']) ? 'selected' : ''; ?>>
                                Default Value
                            </option>
                            <option value="1" <?php echo $ppcp_funding_paylater == '1' ? 'selected' : ''; ?>>On</option>
                            <option value="0" <?php echo $ppcp_funding_paylater == '0' ? 'selected' : ''; ?>>Off
                            </option>
                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td>
                        Venmo:
                    </td>
                    <td>
						<?php $ppcp_funding_venmo = get_post_meta($post_id, 'ppcp_funding_venmo', true); ?>
                        <select name="ppcp_funding_venmo" class="wpedon-button-settings-select">
                            <option value="" <?php echo !in_array($ppcp_funding_venmo, ['0', '1']) ? 'selected' : ''; ?>>
                                Default Value
                            </option>
                            <option value="1" <?php echo $ppcp_funding_venmo == '1' ? 'selected' : ''; ?>>On</option>
                            <option value="0" <?php echo $ppcp_funding_venmo == '0' ? 'selected' : ''; ?>>Off</option>
                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td>
                        Local Alternative Payment Methods:
                    </td>
                    <td>
						<?php $ppcp_funding_alternative = get_post_meta($post_id, 'ppcp_funding_alternative', true); ?>
                        <select name="ppcp_funding_alternative" class="wpedon-button-settings-select">
                            <option value="" <?php echo !in_array($ppcp_funding_alternative, ['0', '1']) ? 'selected' : ''; ?>>
                                Default Value
                            </option>
                            <option value="1" <?php echo $ppcp_funding_alternative == '1' ? 'selected' : ''; ?>>On
                            </option>
                            <option value="0" <?php echo $ppcp_funding_alternative == '0' ? 'selected' : ''; ?>>Off
                            </option>
                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td>
                        Credit & Debit Cards:
                    </td>
                    <td>
						<?php $ppcp_funding_cards = get_post_meta($post_id, 'ppcp_funding_cards', true); ?>
                        <select name="ppcp_funding_cards" class="wpedon-button-settings-select">
                            <option value="" <?php echo !in_array($ppcp_funding_cards, ['0', '1']) ? 'selected' : ''; ?>>
                                Default Value
                            </option>
                            <option value="1" <?php echo $ppcp_funding_cards == '1' ? 'selected' : ''; ?>>On</option>
                            <option value="0" <?php echo $ppcp_funding_cards == '0' ? 'selected' : ''; ?>>Off</option>

                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td>
                        Advanced Credit & Debit Cards (ACDC):
                    </td>
                    <td>
						<?php $ppcp_funding_advanced_cards = get_post_meta($post_id, 'ppcp_funding_advanced_cards', true); ?>
                        <select name="ppcp_funding_advanced_cards" class="wpedon-button-settings-select">
                            <option value="" <?php echo !in_array($ppcp_funding_advanced_cards, ['0', '1']) ? 'selected' : ''; ?>>
                                Default Value
                            </option>
                            <option value="1" <?php echo $ppcp_funding_advanced_cards == '1' ? 'selected' : ''; ?>>On
                            </option>
                            <option value="0" <?php echo $ppcp_funding_advanced_cards == '0' ? 'selected' : ''; ?>>Off
                            </option>
                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td>
                        ACDC Button text:
                    </td>
                    <td>
                        <input type="text" name="wpedon_button_ppcp_acdc_button_text"
                               value="<?php echo get_post_meta($post_id, 'wpedon_button_ppcp_acdc_button_text', true); ?>"/>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <b>PayPal Checkout Buttons</b>
                    </td>
                </tr>

                <tr>
                    <td>
                        Layout:
                    </td>
                    <td>
						<?php $ppcp_layout = get_post_meta($post_id, 'ppcp_layout', true); ?>
                        <select name="ppcp_layout" class="wpedon-button-settings-select">
                            <option value="" <?php echo !in_array($ppcp_layout, ['horizontal', 'vertical']) ? 'selected' : ''; ?>>
                                Default Value
                            </option>
                            <option value="horizontal" <?php echo $ppcp_layout == 'horizontal' ? 'selected' : ''; ?>>
                                Horizontal
                            </option>
                            <option value="vertical" <?php echo $ppcp_layout == 'vertical' ? 'selected' : ''; ?>>
                                Vertical
                            </option>
                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td>
                        Color:
                    </td>
                    <td>
						<?php $ppcp_color = get_post_meta($post_id, 'ppcp_color', true); ?>
                        <select name="ppcp_color" class="wpedon-button-settings-select">
                            <option value="" <?php echo !in_array($ppcp_color, ['gold', 'blue', 'black', 'silver', 'white']) ? 'selected' : ''; ?>>
                                Default Value
                            </option>
                            <option value="gold" <?php echo $ppcp_color == 'gold' ? 'selected' : ''; ?>>Gold</option>
                            <option value="blue" <?php echo $ppcp_color == 'blue' ? 'selected' : ''; ?>>Blue</option>
                            <option value="black" <?php echo $ppcp_color == 'black' ? 'selected' : ''; ?>>Black</option>
                            <option value="silver" <?php echo $ppcp_color == 'silver' ? 'selected' : ''; ?>>Silver
                            </option>
                            <option value="white" <?php echo $ppcp_color == 'white' ? 'selected' : ''; ?>>White</option>
                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td>
                        Shape:
                    </td>
                    <td>
						<?php $ppcp_shape = get_post_meta($post_id, 'ppcp_shape', true); ?>
                        <select name="ppcp_shape" class="wpedon-button-settings-select">
                            <option value="" <?php echo !in_array($ppcp_shape, ['rect', 'pill']) ? 'selected' : ''; ?>>
                                Default Value
                            </option>
                            <option value="rect" <?php echo $ppcp_shape == 'rect' ? 'selected' : ''; ?>>Rectangle
                            </option>
                            <option value="pill" <?php echo $ppcp_shape == 'pill' ? 'selected' : ''; ?>>Pill</option>
                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td>
                        Height:
                    </td>
                    <td>
                        <input type="number" name="ppcp_height"
                               value="<?php echo get_post_meta($post_id, 'ppcp_height', true); ?>" min="25" max="55"/>
                        <br/>
                        25 - 55, a value around 40 is recommended
                        &nbsp;
                        &nbsp;
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td>
                        PayPal buttons width:
                    </td>
                    <td>
                        <input type="number" name="wpedon_button_ppcp_width"
                               value="<?php echo get_post_meta($post_id, 'wpedon_button_ppcp_width', true); ?>"/>
                        <br/>
                        Max buttons width in pixels
                        &nbsp;
                        &nbsp;
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td>PayPal Sandbox Mode:</td>
					<?php $paypal_mode = get_post_meta($post_id, '_wpedon_paypal_mode', true); ?>
                    <td id="paypal-mode">
                        <select name="mode" class="wpedon-button-settings-select">
                            <option value="" <?php echo !in_array($paypal_mode, ['1', '2']) ? 'selected' : ''; ?>>
                                Default Value
                            </option>
                            <option value="1" <?php echo $paypal_mode == '1' ? 'selected' : ''; ?>>On (Sandbox mode)
                            </option>
                            <option value="2" <?php echo $paypal_mode == '2' ? 'selected' : ''; ?>>Off (Live mode)
                            </option>
                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <b>Stripe</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        Disable Stripe:
                    </td>
                    <td>
						<?php $disable_stripe = get_post_meta($post_id, 'wpedon_button_disable_stripe', true); ?>
                        <select name="wpedon_button_disable_stripe" class="wpedon-button-settings-select">
                            <option value="0" <?php if ($disable_stripe == "0") {
								echo "selected";
							} ?>>Default Value
                            </option>
                            <option value="1" <?php if ($disable_stripe == "1") {
								echo "selected";
							} ?>>No
                            </option>
                            <option value="2" <?php if ($disable_stripe == "2") {
								echo "selected";
							} ?>>Yes
                            </option>
                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr class="wpedon-product-connection-row">
                    <td>Stripe Account:</td>
                    <td id="stripe-connection-status-html">
						<?php
						$stripe = new \WPEasyDonation\Base\Stripe();
						echo $stripe->connection_status_html($post_id);
						?></td>
                    <td>Optional - Will override settings page value.</td>
                </tr>
                <tr class="wpedon-product-connection-row">
                    <td>
                        Stripe button width:
                    </td>
                    <td>
                        <input type="number" name="wpedon_button_stripe_width"
                               value="<?php echo get_post_meta($post_id, 'wpedon_button_stripe_width', true); ?>"/>
                        <br/>
                        Max buttons width in pixels
                        &nbsp;
                        &nbsp;
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
                <tr class="wpedon-product-connection-row" data-id="<?php echo $post_id; ?>">
                    <td>Stripe Sandbox Mode:</td>
					<?php $stripe_mode = get_post_meta($post_id, '_wpedon_stripe_mode', true); ?>
                    <td>
                        <select name="mode_stripe" class="wpedon-button-settings-select">
                            <option value="" <?php echo !in_array($stripe_mode, ['1', '2']) ? 'selected' : ''; ?>>
                                Default Value
                            </option>
                            <option value="1" <?php echo $stripe_mode == '1' ? 'selected' : ''; ?>>On (Sandbox mode)
                            </option>
                            <option value="2" <?php echo $stripe_mode == '2' ? 'selected' : ''; ?>>Off (Live mode)
                            </option>
                        </select>
                    </td>
                    <td> Optional - Will override settings page value.</td>
                </tr>
				<tr>
					<td><b>Other</b></td>
					<td></td>
					<td></td>
				</tr>
                <tr>
                    <td>Return URL:</td>
                    <td>
                        <input type="text" name="wpedon_button_return"
                               value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_return', true)); ?>">
                    </td>
                    <td> Optional - Will override setttings page value. <br/>Example: <?php echo $siteurl; ?>/thankyou
                    </td>
                </tr>
                <tr>
                    <td>Show Purpose / Name:</td>
                    <td>
                        <input type="checkbox" name="wpedon_button_enable_name"
                               value="1" <?php if (get_post_meta($post_id, 'wpedon_button_enable_name', true) == "1") {
							echo "CHECKED";
						} ?>>
                    </td>
                    <td>Optional - Show the purpose / name above the button.</td>
                </tr>
                <tr>
                    <td>Show Donation Amount:</td>
                    <td>
                        <input type="checkbox" name="wpedon_button_enable_price"
                               value="1" <?php if (get_post_meta($post_id, 'wpedon_button_enable_price', true) == "1") {
							echo "CHECKED";
						} ?>>
                    </td>
                    <td>Optional - Show the donation amount above the button.</td>
                </tr>
                <tr>
                    <td>Show Currency:</td>
                    <td>
                        <input type="checkbox" name="wpedon_button_enable_currency"
                               value="1" <?php if (get_post_meta($post_id, 'wpedon_button_enable_currency', true) == "1") {
							echo "CHECKED";
						} ?>>
                    </td>
                    <td>Optional - Show the currency (example: USD) after the amount.</td>
                </tr>
                <tr>
                    <td></td>
                    <td><br/></td>
                    <td></td>
                </tr>
				<?php if (get_post_meta($post_id, 'wpedon_button_account', true)): ?>
                    <tr>
                        <td colspan="3">
                            <b>PayPal Standard</b> (is now deprecated)
                        </td>
                    </tr>
                    <tr>
                        <td>PayPal Standard:</td>
                        <td>
                            <input readonly type="text" name="wpedon_button_account"
                                   value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_account', true)); ?>">
                        </td>
                        <td> PayPal Standard is now deprecated. You cannot modify your Standard settings. We highly
                            recommend using PayPal Commerce.
                        </td>
                    </tr>
                    <tr>
                        <td>PayPal Button Size:</td>
                        <td>
                            <select name="wpedon_button_buttonsize" style="width:190px;">
								<?php $wpedon_button_buttonsize = get_post_meta($post_id, 'wpedon_button_buttonsize', true); ?>
                                <option value="0" <?php if ($wpedon_button_buttonsize == "0") {
									echo "SELECTED";
								} ?>>Default Button
                                </option>
                                <option value="1" <?php if ($wpedon_button_buttonsize == "1") {
									echo "SELECTED";
								} ?>>Small
                                </option>
                                <option value="2" <?php if ($wpedon_button_buttonsize == "2") {
									echo "SELECTED";
								} ?>>Big
                                </option>
                                <option value="3" <?php if ($wpedon_button_buttonsize == "3") {
									echo "SELECTED";
								} ?>>Big with Credit Cards
                                </option>
                                <option value="4" <?php if ($wpedon_button_buttonsize == "4") {
									echo "SELECTED";
								} ?>>Small 2 (English only)
                                </option>
                                <option value="5" <?php if ($wpedon_button_buttonsize == "5") {
									echo "SELECTED";
								} ?>>Big 2 (English only)
                                </option>
                                <option value="6" <?php if ($wpedon_button_buttonsize == "6") {
									echo "SELECTED";
								} ?>>Big 2 with Credit Cards (English only)
                                </option>
                                <option value="7" <?php if ($wpedon_button_buttonsize == "7") {
									echo "SELECTED";
								} ?>>Big 3 with logo (English only)
                                </option>
                                <option value="8" <?php if ($wpedon_button_buttonsize == "8") {
									echo "SELECTED";
								} ?>>Custom
                                </option>
                            </select>
                        </td>
                        <td> Optional - Will override setttings page value.</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><br/></td>
                        <td></td>
                    </tr>
				<?php endif; ?>
                <tr>
                    <td><b>Dropdown Menu</b> <br/><br/></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Amount Dropdown Menu:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
                            <tr>
                                <td>
                                    Amount Menu Name: &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                                </td>
                                <td>
                                    <input type="text" name="wpedon_button_scpriceprice" id="wpedon_button_scpriceprice"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpriceprice', true)); ?>">
                                </td>
                                <td> Optional, but required to show menu - show an amount dropdown menu.</td>
                            </tr>
                            <tr>
                                <td>Option / Amount 1:</td>
                                <td>
                                    <input type="text" name="wpedon_button_scpriceaname" id="wpedon_button_scpriceaname"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpriceaname', true)); ?>"
                                           style="width:94px;">
                                    <input style="width:93px;" type="text" name="wpedon_button_scpricea"
                                           id="wpedon_button_scpricea"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricea', true)); ?>">
                                </td>
                                <td> Optional - Example Option: Size Medium Example Amount: 5.00</td>
                            </tr>
                            <tr>
                                <td>Option / Amount 2:</td>
                                <td>
                                    <input type="text" name="wpedon_button_scpricebname" id="wpedon_button_scpricebname"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricebname', true)); ?>"
                                           style="width:94px;">
                                    <input style="width:93px;" type="text" name="wpedon_button_scpriceb"
                                           id="wpedon_button_scpriceb"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpriceb', true)); ?>">
                                </td>
                                <td> Optional</td>
                            </tr>
                            <tr>
                                <td>Option / Amount 3:</td>
                                <td>
                                    <input type="text" name="wpedon_button_scpricecname" id="wpedon_button_scpricecname"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricecname', true)); ?>"
                                           style="width:94px;">
                                    <input style="width:93px;" type="text" name="wpedon_button_scpricec"
                                           id="wpedon_button_scpricec"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricec', true)); ?>">
                                </td>
                                <td> Optional</td>
                            </tr>
                            <tr>
                                <td>Option / Amount 4:</td>
                                <td>
                                    <input type="text" name="wpedon_button_scpricedname" id="wpedon_button_scpricedname"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricedname', true)); ?>"
                                           style="width:94px;">
                                    <input style="width:93px;" type="text" name="wpedon_button_scpriced"
                                           id="wpedon_button_scpriced"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpriced', true)); ?>">
                                </td>
                                <td> Optional</td>
                            </tr>
                            <tr>
                                <td>Option / Amount 5:</td>
                                <td>
                                    <input type="text" name="wpedon_button_scpriceename" id="wpedon_button_scpriceename"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpriceename', true)); ?>"
                                           style="width:94px;">
                                    <input style="width:93px;" type="text" name="wpedon_button_scpricee"
                                           id="wpedon_button_scpricee"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricee', true)); ?>">
                                </td>
                                <td> Optional</td>
                            </tr>
                            <tr>
                                <td>Option / Amount 6:</td>
                                <td>
                                    <input type="text" name="wpedon_button_scpricefname" id="wpedon_button_scpricefname"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricefname', true)); ?>"
                                           style="width:94px;">
                                    <input style="width:93px;" type="text" name="wpedon_button_scpricef"
                                           id="wpedon_button_scpricef"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricef', true)); ?>">
                                </td>
                                <td> Optional</td>
                            </tr>
                            <tr>
                                <td>Option / Amount 7:</td>
                                <td>
                                    <input type="text" name="wpedon_button_scpricegname" id="wpedon_button_scpricegname"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricegname', true)); ?>"
                                           style="width:94px;">
                                    <input style="width:93px;" type="text" name="wpedon_button_scpriceg"
                                           id="wpedon_button_scpriceg"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpriceg', true)); ?>">
                                </td>
                                <td> Optional</td>
                            </tr>
                            <tr>
                                <td>Option / Amount 8:</td>
                                <td>
                                    <input type="text" name="wpedon_button_scpricehname" id="wpedon_button_scpricehname"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricehname', true)); ?>"
                                           style="width:94px;">
                                    <input style="width:93px;" type="text" name="wpedon_button_scpriceh"
                                           id="wpedon_button_scpriceh"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpriceh', true)); ?>">
                                </td>
                                <td> Optional</td>
                            </tr>
                            <tr>
                                <td>Option / Amount 9:</td>
                                <td>
                                    <input type="text" name="wpedon_button_scpriceiname" id="wpedon_button_scpriceiname"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpriceiname', true)); ?>"
                                           style="width:94px;">
                                    <input style="width:93px;" type="text" name="wpedon_button_scpricei"
                                           id="wpedon_button_scpricei"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricei', true)); ?>">
                                </td>
                                <td> Optional</td>
                            </tr>
                            <tr>
                                <td>Option / Amount 10:</td>
                                <td>
                                    <input type="text" name="wpedon_button_scpricejname" id="wpedon_button_scpricejname"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricejname', true)); ?>"
                                           style="width:94px;">
                                    <input style="width:93px;" type="text" name="wpedon_button_scpricej"
                                           id="wpedon_button_scpricej"
                                           value="<?php echo esc_attr(get_post_meta($post_id, 'wpedon_button_scpricej', true)); ?>">
                                </td>
                                <td> Optional</td>
                            </tr>
                        </table>
						<?php wp_nonce_field('edit_' . $post_id); ?>
                        <input type="hidden" name="update">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>