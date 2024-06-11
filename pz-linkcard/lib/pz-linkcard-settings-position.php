<?php defined('ABSPATH' ) || wp_die; ?>
<div class="pz-lkc-page" id="pz-lkc-position">
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	
	<h2><?php echo	__('Position Settings', $this->text_domain ).$help_open.'position'.$help_close; ?></h3>

	<table class="pz-lkc-position-margin">
		<tr>
			<td></td>
			<td>
				<?php _e('Margin top', $this->text_domain ); ?><br>
				<select name="properties[margin-top]">
					<option value=""	 <?php selected($this->options['margin-top'] == ''     ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
					<option value="0"	 <?php selected($this->options['margin-top'] == '0'    ); ?>><?php _e('0', $this->text_domain ); ?></option>
					<option value="4px"	 <?php selected($this->options['margin-top'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
					<option value="8px"	 <?php selected($this->options['margin-top'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
					<option value="16px" <?php selected($this->options['margin-top'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
					<option value="32px" <?php selected($this->options['margin-top'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
					<option value="40px" <?php selected($this->options['margin-top'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
					<option value="64px" <?php selected($this->options['margin-top'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
				</select>
			</td>
			<td></td>
		</tr>
		<tr>
			<td style="vertical-align: middle; text-align: left;">
				<?php _e('Margin left', $this->text_domain ); ?><br>
				<select name="properties[margin-left]">
					<option value=""	 <?php selected($this->options['margin-left'] == ''     ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
					<option value="0"	 <?php selected($this->options['margin-left'] == '0'    ); ?>><?php _e('0', $this->text_domain ); ?></option>
					<option value="4px"	 <?php selected($this->options['margin-left'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
					<option value="8px"	 <?php selected($this->options['margin-left'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
					<option value="16px" <?php selected($this->options['margin-left'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
					<option value="32px" <?php selected($this->options['margin-left'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
					<option value="40px" <?php selected($this->options['margin-left'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
					<option value="64px" <?php selected($this->options['margin-left'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
				</select>
			</td>

			<td>
				<table class="pz-lkc-position-margin-card form-table">
					<tr>
						<td colspan="3">
							<?php _e('Margin top', $this->text_domain ); ?><br>
							<select name="properties[card-top]">
								<option value=""	 <?php selected($this->options['card-top'] == ''     ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
								<option value="0"	 <?php selected($this->options['card-top'] == '0'    ); ?>><?php _e('0', $this->text_domain ); ?></option>
								<option value="4px"	 <?php selected($this->options['card-top'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
								<option value="8px"	 <?php selected($this->options['card-top'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
								<option value="16px" <?php selected($this->options['card-top'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
								<option value="24px" <?php selected($this->options['card-top'] == '24px' ); ?>><?php _e('24px', $this->text_domain ); ?></option>
								<option value="32px" <?php selected($this->options['card-top'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
								<option value="40px" <?php selected($this->options['card-top'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
								<option value="64px" <?php selected($this->options['card-top'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align: left;">
							<?php _e('Margin left', $this->text_domain ); ?><br>
							<select name="properties[card-left]">
								<option value=""	 <?php selected($this->options['card-left'] == ''	  ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
								<option value="0"	 <?php selected($this->options['card-left'] == '0'	  ); ?>><?php _e('0', $this->text_domain ); ?></option>
								<option value="4px"	 <?php selected($this->options['card-left'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
								<option value="8px"	 <?php selected($this->options['card-left'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
								<option value="16px" <?php selected($this->options['card-left'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
								<option value="24px" <?php selected($this->options['card-left'] == '24px' ); ?>><?php _e('24px', $this->text_domain ); ?></option>
								<option value="32px" <?php selected($this->options['card-left'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
								<option value="40px" <?php selected($this->options['card-left'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
								<option value="64px" <?php selected($this->options['card-left'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
							</select>
						</td>
						<td>
							<?php _e('Width', $this->text_domain ); ?> <input name="properties[width]"          type="text" size="2" value="<?php echo	esc_attr($this->options['width'] ); ?>" /><br>
							<?php _e('Height', $this->text_domain ); ?><input name="properties[content-height]" type="text" size="2" value="<?php echo	esc_attr($this->options['content-height'] ); ?>" /><br>
						</td>
						<td style="text-align: right;">
							<?php _e('Margin right', $this->text_domain ); ?><br>
							<select name="properties[card-right]">
								<option value=""	 <?php selected($this->options['card-right'] == ''	   ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
								<option value="0"	 <?php selected($this->options['card-right'] == '0'	   ); ?>><?php _e('0', $this->text_domain ); ?></option>
								<option value="4px"	 <?php selected($this->options['card-right'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
								<option value="8px"	 <?php selected($this->options['card-right'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
								<option value="16px" <?php selected($this->options['card-right'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
								<option value="24px" <?php selected($this->options['card-right'] == '24px' ); ?>><?php _e('24px', $this->text_domain ); ?></option>
								<option value="32px" <?php selected($this->options['card-right'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
								<option value="40px" <?php selected($this->options['card-right'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
								<option value="64px" <?php selected($this->options['card-right'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<?php _e('Margin bottom', $this->text_domain ); ?><br>
							<select name="properties[card-bottom]">
								<option value=""	 <?php selected($this->options['card-bottom'] == ''		); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
								<option value="0"	 <?php selected($this->options['card-bottom'] == '0'	); ?>><?php _e('0', $this->text_domain ); ?></option>
								<option value="4px"	 <?php selected($this->options['card-bottom'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
								<option value="8px"	 <?php selected($this->options['card-bottom'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
								<option value="16px" <?php selected($this->options['card-bottom'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
								<option value="24px" <?php selected($this->options['card-bottom'] == '24px' ); ?>><?php _e('24px', $this->text_domain ); ?></option>
								<option value="32px" <?php selected($this->options['card-bottom'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
								<option value="40px" <?php selected($this->options['card-bottom'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
								<option value="64px" <?php selected($this->options['card-bottom'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
							</select>
						</td>
					</tr>
				</table>

			</td>
			<td style="vertical-align: middle; text-align: right;">
				<?php _e('Margin right', $this->text_domain ); ?><br>
				<select name="properties[margin-right]">
					<option value=""	 <?php selected($this->options['margin-right'] == ''     ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
					<option value="0"	 <?php selected($this->options['margin-right'] == '0'    ); ?>><?php _e('0', $this->text_domain ); ?></option>
					<option value="4px"	 <?php selected($this->options['margin-right'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
					<option value="8px"	 <?php selected($this->options['margin-right'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
					<option value="16px" <?php selected($this->options['margin-right'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
					<option value="32px" <?php selected($this->options['margin-right'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
					<option value="40px" <?php selected($this->options['margin-right'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
					<option value="64px" <?php selected($this->options['margin-right'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label>
					<input type="hidden"   name="properties[centering]" value="0" />
					<input type="checkbox" name="properties[centering]" value="1" <?php checked($this->options['centering'] ); ?> />
					<?php _e('Centering', $this->text_domain ); ?>
				</label>
			</td>
			<td>
				<?php _e('Margin bottom', $this->text_domain ); ?><br>
				<select name="properties[margin-bottom]">
					<option value=""	 <?php selected($this->options['margin-bottom'] == ''     ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
					<option value="0"	 <?php selected($this->options['margin-bottom'] == '0'    ); ?>><?php _e('0', $this->text_domain ); ?></option>
					<option value="4px"	 <?php selected($this->options['margin-bottom'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
					<option value="8px"	 <?php selected($this->options['margin-bottom'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
					<option value="16px" <?php selected($this->options['margin-bottom'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
					<option value="32px" <?php selected($this->options['margin-bottom'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
					<option value="40px" <?php selected($this->options['margin-bottom'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
					<option value="64px" <?php selected($this->options['margin-bottom'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
				</select>
			</td>
			<td>
			</td>
		</tr>
	</table>

	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Link the Whole', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[link-all]" value="0" />
					<input type="checkbox" name="properties[link-all]" value="1" <?php checked($this->options['link-all'] ); ?> />
					<?php _e('Enclose the entire card at anchor.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Use Blockquote Tag', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[blockquote]" value="0" />
					<input type="checkbox" name="properties[blockquote]" value="1" <?php checked($this->options['blockquote'] ); ?> />
					<?php _e('Without using DIV tag, and use BLOCKQUOTE tag.', $this->text_domain ); _e('(Deprecated)', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>
</div>
