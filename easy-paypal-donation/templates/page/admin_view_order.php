<div style="width:98%;">
	<form method='post' action='<?php echo esc_url($_SERVER["REQUEST_URI"]); ?>'>
		<table width="100%">
            <tr>
                <td valign="bottom" width="85%">
					<br />
					<span style="font-size:20pt;">View Donation</span>
				</td>
                <td valign="bottom">
					<a href="<?= get_admin_url(null, 'admin.php?page=wpedon_menu'); ?>"
                       class="button-secondary" style="font-size: 14px;height: 30px;float: right;">View All Donations</a>
				</td>
            </tr>
        </table>

		<br />
        <div id="wpedon-free-message"></div>

		<div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;">
            <br />
			<span style="font-size:16pt;">Donation #<?= $args['post_id']; ?> Details</span>
			<br />
            <br />

			<table width="350px">
				<tr>
					<td>
                        <b>Transaction</b>
                    </td>
				</tr>
				<?php if ($args['payment_method'] === 'paypal'): ?>
					<tr>
						<td>PayPal Transaction ID:</td>
						<td>
							<?php if ( !empty( $args['capture_id'] ) ) { ?>
                                <a target="_blank" href="https://www.<?= $args['mode'] === 'sandbox' ? 'sandbox' : ''; ?>.paypal.com/activity/payment/<?= $args['capture_id']; ?>"><?php echo $args['capture_id']; ?></a>
							<?php } else { ?>
							    <a target="_blank" href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_view-a-trans&id=<?php echo $args['txn_id']; ?>">
								<?php echo $args['txn_id']; ?></a>
							<?php } ?>
						</td>
					</tr>
				<?php elseif ($args['payment_method'] === 'stripe') : ?>
					<tr>
						<td>
							Stripe Transaction ID:
						</td>
						<td>
							<?php echo $args['txn_id']; ?>
						</td>
					</tr>
				<?php endif; ?>
                <tr>
                    <td>
                        Donation Date:
                    </td>
                    <td>
                      <?php $post_timestamp = get_post_timestamp($args['post_id']); echo wp_date(get_option('date_format') . ' ' . get_option('time_format'), strtotime($post_timestamp));  ?>
                    </td>
                </tr>
                <tr>
                    <td><br /></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Item</b></td>
                </tr>
                <tr>
                    <td>Purpose / Name: </td>
                    <td><?php echo esc_html($args['title']); ?></td>
                </tr>
                <tr>
                    <td>Amount: </td>
                    <td><?php echo esc_html( number_format((float)$args['amount'], 2)  ); ?></td>
                </tr>
                <tr>
                    <td>Recurring: </td>
                    <td><?=esc_html($args['recurring']);?></td>
                </tr>
                <tr>
                    <td>Donation ID: </td>
                    <td><?php echo esc_html($args['donation_id']); ?></td>
                </tr>
                <tr>
                    <td><br /></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Payer</b></td>
                </tr>
                <tr>
                    <td>Payer Email: </td>
                    <td><?php echo esc_html($args['payer_email']); ?></td>
                </tr>
                <tr>
                    <td>Payer Currency: </td>
                    <td><?php echo esc_html(strtoupper($args['payer_currency'])); ?></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
				<?php if ( $args['payment_method'] === 'paypal' && !empty( $args['paypal_connection_type'] ) && $args['paypal_connection_type'] === 'ppcp' ) { ?>
                    <tr>
                        <td colspan="2">
                            <br />
                            <div>
                                <button class="button button-primary button-large" id="wpedon-free-paypal-order-refund" <?= strtolower( $args['payment_status'] ) !== 'completed' ? 'disabled' : ''; ?>>Refund</button>
                                <span class="spinner"></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
				<?php } ?>
            </table>
			<input type="hidden" name="update">
		</div>

		<div style="text-align:right">
			Note: If donation was set by donor as recurring on PayPal then <br />the Purpose / Name and Donation ID fields will be unavailable.
		</div>
	</form>

</div>