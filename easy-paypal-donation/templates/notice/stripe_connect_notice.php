<?php
if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly
?>

<div class="notice notice-warning is-dismissible wpedon-stripe-connect-notice" data-dismiss-url="<?= add_query_arg( 'wpedon_admin_stripe_connect_notice_dismiss', 1, admin_url() ); ?>">
	<p>
		<?php
			_e(
				"<b>Important</b> - 'Accept Donations with PayPal & Stripe' now uses Stripe Connect. Stripe Connect improves security and allows for easier setup.
				<br />
				<br />
				If you use Stripe, please use Stripe Connect. Have questions: see the <a target='_blank' href='https://wpplugin.org/documentation/stripe-connect/'>documentation</a>."
			);
		?>
	</p>
	<p>
		<?php $stripe = new \WPEasyDonation\Base\Stripe(); ?>
		<a href="<?= $stripe->connect_url(); ?>" class="stripe-connect-btn">
			<span>Connect with Stripe</span>
		</a>
	</p>
	<br />
	WPPlugin LLC is an official Stripe Partner. Pay as you go pricing: 1% per-transaction fee + Stripe fees.
</div>