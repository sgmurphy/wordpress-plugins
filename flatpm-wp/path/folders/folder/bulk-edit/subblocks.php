<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tab-subblocks" class="white">
	<ul class="collapsible">
		<li class="active">
			<div class="collapsible-header" tabindex="0">
				<b><?php _e( 'Replace code in subblocks:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<div class="row">
					<div class="col s12 m6">
						<textarea class="default" name="bulk[html][replace][from]" style="min-height:95px" placeholder="<?php esc_attr_e( 'Search', 'flatpm_l10n' ); ?>"></textarea>
					</div>

					<div class="col s12 m6">
						<textarea class="default" name="bulk[html][replace][to]" style="min-height:95px" placeholder="<?php esc_attr_e( 'Replace', 'flatpm_l10n' ); ?>"></textarea>
					</div>

					<div class="col s12">
						<p><?php _e( 'Replacement search method:', 'flatpm_l10n' ); ?></p>
					</div>

					<div class="col s12">
						<label>
							<input class="with-gap" name="bulk[html][replace][method]" type="radio" value="default" checked="checked">
							<span><?php _e( 'Full-text', 'flatpm_l10n' ); ?></span>
						</label>
					</div>

					<div class="col s12">
						<label>
							<input class="with-gap" name="bulk[html][replace][method]" type="radio" value="perline">
							<span><?php _e( 'Line by line', 'flatpm_l10n' ); ?></span>
						</label>
					</div>

					<div class="col s12">
						<label>
							<input class="with-gap" name="bulk[html][replace][method]" type="radio" value="regexp">
							<span><?php _e( 'Regular expressions', 'flatpm_l10n' ); ?></span>
						</label>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>