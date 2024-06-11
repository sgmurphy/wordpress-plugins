<?php defined('ABSPATH' ) || wp_die; ?>
<div class="pz-lkc-page" id="pz-lkc-letter">
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	
	<h2><?php echo	__('Letter Settings', $this->text_domain ).$help_open.'letter'.$help_close; ?></h3>
	<table class="form-table">
		<?php
			$table	=	array(
				array( 'slug' => 'title'	,	'title' => __('Title',				$this->text_domain )	),
				array( 'slug' => 'url'		,	'title' => __('URL',				$this->text_domain )	),
				array( 'slug' => 'excerpt'	,	'title' => __('Excerpt',			$this->text_domain )	),
				array( 'slug' => 'more'		,	'title' => __('More Button',		$this->text_domain )	),
				array( 'slug' => 'info'		,	'title' => __('Site Information',	$this->text_domain )	),
				array( 'slug' => 'added'	,	'title' => __('Added Information',	$this->text_domain )	),
			);
			foreach ($table as $t) {
		?>
		<tr>
			<th scope="row"><?php echo	$t['title']; ?></th>
			<td>
				<div class="pz-lkc-letter-box">
					<div>
						<?php _e('Color', $this->text_domain ); ?>
						<?php $name = $t['slug'].'-color';			$val = esc_attr($this->options[$name] ); ?>
						<input name="properties[<?php echo	$name; ?>]" type="color"    value="<?php echo	$val; ?>" class="pz-lkc-sync-text"  />
						<input name="properties[<?php echo	$name; ?>]" type="text"     value="<?php echo	$val; ?>" class="pz-lkc-sync-text pz-lkc-letter-color-code" />
						&emsp;
						<?php $name = $t['slug'].'-outline';		$val = esc_attr($this->options[$name] ); ?>
						<label>
						<input name="properties[<?php echo	$name; ?>]" type="checkbox" value="1" <?php checked($val ); ?> /><?php _e('Outline', $this->text_domain ); ?></label>
						<?php $name = $t['slug'].'-outline-color';	$val = esc_attr($this->options[$name] ); ?>
						<input name="properties[<?php echo	$name; ?>]" type="color"    value="<?php echo	$val; ?>" class="pz-lkc-sync-text" />
						<input name="properties[<?php echo	$name; ?>]" type="text"     value="<?php echo	$val; ?>" class="pz-lkc-sync-text pz-lkc-letter-color-code" />
					</div>
					<div>
						<?php _e('Size', $this->text_domain ); ?>
						<?php $name = $t['slug'].'-size';			$val = esc_attr($this->options[$name] ); ?>
						<input name="properties[<?php echo	$name; ?>]" type="text"     value="<?php echo	$val; ?>" size="2" />
						&emsp;
						<?php _e('Height',	$this->text_domain ); ?>
						<?php $name = $t['slug'].'-height';			$val = esc_attr($this->options[$name] ); ?>
						<input name="properties[<?php echo	$name; ?>]" type="text"     value="<?php echo	$val; ?>" size="2" />
						&emsp;
						<?php $name = $t['slug'].'-trim';			if ( array_key_exists($name, $this->options ) ) { $val = esc_attr($this->options[$name] ); ?>
							<?php _e('Length',	$this->text_domain ); ?>
							<input name="properties[<?php echo	$name; ?>]" type="text"     value="<?php echo	$val; ?>" size="2" />
						<?php } ?>
						<?php $name = $t['slug'].'-nowrap';			if ( array_key_exists($name, $this->options ) ) { $val = esc_attr($this->options[$name] ); ?>
							<label><input name="properties[<?php echo	$name; ?>]" type="checkbox" value="1" <?php checked($val ); ?>><?php _e('No wrap', $this->text_domain ); ?></label>
						<?php } ?>
					</div>
				</div>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<th scope="row"><?php _e('Resize', $this->text_domain ); ?></th>
			<td colspan="4">
				<label>
					<input type="hidden"   name="properties[thumbnail-resize]" value="0" />
					<input type="checkbox" name="properties[thumbnail-resize]" value="1" <?php checked($this->options['thumbnail-resize'] ); ?> />
					<?php _e('Adjust thumbnail and letter size according to width.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>
</div>
