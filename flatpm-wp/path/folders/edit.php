<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$folder = sanitize_text_field( $_GET['folder'] );
$folder_obj = get_term( $folder );

$is_turned = get_term_meta( $folder_obj->term_id, 'turned', true ) === 'true';
$abgroup = get_term_meta( $folder_obj->term_id, 'abgroup', true );
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Edit folder filter', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row">
	<form class="main col s12 folder_update" style="padding-top:0">
		<input type="hidden" name="method" value="folder_update">
		<input type="hidden" name="id" value="<?php echo esc_attr( $folder_obj->term_id ); ?>">

		<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

		<div class="row white">
			<div class="input-field col s12 m6 right">
				<div class="main-control right">
					<span class="helper"><?php _e( 'Enable folder filter:', 'flatpm_l10n' ); ?></span>

					<input type="checkbox" name="turned" id="turned" <?php if( $is_turned ) echo 'checked'; ?>>

					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Enabled', 'flatpm_l10n' ); ?>"
						for="turned"
					>
						<i class="material-icons" style="color:#81C06D!important">turned_in</i>
					</label>
					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Disabled', 'flatpm_l10n' ); ?>"
						for="turned"
					>
						<i class="material-icons" style="color:#d87a87!important">turned_in_not</i>
					</label>

					<span class="helper" style="margin-left:10px"><?php _e( 'Group for A/B', 'flatpm_l10n' ); ?>:</span>

					<input type="number" min="1"
						name="abgroup"
						class="tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Group for A/B', 'flatpm_l10n' ); ?>"
						value="<?php echo esc_attr( $abgroup ); ?>"
						onkeyup="this.setAttribute( 'value', this.value );"
						style="border-radius:10px;border:2px solid #fff!important;box-shadow:0 2px 2px 0 rgba(0,0,0,0.08),0 3px 1px -2px rgba(0,0,0,0.04),0 1px 5px 0 rgba(0,0,0,0.15)"
					>

					<button type="submit" style="border-radius:50%" class="btn waves-effect tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Save', 'flatpm_l10n' ); ?>"
					>
						<i class="material-icons">save</i>
					</button>
				</div>
			</div>

			<div class="input-field col s12 m6">
				<input type="text" id="block-name" class="validate no-border" name="name" value="<?php echo esc_attr( $folder_obj->name ); ?>" placeholder="<?php esc_attr_e( 'Folder name', 'flatpm_l10n' ); ?>" required>
				<span class="helper-text" data-error="<?php esc_attr_e( 'Please fill out this field', 'flatpm_l10n' ); ?>" data-success=""></span>
			</div>
		</div>

		<div class="row white">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab">
						<a class="waves-effect" href="#tab-content"><?php _e( 'Content targeting', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-user"><?php _e( 'User targeting', 'flatpm_l10n' ); ?></a>
					</li>
				</ul>
			</div>
		</div>

		<div class="row">
			<?php include_once 'edit/content.php'; ?>
			<?php include_once 'edit/user.php'; ?>
		</div>

		<br>

		<div class="row">
			<button class="btn btn-large waves-effect waves-light tooltipped"
				type="submit"
				data-position="top"
				data-tooltip="<?php esc_attr_e( 'ctrl+s / alt+s', 'flatpm_l10n' ); ?>"
			>
				<b><?php _e( 'Save folder settings', 'flatpm_l10n' ); ?></b>
			</button>
		</div>
	</form>


	<div id="search-publish-modal" class="modal">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Choose publications', 'flatpm_l10n' ); ?></h4>
			<p><?php _e( 'You can search as a single entry by entering the id, url or title, or as a list.<br>Each query on a new line:', 'flatpm_l10n' ); ?></p>

			<div class="col s12">
				<div class="row" style="margin-bottom:10px">
					<div class="row" style="margin-bottom:0">
						<div class="col s12 m5">
							<textarea class="default" name="search-publish-query" id="search-publish-query" placeholder="<?php esc_attr_e( 'What are we looking for?', 'flatpm_l10n' ); ?>" style="min-height:220.5px"></textarea>
						</div>

						<div class="col s12 m7">
							<ul class="extended_list collection" style="margin:0"></ul>
						</div>
					</div>
				</div>
			</div>

			<small><?php _e( 'minimum query length for url - 8 characters', 'flatpm_l10n' ); ?>,</small>
			<small><?php _e( 'minimum query length for title - 4 characters', 'flatpm_l10n' ); ?></small>
		</div>
	</div>


	<div id="search-taxonomy-modal" class="modal">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Choose taxonomies', 'flatpm_l10n' ); ?></h4>
			<p><?php _e( 'You can search for one taxonomy by entering id, slug or title, or as a list.<br>Each query on a new line:', 'flatpm_l10n' ); ?></p>

			<div class="col s12">
				<div class="row" style="margin-bottom:10px">
					<div class="row" style="margin-bottom:0">
						<div class="col s12 m5">
							<textarea class="default" name="search-taxonomy-query" id="search-taxonomy-query" placeholder="Что будем искать?" style="min-height:220.5px"></textarea>
						</div>

						<div class="col s12 m7">
							<ul class="extended_list collection" style="margin:0"></ul>
						</div>
					</div>
				</div>
			</div>

			<small><?php _e( 'minimum query length for url - 8 characters', 'flatpm_l10n' ); ?>,</small>
			<small><?php _e( 'minimum query length for title - 4 characters', 'flatpm_l10n' ); ?></small>
		</div>
	</div>

	<div class="sidebar sidebar--left">
		<?php require FLATPM_FOLDERS_LIST; ?>
	</div>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>