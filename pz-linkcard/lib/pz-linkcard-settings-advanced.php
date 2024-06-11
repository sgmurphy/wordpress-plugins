<?php defined('ABSPATH' ) || wp_die; ?>
<div class="pz-lkc-page" id="pz-lkc-advanced">
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	
	<h2><?php echo	__('Senior Settings', $this->text_domain ).$help_open.'advanced'.$help_close; ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Trailing Slash', $this->text_domain ); ?></th>
			<td>
				<select name="properties[trail-slash]">
					<option value=""  <?php selected($this->options['trail-slash'] == ''  ); ?>><?php _e('As it',							$this->text_domain ); ?></option>
					<option value="1" <?php selected($this->options['trail-slash'] == '1' ); ?>><?php _e('When only domain name, remove',	$this->text_domain ); ?></option>
					<option value="2" <?php selected($this->options['trail-slash'] == '2' ); ?>><?php _e('Always remove',					$this->text_domain ); ?></option>
				</select>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Class ID to be Added (for PC)', $this->text_domain ); ?></th>
			<td><input name="properties[class-pc]"			type="text" size="40" value="<?php echo	(isset($this->options['class-pc'] ) ? esc_attr($this->options['class-pc'] ) : '' ); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Class ID to be Added (for Mobile)', $this->text_domain ); ?></th>
			<td><input name="properties[class-mobile]"		type="text" size="40" value="<?php echo	(isset($this->options['class-mobile'] ) ? esc_attr($this->options['class-mobile'] ) : '' ); ?>" /><br>
		</tr>

		<tr>
			<th scope="row"><?php _e('Compress', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-compress]" value="0" />
					<input type="checkbox" name="properties[flg-compress]" value="1" <?php checked($this->options['flg-compress'] ); ?> />
					<?php _e('Compress CSS and JavaScript to improve access speed.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Google AMP determination', $this->text_domain ); ?></th>
			<td>
				<p>
					<label>
						<input type="hidden"   name="properties[flg-amp-url]" value="0" />
						<input type="checkbox" name="properties[flg-amp-url]" value="1" <?php checked($this->options['flg-amp-url'] ); ?> />
						<?php echo __('Simplified display if the URL ends with "/amp", "/amp/", or "/?amp=1".', $this->text_domain ).__('<span class="pz-warning">(Deprecated)</span>', $this->text_domain ); ?>
					</label>
				</p>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Hide URL Error', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[error-mode-hide]" value="0" />
					<input type="checkbox" name="properties[error-mode-hide]" value="1" class="pz-lkc-tab-show" <?php checked($this->options['error-mode-hide'] ); ?> />
					<?php echo __('Do not display an error on the admin page.', $this->text_domain ).__('<span class="pz-warning">(Deprecated)</span>', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>

	<h2><?php echo	__('Extension Settings', $this->text_domain ).$help_open.'extension'.$help_close; ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('File Menu', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-filemenu]" value="0" />
					<input type="checkbox" name="properties[flg-filemenu]" value="1" <?php checked($this->options['flg-filemenu'] ); ?> />
					<?php _e('Display the file menu on the card management screen.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Initialize Tab', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-initialize]" value="0" />
					<input type="checkbox" name="properties[flg-initialize]" value="1" class="pz-lkc-tab-show" <?php checked($this->options['flg-initialize'] ); ?> />
					<?php _e('Display the initialize tab on the settings screen.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Survey Mode', $this->text_domain ); ?></span></th>
			<td>
				<label>
					<input type="hidden"   name="properties[debug-mode]" value="0" />
					<input type="checkbox" name="properties[debug-mode]" value="1" class="pz-lkc-tab-show" <?php checked($this->options['debug-mode'] ); ?> />
					<?php echo __('Outputs some events and setting information to a log file.', $this->text_domain ).__('<span class="pz-warning">(Deprecated)</span>', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr class="pz-lkc-debug-only">
			<th scope="row"><?php _e('Administrator Mode', $this->text_domain ); ?></span></th>
			<td>
				<label>
					<input type="hidden"   name="properties[admin-mode]" value="0" />
					<input type="checkbox" name="properties[admin-mode]" value="1" class="pz-lkc-tab-show" <?php checked($this->options['admin-mode'] ); if (!$this->options['admin-mode'] ) {echo 'readonly="readonly"'; }; if (!$this->options['admin-mode'] ) { echo 'ondblclick="this.readOnly=false;"'; } ?> />
					<?php echo __('Display information that is not normally needed or open special settings.', $this->text_domain ).__('<span class="pz-warning">(Deprecated)</span>', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th scope="row"><?php _e('MultiSite Mode', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[multi-mode]" value="0" />
					<input type="checkbox" name="properties[multi-mode]" value="1" <?php checked($menu_multi || $is_multisite ); echo ($is_multisite ? ' readonly="readonly"' : '' ); ?> />
					<?php _e('Displays a menu for Multi-Site', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr  class="pz-lkc-develop-only">
			<th scope="row"><?php _e('Develop Mode', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[develop-mode]" value="0" />
					<input type="checkbox" name="properties[develop-mode]" value="1" <?php checked($this->options['develop-mode'] ); ?> readonly="readonly" />
					<?php _e('Currently working in a development environment.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>
</div>