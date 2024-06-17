<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="item row col s12">
	<div class="list-bg"></div>

	<span class="folders_name">
		<i class="material-icons">lock</i>
		<span><?php echo esc_html_e( 'Most likely you manipulated the database and broke something in it. This block is broken and must be removed. (only if you do not restore the data in the database)', 'flatpm_l10n' ); ?></span>
	</span>

	<a href="<?php echo esc_attr( get_site_url() ); ?>/wp-admin/admin.php?page=fpm_blocks&id=<?php echo esc_attr( $id ); ?>" class="controls controls--title">
		<?php echo esc_html( get_the_title() ); ?>
	</a>

	<div class="layer layer--first">
		<div class="main-control">
			<button class="btn waves-effect tooltipped modal-trigger"
				data-block-id="<?php echo esc_attr( $id ); ?>"
				data-target="confirm-delete-block"
				data-position="top"
				data-tooltip="<?php esc_attr_e( 'Delete block', 'flatpm_l10n' ); ?>"
			>
				<i class="material-icons" style="color:#d87a87!important">delete_forever</i>
			</button>
		</div>
	</div>
</div>