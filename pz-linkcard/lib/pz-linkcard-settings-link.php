<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	$title	=	array(
		array( 'slug' => 'ex',	'type' => 'external',	'title' => __('External Link Settings',		$this->text_domain )	),
		array( 'slug' => 'in',	'type' => 'internal',	'title' => __('Internal Link Settings',		$this->text_domain )	),
		array( 'slug' => 'th',	'type' => 'samepage',	'title' => __('Same Page Link Settings',	$this->text_domain )	),
	);
	foreach ($title as $t) {
		?>
		<div class="pz-lkc-page" id="pz-lkc-<?php echo $t['type']; ?>">
			<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
			
			<h2><?php echo	$t['title'].$help_open.$t['type'].'-link'.$help_close; ?></h3>
			<table class="form-table">
				<tr>
					<th scope="row"><?php _e('Border Color', $this->text_domain ); ?></th>
					<td>
						<input name="properties[<?php echo $t['slug']; ?>-border-color]" type="color" value="<?php echo esc_attr($this->options[$t['slug'].'-border-color'] ); ?>" class="pz-lkc-sync-text" />
						<input name="properties[<?php echo $t['slug']; ?>-border-color]" type="text"  value="<?php echo esc_attr($this->options[$t['slug'].'-border-color'] ); ?>" class="pz-lkc-sync-text pz-lkc-letter-color-code" />
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Background Color', $this->text_domain ); ?></th>
					<td>
						<input name="properties[<?php echo $t['slug']; ?>-bg-color]" type="color" value="<?php echo esc_attr($this->options[$t['slug'].'-bg-color'] ); ?>" class="pz-lkc-sync-text" />
						<input name="properties[<?php echo $t['slug']; ?>-bg-color]" type="text"  value="<?php echo esc_attr($this->options[$t['slug'].'-bg-color'] ); ?>" class="pz-lkc-sync-text pz-lkc-letter-color-code" />
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Background Image', $this->text_domain ); ?></th>
					<td><input name="properties[<?php echo $t['slug']; ?>-image]" type="text" size="80" value="<?php echo	esc_attr($this->options[$t['slug'].'-image'] ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Thumbnail', $this->text_domain ); ?></th>
					<td>
						<?php if ($t['slug'] == 'th' ) { ?>
						<select disabled="disabled">
							<option selected="selected"><?php _e('It is common with setting Internal-link', $this->text_domain ); ?></option>
						</select>
						<?php } else { ?>
						<select name="properties[<?php echo $t['slug']; ?>-thumbnail]" class="pz-lkc-sync-check">
							<option value=""   <?php selected($this->options[$t['slug'].'-thumbnail'] == ''   ); ?>><?php _e('None',							$this->text_domain ); ?></option>
							<option value="1"  <?php selected($this->options[$t['slug'].'-thumbnail'] == '1'  ); ?>><?php _e('Direct',							$this->text_domain ); ?></option>
							<option value="3"  <?php selected($this->options[$t['slug'].'-thumbnail'] == '3'  ); ?>><?php _e('Use WebAPI',						$this->text_domain ); ?></option>
							<option value="13" <?php selected($this->options[$t['slug'].'-thumbnail'] == '13' ); ?>><?php _e('Use WebAPI ,if can not direct',	$this->text_domain ); ?></option>
						</select>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Thumbnail Size', $this->text_domain ); ?></th>
					<td>
						<?php if ($t['slug'] == 'th' ) { ?>
						<select disabled="disabled">
							<option selected="selected"><?php _e('It is common with setting Internal-link', $this->text_domain ); ?></option>
						</select>
						<?php } else { ?>
						<select name="properties[<?php echo $t['slug']; ?>-thumbnail-size]">
							<option value="thumbnail" <?php selected($this->options[$t['slug'].'-thumbnail-size'] == 'thumbnail' ); ?>><?php _e('Thumbnail (150px)',	$this->text_domain ); ?></option>
							<option value="medium"	  <?php selected($this->options[$t['slug'].'-thumbnail-size'] == 'medium'    ); ?>><?php _e('Medium (300px)',		$this->text_domain ); ?></option>
							<option value="large"	  <?php selected($this->options[$t['slug'].'-thumbnail-size'] == 'large'     ); ?>><?php _e('Large (1024px)',		$this->text_domain ); ?></option>
							<option value="full"	  <?php selected($this->options[$t['slug'].'-thumbnail-size'] == 'full'      ); ?>><?php _e('Full size',			$this->text_domain ); ?></option>
						</select>
						<?php } ?>
					</td>
				</tr>

				<tr>
					<th scope="row"><?php _e('Thubnail Alt Text', $this->text_domain ); ?></th>
					<td>
						<?php if ($t['slug'] == 'th' ) { ?>
						<input type="text" value="<?php _e('It is common with setting Internal-link', $this->text_domain ); ?>" class="regular-text" disabled="disabled" />
						<?php } else { ?>
						<input name="properties[<?php echo $t['slug']; ?>-thumbnail-alt]" type="text" value="<?php echo	esc_attr($this->options[$t['slug'].'-thumbnail-alt'] ); ?>" class="regular-text" /></td>
						<?php } ?>
					</td>
				</tr>

				<tr>
					<th scope="row"><?php _e('Site Icon', $this->text_domain ); ?></th>
					<td>
						<?php if ($t['slug'] == 'th' ) { ?>
						<select disabled="disabled">
							<option selected="selected"><?php _e('It is common with setting Internal-link', $this->text_domain ); ?></option>
						</select>
						<?php } else { ?>
						<select name="properties[<?php echo $t['slug']; ?>-favicon]">
							<option value=""   <?php selected($this->options[$t['slug'].'-favicon'] == ''   ); 																													?>><?php _e('None',								$this->text_domain ); ?></option>
							<option value="1"  <?php selected($this->options[$t['slug'].'-favicon'] == '1'  ); disabled($t['slug'] == 'ex' || ($t['slug'] == 'in' && !function_exists('has_site_icon') || !has_site_icon() ) ); ?>><?php _e('Direct',							$this->text_domain ); ?></option>
							<option value="3"  <?php selected($this->options[$t['slug'].'-favicon'] == '3'  );																													?>><?php _e('Use WebAPI',						$this->text_domain ); ?></option>
							<option value="13" <?php selected($this->options[$t['slug'].'-favicon'] == '13' ); disabled($t['slug'] == 'ex' || ($t['slug'] == 'in' && !function_exists('has_site_icon') || !has_site_icon() ) ); ?>><?php _e('Use WebAPI ,if can not direct',	$this->text_domain ); ?></option>
						</select>
						<?php } ?>
					</td>
				</tr>

				<tr>
					<th scope="row"><?php _e('Site Icon Alt Text', $this->text_domain ); ?></th>
					<td>
						<?php if ($t['slug'] == 'th' ) { ?>
						<input type="text" value="<?php _e('It is common with setting Internal-link', $this->text_domain ); ?>" class="regular-text" disabled="disabled" />
						<?php } else { ?>
						<input name="properties[<?php echo $t['slug']; ?>-favicon-alt]" type="text" value="<?php echo	esc_attr($this->options[$t['slug'].'-favicon-alt'] ); ?>" class="regular-text" /></td>
						<?php } ?>
					</td>
				</tr>

				<tr>
					<th scope="row"><?php _e('Added Information', $this->text_domain ); ?></th>
					<td><input name="properties[<?php echo $t['slug']; ?>-info]" type="text" value="<?php echo	esc_attr($this->options[$t['slug'].'-info'] ); ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Text of More Button', $this->text_domain ); ?></th>
					<td>
						<?php if ($t['slug'] == 'th' ) { ?>
						<input type="text" value="<?php _e('It is common with setting Internal-link', $this->text_domain ); ?>" class="regular-text" disabled="disabled" />
						<?php } else { ?>
						<input name="properties[<?php echo $t['slug']; ?>-more-text]" type="text" value="<?php echo	esc_attr($this->options[$t['slug'].'-more-text'] ); ?>" class="regular-text" />
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Open New Window/Tab', $this->text_domain ); ?></th>
					<td>
						<?php if ($t['slug'] == 'th' ) { ?>
						<select disabled="disabled">
							<option selected="selected"><?php _e('It is common with setting Internal-link', $this->text_domain ); ?></option>
						</select>
						<?php } else { ?>
						<select name="properties[<?php echo $t['slug']; ?>-target]">
							<option value=""  <?php selected($this->options[$t['slug'].'-target'] == ''  ); ?>><?php _e('None',					$this->text_domain ); ?></option>
							<option value="1" <?php selected($this->options[$t['slug'].'-target'] == '1' ); ?>><?php _e('All client',			$this->text_domain ); ?></option>
							<option value="2" <?php selected($this->options[$t['slug'].'-target'] == '2' ); ?>><?php _e('Other than mobile',	$this->text_domain ); ?></option>
						</select>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Get Contents', $this->text_domain ); ?></th>
					<td>
						<?php if ($t['slug'] == 'th' ) { ?>
						<select disabled="disabled">
							<option selected="selected"><?php _e('It is common with setting Internal-link', $this->text_domain ); ?></option>
						</select>
						<?php } else { ?>
						<select name="properties[<?php echo $t['slug']; ?>-get]">
							<option value=""  <?php disabled($t['slug'] == 'ex' ); selected($t['slug'] <> 'ex' && $this->options[$t['slug'].'-get'] == ''  ); ?>><?php _e('Always extract from the latest articles', $this->text_domain ); ?></option>
							<option value="1" <?php disabled($t['slug'] == 'ex' ); selected($t['slug'] <> 'ex' && $this->options[$t['slug'].'-get'] == '1' ); ?>><?php _e('If "excerpt" is set, give priority to it', $this->text_domain ); ?></option>
							<option value="2" <?php                                selected($t['slug'] <> 'ex' && $this->options[$t['slug'].'-get'] == '2' ); ?>><?php _e('Always display the contents registered in card management', $this->text_domain ); ?></option>
						</select>
						<?php } ?>
					</td>
				</tr>
				<?php if ($t['slug'] == 'ex' ) { ?>
				<tr>
					<th scope="row"><?php _e('Set NoFollow', $this->text_domain ); ?></th>
					<td>
						<label>
							<input type="hidden"   name="properties[nofollow]" value="0" />
							<input type="checkbox" name="properties[nofollow]" value="1" <?php checked($this->options['nofollow'] ); ?> />
							<?php _e('In the case of an external site, it puts the "nofollow".', $this->text_domain ); _e('<span class="pz-warning">(Deprecated)</span>', $this->text_domain ); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Set NoOpener', $this->text_domain ); ?></th>
					<td>
						<label>
							<input type="hidden"   name="properties[noopener]" value="0" />
							<input type="checkbox" name="properties[noopener]" value="1" <?php checked($this->options['noopener'] ); ?> />
							<?php _e('In the case of an external site, it puts the "noopener".', $this->text_domain ); ?>
						</label>
					</td>
				</tr>
				<?php } else { ?>
				<tr>
					<th scope="row"><?php _e('Retry Get PID', $this->text_domain ); ?></th>
					<td>
						<label>
							<?php if ($t['slug'] == 'th' ) { ?>
							<input type="checkbox" checked="checked" disabled="disabled" /><?php _e('It is common with setting Internal-link', $this->text_domain ); ?>
							<?php } else { ?>
							<input type="checkbox" name="properties[flg-get-pid]" value="1" <?php checked($this->options['flg-get-pid'] ); ?> />
							<?php _e('When the `Post ID` can not be acquired, it is acquired again.', $this->text_domain ); ?></label>
							<?php } ?>
						</label>
					</td>
				</tr>
				<tr><th scope="row"></th><td><label><input type="checkbox" disabled="disabled" /></label></td></tr>
				<?php } ?>
			</table>
			<?php submit_button(); ?>
		</div>
	<?php
	}
