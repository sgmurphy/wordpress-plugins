<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tab-output" class="white">
	<ul class="collapsible">
		<li>
			<div class="collapsible-header" tabindex="0">
				<b><?php _e( 'Based on pixels:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<div class="row">
					<div class="input-field col s12" style="margin-bottom:0">
						<input id="view_pixels_exclude" type="text"
							name="bulk[pixels][exclude]"
							value="<?php echo esc_attr( $flat_pm_default_selectors['pixels'] ); ?>"
						>
						<label for="view_pixels_exclude">
							<?php _e( 'Exceptions', 'flatpm_l10n' ); ?>
						</label>
					</div>

					<div class="col s12" style="margin-bottom:0">
						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[pixels][action]none" name="bulk[pixels][action]" value="none" checked="checked">
							<label for="bulk[pixels][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[pixels][action]add" name="bulk[pixels][action]" value="add">
							<label for="bulk[pixels][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[pixels][action]overwrite" name="bulk[pixels][action]" value="overwrite">
							<label for="bulk[pixels][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>

					<div class="input-field col s12 hidden">
						<input id="view_pixels_xpath" type="text"
							name="bulk[pixels][xpath]"
							value="<?php echo esc_attr( $flat_pm_default_selectors['pixels_xpath'] ); ?>"
						>
						<label for="view_pixels_xpath"><?php _e( 'Selector', 'flatpm_l10n' ); ?></label>
					</div>
				</div>
			</div>
		</li>

		<li>
			<div class="collapsible-header" tabindex="0">
				<b><?php _e( 'Based on symbols:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<div class="row">
					<div class="input-field col s12" style="margin-bottom:0">
						<input id="view_symbols_exclude" type="text"
							name="bulk[symbols][exclude]"
							value="<?php echo esc_attr( $flat_pm_default_selectors['symbols'] ); ?>"
						>
						<label for="view_symbols_exclude">
							<?php _e( 'Exceptions', 'flatpm_l10n' ); ?>
						</label>
					</div>

					<div class="col s12" style="margin-bottom:0">
						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[symbols][action]none" name="bulk[symbols][action]" value="none" checked="checked">
							<label for="bulk[symbols][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[symbols][action]add" name="bulk[symbols][action]" value="add">
							<label for="bulk[symbols][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[symbols][action]overwrite" name="bulk[symbols][action]" value="overwrite">
							<label for="bulk[symbols][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>

					<div class="input-field col s12 hidden">
						<input id="view_symbols_xpath" type="text"
							name="bulk[symbols][xpath]"
							value="<?php echo esc_attr( $flat_pm_default_selectors['symbols_xpath'] ); ?>"
						>
						<label for="view_symbols_xpath"><?php _e( 'Selector', 'flatpm_l10n' ); ?></label>
					</div>
				</div>
			</div>
		</li>

		<li>
			<div class="collapsible-header" tabindex="0">
				<b><?php _e( 'Video pre-roll:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<div class="row">
					<div class="input-field col s12" style="margin-bottom:0">
						<input id="view_preroll_exclude" type="text"
							name="bulk[preroll][exclude]"
							value="<?php echo esc_attr( $flat_pm_default_selectors['preroll'] ); ?>"
						>
						<label for="view_preroll_exclude">
							<?php _e( 'Selector for iframes or video containers', 'flatpm_l10n' ); ?>
						</label>
					</div>

					<div class="col s12" style="margin-bottom:0">
						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[preroll][action]none" name="bulk[preroll][action]" value="none" checked="checked">
							<label for="bulk[preroll][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[preroll][action]add" name="bulk[preroll][action]" value="add">
							<label for="bulk[preroll][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[preroll][action]overwrite" name="bulk[preroll][action]" value="overwrite">
							<label for="bulk[preroll][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>

					<div class="input-field col s12 hidden">
						<input id="view_preroll_xpath" type="text"
							name="bulk[preroll][xpath]"
							value="<?php echo esc_attr( $flat_pm_default_selectors['preroll_xpath'] ); ?>"
						>
						<label for="view_preroll_xpath"><?php _e( 'Selector', 'flatpm_l10n' ); ?></label>
					</div>
				</div>
			</div>
		</li>

		<li>
			<div class="collapsible-header" tabindex="0">
				<b><?php _e( 'Hover-roll:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<div class="row">
					<div class="input-field col s12" style="margin-bottom:0">
						<input id="view_hoverroll_exclude" type="text"
							name="bulk[hoverroll][exclude]"
							value="<?php echo esc_attr( $flat_pm_default_selectors['hoverroll'] ); ?>"
						>
						<label for="view_hoverroll_exclude">
							<?php _e( 'Selector for containers', 'flatpm_l10n' ); ?>
						</label>
					</div>

					<div class="col s12" style="margin-bottom:0">
						<div class="exclude_block_flat_pm">
							<input type="radio" id="bulk[hoverroll][action]none" name="bulk[hoverroll][action]" value="none" checked="checked">
							<label for="bulk[hoverroll][action]none">
								<?php _e( 'Ignore', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[hoverroll][action]add" name="bulk[hoverroll][action]" value="add">
							<label for="bulk[hoverroll][action]add">
								<?php _e( 'Add', 'flatpm_l10n' ); ?>
							</label>

							<input type="radio" id="bulk[hoverroll][action]overwrite" name="bulk[hoverroll][action]" value="overwrite">
							<label for="bulk[hoverroll][action]overwrite">
								<?php _e( 'Overwrite', 'flatpm_l10n' ); ?>
							</label>
						</div>
					</div>

					<div class="input-field col s12 hidden">
						<input id="view_hoverroll_xpath" type="text"
							name="bulk[hoverroll][xpath]"
							value="<?php echo esc_attr( $flat_pm_default_selectors['hoverroll_xpath'] ); ?>"
						>
						<label for="view_hoverroll_xpath"><?php _e( 'Selector', 'flatpm_l10n' ); ?></label>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>