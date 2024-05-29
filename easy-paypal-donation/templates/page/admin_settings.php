<div class="wrap">
    <form method='post' action='<?php $_SERVER["REQUEST_URI"]; ?>'>
        <!--    tabs menu    -->
        <table width='100%'>
            <tr>
                <td>
                    <br/>
                    <span style="font-size:20pt;">PayPal & Stripe Settings</span>
                </td>
                <td valign="bottom">
                    <input type="submit" name='btn2' class='button-primary'
                           style='font-size: 14px;height: 30px;float: right;' value="Save Settings">
                </td>
            </tr>
        </table>

		<?php if (!empty($_GET['saved'])): ?>
            <div class='updated'><p>Settings Updated.</p></div>
		<?php endif; ?>

        <table width="100%">
            <tr>
                <td valign="top">
                    <script type="text/javascript">
                        function activateTab(e) {
                            e.preventDefault()

                            const id = e.target.id.replace('id', '')

                            for (let i = 1; i <= 5; i++) {
                                document.getElementById(i).style.display = 'none'
                                document.getElementById('id' + i).classList.remove('nav-tab-active')
                            }

                            e.target.classList.add('nav-tab-active')
                            document.getElementById(id).style.display = 'block'
                            document.getElementById('active-tab').value = id

                            return false
                        }
                    </script>

                    <h2 class="nav-tab-wrapper">
                        <a onclick='activateTab(event);' href="#" id="id1"
                           class="nav-tab <?php echo $args['active_tab'] === 1 ? 'nav-tab-active' : ''; ?>">Getting
                            Started</a>
                        <a onclick='activateTab(event);' href="#" id="id2"
                           class="nav-tab <?php echo $args['active_tab'] === 2 ? 'nav-tab-active' : ''; ?>">Language &
                            Currency</a>
                        <a onclick='activateTab(event);' href="#" id="id3"
                           class="nav-tab <?php echo $args['active_tab'] === 3 ? 'nav-tab-active' : ''; ?>">PayPal</a>
                        <a onclick='activateTab(event);' href="#" id="id4"
                           class="nav-tab <?php echo $args['active_tab'] === 4 ? 'nav-tab-active' : ''; ?>">Stripe</a>
                        <a onclick='activateTab(event);' href="#" id="id5"
                           class="nav-tab <?php echo $args['active_tab'] === 5 ? 'nav-tab-active' : ''; ?>">Actions</a>
                    </h2>

                    <br/>

                    <div id="1"
                         style="display:none;border: 1px solid #CCCCCC;<?php echo $args['active_tab'] == '1' ? 'display:block;' : ''; ?>">
                        <div style="background-color:#2271b1;padding:8px;font-size:15px;color:#fff;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
                            Getting Started
                        </div>
                        <div style="background-color:#fff;border: 1px solid #E5E5E5;padding:5px;"><br>
                            <b>1. Connect Payment Accounts</b><br>
                            Connect your PayPal and Stripe accounts. <br><br>

                            <b>2. Make a button</b><br>
                            On the <a href="<?= get_admin_url(null, 'admin.php?page=wpedon_buttons'); ?>"
                                      target="_blank">buttons page</a>, make a new button. <br><br>

                            <b>3. Place button on page</b><br>
                            You can place the button on your site in 3 ways. In you Page / Post editor you can use the
                            button titled "PayPal Donation Button". You can use the "PayPal Donation Button" Widget. Or
                            you can manually place the shortcode on a Page / Post.<br><br>

                            <b>4. View donations</b><br>
                            On the <a href="<?= get_admin_url(null, 'admin.php?page=wpedon_menu'); ?>" target="_blank">donations
                                page</a> you can view the donations that have been made on your site.<br><br>
                        </div>
                    </div>

                    <div id="2"
                         style="display:none;border: 1px solid #CCCCCC;<?php echo $args['active_tab'] == '2' ? 'display:block;' : ''; ?>">
                        <div style="background-color:#2271b1;padding:8px;font-size:15px;color:#fff;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
                            Language & Currency Settings
                        </div>
                        <div style="background-color:#fff;padding:8px;">
                            <table>
                                <tr>
                                    <td colspan="2">
                                        <h3>Language Settings</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Language:</b>
                                    </td>
                                    <td>
                                        <select name="language" style="width: 280px">
                                            <option <?php if ($args['options']['language'] == "default") {
												echo "selected";
											} ?> value="default">Default
                                            </option>
                                            <option <?php if ($args['options']['language'] == "1") {
												echo "selected";
											} ?> value="1">Danish
                                            </option>
                                            <option <?php if ($args['options']['language'] == "2") {
												echo "selected";
											} ?> value="2">Dutch
                                            </option>
                                            <option <?php if ($args['options']['language'] == "3") {
												echo "selected";
											} ?> value="3">English
                                            </option>
                                            <option <?php if ($args['options']['language'] == "20") {
												echo "selected";
											} ?> value="20">English - UK
                                            </option>
                                            <option <?php if ($args['options']['language'] == "4") {
												echo "selected";
											} ?> value="4">French
                                            </option>
                                            <option <?php if ($args['options']['language'] == "5") {
												echo "selected";
											} ?> value="5">German
                                            </option>
                                            <option <?php if ($args['options']['language'] == "6") {
												echo "selected";
											} ?> value="6">Hebrew
                                            </option>
                                            <option <?php if ($args['options']['language'] == "7") {
												echo "selected";
											} ?> value="7">Italian
                                            </option>
                                            <option <?php if ($args['options']['language'] == "8") {
												echo "selected";
											} ?> value="8">Japanese
                                            </option>
                                            <option <?php if ($args['options']['language'] == "9") {
												echo "selected";
											} ?> value="9">Norwegian
                                            </option>
                                            <option <?php if ($args['options']['language'] == "10") {
												echo "selected";
											} ?> value="10">Polish
                                            </option>
                                            <option <?php if ($args['options']['language'] == "11") {
												echo "selected";
											} ?> value="11">Portuguese
                                            </option>
                                            <option <?php if ($args['options']['language'] == "12") {
												echo "selected";
											} ?> value="12">Russian
                                            </option>
                                            <option <?php if ($args['options']['language'] == "13") {
												echo "selected";
											} ?> value="13">Spanish
                                            </option>
                                            <option <?php if ($args['options']['language'] == "14") {
												echo "selected";
											} ?> value="14">Swedish
                                            </option>
                                            <option <?php if ($args['options']['language'] == "15") {
												echo "selected";
											} ?> value="15">Simplified Chinese -China only
                                            </option>
                                            <option <?php if ($args['options']['language'] == "16") {
												echo "selected";
											} ?> value="16">Traditional Chinese - Hong Kong only
                                            </option>
                                            <option <?php if ($args['options']['language'] == "17") {
												echo "selected";
											} ?> value="17">Traditional Chinese - Taiwan only
                                            </option>
                                            <option <?php if ($args['options']['language'] == "18") {
												echo "selected";
											} ?> value="18">Turkish
                                            </option>
                                            <option <?php if ($args['options']['language'] == "19") {
												echo "selected";
											} ?> value="19">Thai
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        PayPal currently supports 18 languages.
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <br/>
                                        <h3>Currency Settings</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Currency:</b>
                                    </td>
                                    <td>
                                        <select name="currency" style="width: 280px">
                                            <option <?php if ($args['options']['currency'] == "1") {
												echo "selected";
											} ?> value="1">Australian Dollar - AUD
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "2") {
												echo "selected";
											} ?> value="2">Brazilian Real - BRL
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "3") {
												echo "selected";
											} ?> value="3">Canadian Dollar - CAD
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "4") {
												echo "selected";
											} ?> value="4">Czech Koruna - CZK
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "5") {
												echo "selected";
											} ?> value="5">Danish Krone - DKK
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "6") {
												echo "selected";
											} ?> value="6">Euro - EUR
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "7") {
												echo "selected";
											} ?> value="7">Hong Kong Dollar - HKD
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "8") {
												echo "selected";
											} ?> value="8">Hungarian Forint - HUF
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "9") {
												echo "selected";
											} ?> value="9">Israeli New Sheqel - ILS
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "10") {
												echo "selected";
											} ?> value="10">Japanese Yen - JPY
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "11") {
												echo "selected";
											} ?> value="11">Malaysian Ringgit - MYR
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "12") {
												echo "selected";
											} ?> value="12">Mexican Peso - MXN
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "13") {
												echo "selected";
											} ?> value="13">Norwegian Krone - NOK
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "14") {
												echo "selected";
											} ?> value="14">New Zealand Dollar - NZD
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "15") {
												echo "selected";
											} ?> value="15">Philippine Peso - PHP
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "16") {
												echo "selected";
											} ?> value="16">Polish Zloty - PLN
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "17") {
												echo "selected";
											} ?> value="17">Pound Sterling - GBP
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "18") {
												echo "selected";
											} ?> value="18">Russian Ruble - RUB
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "19") {
												echo "selected";
											} ?> value="19">Singapore Dollar - SGD
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "20") {
												echo "selected";
											} ?> value="20">Swedish Krona - SEK
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "21") {
												echo "selected";
											} ?> value="21">Swiss Franc - CHF
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "22") {
												echo "selected";
											} ?> value="22">Taiwan New Dollar - TWD
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "23") {
												echo "selected";
											} ?> value="23">Thai Baht - THB
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "24") {
												echo "selected";
											} ?> value="24">Turkish Lira - TRY
                                            </option>
                                            <option <?php if ($args['options']['currency'] == "25") {
												echo "selected";
											} ?> value="25">U.S. Dollar - USD
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        PayPal currently supports 25 currencies.
                                    </td>
                                </tr>
                            </table>
                            <br/>
                            <br/>
                        </div>
                    </div>

                    <div id="3"
                         style="display:none;border: 1px solid #CCCCCC;<?php echo $args['active_tab'] == '3' ? 'display:block;' : ''; ?>">
                        <div style="background-color:#2271b1;padding:8px;font-size:15px;color:#fff;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
                            PayPal Settings
                        </div>
                        <div style="background-color:#fff;padding:8px;">
                            <table>
                                <tr>
                                    <td colspan="2">
                                        <h3>PayPal Account</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <br/>
                                    </td>
                                </tr>
                            </table>
							<?= $args['ppcp_markup']; ?>
                            <table>
                                <tr>
                                    <td colspan="2">
                                        <h3>PayPal Options</h3>
                                    </td>
                                </tr>

                                <tr class="wpedon-paypal-mode">
                                    <td class="wpedon-cell-left">
                                        <b>Sandbox Mode:</b>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if ($args['options']['mode'] == "1") {
												echo "checked='checked'";
											} ?> type='radio' name='mode' value='1'>
                                            On (Sandbox mode)
                                        </label>
                                        &nbsp;
                                        &nbsp;
                                        <label>
                                            <input <?php if ($args['options']['mode'] == "2") {
												echo "checked='checked'";
											} ?> type='radio' name='mode' value='2'>
                                            Off (Live mode)
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Disable PayPal:</b>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if ($args['options']['disable_paypal'] == "1") {
												echo "checked='checked'";
											} ?> type='radio' name='disable_paypal' value='1'>
                                            No
                                        </label>
                                        &nbsp;
                                        &nbsp;
                                        <label>
                                            <input <?php if ($args['options']['disable_paypal'] == "2") {
												echo "checked='checked'";
											} ?> type='radio' name='disable_paypal' value='2'>
                                            Yes
                                        </label>
                                    </td>
                                </tr>
                            </table>
							<?php if (!empty($args['options']['liveaccount']) || !empty($args['options']['sandboxaccount'])): ?>
                                <table>
                                    <tr>
                                        <td colspan='2'>
                                            <h3>PayPal Standard</h3>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="wpedon-cell-left">
                                            <b>Default Button Style:</b>
                                        </td>
                                        <td class="wpedon-cell-flex" colspan='2'>
                                            <label>
                                                <input <?php if ($args['options']['size'] == "1") {
													echo "checked='checked'";
												} ?> type='radio' name='size' value='1'/>
                                                Small<br/>
                                                <img src='https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif'>
                                            </label>
                                            <label>
                                                <input <?php if ($args['options']['size'] == "2") {
													echo "checked='checked'";
												} ?> type='radio' name='size' value='2'>
                                                Big<br/>
                                                <img src='https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif'>
                                            </label>
                                            <label>
                                                <input <?php if ($args['options']['size'] == "3") {
													echo "checked='checked'";
												} ?> type='radio' name='size' value='3'>
                                                Big with Credit Cards<br/>
                                                <img src='https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif'>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="wpedon-cell-left">
                                            <b></b>
                                        </td>
                                        <td class="wpedon-cell-flex" colspan='2'>
                                            <label>
                                                <input <?php if ($args['options']['size'] == "4") {
													echo "checked='checked'";
												} ?> type='radio' name='size' value='4'/>
                                                Small 2 (English only)<br/>
                                                <img src='https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png'>
                                            </label>
                                            <label>
                                                <input <?php if ($args['options']['size'] == "5") {
													echo "checked='checked'";
												} ?> type='radio' name='size' value='5'>
                                                Big 2 (English only)<br/>
                                                <img src='https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png'>
                                            </label>
                                            <label>
                                                <input <?php if ($args['options']['size'] == "6") {
													echo "checked='checked'";
												} ?> type='radio' name='size' value='6'>
                                                Big 2 with Credit Cards (English only)<br/>
                                                <img src='https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png'>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="wpedon-cell-left">
                                            <b></b>
                                        </td>
                                        <td class="wpedon-cell-flex" colspan='2'>
                                            <label>
                                                <input <?php if ($args['options']['size'] == "7") {
													echo "checked='checked'";
												} ?> type='radio' name='size' value='7'/>
                                                Big 3 with logo (English only)<br/>
                                                <img src='https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png'>
                                            </label>
                                            <label>
                                                <input <?php if ($args['options']['size'] == "8") {
													echo "checked='checked'";
												} ?> type='radio' name='size' value='8'/>
                                                <input type='text' id='image_1' name='image_1' size='15'
                                                       value='<?php echo isset($args['options']["image_1"]) ? esc_attr($args['options']["image_1"]) : ''; ?>'>
                                                <input id='_btn' class='upload_image_button' type='button'
                                                       value='Select Image'>
                                                Custom Use your own image <br/>
                                            </label>
                                        </td>
                                    </tr>
									<?php if (!empty($args['options']['liveaccount'])): ?>
                                        <tr>
                                            <td>
                                                <b>Live Account:</b>
                                            </td>
                                            <td>
                                                <input type='text' name='liveaccount'
                                                       value='<?php echo $args['options']['liveaccount']; ?>'/>
                                            </td>
                                        </tr>
									<?php endif; ?>

									<?php if (!empty($args['options']['sandboxaccount'])): ?>
                                        <tr>
                                            <td>
                                                <b>Sandbox Account:</b>
                                            </td>
                                            <td>
                                                <input type='text' name='sandboxaccount'
                                                       value='<?php echo $args['options']['sandboxaccount']; ?>'/>
                                            </td>
                                        </tr>
									<?php endif; ?>

									<?php if (!empty($args['options']['liveaccount']) || !empty($args['options']['sandboxaccount'])): ?>
                                        <tr>
                                            <td></td>
                                            <td>PayPal Standard is now deprecated. You cannot modify your Standard
                                                settings. We highly recommend using PayPal Commerce.
                                            </td>
                                        </tr>
									<?php endif; ?>
                                </table>
							<?php endif; ?>
                            <br/>
                            <br/>
                        </div>
                    </div>

                    <div id="4"
                         style="display:none;border: 1px solid #CCCCCC;<?php echo $args['active_tab'] == '4' ? 'display:block;' : ''; ?>">
                        <div style="background-color:#2271b1;padding:8px;font-size:15px;color:#fff;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
                            Stripe Settings
                        </div>
                        <div style="background-color:#fff;padding:8px;">
                            <table id="wpedon-stripe-connect-table">
                                <tr>
                                    <td colspan="2">
                                        <h3>Stripe Account</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='2'>
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Connection status: </b>
                                    </td>
                                    <td id="stripe-connection-status-html">
										<?= $args['stripe_status_html']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Width:</b>
                                    </td>
                                    <td>
                                        <input type="number" name="stripe_width"
                                               value="<?php echo $args['options']['stripe_width']; ?>"/>
                                        <br/>
                                        Max button width in pixels
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='2'>
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Sandbox Mode:</b>
                                    </td>
                                    <td>
                                        <label>
                                            <input type='radio' name='mode_stripe'
                                                   value='1' <?php echo ($args['options']['mode_stripe'] != '2') ? 'checked' : ''; ?> />
                                            On (Sandbox mode)
                                        </label>
                                        &nbsp; &nbsp;
                                        <label>
                                            <input type='radio' name='mode_stripe'
                                                   value='2' <?php echo ($args['options']['mode_stripe'] == '2') ? 'checked' : ''; ?> />
                                            Off (Live mode)
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Disable Stripe:</b>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if ($args['options']['disable_stripe'] == "1") {
												echo "checked='checked'";
											} ?> type='radio' name='disable_stripe' value='1'>
                                            No
                                        </label>
                                        &nbsp; &nbsp;
                                        <label>
                                            <input <?php if ($args['options']['disable_stripe'] == "2") {
												echo "checked='checked'";
											} ?> type='radio' name='disable_stripe' value='2'>
                                            Yes
                                        </label>
                                    </td>
                                </tr>
                            </table>
                            <br/>
                        </div>
                    </div>

                    <div id="5"
                         style="display:none;border: 1px solid #CCCCCC;<?php echo $args['active_tab'] == '5' ? 'display:block;' : ''; ?>">
                        <div style="background-color:#2271b1;padding:8px;font-size:15px;color:#fff;font-weight: 700;border-bottom: 1px solid #CCCCCC;">
                            Action Settings
                        </div>
                        <div style="background-color:#fff;padding:8px;">
                            <table>
                                <tr>
                                    <td colspan="2">
                                        <h3>Action Settings</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Button opens in:</b>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if ($args['options']['opens'] == "1") {
												echo "checked='checked'";
											} ?> type='radio' name='opens' value='1'>
                                            Same window
                                        </label>
                                        &nbsp; &nbsp;
                                        <label>
                                            <input <?php if ($args['options']['opens'] == "2") {
												echo "checked='checked'";
											} ?> type='radio' name='opens' value='2'>
                                            New window
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left"></td>
                                    <td>
                                        Note: PayPal can only open in a popup window.<br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Prompt buyers for a shipping address:</b>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if ($args['options']['no_shipping'] == "0") {
												echo "checked='checked'";
											} ?> type='radio' name='no_shipping' value='0'>
                                            Yes
                                        </label>
                                        &nbsp; &nbsp;
                                        <label>
                                            <input <?php if ($args['options']['no_shipping'] == "1") {
												echo "checked='checked'";
											} ?> type='radio' name='no_shipping' value='1'>
                                            No
                                        </label>
                                        &nbsp; &nbsp;
                                        <label>
                                            <input <?php if ($args['options']['no_shipping'] == "2") {
												echo "checked='checked'";
											} ?> type='radio' name='no_shipping' value='2'>
                                            Yes, and require
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Prompt buyers to include a note with their payments::</b>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if ($args['options']['no_note'] == "0") {
												echo "checked='checked'";
											} ?> type='radio' name='no_note' value='0'>
                                            Yes
                                        </label>
                                        &nbsp; &nbsp;
                                        <label>
                                            <input <?php if ($args['options']['no_note'] == "1") {
												echo "checked='checked'";
											} ?> type='radio' name='no_note' value='1'>
                                            No
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Default Cancel URL:</b>
                                    </td>
                                    <td>
                                        <input type='text' name='cancel'
                                               value='<?php echo $args['options']['cancel']; ?>'> Optional
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left"></td>
                                    <td>
                                        If the customer goes to PayPal and clicks the cancel button, where do they go.
                                        Example: <?php echo get_site_url(); ?>/cancel. Max length: 1,024.<br/><br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left">
                                        <b>Default Return URL:</b>
                                    </td>
                                    <td>
                                        <input type='text' name='return'
                                               value='<?php echo $args['options']['return']; ?>'> Optional
                                    </td>
                                </tr>
                                <tr>
                                    <td class="wpedon-cell-left"></td>
                                    <td>
                                        If the customer goes to PayPal and successfully pays, where are they redirected
                                        to after. Example: <?php echo get_site_url(); ?>/thankyou. Max length: 1,024.
                                    </td>
                                </tr>
                            </table>
                            <br/>
                        </div>
                    </div>
                </td>
                <td width="3%"></td>
                <td valign="top" width="24%" style="padding-top: 64px;">
                    <div style="background-color:#2271b1;padding:8px;color:#fff;font-size:15px;font-weight:bold;border:1px solid #CCC;border-bottom: none">
                        &nbsp; Get the Pro Version
                    </div>

                    <div style="background-color:#fff;border: 1px solid #CCC;padding:8px;">
                        <center><label style="font-size:14pt;font-weight:bold;">With the Pro version you can: </label>
                        </center>
                        <br/>
                        <div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div>
                        Offer recurring donations<br/>
                        <div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div>
                        Offer daily, weekly, monthly, and yearly billing<br/>
                        <div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div>
                        Set how long should billing should continue<br/>
                        <div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div>
                        Recurring donations dropdown menu<br/>
                        <div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div>
                        Offer up to 20 amount dropdown menu options<br/>
						<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div>
                        No 1% Donation Fee<br/>
						<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Amazing plugin support agents from USA<br />
						<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> No risk, 30 day return policy <br />
						<div class="dashicons dashicons-yes" style="margin-bottom: 6px;"></div> Many more features! <br />
                        <br/>
                        <center><a target='_blank' href="https://wpplugin.org/downloads/paypal-donation-pro/"
                                   class='button-primary' style='font-size: 17px;line-height: 28px;height: 32px;'>Upgrade Now</a></center>
                        <br/>
                    </div>
                    <br/>
                </td>
            </tr>
        </table>

        <input type='hidden' name='update' value='1'>
        <input type='hidden' name='tab' id="active-tab" value="<?php echo $args['active_tab']; ?>">
    </form>
</div>
<script>
    jQuery(document).ready(function () {
        var formfield;
        jQuery('.upload_image_button').click(function () {
            jQuery('html').addClass('Image');
            formfield = jQuery(this).prev().attr('name');
            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
            return false;
        });
        window.original_send_to_editor = window.send_to_editor;
        window.send_to_editor = function (html) {
            if (formfield) {
                fileurl = jQuery('img', html).attr('src');
                jQuery('#' + formfield).val(fileurl);
                tb_remove();
                jQuery('html').removeClass('Image');
            } else {
                window.original_send_to_editor(html);
            }
        };
    });
</script>