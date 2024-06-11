<?php defined('ABSPATH' ) || wp_die; ?>
<div class="pz-lkc-page" id="pz-lkc-check">
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	
	<h2><?php echo	__('Link Check Settings', $this->text_domain ).$help_open.'link-check'.$help_close; ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Relative URL', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-relative-url]" value="0" />
					<input type="checkbox" name="properties[flg-relative-url]" value="1" <?php checked($this->options['flg-relative-url'] ); ?> />
					<?php _e('For relative-specified URLs, complement the site URL.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Do Not Link at Error', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-unlink]" value="0" />
					<input type="checkbox" name="properties[flg-unlink]" value="1" <?php checked($this->options['flg-unlink'] ); ?> />
					<?php _e('When access status is "403", "404", "410", unlink.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Disable SSL Verification', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-ssl]" value="0" />
					<input type="checkbox" name="properties[flg-ssl]" value="1" <?php checked($this->options['flg-ssl'] ); ?> />
					<?php _e('Try setting if the contents of the SSL site can not be acquired.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Follow Location', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-redir]" value="0" />
					<input type="checkbox" name="properties[flg-redir]" value="1" <?php checked($this->options['flg-redir'] ); ?> />
					<?php _e('Track when the link destination is redirected.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Set Referer', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-referer]" value="0" />
					<input type="checkbox" name="properties[flg-referer]" value="1" <?php checked($this->options['flg-referer'] ); ?> />
					<?php _e('Notify the article URL to the link destination.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Use User-Agent', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-agent]" value="0" />
					<input type="checkbox" name="properties[flg-agent]" value="1" <?php checked($this->options['flg-agent'] ); ?> class="pz-lkc-sync-check" />
					<?php _e('Notify using Pz-LinkCard to the link destination.', $this->text_domain ); ?>
				</label>
				<p>&emsp;&ensp;<input name="properties[user-agent]" type="text" size="80" value="<?php echo	esc_attr($this->options['user-agent'] ); ?>" /></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Broken Link Checker', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-alive]" value="0" />
					<input type="checkbox" name="properties[flg-alive]" value="1" <?php checked($this->options['flg-alive'] ); ?> />
					<?php _e('Alive confirmation of the link destination.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Broken Link Count', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[flg-alive-count]" value="0" />
					<input type="checkbox" name="properties[flg-alive-count]" value="1" <?php checked($this->options['flg-alive-count'] ); ?> />
					<?php _e('The number of broken links is displayed next to the submenu.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>
</div>
