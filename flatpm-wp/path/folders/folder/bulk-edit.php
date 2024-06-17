<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flat_pm_default_selectors = get_option( 'flat_pm_default_selectors' );
?>
<div id="confirm-bulk-editing" class="modal" style="width:1200px">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Bulk block edit', 'flatpm_l10n' ); ?></h4>

		<p><?php _e( 'Be careful and check everything before apply settings.', 'flatpm_l10n' ); ?></p>
		<br>

		<ul class="tabs">
			<li class="tab">
				<a class="waves-effect" href="#tab-subblocks"><?php _e( 'Subblocks', 'flatpm_l10n' ); ?></a>
			</li>
			<li class="tab">
				<a class="waves-effect" href="#tab-output"><?php _e( 'Output options', 'flatpm_l10n' ); ?></a>
			</li>
			<li class="tab">
				<a class="waves-effect" href="#tab-content"><?php _e( 'Content targeting', 'flatpm_l10n' ); ?></a>
			</li>
			<li class="tab">
				<a class="waves-effect" href="#tab-user"><?php _e( 'User targeting', 'flatpm_l10n' ); ?></a>
			</li>
		</ul>

		<?php include_once 'bulk-edit/subblocks.php'; ?>
		<?php include_once 'bulk-edit/output.php'; ?>
		<?php include_once 'bulk-edit/content.php'; ?>
		<?php include_once 'bulk-edit/user.php'; ?>

		<button class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
		<button class="waves-effect btn-flat confirm-bulk-editing"><?php _e( 'Apply bulk settings', 'flatpm_l10n' ); ?></button>
		<button class="waves-effect btn-flat clear-bulk-editing right"><?php _e( 'Clear bulk settings', 'flatpm_l10n' ); ?></button>
	</div>
</div>