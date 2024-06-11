<?php defined('ABSPATH' ) || wp_die; ?>
<div class="pz-lkc-page" id="pz-lkc-display">
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	
	<h2><?php echo	__('Display Settings', $this->text_domain ).$help_open.'display'.$help_close; ?></h3>
	<table class="form-table" style="width: 100%;">
		<tr>
			<th scope="row"><?php _e('Layout', $this->text_domain ); ?></th>
			<td>
				<table class="pz-lkc-display-layout">
					<tr>
						<td colspan="2">
							<?php _e('Site Information', $this->text_domain ); ?>
							<select name="properties[info-position]">
								<option value=""  <?php selected($this->options['info-position'] == ''  ); ?>><?php _e('None',				$this->text_domain ); ?></option>
								<option value="1" <?php selected($this->options['info-position'] == '1' ); ?>><?php _e('Upper Side',		$this->text_domain ); ?></option>
								<option value="3" <?php selected($this->options['info-position'] == '3' ); ?>><?php _e('Above the Title',	$this->text_domain ); ?></option>
								<option value="2" <?php selected($this->options['info-position'] == '2' ); ?>><?php _e('Under Side',		$this->text_domain ); ?></option>
							</select>
							<label>
								<input type="hidden"   name="properties[use-sitename]" value="0" />
								<input type="checkbox" name="properties[use-sitename]" value="1" <?php checked($this->options['use-sitename'] ); ?> />
								<?php _e('Use SiteName', $this->text_domain ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								<input type="hidden"   name="properties[display-date]" value="0" />
								<input type="checkbox" name="properties[display-date]" value="1" <?php checked($this->options['display-date'] ); ?> />
								<?php _e('For internal links, display the posting date', $this->text_domain ); ?>
							</label>
						</td>
						<td rowspan="10" class="pz-lkc-display-layout-thumbnail">
							<table class="pz-lkc-display-thumbnail">
								<tr>
									<td><?php _e('Thumbnail', $this->text_domain ); ?></td>
								</tr>
								<tr>
									<td>
										<?php _e('Position', $this->text_domain ); ?>
										<select name="properties[thumbnail-position]">
											<option value="0" <?php selected($this->options['thumbnail-position'] == '0' ); ?>><?php _e('None',			$this->text_domain ); ?></option>
											<option value="1" <?php selected($this->options['thumbnail-position'] == '1' ); ?>><?php _e('Right Side',	$this->text_domain ); ?></option>
											<option value="2" <?php selected($this->options['thumbnail-position'] == '2' ); ?>><?php _e('Left Side',	$this->text_domain ); ?></option>
											<option value="3" <?php selected($this->options['thumbnail-position'] == '3' ); ?>><?php _e('Upper Side',	$this->text_domain ); ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td><?php _e('Width', $this->text_domain );  ?><input name="properties[thumbnail-width]"	type="text" size="2" value="<?php echo $this->options['thumbnail-width']; ?>" /></td>
								</tr>
								<tr>
									<td><?php _e('Height', $this->text_domain ); ?><input name="properties[thumbnail-height]"	type="text" size="2" value="<?php echo $this->options['thumbnail-height']; ?>" /></td>
								</tr>
								<tr>
									<td>
										<label>
											<input type="hidden"   name="properties[thumbnail-shadow]" value="0" />
											<input type="checkbox" name="properties[thumbnail-shadow]" value="1" <?php checked($this->options['thumbnail-shadow'] ); ?> />
											<?php _e('Shadow', $this->text_domain ); ?>
										</label>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								<input type="hidden"   name="properties[heading]" value="0" />
								<input type="checkbox" name="properties[heading]" value="1" <?php checked($this->options['heading'] ); ?> />
								<?php _e('Make additional information heading display', $this->text_domain ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								<input type="hidden"   name="properties[flg-anchor]" value="0" />
								<input type="checkbox" name="properties[flg-anchor]" value="1" <?php checked($this->options['flg-anchor'] ); ?> />
								<?php _e('Turn off the anchor text underlining', $this->text_domain ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								<input type="hidden"   name="properties[separator]" value="0" />
								<input type="checkbox" name="properties[separator]" value="1" <?php checked($this->options['separator'] ); ?> />
								<?php _e('Separator line', $this->text_domain ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								<?php _e('Display URL', $this->text_domain ); ?>
								<select name="properties[display-url]">
									<option value=""  <?php selected($this->options['display-url'] == ''  ); ?>><?php _e('None',				$this->text_domain ); ?></option>
									<option value="1" <?php selected($this->options['display-url'] == '1' ); ?>><?php _e('Under Title',			$this->text_domain ); ?></option>
									<option value="2" <?php selected($this->options['display-url'] == '2' ); ?>><?php _e('Bihind Site-Info',	$this->text_domain ); ?></option>
								</select>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								<input type="hidden"   name="properties[content-inset]" value="0" />
								<input type="checkbox" name="properties[content-inset]" value="1" <?php checked($this->options['content-inset'] ); ?> />
								<?php _e('Hollow content area', $this->text_domain ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								<input type="hidden"   name="properties[display-excerpt]" value="0" />
								<input type="checkbox" name="properties[display-excerpt]" value="1" <?php checked($this->options['display-excerpt'] ); ?> />
								<?php _e('display-excerpt', $this->text_domain ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								<input type="hidden"   name="properties[shadow-inset]" value="0" />
								<input type="checkbox" name="properties[shadow-inset]" value="1" <?php checked($this->options['shadow-inset'] ); ?> />
								<?php _e('shadow-inset', $this->text_domain ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								<input type="hidden"   name="properties[shadow]" value="0" />
								<input type="checkbox" name="properties[shadow]" value="1" <?php checked($this->options['shadow'] ); ?> />
								<?php _e('shadow', $this->text_domain ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Round a square', $this->text_domain ); ?>
							<select name="properties[radius]">
								<option value=""  <?php selected($this->options['radius'] == ''  ); ?>><?php _e('None',	$this->text_domain ); ?></option>
								<option value="2" <?php selected($this->options['radius'] == '2' ); ?>><?php _e('4px',	$this->text_domain ); ?></option>
								<option value="1" <?php selected($this->options['radius'] == '1' ); ?>><?php _e('8px',	$this->text_domain ); ?></option>
								<option value="3" <?php selected($this->options['radius'] == '3' ); ?>><?php _e('16px',	$this->text_domain ); ?></option>
								<option value="4" <?php selected($this->options['radius'] == '4' ); ?>><?php _e('32px',	$this->text_domain ); ?></option>
								<option value="5" <?php selected($this->options['radius'] == '5' ); ?>><?php _e('64px',	$this->text_domain ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label>
								<?php _e('When the mouse is on', $this->text_domain ); ?>
								<select name="properties[hover]">
									<option value=""  <?php selected($this->options['hover'] == ''  ); ?>><?php _e('None',			$this->text_domain ); ?></option>
									<option value="1" <?php selected($this->options['hover'] == '1' ); ?>><?php _e('Lighten',		$this->text_domain ); ?></option>
									<option value="2" <?php selected($this->options['hover'] == '2' ); ?>><?php _e('Hover (light)',	$this->text_domain ); ?></option>
									<option value="3" <?php selected($this->options['hover'] == '3' ); ?>><?php _e('Hover (dark)',	$this->text_domain ); ?></option>
									<option value="7" <?php selected($this->options['hover'] == '7' ); ?>><?php _e('Radius',		$this->text_domain ); ?></option>
								</select>
							</label>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Border', $this->text_domain ); ?></th>
			<td>
				<select name="properties[border-style]">
					<option value="none"	<?php selected($this->options['border-style'] == 'none'   ); ?>><?php _e('None',	$this->text_domain ); ?></option>
					<option value="solid"	<?php selected($this->options['border-style'] == 'solid'  ); ?>><?php _e('Solid',	$this->text_domain ); ?></option>
					<option value="dotted"	<?php selected($this->options['border-style'] == 'dotted' ); ?>><?php _e('Dotted',	$this->text_domain ); ?></option>
					<option value="dashed"	<?php selected($this->options['border-style'] == 'dashed' ); ?>><?php _e('Dashed',	$this->text_domain ); ?></option>
					<option value="double"	<?php selected($this->options['border-style'] == 'double' ); ?>><?php _e('Double',	$this->text_domain ); ?></option>
					<option value="groove"	<?php selected($this->options['border-style'] == 'groove' ); ?>><?php _e('Groove',	$this->text_domain ); ?></option>
					<option value="ridge"	<?php selected($this->options['border-style'] == 'ridge'  ); ?>><?php _e('Ridge',	$this->text_domain ); ?></option>
					<option value="inset"	<?php selected($this->options['border-style'] == 'inset'  ); ?>><?php _e('Inset',	$this->text_domain ); ?></option>
					<option value="outset"	<?php selected($this->options['border-style'] == 'outset' ); ?>><?php _e('Outset',	$this->text_domain ); ?></option>
				</select>
				&nbsp;<?php _e('Width', $this->text_domain ); ?><input name="properties[border-width]" type="text" size="2" value="<?php echo	$this->options['border-width']; ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Reset Image Style', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[style-reset-img]" value="0" />
					<input type="checkbox" name="properties[style-reset-img]" value="1" <?php checked($this->options['style-reset-img'] ); ?> />
					<?php _e('When unnecessary frame is displayed on the image, you can improve it by case', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('More Button', $this->text_domain ); ?></th>
			<td>
				<select name="properties[flg-more]">
					<option value=""  <?php selected($this->options['flg-more'] == ''  ); ?>><?php _e('None',			$this->text_domain ); ?></option>
					<option value="1" <?php selected($this->options['flg-more'] == '1' ); ?>><?php _e('Text link',		$this->text_domain ); ?></option>
					<option value="2" <?php selected($this->options['flg-more'] == '2' ); ?>><?php _e('Simple button',	$this->text_domain ); ?></option>
					<option value="3" <?php selected($this->options['flg-more'] == '3' ); ?>><?php _e('Blue',			$this->text_domain ); ?></option>
					<option value="4" <?php selected($this->options['flg-more'] == '4' ); ?>><?php _e('Dark',			$this->text_domain ); ?></option>
				</select>
				<p><?php _e('*', $this->text_domain ); ?> <?php _e('It is recommended that you leave the card height blank when using this setting.', $this->text_domain ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Display SNS Count', $this->text_domain ); ?></th>
			<td>
				<select name="properties[sns-position]">
					<option value=""  <?php selected($this->options['sns-position'] == ''  ); ?>><?php _e('None',				$this->text_domain ); ?></option>
					<option value="1" <?php selected($this->options['sns-position'] == '1' ); ?>><?php _e('Bihind Title',		$this->text_domain ); ?></option>
					<option value="2" <?php selected($this->options['sns-position'] == '2' ); ?>><?php _e('Bihind Site-Info',	$this->text_domain ); ?></option>
				</select>
				<ul>
					<li>
						<label>
							<input type="hidden"   name="properties[sns-tw]" value="0" />
							<input type="checkbox" name="properties[sns-tw]" value="1" <?php checked($this->options['sns-tw'] ); ?> />
							<?php echo __('X (Twitter)',	$this->text_domain ).__('* number is not updated',	$this->text_domain ); ?>
						</label>
						<label>
							<input type="hidden"   name="properties[sns-tw-x]" value="0" />
							<input type="checkbox" name="properties[sns-tw-x]" value="1" <?php checked($this->options['sns-tw-x'] ); ?> />
							<?php echo __('Change the unit of measure to "tweets".', $this->text_domain ); ?>
						</label>
					</li>
					<li>
						<label>
							<input type="hidden"   name="properties[sns-fb]" value="0" />
							<input type="checkbox" name="properties[sns-fb]" value="1" <?php checked($this->options['sns-fb'] ); ?> />
							<?php echo __('Facebook', $this->text_domain ).__('* number is not updated', $this->text_domain ); ?>
						</label>
					</li>
					<li>
						<label>
							<input type="hidden"   name="properties[sns-hb]" value="0" />
							<input type="checkbox" name="properties[sns-hb]" value="1" <?php checked($this->options['sns-hb'] ); ?> />
							<?php echo __('Hatena', $this->text_domain ); ?>
						</label>
					</li>
					<li>
						<label>
							<input type="hidden"   name="properties[sns-po]" value="0" />
							<input type="checkbox" name="properties[sns-po]" value="1" <?php checked($this->options['sns-po'] ); ?> />
							<?php echo __('Pocket',		$this->text_domain ); ?>
						</label>
					</li>
				</ul>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>
</div>
