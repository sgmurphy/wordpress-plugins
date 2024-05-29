<?php
if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly
?>

<div class="notice notice-warning is-dismissible wpedon-ppcp-connect-notice" data-dismiss-url="<?= add_query_arg( 'wpedon_admin_ppcp_notice_dismiss', 1, admin_url() ); ?>">
	<p>
		<?php
			_e(
				"<b>Important</b> - 'Accept Donations with PayPal & Stripe' now uses PayPal Commerce Platform.
				<u><b>PayPal Standard is now a Legacy product.</b></u>
				<br />
				<br />
				<b><u>If you use PayPal, please update to PayPal Commerce Platform.</u></b>"
			);
		?>
	</p>
	<p>
        <?php $ppcp = new \WPEasyDonation\Base\PpcpController(); ?>
		<a class="wpedon-ppcp-button"
		   href="<?= $ppcp->connect_tab_url( 'general'  ); ?>"
		>
			<img class="wpedon-ppcp-paypal-logo" style="max-height:25px" src="<?= WPEDON_FREE_URL; ?>/assets/images/paypal-logo.png" alt="paypal-logo" />
			<br />
			Get Started
		</a>
	</p>
	<br />
	WPPlugin LLC is an official PayPal Partner. Pay as you go pricing: 1% per-transaction fee + PayPal fees.
</div>