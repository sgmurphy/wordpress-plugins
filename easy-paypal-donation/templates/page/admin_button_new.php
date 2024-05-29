<div style="width:98%;">
	<form method='post'>
		<table width="100%">
			<tr>
				<td valign="bottom" width="85%">
					<br/>
					<span style="font-size:20pt;">New Donation Button</span>
				</td>
				<td valign="bottom">
					<input type="submit" class="button-primary" style="font-size: 14px;height: 30px;float: right;"
					       value="Save PayPal & Stripe Donation Button">
				</td>
				<td valign="bottom">
					<a href="<?= get_admin_url(null, 'admin.php?page=wpedon_buttons'); ?>" class="button-secondary"
					   style="font-size: 14px;height: 30px;float: right;">Cancel</a>
				</td>
			</tr>
		</table>
		<!--Errors-->
		<?php if (isset($args['error']) && isset($args['message'])): ?>
			<div class='error'><p><?= $args['message']; ?></p></div>
		<?php endif; ?>
		<br/>
		<div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;"><br/>
			<table>
				<tr>
					<td><b>Main</b></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>
						Purpose / Name:
					</td>
					<td>
						<input type="text" name="wpedon_button_name" value="<?php if (isset($_POST['wpedon_button_name'])) {echo esc_attr($_POST['wpedon_button_name']);}?>">
					</td>
					<td> Optional - The purpose of the donation. If blank, customer enters purpose.</td>
				</tr>
                <tr>
                    <td>
                        Donation Amount Type:
                    </td>
                    <td>
                        <label>
                            <input type="radio" name="wpedon_button_price_type" value="fixed" checked /> Fixed value
                        </label>

                        <label>
                            <input type="radio" name="wpedon_button_price_type" value="manual" /> Manual entry
                        </label>
                    </td>
                    <td></td>
                </tr>
				<tr>
					<td>
						Donation Amount<span id="wpedon-amount-label" style="display:none;"> (default)</span>:
					</td>
					<td>
						<input type="number" required name="wpedon_button_price" value="<?php if (isset($_POST['wpedon_button_price'])) {echo esc_attr($_POST['wpedon_button_price']);}?>">
					</td>
					<td>
						Required - Example: 6.99. If using dropdown prices, enter 1. Minimum amount for Stripe is $1.00
					</td>
				</tr>
				<tr>
					<td>
						Donation ID:
					</td>
					<td>
						<input type="text" name="wpedon_button_id" value="<?php if (isset($_POST['wpedon_button_id'])) {echo esc_attr($_POST['wpedon_button_id']);} ?>">
					</td>
					<td>
						Optional - Example: S12T-Gec-RS.
					</td>
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
					<td>
						<b>Language:</b>
					</td>
					<td>
						<select name="wpedon_button_language" style="width: 190px">
							<?php $wpedon_button_language = isset($_POST['wpedon_button_language']) ? sanitize_text_field($_POST['wpedon_button_language']) : -1; ?>
							<option <?php if ($wpedon_button_language == "0") { echo "SELECTED";} ?> value="0">Default Language</option>
							<option <?php if ($wpedon_button_language == "1") { echo "SELECTED";} ?> value="1">Danish</option>
							<option <?php if ($wpedon_button_language == "2") { echo "SELECTED"; } ?> value="2">Dutch</option>
							<option <?php if ($wpedon_button_language == "3") { echo "SELECTED"; } ?> value="3">English</option>
							<option <?php if ($wpedon_button_language == "20") { echo "SELECTED"; } ?> value="20">English - UK</option>
							<option <?php if ($wpedon_button_language == "4") {  echo "SELECTED"; } ?> value="4">French</option>
							<option <?php if ($wpedon_button_language == "5") { echo "SELECTED"; } ?> value="5">German</option>
							<option <?php if ($wpedon_button_language == "6") { echo "SELECTED"; } ?> value="6">Hebrew</option>
							<option <?php if ($wpedon_button_language == "7") { echo "SELECTED"; } ?> value="7">Italian</option>
							<option <?php if ($wpedon_button_language == "8") { echo "SELECTED"; } ?> value="8">Japanese</option>
							<option <?php if ($wpedon_button_language == "9") { echo "SELECTED"; } ?> value="9">Norwgian</option>
							<option <?php if ($wpedon_button_language == "10") { echo "SELECTED"; } ?> value="10">Polish</option>
							<option <?php if ($wpedon_button_language == "11") { echo "SELECTED";} ?> value="11">Portuguese</option>
							<option <?php if ($wpedon_button_language == "12") { echo "SELECTED"; } ?> value="12">Russian</option>
							<option <?php if ($wpedon_button_language == "13") { echo "SELECTED"; } ?> value="13">Spanish</option>
							<option <?php if ($wpedon_button_language == "14") { echo "SELECTED"; } ?> value="14">Swedish</option>
							<option <?php if ($wpedon_button_language == "15") { echo "SELECTED"; } ?> value="15">Simplified Chinese -China only</option>
							<option <?php if ($wpedon_button_language == "16") { echo "SELECTED"; } ?> value="16">Traditional Chinese - Hong Kong only</option>
							<option <?php if ($wpedon_button_language == "17") { echo "SELECTED"; } ?> value="17">Traditional Chinese - Taiwan only</option>
							<option <?php if ($wpedon_button_language == "18") { echo "SELECTED"; } ?> value="18">Turkish</option>
							<option <?php if ($wpedon_button_language == "19") { echo "SELECTED"; } ?> value="19">Thai</option>
						</select>
					</td>
					<td>Optional - Will override setttings page value.</td>
					<td></td>
				</tr>
				<tr>
					<td>
					</td>
					<td><br/></td>
					<td></td>
				</tr>
				<tr>
					<td><b>Currency:</b></td>
					<td>
						<select name="wpedon_button_currency" style="width: 190px">
							<?php $wpedon_button_currency = isset($_POST['wpedon_button_currency']) ? sanitize_text_field($_POST['wpedon_button_currency']) : -1; ?>
							<option <?php if($wpedon_button_currency == "0") { echo "SELECTED"; } ?> value="0">Default Currency</option>
							<option <?php if($wpedon_button_currency == "1") { echo "SELECTED"; } ?> value="1">Australian Dollar - AUD</option>
							<option <?php if($wpedon_button_currency == "2") { echo "SELECTED"; } ?> value="2">Brazilian Real - BRL</option>
							<option <?php if($wpedon_button_currency == "3") { echo "SELECTED"; } ?> value="3">Canadian Dollar - CAD</option>
							<option <?php if($wpedon_button_currency == "4") { echo "SELECTED"; } ?> value="4">Czech Koruna - CZK</option>
							<option <?php if($wpedon_button_currency == "5") { echo "SELECTED"; } ?> value="5">Danish Krone - DKK</option>
							<option <?php if($wpedon_button_currency == "6") { echo "SELECTED"; } ?> value="6">Euro - EUR</option>
							<option <?php if($wpedon_button_currency == "7") { echo "SELECTED"; } ?> value="7">Hong Kong Dollar - HKD</option>
							<option <?php if($wpedon_button_currency == "8") { echo "SELECTED"; } ?> value="8">Hungarian Forint - HUF</option>
							<option <?php if($wpedon_button_currency == "9") { echo "SELECTED"; } ?> value="9">Israeli New Sheqel - ILS</option>
							<option <?php if($wpedon_button_currency == "10") { echo "SELECTED"; } ?> value="10">Japanese Yen - JPY</option>
							<option <?php if($wpedon_button_currency == "11") { echo "SELECTED"; } ?> value="11">Malaysian Ringgit - MYR</option>
							<option <?php if($wpedon_button_currency == "12") { echo "SELECTED"; } ?> value="12">Mexican Peso - MXN</option>
							<option <?php if($wpedon_button_currency == "13") { echo "SELECTED"; } ?> value="13">Norwegian Krone - NOK</option>
							<option <?php if($wpedon_button_currency == "14") { echo "SELECTED"; } ?> value="14">New Zealand Dollar - NZD</option>
							<option <?php if($wpedon_button_currency == "15") { echo "SELECTED"; } ?> value="15">Philippine Peso - PHP</option>
							<option <?php if($wpedon_button_currency == "16") { echo "SELECTED"; } ?> value="16">Polish Zloty - PLN</option>
							<option <?php if($wpedon_button_currency == "17") { echo "SELECTED"; } ?> value="17">Pound Sterling - GBP</option>
							<option <?php if($wpedon_button_currency == "18") { echo "SELECTED"; } ?> value="18">Russian Ruble - RUB</option>
							<option <?php if($wpedon_button_currency == "19") { echo "SELECTED"; } ?> value="19">Singapore Dollar - SGD</option>
							<option <?php if($wpedon_button_currency == "20") { echo "SELECTED"; } ?> value="20">Swedish Krona - SEK</option>
							<option <?php if($wpedon_button_currency == "21") { echo "SELECTED"; } ?> value="21">Swiss Franc - CHF</option>
							<option <?php if($wpedon_button_currency == "22") { echo "SELECTED"; } ?> value="22">Taiwan New Dollar - TWD</option>
							<option <?php if($wpedon_button_currency == "23") { echo "SELECTED"; } ?> value="23">Thai Baht - THB</option>
							<option <?php if($wpedon_button_currency == "24") { echo "SELECTED"; } ?> value="24">Turkish Lira - TRY</option>
							<option <?php if($wpedon_button_currency == "25") { echo "SELECTED"; } ?> value="25">U.S. Dollar - USD</option>
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
					<td><b>Gateways</b></td>
					<td></td>
					<td></td>
				</tr>
				<tr class="wpedon-product-connection-row">
					<td>PayPal Account:</td>
					<td>You will be able to connect your PayPal account after saving this button</td>
					<td></td>
				</tr>
				<tr class="wpedon-product-connection-row">
					<td>Stripe Account:</td>
					<td>You will be able to connect your Stripe account after saving this button</td>
					<td></td>
				</tr>
				<tr>
					<td><b>Other</b></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Return URL:</td>
					<td>
						<input type="text" name="wpedon_button_return" value="<?php if (isset($_POST['wpedon_button_return'])) { echo esc_attr($_POST['wpedon_button_return']);} ?>">
					</td>
					<td> Optional - Will override setttings page value.</td>
				</tr>
				<tr>
					<td>
						Show Purpose / Name:
					</td>
					<td><input type="checkbox" name="wpedon_button_enable_name" value="1" <?php if (isset($_POST['wpedon_button_enable_name'])) {echo "CHECKED";} ?>></td>
					<td>Optional - Show the purpose / name above the button.</td>
				</tr>
				<tr>
					<td>
						Show Donation Amount:
					</td>
					<td><input type="checkbox" name="wpedon_button_enable_price" value="1" <?php if (isset($_POST['wpedon_button_enable_price'])) { echo "CHECKED"; } ?>></td>
					<td>Optional - Show the donation amount above the button.</td>
				</tr>
				<tr>
					<td>Show Currency:</td>
					<td><input type="checkbox" name="wpedon_button_enable_currency" value="1" <?php if (isset($_POST['wpedon_button_enable_currency'])) { echo "CHECKED"; } ?>></td>
					<td>Optional - Show the currency (example: USD) after the amount.</td>
				</tr>
				<tr>
					<td></td>
					<td><br/></td>
					<td></td>
				</tr>
				<tr>
					<td><b>Dropdown Menus</b> <br/><br/></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>
						Amount Dropdown Menu:
					</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3">
						<table>
							<tr>
								<td>Amount Menu Name: &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</td>
								<td>
									<input type="text" name="wpedon_button_scpriceprice" id="wpedon_button_scpriceprice"
						           value="<?php if (isset($_POST['wpedon_button_scpriceprice'])) { echo esc_attr($_POST['wpedon_button_scpriceprice']); } ?>">
								</td>
								<td>Optional, but required to show menu - show an amount dropdown menu.</td>
							</tr>
							<tr>
								<td>Option / Amount 1:</td>
								<td>
									<input type="text" name="wpedon_button_scpriceaname" id="wpedon_button_scpriceaname"
									       value="<?php if (isset($_POST['wpedon_button_scpriceaname'])) {
										       echo esc_attr($_POST['wpedon_button_scpriceaname']);
									       } ?>"
									       style="width:94px;">
									<input style="width:93px;" type="text"
									       name="wpedon_button_scpricea"
									       id="wpedon_button_scpricea"
									       value="<?php if (isset($_POST['wpedon_button_scpricea'])) {
														echo esc_attr($_POST['wpedon_button_scpricea']);
													} ?>">
								</td>
								<td>Optional</td>
							</tr>
							<tr>
								<td>
									Option / Amount 2:
								</td>
								<td>
									<input type="text" name="wpedon_button_scpricebname" id="wpedon_button_scpricebname"
									       value="<?php
									       if (isset($_POST['wpedon_button_scpricebname'])) {
										       echo esc_attr($_POST['wpedon_button_scpricebname']);
									       } ?>" style="width:94px;">
									<input style="width:93px;" type="text"
									       name="wpedon_button_scpriceb"
									       id="wpedon_button_scpriceb" value="<?php
									if (isset($_POST['wpedon_button_scpriceb'])) {
										echo esc_attr($_POST['wpedon_button_scpriceb']);
									} ?>"></td>
								<td> Optional</td>
							</tr>
							<tr>
								<td>
									Option / Amount 3:
								</td>
								<td>
									<input type="text" name="wpedon_button_scpricecname" id="wpedon_button_scpricecname"
									       value="<?php
									       if (isset($_POST['wpedon_button_scpricecname'])) {
										       echo esc_attr($_POST['wpedon_button_scpricecname']);
									       } ?>" style="width:94px;">
									<input style="width:93px;" type="text"
									       name="wpedon_button_scpricec"
									       id="wpedon_button_scpricec" value="<?php
									if (isset($_POST['wpedon_button_scpricec'])) {
										echo esc_attr($_POST['wpedon_button_scpricec']);
									} ?>">
								</td>
								<td>Optional</td>
							</tr>
							<tr>
								<td>Option / Amount 4:</td>
								<td><input type="text" name="wpedon_button_scpricedname" id="wpedon_button_scpricedname"
								           value="<?php
								           if (isset($_POST['wpedon_button_scpricedname'])) {
									           echo esc_attr($_POST['wpedon_button_scpricedname']);
								           } ?>" style="width:94px;">
									<input style="width:93px;" type="text"
									       name="wpedon_button_scpriced"
									       id="wpedon_button_scpriced" value="<?php
									if (isset($_POST['wpedon_button_scpriced'])) {
										echo esc_attr($_POST['wpedon_button_scpriced']);
									} ?>">
								</td>
								<td>Optional</td>
							</tr>
							<tr>
								<td>Option / Amount 5:</td>
								<td><input type="text" name="wpedon_button_scpriceename" id="wpedon_button_scpriceename"
								           value="<?php
								           if (isset($_POST['wpedon_button_scpriceename'])) {
									           echo esc_attr($_POST['wpedon_button_scpriceename']);
								           } ?>" style="width:94px;">
									<input style="width:93px;" type="text"
									       name="wpedon_button_scpricee"
									       id="wpedon_button_scpricee" value="<?php
									if (isset($_POST['wpedon_button_scpricee'])) {
										echo esc_attr($_POST['wpedon_button_scpricee']);
									} ?>"></td>
								<td> Optional</td>
							</tr>
							<tr>
								<td>Option / Amount 6:</td>
								<td>
									<input type="text" name="wpedon_button_scpricefname" id="wpedon_button_scpricefname"
									       value="<?php
									       if (isset($_POST['wpedon_button_scpricefname'])) {
										       echo esc_attr($_POST['wpedon_button_scpricefname']);
									       } ?>" style="width:94px;">
									<input style="width:93px;" type="text"
									       name="wpedon_button_scpricef"
									       id="wpedon_button_scpricef" value="<?php
									if (isset($_POST['wpedon_button_scpricef'])) {
										echo esc_attr($_POST['wpedon_button_scpricef']);
									} ?>"></td>
								<td>Optional</td>
							</tr>
							<tr>
								<td>Option / Amount 7:</td>
								<td>
									<input type="text" name="wpedon_button_scpricegname" id="wpedon_button_scpricegname"
									       value="<?php
									       if (isset($_POST['wpedon_button_scpricegname'])) {
										       echo esc_attr($_POST['wpedon_button_scpricegname']);
									       } ?>" style="width:94px;">
									<input style="width:93px;" type="text"
									       name="wpedon_button_scpriceg"
									       id="wpedon_button_scpriceg" value="<?php
									if (isset($_POST['wpedon_button_scpriceg'])) {
										echo esc_attr($_POST['wpedon_button_scpriceg']);
									} ?>">
								</td>
								<td>Optional</td>
							</tr>
							<tr>
								<td>
									Option / Amount 8:
								</td>
								<td><input type="text" name="wpedon_button_scpricehname" id="wpedon_button_scpricehname"
								           value="<?php
								           if (isset($_POST['wpedon_button_scpricehname'])) {
									           echo esc_attr($_POST['wpedon_button_scpricehname']);
								           } ?>" style="width:94px;">
									<input style="width:93px;" type="text"
									       name="wpedon_button_scpriceh"
									       id="wpedon_button_scpriceh" value="<?php
									if (isset($_POST['wpedon_button_scpriceh'])) {
										echo esc_attr($_POST['wpedon_button_scpriceh']);
									} ?>">
								</td>
								<td> Optional</td>
							</tr>
							<tr>
								<td>Option / Amount 9:</td>
								<td>
									<input type="text" name="wpedon_button_scpriceiname" id="wpedon_button_scpriceiname"
									       value="<?php
									       if (isset($_POST['wpedon_button_scpriceiname'])) {
										       echo esc_attr($_POST['wpedon_button_scpriceiname']);
									       } ?>" style="width:94px;">
									<input style="width:93px;" type="text"
									       name="wpedon_button_scpricei"
									       id="wpedon_button_scpricei" value="<?php
									if (isset($_POST['wpedon_button_scpricei'])) {
										echo esc_attr($_POST['wpedon_button_scpricei']);
									} ?>">
								</td>
								<td>Optional</td>
							</tr>
							<tr>
								<td>Option / Amount 10:</td>
								<td>
									<input type="text" name="wpedon_button_scpricejname" id="wpedon_button_scpricejname"
									       value="<?php
									       if (isset($_POST['wpedon_button_scpricejname'])) {
										       echo esc_attr($_POST['wpedon_button_scpricejname']);
									       } ?>" style="width:94px;">
									<input style="width:93px;" type="text"
									       name="wpedon_button_scpricej"
									       id="wpedon_button_scpricej" value="<?php
									if (isset($_POST['wpedon_button_scpricej'])) {
										echo esc_attr($_POST['wpedon_button_scpricej']);
									} ?>">
								</td>
								<td>Optional</td>
							</tr>
						</table>
						<?php wp_nonce_field('new_wpedon_button'); ?>
						<input type="hidden" name="update">
					</td>
				</tr>
			</table>
		</div>
	</form>
</div>
