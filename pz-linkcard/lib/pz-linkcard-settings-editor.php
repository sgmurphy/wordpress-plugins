<?php defined('ABSPATH' ) || wp_die; ?>
<div class="pz-lkc-page" id="pz-lkc-editor">
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	
	<h2><?php echo	__('Convert Settings', $this->text_domain ).$help_open.'editor'.$help_close; ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Convert from Text Link', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[auto-atag]" value="0" />
					<input type="checkbox" name="properties[auto-atag]" value="1" <?php checked($this->options['auto-atag'] ); ?> class="pz-lkc-sync-check" />
					<?php _e('Convert lines with text link only to Linkcard.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Convert from URL', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[auto-url]" value="0" />
					<input type="checkbox" name="properties[auto-url]" value="1" <?php checked($this->options['auto-url'] ); ?> class="pz-lkc-sync-check" />
					<?php _e('Convert lines with URL only to Linkcard.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('External Link Only', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[auto-external]" value="0" />
					<input type="checkbox" name="properties[auto-external]" value="1" <?php checked($this->options['auto-external'] ); ?> />
					<?php _e('Convert only external links.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Do Shortcode', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-do-shortcode]" value="0" />
					<input type="checkbox" name="properties[flg-do-shortcode]" value="1" <?php checked($this->options['flg-do-shortcode'] ); ?> />
					<?php _e('Force shortcode development.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>

	<h2><?php echo	__('Editor Settings', $this->text_domain ).$help_open.'editor'.$help_close; ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Add Insert Button', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-edit-insert]" value="0" />
					<input type="checkbox" name="properties[flg-edit-insert]" value="1" <?php checked($this->options['flg-edit-insert'] ); ?> />
					<?php _e('Add insert button to visual editor.', $this->text_domain ); ?>
				</label>
				<P>&emsp;&ensp;<?php _e('Filter Priority:', $this->text_domain ); ?><input name="properties[mce-priority]" type="number" min="0" max="9999" size="80" value="<?php echo esc_attr($this->options['mce-priority'] ); ?>" /><?php _e('(Null or 0-9999)',  $this->text_domain ); ?></P>
				<P>&emsp;&ensp;<?php _e('Setting a larger value may improve when the insert button does not appear in the editor.', $this->text_domain ); ?></P>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Add Quick Tag', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-edit-qtag]" value="0" />
					<input type="checkbox" name="properties[flg-edit-qtag]" value="1" <?php checked($this->options['flg-edit-qtag'] ); ?> />
					<?php _e('Add quick tag button to text editor.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>

	<h2><?php echo	__('Shortcode Settings', $this->text_domain ).$help_open.'editor'.$help_close; ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('ShortCode 1', $this->text_domain ); ?></th>
			<td>[<input name="properties[code1]" type="text" class="pz-lkc-shortcode pz-lkc-shortcode-1" value="<?php echo	esc_attr($this->options['code1'] ); ?>" /> url="http://popozure.info" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span> <span class="pz-lkc-shortcode-content"><span class="pz-lkc-shortcode-parameter">content</span>="xxxxxx"</span>]<p><?php _e('Case-sensitive', $this->text_domain ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Use InLineText', $this->text_domain ); ?></th>
			<td>
				[<span class="pz-lkc-shortcode-copy"><?php echo	esc_attr($this->options['code1'] ); ?></span> url="http://xxx"]
				<select name="properties[use-inline]" class="pz-lkc-shortcode-enabled">
					<option value=""	<?php selected($this->options['use-inline'] == ''  ); ?>><?php _e('No use',			$this->text_domain ); ?></option>
					<option value="1"	<?php selected($this->options['use-inline'] == '1' ); ?>><?php _e('Use to excerpt',	$this->text_domain ); ?></option>
					<option value="2"	<?php selected($this->options['use-inline'] == '2' ); ?>><?php _e('Use to title',	$this->text_domain ); ?></option>
				</select>
				[/<span class="pz-lkc-shortcode-copy"><?php echo	esc_attr($this->options['code1'] ); ?></span>]
				<p><?php _e('This setting applies only to the Shortcode1', $this->text_domain ); ?></p></td>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('ShortCode 2', $this->text_domain ); ?></th>
			<td>[<input name="properties[code2]" type="text" class="pz-lkc-shortcode" value="<?php echo	esc_attr($this->options['code2'] ); ?>" /> url="http://popozure.info" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span> <span class="pz-lkc-shortcode-content"><span class="pz-lkc-shortcode-parameter">content</span>="xxxxxx"</span>]<p><?php _e('Case-sensitive', $this->text_domain ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('ShortCode 3', $this->text_domain ); ?></th>
			<td>[<input name="properties[code3]" type="text" class="pz-lkc-shortcode" value="<?php echo	esc_attr($this->options['code3'] ); ?>" /> url="http://popozure.info" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span> <span class="pz-lkc-shortcode-content"><span class="pz-lkc-shortcode-parameter">content</span>="xxxxxx"</span>]<p><?php _e('Case-sensitive', $this->text_domain ); ?></p></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th scope="row"><?php _e('ShortCode 4', $this->text_domain ); ?></th>
			<td>[<input name="properties[code4]" type="text" class="pz-lkc-shortcode" value="<?php echo	esc_attr($this->options['code4'] ); ?>" /> url="http://popozure.info" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span> <span class="pz-lkc-shortcode-content"><span class="pz-lkc-shortcode-parameter">content</span>="xxxxxx"</span>]<p><?php _e('Case-sensitive', $this->text_domain ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Example Entry', $this->text_domain ); ?></th>
			<td>
				<p><?php echo __('ex1.', $this->text_domain ).'&ensp;'.__('Specify only URL parameters.', $this->text_domain ); ?><div class="pz-lkc-shortcode-example pz-click-all-select">[<span class="pz-lkc-shortcode-copy"><?php echo esc_attr($this->options['code1'] ); ?></span> url="https://xxx"]</div></p>
				<p><?php echo __('ex2.', $this->text_domain ).'&ensp;'.__('Specify URL and title parameters.', $this->text_domain ); ?><div class="pz-lkc-shortcode-example pz-click-all-select">[<span class="pz-lkc-shortcode-copy"><?php echo esc_attr($this->options['code1'] ); ?></span> url="https://xxx" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span>]</div></p>
				<p><?php echo __('ex3.', $this->text_domain ).'&ensp;'.__('Specify URL, title and content parameters.', $this->text_domain ); ?><div class="pz-lkc-shortcode-example pz-click-all-select">[<span class="pz-lkc-shortcode-copy"><?php echo esc_attr($this->options['code1'] ); ?></span> url="https://xxx" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span> <span class="pz-lkc-shortcode-content"><span class="pz-lkc-shortcode-parameter">content</span>="xxxxxx"</span>]</div></p>
				<p><?php _e('For any shortcode you can change the title and excerpt with `title` parameter and `content` parameter', $this->text_domain ); ?></p>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>
</div>