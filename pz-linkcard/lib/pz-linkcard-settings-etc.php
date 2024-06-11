<?php defined('ABSPATH' ) || wp_die; ?>
<div class="pz-lkc-page" id="pz-lkc-etc">
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	
	<h2><?php echo	__('Stylesheet Settings', $this->text_domain ).$help_open.'css'.$help_close; ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Stylesheet URL', $this->text_domain ); ?></th>
			<td>
				<p><input name="properties[css-url]"	type="url"  size="80" title="<?php echo	esc_attr($this->options['css-url'] ); ?>" class="pz-click-all-select" value="<?php echo	esc_attr($this->options['css-url'] ); ?>" readonly="readonly" /></p>
				<p><?php _e('Schemes (http and https) are omitted.', $this->text_domain ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Stylesheet URL to Add', $this->text_domain ); ?></th>
			<td><input name="properties[css-add-url]"	type="url"  size="80" title="<?php echo	esc_attr($this->options['css-add-url'] ); ?>" value="<?php echo	esc_attr($this->options['css-add-url'] ); ?>" /><br><p><?php echo	__('(', $this->text_domain ).__('ex.', $this->text_domain ).' '.$this->home_url.'/style.css '.__(')', $this->text_domain ); ?></p></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Stylesheet Text to Add', $this->text_domain ); ?></th>
			<td><input name="properties[css-add]"		type="text" size="80" title="<?php echo	esc_attr($this->options['css-add'] ); ?>" value="<?php echo	esc_attr($this->options['css-add'] ); ?>" /></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th scope="row"><?php _e('Stylesheet Version', $this->text_domain ); ?></th>
			<td><input name="properties[css-count]"		type="text" size="10" title="<?php echo	esc_attr($this->options['css-count'] ); ?>" value="<?php echo	esc_attr($this->options['css-count'] ); ?>" readonly="readonly" <?php if ($this->options['admin-mode'] ) { echo	'ondblclick="this.readOnly=false;" '; }?>/></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th scope="row"><?php _e('Stylesheet File', $this->text_domain ); ?></th>
			<td><input name="properties[css-path]"		type="text" size="80" title="<?php echo	esc_attr($this->options['css-path'] ); ?>" class="pz-click-all-select" value="<?php echo	esc_attr($this->options['css-path'] ); ?>" readonly="readonly" /></td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th scope="row"><?php _e('Stylesheet Templete File', $this->text_domain ); ?></th>
			<td><input name="properties[css-templete]"	type="text" size="80" title="<?php echo	esc_attr($this->options['css-templete'] ); ?>" class="pz-click-all-select" value="<?php echo	esc_attr($this->options['css-templete'] ); ?>" readonly="readonly" /></td>
		</tr>
	</table>
	<?php submit_button(); ?>

	<h2><?php echo	__('Image Settings', $this->text_domain ).$help_open.'image'.$help_close; ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Image Cache URL', $this->text_domain ); ?></th>
			<td>
				<p><input name="properties[thumbnail-url]" type="url" title="<?php echo	$this->options['thumbnail-url']; ?>" class="pz-click-all-select" value="<?php echo	$this->options['thumbnail-url']; ?>" size="80" readonly="readonly" /></p>
				<p><?php _e('Schemes (http and https) are omitted.', $this->text_domain ); ?></p>
				<p><?php $size = pz_GetDirSize($this->options['thumbnail-dir'] ); echo	__('Used', $this->text_domain ).__(': ', $this->text_domain ).pz_GetSizeStringSi($size).' ('.pz_GetStringBytes($size).')'; ?></p>
			</td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th scope="row"><?php _e('Image Cache Directory', $this->text_domain ); ?></th>
			<td>
				<p><input name="properties[thumbnail-dir]" type="text" title="<?php echo	$this->options['thumbnail-dir']; ?>" class="pz-click-all-select" value="<?php echo	$this->options['thumbnail-dir']; ?>" size="80" readonly="readonly" /></p>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>


	<div class="pz-lkc-debug-only">
		<h2><?php echo	__('Survey Settings', $this->text_domain ); ?></h3>
		<table class="form-table">
			<tr class="pz-lkc-debug-only">
				<th scope="row"><?php _e('Log URL', $this->text_domain ); ?></th>
				<td>
					<p><input name="properties[debug-url]" type="url" title="<?php echo	$this->options['debug-url']; ?>" class="pz-click-all-select" value="<?php echo	$this->options['debug-url']; ?>" size="80" readonly="readonly" /></p>
					<p><?php $size = pz_GetDirSize($this->options['debug-dir'] ); echo	__('Used', $this->text_domain ).__(': ', $this->text_domain ).pz_GetSizeStringSi($size).' ('.pz_GetStringBytes($size).')'; ?></p>
				</td>
			</tr>
			<tr class="pz-lkc-admin-only">
				<th scope="row"><?php _e('Log Directory', $this->text_domain ); ?></th>
				<td>
					<p><input name="properties[debug-dir]" type="text" title="<?php echo	$this->options['debug-dir']; ?>" class="pz-click-all-select" value="<?php echo	$this->options['debug-dir']; ?>" size="80" readonly="readonly" /></p>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</div>

	<h2><?php echo	__('Web-API Settings', $this->text_domain ).$help_open.'web-api'.$help_close; ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Site Icon API', $this->text_domain ); ?></th>
			<td>
				<input name="properties[favicon-api]" type="url" size="80" class="pz-click-all-select" value="<?php echo	esc_attr($this->options['favicon-api'] ); ?>" />
				<p><?php echo	__('%DOMAIN% replace to domain name.', $this->text_domain ).' '.__('(', $this->text_domain ).__('ex.', $this->text_domain ).' '.$pz_domain.' '.__(')', $this->text_domain ).'<br>'.__('%DOMAIN_URL% replace to domain URL.').' '.__('(', $this->text_domain ).__('ex.', $this->text_domain ).' '.$pz_domain_url.' '.__(')', $this->text_domain ).'<br>'.__('%URL% replace to URL.', $this->text_domain ).' '.__('(', $this->text_domain ).__('ex.', $this->text_domain ).' '.$pz_url.self::PLUGIN_PATH.' '.__(')', $this->text_domain ); ?>
				<p><?php _e('ex1.', $this->text_domain ); ?><input name="" type="text" size="70" class="pz-click-all-select" value="https://www.google.com/s2/favicons?domain=%DOMAIN%" readonly="readonly" /></p>
				<p><?php _e('ex2.', $this->text_domain ); ?><input name="" type="text" size="70" class="pz-click-all-select" value="https://favicon.hatena.ne.jp/?url=%URL%" readonly="readonly" /></p>
			</td>
		</tr>
		<tr>
			<th scope="row" rowspan="3"><?php _e('Thumbnail API', $this->text_domain ); ?></th>
			<td>
				<input name="properties[thumbnail-api]" type="url" size="80" class="pz-click-all-select" value="<?php echo	esc_attr($this->options['thumbnail-api'] ); ?>" />
				<p><?php echo	__('%URL% replace to URL.', $this->text_domain ).' '.__('(', $this->text_domain ).__('ex.', $this->text_domain ).' '.$pz_url.self::PLUGIN_PATH.' '.__(')', $this->text_domain ); ?></p>
				<p><?php _e('ex1.', $this->text_domain ); ?><input name="" type="text" size="70" class="pz-click-all-select" value="https://s.wordpress.com/mshots/v1/%URL%?w=200" readonly="readonly" /></p>
				<p><?php _e('ex2.', $this->text_domain ); ?><input name="" type="text" size="70" class="pz-click-all-select" value="https://capture.heartrails.com/200x200?%URL%" readonly="readonly" /></p>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>
</div>
