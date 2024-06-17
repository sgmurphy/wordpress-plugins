<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tab-content" class="white">
	<ul class="collapsible">
		<li>
			<div class="collapsible-header" tabindex="0">
				<b><?php _e( 'Post types:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<div class="row">
					<?php
					$args = array(
						'public' => true
					);

					$post_types = array_diff( array_values( get_post_types( $args, 'names', 'and' ) ), array('flat_pm_block','attachment') );
					?>

					<div class="col s12" style="display:flex;column-gap:40px;flex-wrap:wrap">
						<?php
						foreach( $post_types as $type ){
							$type = get_post_type_object( $type );

							echo '
							<p>
								<label>
									<input type="checkbox"
										id="post_types_' . $type->name . '"
										name="bulk[post_types][' . esc_attr( $type->name ) . ']"
									>
									<span>' . $type->labels->name . '</span>
								</label>
							</p>';
						}
						?>
					</div>

					<div class="col s12" style="margin-bottom:0">
						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[post_types][action]none" name="bulk[post_types][action]" value="none" checked="checked">
							<label for="bulk[post_types][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[post_types][action]add" name="bulk[post_types][action]" value="add">
							<label for="bulk[post_types][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[post_types][action]overwrite" name="bulk[post_types][action]" value="overwrite">
							<label for="bulk[post_types][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>
				</div>
			</div>
		</li>

		<li>
			<div class="collapsible-header" tabindex="0">
				<b><?php _e( 'Posts:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<div class="row">
					<div class="col s12 m6">
						<p>
							<?php _e( 'In which posts to show:', 'flatpm_l10n' ); ?>
							<button type="button" class="delete-all btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right" data-position="top" data-tooltip="<?php esc_attr_e( 'Remove all', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
								<i class="material-icons" style="color:#d87a87!important">close</i>
							</button>
							<button type="button" data-target="search-publish-modal" class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right modal-trigger" data-position="top" data-tooltip="<?php esc_attr_e( 'Add', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
								<i class="material-icons">edit</i>
							</button>
						</p>

						<ul class="extended_list collection" data-type="publish_enabled"></ul>

						<div class="empty-list">
							<img width="250" height="146" src="<?php echo esc_attr( FLATPM_URL ); ?>assets/admin/img/empty_state.svg">
						</div>

						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[publish_enabled][action]none" name="bulk[publish_enabled][action]" value="none" checked="checked">
							<label for="bulk[publish_enabled][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[publish_enabled][action]add" name="bulk[publish_enabled][action]" value="add">
							<label for="bulk[publish_enabled][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[publish_enabled][action]overwrite" name="bulk[publish_enabled][action]" value="overwrite">
							<label for="bulk[publish_enabled][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>

					<div class="col s12 m6">
						<p>
							<?php _e( 'In which posts to not show:', 'flatpm_l10n' ); ?>
							<button type="button" class="delete-all btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right" data-position="top" data-tooltip="<?php esc_attr_e( 'Remove all', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
								<i class="material-icons" style="color:#d87a87!important">close</i>
							</button>
							<button type="button" data-target="search-publish-modal" class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right modal-trigger" data-position="top" data-tooltip="<?php esc_attr_e( 'Add', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
								<i class="material-icons">edit</i>
							</button>
						</p>

						<ul class="extended_list collection" data-type="publish_disabled"></ul>

						<div class="empty-list">
							<img width="250" height="146" src="<?php echo esc_attr( FLATPM_URL ); ?>assets/admin/img/empty_state.svg">
						</div>

						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[publish_disabled][action]none" name="bulk[publish_disabled][action]" value="none" checked="checked">
							<label for="bulk[publish_disabled][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[publish_disabled][action]add" name="bulk[publish_disabled][action]" value="add">
							<label for="bulk[publish_disabled][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[publish_disabled][action]overwrite" name="bulk[publish_disabled][action]" value="overwrite">
							<label for="bulk[publish_disabled][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>
				</div>
			</div>
		</li>

		<li>
			<div class="collapsible-header" tabindex="0">
				<b><?php _e( 'Taxonomies:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<div class="row">
					<div class="col s12 m6">
						<p>
							<?php _e( 'In which taxonomies to show:', 'flatpm_l10n' ); ?>
							<button type="button" class="delete-all btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right" data-position="top" data-tooltip="<?php esc_attr_e( 'Remove all', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
								<i class="material-icons" style="color:#d87a87!important">close</i>
							</button>
							<button type="button" data-target="search-taxonomy-modal" class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right modal-trigger" data-position="top" data-tooltip="<?php esc_attr_e( 'Add', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
								<i class="material-icons">edit</i>
							</button>
						</p>

						<ul class="extended_list collection" data-type="taxonomy_enabled"></ul>

						<div class="empty-list">
							<img width="250" height="146" src="<?php echo esc_attr( FLATPM_URL ); ?>assets/admin/img/empty_state.svg">
						</div>

						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[taxonomy_enabled][action]none" name="bulk[taxonomy_enabled][action]" value="none" checked="checked">
							<label for="bulk[taxonomy_enabled][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[taxonomy_enabled][action]add" name="bulk[taxonomy_enabled][action]" value="add">
							<label for="bulk[taxonomy_enabled][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[taxonomy_enabled][action]overwrite" name="bulk[taxonomy_enabled][action]" value="overwrite">
							<label for="bulk[taxonomy_enabled][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>

					<div class="col s12 m6">
						<p>
							<?php _e( 'In which taxonomies not to show:', 'flatpm_l10n' ); ?>
							<button type="button" class="delete-all btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right" data-position="top" data-tooltip="<?php esc_attr_e( 'Remove all', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
								<i class="material-icons" style="color:#d87a87!important">close</i>
							</button>
							<button type="button" data-target="search-taxonomy-modal" class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right modal-trigger" data-position="top" data-tooltip="<?php esc_attr_e( 'Add', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
								<i class="material-icons">edit</i>
							</button>
						</p>

						<ul class="extended_list collection" data-type="taxonomy_disabled"></ul>

						<div class="empty-list">
							<img width="250" height="146" src="<?php echo esc_attr( FLATPM_URL ); ?>assets/admin/img/empty_state.svg">
						</div>

						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[taxonomy_disabled][action]none" name="bulk[taxonomy_disabled][action]" value="none" checked="checked">
							<label for="bulk[taxonomy_disabled][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[taxonomy_disabled][action]add" name="bulk[taxonomy_disabled][action]" value="add">
							<label for="bulk[taxonomy_disabled][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[taxonomy_disabled][action]overwrite" name="bulk[taxonomy_disabled][action]" value="overwrite">
							<label for="bulk[taxonomy_disabled][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>
				</div>
			</div>
		</li>

		<li>
			<div class="collapsible-header" tabindex="0">
				<b><?php _e( 'Content restriction:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<div class="row">
					<div class="input-field col s12 m6">
						<input id="content_restriction_content_less" type="number" class="validate" min="0" step="1" name="bulk[restriction][content_less]">
						<label for="content_restriction_content_less"><?php _e( 'Hide if the content is less than N characters:', 'flatpm_l10n' ); ?></label>
					</div>

					<div class="input-field col s12 m6">
						<input id="content_restriction_title_less" type="number" class="validate" min="0" step="1" name="bulk[restriction][title_less]">
						<label for="content_restriction_title_less"><?php _e( 'Hide if there are less than N subheadings:', 'flatpm_l10n' ); ?></label>
					</div>

					<div class="input-field col s12 m6">
						<input id="content_restriction_content_more" type="number" class="validate" min="0" step="1" name="bulk[restriction][content_more]">
						<label for="content_restriction_content_more"><?php _e( 'Hide if the content is more than N characters:', 'flatpm_l10n' ); ?></label>
					</div>

					<div class="input-field col s12 m6">
						<input id="content_restriction_title_more" type="number" class="validate" min="0" step="1" name="bulk[restriction][title_more]">
						<label for="content_restriction_title_more"><?php _e( 'Hide if there are more than N subheadings:', 'flatpm_l10n' ); ?></label>
					</div>

					<div class="col s12" style="margin-bottom:0">
						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[restriction][action]none" name="bulk[restriction][action]" value="none" checked="checked">
							<label for="bulk[restriction][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[restriction][action]add" name="bulk[restriction][action]" value="add">
							<label for="bulk[restriction][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[restriction][action]overwrite" name="bulk[restriction][action]" value="overwrite">
							<label for="bulk[restriction][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>
				</div>
			</div>
		</li>

		<li>
			<div class="collapsible-header" tabindex="0">
				<b><?php _e( 'Author targeting:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<?php
				$users = get_users( array(
					'capability' => 'edit_posts',
					'fields' => array( 'ID', 'display_name' ),
					'has_published_posts' => true
				) );
				?>
				<div class="row">
					<div class="input-field col s12 m6">
						<select multiple name="bulk[author][allow]" id="content_author_allow">
							<option value="" disabled><?php _e( 'Select Authors', 'flatpm_l10n' ); ?></option>
							<?php
							foreach( $users as $user ){
								echo '<option value="' . esc_attr( $user->ID ) . '">' . esc_html( $user->display_name ) . '</option>';
							}
							?>
						</select>
						<label><?php _e( 'Show if author:', 'flatpm_l10n' ); ?></label>

						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[author][allow][action]none" name="bulk[author][allow][action]" value="none" checked="checked">
							<label for="bulk[author][allow][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[author][allow][action]add" name="bulk[author][allow][action]" value="add">
							<label for="bulk[author][allow][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[author][allow][action]overwrite" name="bulk[author][allow][action]" value="overwrite">
							<label for="bulk[author][allow][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>

					<div class="input-field col s12 m6">
						<select multiple name="bulk[author][disallow]" id="content_author_disallow">
							<option value="" disabled><?php _e( 'Select Authors', 'flatpm_l10n' ); ?></option>
							<?php
							foreach( $users as $user ){
								echo '<option value="' . esc_attr( $user->ID ) . '">' . esc_html( $user->display_name ) . '</option>';
							}
							?>
						</select>
						<label><?php _e( 'Hide if author:', 'flatpm_l10n' ); ?></label>

						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[author][disallow][action]none" name="bulk[author][disallow][action]" value="none" checked="checked">
							<label for="bulk[author][disallow][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[author][disallow][action]add" name="bulk[author][disallow][action]" value="add">
							<label for="bulk[author][disallow][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[author][disallow][action]overwrite" name="bulk[author][disallow][action]" value="overwrite">
							<label for="bulk[author][disallow][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>
				</div>
			</div>
		</li>

		<li>
			<div class="collapsible-header" tabindex="0">
				<b><?php _e( 'Template types:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<div class="row">
					<div class="col s12 m6">
						<p>
							<label>
								<input type="checkbox" name="bulk[templates][home]">
								<span><?php _e( 'Show on', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_home(), is_front_page()"><?php _e( 'homepage', 'flatpm_l10n' ); ?></ins></span>
							</label>
						</p>
					</div>
					<div class="col s12 m6">
						<p>
							<label>
								<input type="checkbox" name="bulk[templates][singular]">
								<span><?php _e( 'Show on', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_singular()"><?php _e( 'singular', 'flatpm_l10n' ); ?></ins></span>
							</label>
						</p>
					</div>
					<div class="col s12 m6">
						<p>
							<label>
								<input type="checkbox" name="bulk[templates][archives]">
								<span><?php _e( 'Show in', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_archive()"><?php _e( 'archives', 'flatpm_l10n' ); ?></ins></span>
							</label>
						</p>
					</div>
					<div class="col s12 m6">
						<p>
							<label>
								<input type="checkbox" name="bulk[templates][categories]">
								<span><?php _e( 'Show in', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_category(), is_tax()"><?php _e( 'categories', 'flatpm_l10n' ); ?></ins></span>
							</label>
						</p>
					</div>
					<div class="col s12 m6">
						<p>
							<label>
								<input type="checkbox" name="bulk[templates][search]">
								<span><?php _e( 'Show on', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_search()"><?php _e( 'search page', 'flatpm_l10n' ); ?></ins></span>
							</label>
						</p>
					</div>
					<div class="col s12 m6">
						<p>
							<label>
								<input type="checkbox" name="bulk[templates][404]">
								<span><?php _e( 'Show on', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_404()"><?php _e( 'page 404 errors', 'flatpm_l10n' ); ?></ins></span>
							</label>
						</p>
					</div>
					<div class="col s12 m6">
						<p>
							<label>
								<input type="checkbox" name="bulk[templates][paged]">
								<span><?php _e( 'Show on', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_paged()"><?php _e( 'pagination page', 'flatpm_l10n' ); ?></ins></span>
							</label>
						</p>
					</div>

					<div class="col s12" style="margin-bottom:0">
						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[templates][action]none" name="bulk[templates][action]" value="none" checked="checked">
							<label for="bulk[templates][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[templates][action]add" name="bulk[templates][action]" value="add">
							<label for="bulk[templates][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[templates][action]overwrite" name="bulk[templates][action]" value="overwrite">
							<label for="bulk[templates][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>