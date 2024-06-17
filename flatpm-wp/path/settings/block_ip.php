<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ips = file_get_contents( ABSPATH . 'ip.html' );
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Blacklist IP', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row">
	<form class="main col s12 blacklist_ip_update" style="padding-top:0">
		<input type="hidden" name="method" value="blacklist_ip_update">
		<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

		<div class="row">
			<div class="col s12 white" style="border-radius:10px">
				<div class="col s12 m4">
					<br>

					<textarea class="default" name="ip" placeholder="<?php _e( 'For example: 37.146.224.246', 'flatpm_l10n' ); ?>" style="min-height:68vh"><?php echo esc_html( $ips ); ?></textarea>
				</div>
				<div class="col s12 m8">
					<p><?php _e( 'Enter each ip address on a new line. <br>Targeting is enabled in the block settings, for each one individually, or in the folder settings.', 'flatpm_l10n' ); ?></p>
					<p><?php _e( 'The entire list is saved not in the database, but in a file', 'flatpm_l10n' ); ?> <code><?php echo ABSPATH; ?>ip.html</code></p>
					<p>
						<?php _e( 'You can also use a range for the IP address, for example:', 'flatpm_l10n' ); ?> <b>37.146.224.0-37.146.224.255</b><br>
						<?php _e( 'Or it could be ipv6 range:', 'flatpm_l10n' ); ?> <b>2a0d:5600:24:61:a0::1 - 2a0d:5600:24:61:a0::4</b>
					</p>
					<p><?php _e( 'Your IP:', 'flatpm_l10n' ); ?> <span class="your_ip"><?php echo flat_pm_get_real_ip(); ?></span></p>
				</div>

				<div class="row"></div>
			</div>
		</div>

		<br>

		<div class="row">
			<button class="btn btn-large waves-effect waves-light tooltipped"
				type="submit"
				data-position="top"
				data-tooltip="<?php esc_attr_e( 'ctrl+s / alt+s', 'flatpm_l10n' ); ?>"
			>
				<b><?php _e( 'Save settings', 'flatpm_l10n' ); ?></b>
			</button>
		</div>
	</form>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>