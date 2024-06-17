<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flat_pm_pagespeed = get_option( 'flat_pm_pagespeed' );

$folder_id = ( isset( $_GET[ 'folder' ] ) ) ? sanitize_text_field( $_GET[ 'folder' ] ) : '';
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Add new block', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row wp-exclude-emoji">
	<div class="sidebar sidebar--left">
		<?php require FLATPM_FOLDERS_LIST; ?>
	</div>

	<form class="main col s12 block_update" style="padding-top:0">
		<input type="hidden" name="method" value="block_update">
		<input type="hidden" name="abgroup" value="">
		<?php if( ! empty( $folder_id ) ){ ?>
			<input type="hidden" name="folder_id" value="<?php echo esc_attr( $folder_id ); ?>">
		<?php } ?>
		<input type="hidden" id="same_code" data-html="<?php esc_attr_e( '<span>The note!<br><span>In order not to use the same code in two columns, enable duplication for Adblock in the plugin options</span></span>', 'flatpm_l10n' ); ?>">

		<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

		<div class="row white" style="border-radius:10px 10px 0 0">
			<div class="input-field col s12 m6 right">
				<div class="main-control right">
					<input type="checkbox" name="turned" id="turned" checked>
					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Enabled block', 'flatpm_l10n' ); ?>"
						for="turned"
					>
						<i class="material-icons" style="color:#81C06D!important">turned_in</i>
					</label>
					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Disabled block', 'flatpm_l10n' ); ?>"
						for="turned"
					>
						<i class="material-icons" style="color:#d87a87!important">turned_in_not</i>
					</label>

					<input type="checkbox" name="fast" id="fast">
					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Enabled fast mode', 'flatpm_l10n' ); ?>"
						for="fast"
					>
						<i class="material-icons" style="color:#81C06D!important">flash_on</i>
					</label>
					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Disabled fast mode', 'flatpm_l10n' ); ?>"
						for="fast"
					>
						<i class="material-icons" style="color:#d87a87!important">flash_off</i>
					</label>

					<?php if( $flat_pm_pagespeed['lazyload'] === 'true' ){ ?>
						<input type="checkbox" name="lazy" id="lazy" checked>
						<label style="border-radius:50%" class="btn tooltipped"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Enabled lazyload', 'flatpm_l10n' ); ?>"
							for="lazy"
						>
							<i class="material-icons" style="color:#81C06D!important">free_breakfast</i>
						</label>
						<label style="border-radius:50%" class="btn tooltipped"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Disabled lazyload', 'flatpm_l10n' ); ?>"
							for="lazy"
						>
							<i class="material-icons" style="color:#d87a87!important">free_breakfast</i>
						</label>
					<?php } ?>

					<button type="submit" style="border-radius:50%" class="btn waves-effect tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Save', 'flatpm_l10n' ); ?>"
					>
						<i class="material-icons">save</i>
					</button>
				</div>
			</div>

			<div class="input-field col s12 m6">
				<input type="text" id="block-name" class="validate no-border" name="name" placeholder="<?php esc_attr_e( 'Block name', 'flatpm_l10n' ); ?>" required>
				<span class="helper-text" data-error="<?php esc_attr_e( 'Please fill out this field', 'flatpm_l10n' ); ?>" data-success=""></span>
			</div>
		</div>

		<div class="row white">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab">
						<a class="waves-effect active" href="#tab-html"><?php _e( 'Subblocks', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-view"><?php _e( 'Output options', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-content"><?php _e( 'Content targeting', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-user"><?php _e( 'User targeting', 'flatpm_l10n' ); ?></a>
					</li>
				</ul>
			</div>
		</div>

		<div class="row" style="border-radius:0 0 10px 10px">
			<?php include_once 'add/html.php'; ?>
			<?php include_once 'add/view.php'; ?>
			<?php include_once 'add/content.php'; ?>
			<?php include_once 'add/user.php'; ?>
		</div>

		<br>

		<div class="row" style="border-radius:0 0 10px 10px">
			<button class="btn btn-large waves-effect waves-light tooltipped"
				type="submit"
				data-position="top"
				data-tooltip="<?php esc_attr_e( 'ctrl+s / alt+s', 'flatpm_l10n' ); ?>"
			>
				<b><?php _e( 'Create new block', 'flatpm_l10n' ); ?></b>
			</button>
		</div>
	</form>


	<?php include_once 'modals.php'; ?>


	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>