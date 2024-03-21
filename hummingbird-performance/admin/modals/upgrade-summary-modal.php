<?php
/**
 * Upgrade highlight modal.
 *
 * @since 2.6.0
 * @package Hummingbird
 */

use Hummingbird\Core\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="sui-modal sui-modal-md">
	<div
			role="dialog"
			id="upgrade-summary-modal"
			class="sui-modal-content"
			aria-modal="true"
			aria-labelledby="upgrade-summary-modal-title"
	>
		<div class="sui-box">
			<div class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60">
				<?php if ( ! apply_filters( 'wpmudev_branding_hide_branding', false ) ) : ?>
					<figure class="sui-box-banner" aria-hidden="true">
						<img src="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/upgrade-summary-bg.png' ); ?>" alt=""
							srcset="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/upgrade-summary-bg.png' ); ?> 1x, <?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/upgrade-summary-bg@2x.png' ); ?> 2x">
					</figure>
				<?php endif; ?>

				<button class="sui-button-icon sui-button-float--right" onclick="window.WPHB_Admin.dashboard.hideUpgradeSummary( this )">
					<span class="sui-icon-close sui-md" aria-hidden="true"></span>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Close this modal', 'wphb' ); ?></span>
				</button>

				<h3 id="upgrade-summary-modal-title" class="sui-box-title sui-lg" style="white-space: inherit">
					<?php esc_html_e( 'New Core Web Vital - INP', 'wphb' ); ?>
				</h3>
			</div>

			<div class="sui-box-body sui-spacing-top--20 sui-spacing-bottom--20">
				<div class="wphb-upgrade-feature">
					<p class="wphb-upgrade-item-desc" style="text-align: center">
						<?php
						printf( /* translators: %1$s - username, %2$s - opening <strong> tag, %3$s - closing <strong> tag */
							esc_html__( 'Hey %1$s! Performance reports have been updated to include %2$sGoogle\'s new Interaction to Next Paint (INP) core web vital.%3$s INP measures the longest time required for your page to respond to user click, tap, or keyboard interaction.', 'wphb' ),
							esc_html( Utils::get_user_name() ),
							'<strong>',
							'</strong>',
						);
						?>
					</p>
				</div>
			</div>
			<?php
				$hb_button      = esc_html__( 'Run a performance test now', 'wphb' );
				$hb_button_link = Utils::get_admin_menu_url( 'minification' ) . '&view=tools';
				$scan_link      = add_query_arg(
					array(
						'run'  => 'true',
						'type' => 'performance',
					),
					Utils::get_admin_menu_url()
				);
				?>
			<div class="sui-box-footer sui-flatten sui-content-center" style="padding-bottom: 15px;">
				<a href="<?php echo esc_url( wp_nonce_url( $scan_link, 'wphb-run-dashboard' ) ); ?>" class="sui-button sui-button-blue" onclick="window.WPHB_Admin.dashboard.hideUpgradeSummary( this )">
					<?php echo esc_html( $hb_button ); ?>
				</a>
			</div>
			<div class="sui-box-footer sui-flatten sui-content-center">
				<a href="<?php echo esc_url( 'https://web.dev/articles/inp' ); ?>" target="_blank" style="color: #888888;font-size: 12px;background: #F8F8F8;" class="sui-button sui-button-blue">
					<span class="sui-icon-open-new-window" aria-hidden="true"></span><?php esc_html_e( 'LEARN MORE ABOUT INP', 'wphb' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
