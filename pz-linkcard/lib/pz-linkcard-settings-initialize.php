<?php defined('ABSPATH' ) || wp_die; ?>
<div class="pz-lkc-page" id="pz-lkc-initialize">
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	
	<h2><?php echo	__('Initialize', $this->text_domain ).$help_open.'initialize'.$help_close; ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Initialize Settings', $this->text_domain ); ?></th>
			<td>
				<button type="submit" name="action" value="init-settings" class="pz-lkc-button-sure" onclick="return confirm('<?php _e('Are you sure?', $this->text_domain ); ?>');"><?php _e('Run', $this->text_domain ); ?></button>
				&ensp;<span><?php _e('Reset the "Settings" to the initial value.', $this->text_domain ); ?></span>
			</td>
		</tr>
		<tr class="pz-lkc-admin-only">
			<th scope="row"><?php _e('Initialization Exception', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[initialize-exception]" value="0" />
					<input type="checkbox" name="properties[initialize-exception]" value="1" <?php checked($this->options['initialize-exception'] ); ?> />
					<?php _e('Do not initialize "Survey Mode" and "Administrator Mode".', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>
</div>

