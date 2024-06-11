<?php defined('ABSPATH' ) || wp_die; ?>
<div class="pz-lkc-page" id="pz-lkc-multisite">
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	<h2><?php echo	__('Multi Site Information', $this->text_domain ).$help_open.'multisite'.$help_close; ?></h2>
	<div class="pz-lkc-multi-notice"><?php echo __('*** Cannot be changed ***', $this->text_domain ); ?></div>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Multi Site', $this->text_domain ); ?></th>
			<td>
				<select>
					<option value="0" <?php selected(!$is_multisite ); disabled( $is_multisite ); ?>><?php _e('Disabled',			$this->text_domain ); ?></option>
					<option value="1" <?php selected( $is_multisite ); disabled(!$is_multisite ); ?>><?php _e('Enabled',			$this->text_domain ); ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Type', $this->text_domain ); ?></th>
			<td>
				<select <?php disabled(!$is_multisite ); ?>>
					<option value="0" <?php selected(!$is_subdomain ); disabled( $is_subdomain ); ?>><?php _e('Subdirectories',	$this->text_domain ); ?></option>
					<option value="1" <?php selected( $is_subdomain ); disabled(!$is_subdomain ); ?>><?php _e('Subdomains',		$this->text_domain ); ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Current Blog ID', $this->text_domain ); ?></th>
			<td>
				<input name="properties[multi-myid]" type="text" size="8" value="<?php echo	esc_attr($multi_myid ); ?>" readonly="readonly" />
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Number of Sites', $this->text_domain ); ?></th>
			<td>
				<input name="properties[multi-count]" type="text" size="8" value="<?php echo	esc_attr($multi_count ); ?>" readonly="readonly" />
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Table Name', $this->text_domain ); ?></th>
			<td><input type="text" size="40" value="<?php echo esc_html($this->db_name ); ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Link to SubSite', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="checkbox" value="1" checked="checked" readonly="readonly" />
					<?php _e('Treat links to subsites as external links.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>

	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	<h2><?php echo	__('Site List', $this->text_domain ).$help_open.'multisite'.$help_close; ?></h2>
	<div class="pz-lkc-multi-notice"><?php echo __('*** Cannot be changed ***', $this->text_domain ); ?></div>
	<table class="form-table pz-lkc-multi-list widefat striped">
		<thead>
			<tr>
				<th scope="col" class="pz-lkc-multi-head-current"><?php _e('Current', $this->text_domain ); ?></th>
				<th scope="col" class="pz-lkc-multi-head-blog-id"><?php _e('Blog ID', $this->text_domain ); ?></th>
				<th scope="col" class="pz-lkc-multi-head-site-name"><?php _e('Site Name', $this->text_domain ); ?></th>
				<th scope="col" class="pz-lkc-multi-head-url"><?php _e('URL', $this->text_domain ); ?></th>
				<th scope="col" class="pz-lkc-multi-head-domain"><?php _e('Domain', $this->text_domain ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php for ($i = 1; $i <= $multi_count; $i++) { ?>
			<tr>
				<th class="pz-lkc-multi-body-current" scope="row">
					<input type="hidden"   name="" value="0" />
					<input type="checkbox" name="" value="1" <?php checked($multi[$i]['id'] == $multi_myid ); ?> readonly="readonly" />
				</th>
				<td class="pz-lkc-multi-body-blog-id"><input name="properties[multi-<?php echo	$i; ?>-id]"     type="hidden" value="<?php echo	$multi[$i]['id'];     ?>" /><?php echo	$multi[$i]['id'];     ?></td>
				<td class="pz-lkc-multi-body-site-name"><input name="properties[multi-<?php echo	$i; ?>-name]"   type="hidden" value="<?php echo	$multi[$i]['name'];   ?>" /><?php echo	$multi[$i]['name'];   ?></td>
				<td class="pz-lkc-multi-body-url"><input name="properties[multi-<?php echo	$i; ?>-url]"    type="hidden" value="<?php echo	$multi[$i]['url'];    ?>" /><?php echo	$multi[$i]['url'];    ?></td>
				<td class="pz-lkc-multi-body-domain"><input name="properties[multi-<?php echo	$i; ?>-domain]" type="hidden" value="<?php echo	$multi[$i]['domain']; ?>" /><?php echo	$multi[$i]['domain']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php submit_button(); ?>
</div>
