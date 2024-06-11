<?php defined('ABSPATH' ) || wp_die; ?>
<!-- 編集用フォーム -->
&nbsp;
<div class="pz-lkc-man-cache-editor-title"><div class="pz-lkc-man-cache-editor-icon"><?php echo __('&#x1f4dd;&#xfe0f;', $this->text_domain ); ?></div>&ensp;<div class="pz-lkc-man-cache-editor-text"><?php echo __('Cache Editor', $this->text_domain ); ?></div></div>
<div class="pz-lkc-man-cache-editor">
	<table class="wp-list-table"><!--  wp-list-table widefat fixed -->
		<tr>
			<td colspan="2" style="text-align: right;">
				<button type="submit" name="action" value="update" class="button button-primary button-large"><?php _e('Update', $this->text_domain ) ?></button>
				&emsp;
				<button type="submit" name="action" value="cancel" class="button button-large"><?php _e('Cancel', $this->text_domain ) ?></button>
			</td>
		</tr>
		<tr>
			<th><?php _e('ID', $this->text_domain ) ?></th>
			<td><input name="data[id]" type="text" value="<?php echo esc_attr($data['id'] ); ?>" size="5" readonly="readonly" /></td>
		</tr>
		<tr>
			<th><?php _e('URL', $this->text_domain ) ?></th>
			<td><input name="data[url]" type="url" value="<?php echo esc_attr($data['url'] ); ?>" size="80" readonly="readonly" /></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Redirect URL', $this->text_domain ) ?></th>
			<td><input name="data[url_redir]" type="url" value="<?php echo esc_attr($data['url_redir'] ); ?>" size="80" readonly="readonly" /></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('URL Key', $this->text_domain ) ?></th>
			<td><input name="data[url_key]" type="text" value="<?php echo bin2hex($data['url_key'] ); ?>" size="80" readonly="readonly" /></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Scheme', $this->text_domain ) ?></th>
			<td><input name="data[scheme]" type="text" value="<?php echo esc_attr($data['scheme'] ); ?>" size="80" readonly="readonly" /></td>
		</tr>
		<tr>
			<th><?php _e('Site Name', $this->text_domain ) ?> (<span style="text-decoration: underline;">1</span>)</th>
			<td><input name="data[site_name]" type="text" value="<?php echo esc_attr($data['site_name'] ); ?>" size="80" accesskey="1" /></td>
		</tr>
		<tr>
			<th><?php _e('Domain', $this->text_domain ) ?></th>
			<?php if (function_exists('idn_to_utf8' ) && substr($data['domain'], 0, 4 ) == 'xn--' ) { ?>
			<td><input name="data[domain]" type="text" value="<?php echo $data['domain']; ?>" size="40" readonly="readonly" />&nbsp;<input name="data[domain]" type="text" value="<?php echo idn_to_utf8($data['domain'], 0, INTL_IDNA_VARIANT_UTS46 ); ?>" size="31" readonly="readonly" /></td>
			<?php } else { ?>
			<td><input name="data[domain]" type="text" value="<?php echo $data['domain']; ?>" size="80" readonly="readonly" /></td>
			<?php } ?>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Registration Title', $this->text_domain ) ?></th>
			<td><input name="data[regist_title]" type="text" value="<?php echo esc_attr($data['regist_title'] ); ?>" size="80" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> /></td>
		</tr>
		<tr>
			<th><?php _e('Title', $this->text_domain ) ?> (<span style="text-decoration: underline;">2</span>)</th>
			<td><input name="data[title]" type="text" value="<?php echo esc_attr($data['title'] ); ?>" size="80" accesskey="2" /></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Modify Title', $this->text_domain ) ?></th>
			<td><input name="data[mod_title]" type="text" value="<?php echo ($data['title'] <> $data['regist_title'] ? true : false ); ?>" size="1" readonly="readonly" /></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Registration Excerpt', $this->text_domain ) ?></th>
			<td><textarea name="data[regist_excerpt]" cols="83" rows="5" wrap="soft" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?>><?php echo esc_attr($data['regist_excerpt'] ); ?></textarea></td>
		</tr>
		<tr>
			<th><?php _e('Excerpt', $this->text_domain ) ?> (<span style="text-decoration: underline;">3</span>)</th>
			<td><textarea name="data[excerpt]" cols="83" rows="5" wrap="soft" accesskey="3"><?php echo esc_attr($data['excerpt'] ); ?></textarea></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Modify Excerpt', $this->text_domain ) ?></th>
			<td><input name="data[mod_excerpt]" type="text" value="<?php echo ($data['excerpt'] <> $data['regist_excerpt'] ? true : false ); ?>" size="1" readonly="readonly" /></td>
		</tr>
		<tr>
			<th><?php _e('Character Set', $this->text_domain ) ?></th>
			<td><?php echo $data['regist_charset'].'&nbsp;'.__('->', $this->text_domain ); ?>&nbsp;<input name="data[charset]" type="text" value="edit" size="8" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> /></td>
		</tr>
		<tr>
			<th><?php _e('Thumbnail URL', $this->text_domain ) ?></th>
			<td><input name="data[thumbnail]" type="url" value="<?php echo $data['thumbnail']; ?>" size="80" readonly="readonly" ondblclick="this.readOnly=false;" /></td>
		</tr>
		<tr>
			<th><?php _e('Favicon URL', $this->text_domain ) ?></th>
			<td><input name="data[favicon]" type="url" value="<?php echo $data['favicon']; ?>" size="80" readonly="readonly" ondblclick="this.readOnly=false;" /></td>
		</tr>
		<tr id="update_result">
			<th><?php _e('Result Code', $this->text_domain ) ?></th>
			<td>
				<input name="data[update_result]" type="text" value="<?php echo $data['update_result']; ?>" size="1" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
				&ensp;<?php $rs = $data['update_result']; echo $rs.' '.$this->pz_HTTPMessage($rs ); ?>
			</td>
		</tr>
		<tr>
			<th><?php _e('No Failure', $this->text_domain ) ?> (<span style="text-decoration: underline;">4</span>)</th>
			<td>
				<label><input name="data[no_failure]" type="checkbox" value="1" <?php checked(!empty($data['no_failure'] ? true : false ) ); ?> accesskey="4" /><?php _e('The result code is inaccessible but can actually be accessed.', $this->text_domain ); ?></label>
			</td>
		</tr>
		<tr>
			<th><?php _e('Post ID', $this->text_domain ) ?></th>
			<td>
				<input name="data[use_post_id1]" type="text" value="<?php echo $data['use_post_id1']; ?>" size="5" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
				<input name="data[use_post_id2]" type="text" value="<?php echo $data['use_post_id2']; ?>" size="5" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
				<input name="data[use_post_id3]" type="text" value="<?php echo $data['use_post_id3']; ?>" size="5" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
				<input name="data[use_post_id4]" type="text" value="<?php echo $data['use_post_id4']; ?>" size="5" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
				<input name="data[use_post_id5]" type="text" value="<?php echo $data['use_post_id5']; ?>" size="5" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
				<input name="data[use_post_id6]" type="text" value="<?php echo $data['use_post_id6']; ?>" size="5" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
			</td>
		</tr>
		<tr>
			<th><?php _e('SNS', $this->text_domain ) ?></th>
			<td>
				<?php _e('Tw', $this->text_domain ) ?>:<input name="data[sns_twitter]"  type="text" value="<?php echo $data['sns_twitter'];	 ?>" size="5" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
				<?php _e('fb', $this->text_domain ) ?>:<input name="data[sns_facebook]" type="text" value="<?php echo $data['sns_facebook']; ?>" size="5" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
				<?php _e('B!', $this->text_domain ) ?>:<input name="data[sns_hatena]"   type="text" value="<?php echo $data['sns_hatena'];	 ?>" size="5" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
				<?php _e('Po', $this->text_domain ) ?>:<input name="data[sns_pocket]"   type="text" value="<?php echo $data['sns_pocket'];	 ?>" size="5" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
			</td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Last SNS Check', $this->text_domain ) ?></th>
			<td><input name="data[sns_time]" type="text" value="<?php echo $data['sns_time']; ?>" size="8" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> /><?php echo ' '.date($this->datetime_format, $data['sns_time'] ); ?></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Next SNS Check', $this->text_domain ) ?></th>
			<td><input name="data[sns_nexttime]" type="text" value="<?php echo $data['sns_nexttime']; ?>" size="8" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> /><?php echo ' '.date($this->datetime_format, $data['sns_nexttime'] ); ?></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Registration Character Set', $this->text_domain ) ?></th>
			<td><input name="data[regist_charset]" type="text" value="<?php echo $data['regist_charset']; ?>" size="8" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> /></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Registration Date', $this->text_domain ) ?></th>
			<td><input name="data[regist_time]" type="text" value="<?php echo $data['regist_time']; ?>" size="8" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> /></td>
		</tr>
		<tr>
			<th><?php _e('Registration Date', $this->text_domain ) ?></th>
			<td><?php echo ' '.date($this->datetime_format, $data['regist_time'] ); ?></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Registration Result Code', $this->text_domain ) ?></th>
			<td>
				<input name="data[regist_result]" type="text" value="<?php echo $data['regist_result']; ?>" size="1" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
				&ensp;<?php $rs = $data['regist_result']; echo $rs.' '.$this->pz_HTTPMessage($rs ); ?>
			</td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Last Alive Check', $this->text_domain ) ?></th>
			<td><input name="data[alive_time]" type="text" value="<?php echo $data['alive_time']; ?>" size="8" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> /><?php echo ' '.date($this->datetime_format, $data['alive_time'] ); ?></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Next Alive Check', $this->text_domain ) ?></th>
			<td><input name="data[alive_nexttime]" type="text" value="<?php echo $data['alive_nexttime']; ?>" size="8" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> /><?php echo ' '.date($this->datetime_format, $data['alive_nexttime'] ); ?></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Result Code of Alive Check', $this->text_domain ) ?></th>
			<td>
				<input name="data[alive_result]" type="text" value="<?php echo $data['alive_result']; ?>" size="1" readonly="readonly"<?php if ($this->options['admin-mode'] ) { echo ' ondblclick="this.readOnly=false;"'; } ?> />
				&ensp;<?php $rs = $data['alive_result']; echo $rs.' '.$this->pz_HTTPMessage($rs ); ?>
			</td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th><?php _e('Update Date', $this->text_domain ) ?></th>
			<td><input name="data[update_time]" type="text" value="<?php echo $data['update_time']; ?>" size="8" readonly="readonly" /></td>
		</tr>
		<tr>
			<th><?php _e('Update Date', $this->text_domain ) ?></th>
			<td><?php echo ' '.date($this->datetime_format, $data['update_time'] ); ?></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: right;">
				<button type="submit" name="action" value="update" class="button button-primary button-large"><?php _e('Update', $this->text_domain ) ?></button>
				&emsp;
				<button type="submit" name="action" value="cancel" class="button button-large"><?php _e('Cancel', $this->text_domain ) ?></button>
			</td>
		</tr>
	</table>
</div>
