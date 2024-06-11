<?php defined('ABSPATH' ) || wp_die; ?>
<div class="pz-lkc-page" id="pz-lkc-basic">
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>
	
	<h2><?php echo	__('Basic Settings', $this->text_domain ).$help_open.'basic'.$help_close; ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Easy format', $this->text_domain ); ?></th>
			<td>
				<select name="properties[special-format]">
					<option value=""	<?php selected($this->options['special-format'] == ''    ); ?>><?php _e('None', $this->text_domain ); ?></option>
					<option value="LkC"	<?php selected($this->options['special-format'] == 'LkC' ); ?>><?php _e('Pz-LkC Default', $this->text_domain ); ?></option>

					<option value="hbc"	<?php selected($this->options['special-format'] == 'hbc' ); ?>><?php _e('Normal', $this->text_domain ); ?></option>
					<option value="cmp"	<?php selected($this->options['special-format'] == 'cmp' ); ?>><?php _e('Compact', $this->text_domain ); ?></option>
					<option value="smp"	<?php selected($this->options['special-format'] == 'smp' ); ?>><?php _e('Simple', $this->text_domain ); ?></option>
					<option value="JIN"	<?php selected($this->options['special-format'] == 'JIN' ); ?>><?php _e('Headline', $this->text_domain ); ?></option>

					<option value="ct1"	<?php selected($this->options['special-format'] == 'ct1' ); ?>><?php _e('Cellophane tape "center"', $this->text_domain ); ?></option>
					<option value="ct2"	<?php selected($this->options['special-format'] == 'ct2' ); ?>><?php _e('Cellophane tape "Top corner"', $this->text_domain ); ?></option>
					<option value="ct3"	<?php selected($this->options['special-format'] == 'ct3' ); ?>><?php _e('Cellophane tape "long"', $this->text_domain ); ?></option>
					<option value="ct4"	<?php selected($this->options['special-format'] == 'ct4' ); ?>><?php _e('Cellophane tape "digonal"', $this->text_domain ); ?></option>
					<option value="tac"	<?php selected($this->options['special-format'] == 'tac' ); ?>><?php _e('Cellophane tape and curling', $this->text_domain ); ?></option>
					<option value="ppc"	<?php selected($this->options['special-format'] == 'ppc' ); ?>><?php _e('Curling paper', $this->text_domain ); ?></option>

					<option value="sBR"	<?php selected($this->options['special-format'] == 'sBR' ); ?>><?php _e('Stitch blue & red', $this->text_domain ); ?></option>
					<option value="sGY"	<?php selected($this->options['special-format'] == 'sGY' ); ?>><?php _e('Stitch green & yellow', $this->text_domain ); ?></option>

					<option value="sqr"	<?php selected($this->options['special-format'] == 'sqr' ); ?>><?php _e('Square', $this->text_domain ); ?></option>

					<option value="ecl"	<?php selected($this->options['special-format'] == 'ecl' ); ?>><?php _e('Enclose', $this->text_domain ); ?></option>
					<option value="ref"	<?php selected($this->options['special-format'] == 'ref' ); ?>><?php _e('Reflection', $this->text_domain ); ?></option>

					<option value="inI"	<?php selected($this->options['special-format'] == 'inI' ); ?>><?php _e('Infomation orange', $this->text_domain ); ?></option>
					<option value="inN"	<?php selected($this->options['special-format'] == 'inN' ); ?>><?php _e('Neutral bluegreen', $this->text_domain ); ?></option>
					<option value="inE"	<?php selected($this->options['special-format'] == 'inE' ); ?>><?php _e('Enlightened green', $this->text_domain ); ?></option>
					<option value="inR"	<?php selected($this->options['special-format'] == 'inR' ); ?>><?php _e('Resistance blue', $this->text_domain ); ?></option>

					<option value="wxp"	<?php selected($this->options['special-format'] == 'wxp' ); ?>><?php _e('Windows XP', $this->text_domain ); ?></option>
					<option value="w95"	<?php selected($this->options['special-format'] == 'w95' ); ?>><?php _e('Windows 95', $this->text_domain ); ?></option>

					<option value="slt"	<?php selected($this->options['special-format'] == 'slt' ); ?>><?php _e('Slanting', $this->text_domain ); ?></option>

					<option value="3Dr"	<?php selected($this->options['special-format'] == '3Dr' ); ?>><?php _e('3D Rotate', $this->text_domain ); ?></option>
					<option value="pin"	<?php selected($this->options['special-format'] == 'pin' ); ?>><?php _e('Pushpin', $this->text_domain ); ?></option>
				</select>
				<br><span class="pz-lkc-note"><?php echo __('*', $this->text_domain ).' '.__('It applies over other formatting settings.', $this->text_domain ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Saved Datetime', $this->text_domain ); ?></th>
			<td>
				<input type="text" size="40" value="<?php echo is_numeric($this->options['saved-date'] ) ? date($this->datetime_format, $this->options['saved-date'] ) : $this->options['saved-date']; ?>" readonly="readonly" />
				<input name="properties[saved-date]" type="text" value="<?php echo $this->options['saved-date']; ?>" class="pz-lkc-admin-only" readonly="readonly" />
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>

	<h2><?php echo	__('Changelog', $this->text_domain ); ?></h3>
	<div class="pz-lkc-changelog">
		<?php echo	$changelog; ?>
	</div>
	<?php submit_button(); ?>

	<h2><?php echo	__('Related Information', $this->text_domain ); ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php echo	__('How to', $this->text_domain ).' '.__('(', $this->text_domain ).__('Japanese Only', $this->text_domain ).__(')', $this->text_domain ); ?></th>
			<td>
				<p><?php echo	self::PLUGIN_NAME.' Ver.'.PLUGIN_VERSION; ?></p>
				<p><a href="<?php echo	esc_attr($plugin_url ); ?>" rel="external noopener" target="_blank"><?php echo	esc_attr($plugin_url ); ?></a></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e("Author's Site", $this->text_domain ); ?></th>
			<td><?php echo	__('Popozure.', $this->text_domain ).' ('.__("Poporon's PC Daily Diary", $this->text_domain ).')'; ?><BR><a href="<?php echo $pz_url; ?>" rel="external noopener" target="_blank"><?php echo $pz_url; ?></A></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('When in Trouble', $this->text_domain ); ?></th>
			<td><?php echo	__('Twitter Account', $this->text_domain ); ?><BR><a href="<?php echo self::AUTHOR_TWITTER_URL; ?>" rel="external noopener" target="_blank"><?php echo self::AUTHOR_TWITTER; ?></A></td>
		</tr>

		<tr class="pz-lkc-debug-only">
			<th scope="row"><?php _e('Donation', $this->text_domain ); ?></th>
			<td><a href="<?php echo self::AUTHOR_DONATE_URL; ?>" rel="external noopenner noreferrer" target="_blank" target="_blank"><?php _e('Wishlist', $this->text_domain ); ?></a></td>
		</tr>

	</table>
	<?php submit_button(); ?>
</div>
