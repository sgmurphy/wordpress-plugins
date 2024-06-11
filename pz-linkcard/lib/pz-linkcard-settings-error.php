<?php defined('ABSPATH' ) || wp_die; ?>
<div class="pz-lkc-page" id="pz-lkc-error">
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	
	<h2><?php echo	__('Error Settings', $this->text_domain ).$help_open.'error'.$help_close; ?></h3>
	<div class="pz-error-text">
		<?php _e('The shortcode description is incorrect. Please open the "Linked Articles" section and correct it.', $this->text_domain ); ?>
	</div>
	<table class="pz-lkc-set-table form-table">
		<tr>
			<th scope="row"><?php _e('Post URL', $this->text_domain ); ?></th>
			<td>
				<a href="<?php echo esc_url($this->options['error-url'] ); ?>" class="pz-lkc-error-url"><?php echo esc_url($this->options['error-url'] ); ?></a>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Occurrence Time', $this->text_domain ); ?></th>
			<td>
				<span><?php echo is_numeric($this->options['error-time'] ) ? date($this->datetime_format, $this->options['error-time'] ) : $this->options['error-time']; ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Error Reset', $this->text_domain ); ?></th>
			<td>
				<button type="submit" name="action" value="clear-error" class="pz-lkc-button"><?php _e('Reset', $this->text_domain ); ?></button>
				&ensp;<span><?php _e('Cancel the error condition.', $this->text_domain ); ?></span>
				<br /><span class="pz-warning"><?php _e('* If you have not corrected the error, you may still get an error even if you cancel the error.', $this->text_domain ); ?></span>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>
</div>
