<div id="wpedon-ppcp-status-table">
	<table>
		<tr>
			<?php if ( $args['button_id'] === 'general' ): ?>
				<td class="wpedon-cell-left">
					<b>Connection status: </b>
				</td>
			<?php endif; ?>
			<td>
				<div class="notice inline wpedon-ppcp-connect notice-<?php echo $args['notice_type']; ?>">
					<p>
						<?php if ( !empty( $args['status']['legal_name'] ) ): ?>
							<strong><?php echo $args['status']['legal_name']; ?></strong>
							<br>
						<?php endif; ?>
						<?php echo !empty( $args['status']['primary_email'] ) ? $args['status']['primary_email'] . ' — ' : ''; ?>Administrator (Owner)
					</p>
				</div>
				<div>
					<?php $reconnect_mode = $args['status']['env'] === 'live' ? 'sandbox' : 'live'; ?>
					Your PayPal account is connected in <strong><?php echo $args['status']['env']; ?></strong> mode.
					<a href="#TB_inline?&inlineId=wpedon-ppcp-setup-account-modal" class="wpedon-ppcp-onboarding-start thickbox" data-connect-mode="<?php echo $reconnect_mode; ?>">
						Connect in <strong><?php echo $reconnect_mode; ?></strong> mode
					</a> or <a href="#" id="wpedon-ppcp-disconnect" data-button-id="<?php echo $args['button_id']; ?>">disconnect this account</a>.
				</div>

				<?php if ( $args['status']['mode'] === 'error' ): ?>
					<p>
						<strong>There were errors connecting your PayPal account. Resolve them in your account settings, by contacting support or by reconnecting your PayPal account.</strong>
					</p>
					<?php if ( !empty( $args['status']['errors'] ) ): ?>
						<p>
							<strong>See below for more details.</strong>
						</p>
						<ul class="wpedon-ppcp-list wpedon-ppcp-list-error">
							<?php foreach ( $args['status']['errors'] as $error ): ?>
								<li><?php echo $error; ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				<?php elseif ( !empty( $args['status']['warnings'] ) ): ?>
					<p>
						<strong>Please review the warnings below and resolve them in your account settings or by contacting support.</strong>
					</p>
					<ul class="wpedon-ppcp-list wpedon-ppcp-list-warning">
						<?php foreach ( $args['status']['warnings'] as $warning ): ?>
							<li><?php echo $warning; ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $args['show_links'] ): ?>
					<ul class="wpedon-ppcp-list">
						<li><a href="https://www.paypal.com/myaccount/settings/" target="_blank">PayPal account settings</a></li>
						<li><a href="https://www.paypal.com/us/smarthelp/contact-us" target="_blank">PayPal support</a></li>
					</ul>
				<?php endif; ?>
			</td>
		</tr>
	</table>

	<?php if ( $args['show_settings'] &&  $args['button_id'] === 'general' ): ?>
		<table>
			<tr>
				<td colspan="2">
					<br />
					<h3>Payments Methods Accepted</h3>
				</td>
			</tr>
			<tr>
				<td class="wpedon-cell-left">
					<b>PayPal:</b>
				</td>
				<td>
					<label>
						<input type="radio" name="ppcp_funding_paypal" value="1" <?php echo !empty( $args['options']['ppcp_funding_paypal'] ) ? 'checked ' : ''; ?>/>
						On
					</label>
					&nbsp;
					&nbsp;
					<label>
						<input type="radio" name="ppcp_funding_paypal" value="0" <?php echo empty( $args['options']['ppcp_funding_paypal'] ) ? 'checked ' : ''; ?>/>
						Off
					</label>
				</td>
			</tr>
			<tr>
				<td class="wpedon-cell-left">
					<b>PayPal PayLater:</b>
				</td>
				<td>
					<label>
						<input type="radio" name="ppcp_funding_paylater" value="1" <?php echo !empty( $args['options']['ppcp_funding_paylater'] ) ? 'checked ' : ''; ?>/>
						On
					</label>
					&nbsp;
					&nbsp;
					<label>
						<input type="radio" name="ppcp_funding_paylater" value="0" <?php echo empty( $args['options']['ppcp_funding_paylater'] ) ? 'checked ' : ''; ?>/>
						Off
					</label>
				</td>
			</tr>
			<tr>
				<td class="wpedon-cell-left">
					<b>Venmo:</b>
				</td>
				<td>
					<label>
						<input type="radio" name="ppcp_funding_venmo" value="1" <?php echo !empty( $args['options']['ppcp_funding_venmo'] ) ? 'checked ' : ''; ?>/>
						On
					</label>
					&nbsp;
					&nbsp;
					<label>
						<input type="radio" name="ppcp_funding_venmo" value="0" <?php echo empty( $args['options']['ppcp_funding_venmo'] ) ? 'checked ' : ''; ?>/>
						Off
					</label>
				</td>
			</tr>
			<tr>
				<td class="wpedon-cell-left">
					<b>Local Alternative Payment Methods:</b>
				</td>
				<td>
					<label>
						<input type="radio" name="ppcp_funding_alternative" value="1" <?php echo !empty( $args['options']['ppcp_funding_alternative'] ) ? 'checked ' : ''; ?>/>
						On
					</label>
					&nbsp;
					&nbsp;
					<label>
						<input type="radio" name="ppcp_funding_alternative" value="0" <?php echo empty( $args['options']['ppcp_funding_alternative'] ) ? 'checked ' : ''; ?>/>
						Off
					</label>
				</td>
			</tr>
			<tr>
				<td class="wpedon-cell-left">
					<b>Credit & Debit Cards:</b>
				</td>
				<td>
					<label>
						<input type="radio" name="ppcp_funding_cards" value="1" <?php echo !empty( $args['options']['ppcp_funding_cards'] ) ? 'checked ' : ''; ?>/>
						On
					</label>
					&nbsp;
					&nbsp;
					<label>
						<input type="radio" name="ppcp_funding_cards" value="0" <?php echo empty( $args['options']['ppcp_funding_cards'] ) ? 'checked ' : ''; ?>/>
						Off
					</label>
				</td>
			</tr>

			<?php if ( $args['status']['mode'] === 'advanced' ) { ?>
				<tr>
					<td class="wpedon-cell-left">
						<b>Advanced Credit & Debit Cards (ACDC):</b>
					</td>
					<td>
						<label>
							<input type="radio" name="ppcp_funding_advanced_cards" value="1" <?php echo !empty( $args['options']['ppcp_funding_advanced_cards'] ) ? 'checked ' : ''; ?>/>
							On
						</label>
						&nbsp;
						&nbsp;
						<label>
							<input type="radio" name="ppcp_funding_advanced_cards" value="0" <?php echo empty( $args['options']['ppcp_funding_advanced_cards'] ) ? 'checked ' : ''; ?>/>
							Off
						</label>
					</td>
				</tr>
				<tr>
					<td class="wpedon-cell-left">
						<b>ACDC Button text:</b>
					</td>
					<td>
						<input type="text" name="ppcp_acdc_button_text" value="<?php echo $args['options']['ppcp_acdc_button_text']; ?>" />
						<br />
						Payment button text
					</td>
				</tr>
			<?php } ?>

			<tr>
				<td colspan="2">
					<br />
					<h3>PayPal Checkout Buttons</h3>
				</td>
			</tr>
			<tr>
				<td class="wpedon-cell-left">
					<b>Layout:</b>
				</td>
				<td>
					<label>
						<input type="radio" name="ppcp_layout" value="horizontal" <?php echo $args['options']['ppcp_layout'] === 'horizontal' ? 'checked ' : ''; ?>/>
						Horizontal
					</label>
					&nbsp;
					&nbsp;
					<label>
						<input type="radio" name="ppcp_layout" value="vertical" <?php echo $args['options']['ppcp_layout'] === 'vertical' ? 'checked ' : ''; ?>/>
						Vertical
					</label>
				</td>
			</tr>
			<tr>
				<td class="wpedon-cell-left">
					<b>Color:</b>
				</td>
				<td>
					<label>
						<input type="radio" name="ppcp_color" value="gold" <?php echo $args['options']['ppcp_color'] === 'gold' ? 'checked ' : ''; ?>/>
						Gold
					</label>
					&nbsp;
					&nbsp;
					<label>
						<input type="radio" name="ppcp_color" value="blue" <?php echo $args['options']['ppcp_color'] === 'blue' ? 'checked ' : ''; ?>/>
						Blue
					</label>
					&nbsp;
					&nbsp;
					<label>
						<input type="radio" name="ppcp_color" value="black" <?php echo $args['options']['ppcp_color'] === 'black' ? 'checked ' : ''; ?>/>
						Black
					</label>
					&nbsp;
					&nbsp;
					<label>
						<input type="radio" name="ppcp_color" value="silver" <?php echo $args['options']['ppcp_color'] === 'silver' ? 'checked ' : ''; ?>/>
						Silver
					</label>
					&nbsp;
					&nbsp;
					<label>
						<input type="radio" name="ppcp_color" value="white" <?php echo $args['options']['ppcp_color'] === 'white' ? 'checked ' : ''; ?>/>
						White
					</label>
				</td>
			</tr>
			<tr>
				<td class="wpedon-cell-left">
					<b>Shape:</b>
				</td>
				<td>
					<label>
						<input type="radio" name="ppcp_shape" value="rect" <?php echo $args['options']['ppcp_shape'] === 'rect' ? 'checked ' : ''; ?>/>
						Rectangle
					</label>
					&nbsp;
					&nbsp;
					<label>
						<input type="radio" name="ppcp_shape" value="pill" <?php echo $args['options']['ppcp_shape'] === 'pill' ? 'checked ' : ''; ?>/>
						Pill
					</label>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<br />
				</td>
			</tr>
			<tr>
				<td class="wpedon-cell-left">
					<b>Height:</b>
				</td>
				<td>
					<input type="number" name="ppcp_height" value="<?php echo $args['options']['ppcp_height']; ?>" min="25" max="55" />
					<br />
					25 - 55, a value around 40 is recommended
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<br />
				</td>
			</tr>
			<tr>
				<td class="wpedon-cell-left">
					<b>Width:</b>
				</td>
				<td>
					<input type="number" name="ppcp_width" value="<?php echo $args['options']['ppcp_width']; ?>" />
					<br />
					Max buttons width in pixels
				</td>
			</tr>
		</table>
		<br />
	<?php endif; ?>
</div>