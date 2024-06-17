<div id="search-publish-modal" class="modal">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Choose publications', 'flatpm_l10n' ); ?></h4>
		<p><?php _e( 'You can search as a single entry by entering the id, url or title, or as a list.<br>Each query on a new line:', 'flatpm_l10n' ); ?></p>

		<div class="col s12">
			<div class="row" style="margin-bottom:10px">
				<div class="row" style="margin-bottom:0">
					<div class="col s12 m5">
						<textarea class="default" name="search-publish-query" id="search-publish-query" placeholder="<?php esc_attr_e( 'What are we looking for?', 'flatpm_l10n' ); ?>" style="min-height:220.5px"></textarea>
					</div>

					<div class="col s12 m7">
						<ul class="extended_list collection" style="margin:0"></ul>
					</div>
				</div>
			</div>
		</div>

		<small><?php _e( 'minimum query length for url - 8 characters', 'flatpm_l10n' ); ?>,</small>
		<small><?php _e( 'minimum query length for title - 4 characters', 'flatpm_l10n' ); ?></small>

		<div class="col s12 add_all">
			<button class="row btn btn-small z-depth-0 waves-effect right" type="button"><?php _e( 'Add all', 'flatpm_l10n' ); ?></button>
		</div>
	</div>
</div>


<div id="search-taxonomy-modal" class="modal">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Choose taxonomies', 'flatpm_l10n' ); ?></h4>
		<p><?php _e( 'You can search for one taxonomy by entering id, slug or title, or as a list.<br>Each query on a new line:', 'flatpm_l10n' ); ?></p>

		<div class="col s12">
			<div class="row" style="margin-bottom:10px">
				<div class="row" style="margin-bottom:0">
					<div class="col s12 m5">
						<textarea class="default" name="search-taxonomy-query" id="search-taxonomy-query" placeholder="Что будем искать?" style="min-height:220.5px"></textarea>
					</div>

					<div class="col s12 m7">
						<ul class="extended_list collection" style="margin:0"></ul>
					</div>
				</div>
			</div>
		</div>

		<small><?php _e( 'minimum query length for url - 8 characters', 'flatpm_l10n' ); ?>,</small>
		<small><?php _e( 'minimum query length for title - 4 characters', 'flatpm_l10n' ); ?></small>

		<div class="col s12 add_all">
			<button class="row btn btn-small z-depth-0 waves-effect right" type="button"><?php _e( 'Add all', 'flatpm_l10n' ); ?></button>
		</div>
	</div>
</div>

<div id="confirm-enable-fast-mode" class="modal" style="width:600px" tabindex="0">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Confirm enabling "Fast Mode"', 'flatpm_l10n' ) ?></h4>
		<p><?php _e( 'In this mode, all types of block output will be turned off, except for "Based on selectors (Once)"', 'flatpm_l10n' ) ?></p>

		<button class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
		<button class="modal-close waves-effect btn-flat confirm-enable-fast-mode"><?php _e( 'I confirm', 'flatpm_l10n' ); ?></button>
	</div>
</div>



<form id="confirm-insert-link_image" class="modal" style="width:600px" tabindex="0">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Link & Image insertion assistant', 'flatpm_l10n' ) ?></h4>

		<div class="row" style="margin:0 -0.75rem">
			<div class="input-field col s12" style="margin-bottom:0">
				<input type="text" id="confirm-insert-link-url">
				<label for="confirm-insert-link-url"><?php _e( 'Link url:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12" style="margin-bottom:0">
				<input type="text" id="confirm-insert-link-text">
				<label for="confirm-insert-link-text"><?php _e( 'Link text:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12 m6">
				<select id="confirm-insert-link-target">
					<option value="">_self</option>
					<option value="_blank">_blank</option>
					<option value="_parent">_parent</option>
					<option value="_top">_top</option>
				</select>
				<label for="confirm-insert-link-target"><?php _e( 'Link target:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12 m6">
				<select id="confirm-insert-link-rel" multiple>
					<option value="nofollow">nofollow</option>
					<option value="noreferrer">noreferrer</option>
					<option value="noopener">noopener</option>
				</select>
				<label for="confirm-insert-link-rel"><?php _e( 'Link rel:', 'flatpm_l10n' ) ?></label>
			</div>

			<div class="input-field col s12" style="display:flex;justify-content:center;align-items:center;flex-direction:row-reverse;gap:10px;margin-bottom:0">
				<button type="button" class="btn confirm-insert-image-media" style="flex-shrink:0">
					<?php _e( 'Media library', 'flatpm_l10n' ) ?>
				</button>
				<input type="text" id="confirm-insert-image-url">
				<label for="confirm-insert-image-url"><?php _e( 'Image url:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12" style="margin-bottom:0">
				<input type="text" id="confirm-insert-image-alt">
				<label for="confirm-insert-image-alt"><?php _e( 'Image alt:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12 m6">
				<input type="number" id="confirm-insert-image-width">
				<label for="confirm-insert-image-width"><?php _e( 'Image width:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12 m6">
				<input type="number" id="confirm-insert-image-height">
				<label for="confirm-insert-image-height"><?php _e( 'Image height:', 'flatpm_l10n' ) ?></label>
			</div>
		</div>

		<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
		<button type="submit" class="waves-effect btn-flat"><?php _e( 'Insert', 'flatpm_l10n' ); ?></button>

		<button type="button" class="waves-effect btn-flat right clear-all-fields"><?php _e( 'Clear All', 'flatpm_l10n' ); ?></button>
	</div>
</form>



<form id="confirm-insert-sticky" class="modal" style="width:600px" tabindex="0">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Sticky insertion assistant', 'flatpm_l10n' ) ?></h4>

		<div class="row" style="margin:0 -0.75rem">
			<div class="input-field col s12 m6" style="margin-bottom:0">
				<div class="unit">
					<input type="radio" name="confirm-insert-sticky-height-unit" id="confirm-insert-sticky-height-unit[px]" value="px" checked>
					<label for="confirm-insert-sticky-height-unit[px]">px</label>
					<input type="radio" name="confirm-insert-sticky-height-unit" id="confirm-insert-sticky-height-unit[vh]" value="vh">
					<label for="confirm-insert-sticky-height-unit[vh]">vh</label>
				</div>
				<input type="number" id="confirm-insert-sticky-height" value="500">
				<label for="confirm-insert-sticky-height"><?php _e( 'Sticky height:', 'flatpm_l10n' ) ?></label>
			</div>

			<div class="input-field col s12 m6" style="margin-bottom:0">
				<input type="number" id="confirm-insert-sticky-offset" value="20">
				<label for="confirm-insert-sticky-offset"><?php _e( 'Offset from top:', 'flatpm_l10n' ) ?></label>
			</div>

			<div class="input-field col s12 m6" style="margin-bottom:0">
				<div class="unit">
					<input type="radio" name="confirm-insert-sticky-width-unit" id="confirm-insert-sticky-width-unit[%]" value="%" checked>
					<label for="confirm-insert-sticky-width-unit[%]">%</label>
					<input type="radio" name="confirm-insert-sticky-width-unit" id="confirm-insert-sticky-width-unit[px]" value="px">
					<label for="confirm-insert-sticky-width-unit[px]">px</label>
				</div>
				<input type="number" id="confirm-insert-sticky-width" value="100">
				<label for="confirm-insert-sticky-width"><?php _e( 'Sticky width:', 'flatpm_l10n' ) ?></label>
			</div>

			<div class="input-field col s12 m6" style="margin-bottom:0">
				<select id="confirm-insert-sticky-align">
					<option value="center"><?php _e( 'Center', 'flatpm_l10n' ) ?></option>
					<option value="left"><?php _e( 'Left', 'flatpm_l10n' ) ?></option>
					<option value="right"><?php _e( 'Right', 'flatpm_l10n' ) ?></option>
				</select>
				<label for="confirm-insert-sticky-align"><?php _e( 'Sticky align:', 'flatpm_l10n' ) ?></label>
			</div>

			<div class="input-field col s12" style="margin-top:0">
				<textarea class="default" type="text" id="confirm-insert-sticky-code"></textarea>
			</div>
		</div>

		<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
		<button type="submit" class="waves-effect btn-flat"><?php _e( 'Insert', 'flatpm_l10n' ); ?></button>

		<button type="button" class="waves-effect btn-flat right clear-all-fields"><?php _e( 'Clear All', 'flatpm_l10n' ); ?></button>
	</div>
</form>



<form id="confirm-insert-sidebar" class="modal" style="width:600px" tabindex="0">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Sidebar block insertion assistant', 'flatpm_l10n' ) ?></h4>

		<div class="items" class="row" style="margin:0 -0.75rem">
			<div class="item" data-id="0">
				<div class="input-field col s12" style="display:flex;gap:10px;margin-bottom:0">
					<input type="number" id="confirm-insert-sidebar-offset-block_0" value="20" style="max-width:calc(100% - 62px)">
					<label for="confirm-insert-sidebar-offset-block_0"><?php _e( 'Offset from top:', 'flatpm_l10n' ) ?></label>

					<button type="button" class="btn-flat waves-effect confirm-delete-item" style="height:46px;line-height:46px;margin:0 0 7px">
						<i class="material-icons" style="color:#d87a87!important;">delete_forever</i>
					</button>
				</div>
				<div class="input-field col s12" style="margin-top:0">
					<textarea class="default" type="text" id="confirm-insert-sidebar-code-block_0"></textarea>
				</div>
			</div>
		</div>

		<center>
			<button type="button" class="btn-small waves-effect confirm-add-more">
				<?php _e( 'Add more', 'flatpm_l10n' ) ?>
			</button>
		</center>

		<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
		<button type="submit" class="waves-effect btn-flat"><?php _e( 'Insert', 'flatpm_l10n' ); ?></button>

		<button type="button" class="waves-effect btn-flat right clear-all-fields"><?php _e( 'Clear All', 'flatpm_l10n' ); ?></button>
	</div>
</form>



<form id="confirm-insert-slider" class="modal" style="width:600px" tabindex="0">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Slider insertion assistant', 'flatpm_l10n' ) ?></h4>

		<p><?php _e( 'A slider is a block in which ads will rotate one after another at set intervals.', 'flatpm_l10n' ) ?></p>

		<div class="items" class="row" style="margin:0 -0.75rem">
			<div class="item" data-id="0">
				<div class="input-field col s12" style="display:flex;gap:10px;margin-bottom:0">
					<input type="number" id="confirm-insert-slider-timer-block_0" value="30" style="max-width:calc(100% - 62px)">
					<label for="confirm-insert-slider-timer-block_0"><?php _e( 'Time to show slide:', 'flatpm_l10n' ) ?></label>

					<button type="button" class="btn-flat waves-effect confirm-delete-item" style="height:46px;line-height:46px;margin:0 0 7px">
						<i class="material-icons" style="color:#d87a87!important;">delete_forever</i>
					</button>
				</div>
				<div class="input-field col s12" style="margin-top:0">
					<textarea class="default" type="text" id="confirm-insert-slider-code-block_0"></textarea>
				</div>
			</div>
		</div>

		<center>
			<button type="button" class="btn-small waves-effect confirm-add-more">
				<?php _e( 'Add more', 'flatpm_l10n' ) ?>
			</button>
		</center>

		<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
		<button type="submit" class="waves-effect btn-flat"><?php _e( 'Insert', 'flatpm_l10n' ); ?></button>

		<button type="button" class="waves-effect btn-flat right clear-all-fields"><?php _e( 'Clear All', 'flatpm_l10n' ); ?></button>
	</div>
</form>



<form id="confirm-insert-interscroller" class="modal" style="width:600px" tabindex="0">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Interscroller insertion assistant', 'flatpm_l10n' ) ?></h4>

		<p><?php _e( 'Interscroller is an advertising format where the ad scrolls between the content and remains in the user\'s field of view. ', 'flatpm_l10n' ) ?></p>

		<div class="row" style="margin:0 -0.75rem">
			<div class="input-field col s12 m6" style="margin-bottom:0">
				<div class="unit">
					<input type="radio" name="confirm-insert-interscroller-unit" id="confirm-insert-interscroller-unit[px]" value="px" checked>
					<label for="confirm-insert-interscroller-unit[px]">px</label>
					<input type="radio" name="confirm-insert-interscroller-unit" id="confirm-insert-interscroller-unit[vh]" value="vh">
					<label for="confirm-insert-interscroller-unit[vh]">vh</label>
				</div>
				<input type="number" id="confirm-insert-interscroller-height" value="500">
				<label for="confirm-insert-interscroller-height"><?php _e( 'Sticky height:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12 m6" style="margin-bottom:0">
				<input type="number" id="confirm-insert-interscroller-lock" value="">
				<label for="confirm-insert-interscroller-lock">
					<i class="material-icons tooltipped" data-position="top" data-tooltip="<?php esc_attr_e( '<div style="text-align:left">As soon as the user scrolls to this block, the scroll lock will be enabled (in seconds).<br>Set to 0 or leave the field blank to disable scroll blocking.</div>', 'flatpm_l10n' ); ?>">info_outline</i>
					<?php _e( 'Scroll lock time:', 'flatpm_l10n' ) ?>
				</label>
			</div>
			<div class="input-field col s12" style="margin-bottom:0">
				<div class="background-example" style="background:linear-gradient( 135deg, #CE9FFC 10%, #7367F0 100%)"></div>
				<input type="text" id="confirm-insert-interscroller-background" value="linear-gradient( 135deg, #CE9FFC 10%, #7367F0 100%)">
				<label for="confirm-insert-interscroller-background">
					<i class="material-icons tooltipped" data-position="top" data-tooltip="<?php esc_attr_e( '<div style="text-align:left">You can specify background by css spec like:<br>1. <code>#CE9FFC</code><br>2. <code>linear-gradient( 135deg, #CE9FFC 10%, #7367F0 100%)</code><br>3. <code>url(https://yourdomain.com/your-picture.png) no-repeat center / cover</code><br>Or any other way</div>', 'flatpm_l10n' ); ?>">info_outline</i>
					<?php _e( 'Background:', 'flatpm_l10n' ) ?>
				</label>
			</div>

			<div class="input-field col s12" style="margin-bottom:0">
				<input type="text" id="confirm-insert-interscroller-top-text" value="">
				<label for="confirm-insert-interscroller-top-text">
					<i class="material-icons tooltipped" data-position="top" data-tooltip="<?php esc_attr_e( '<div style="text-align:left">Leave the field blank to disable top text<br>In the text, you can use the shortcode <code>{{timer}}</code> to display the scroll lock countdown</div>', 'flatpm_l10n' ); ?>">info_outline</i>
					<?php _e( 'Top text:', 'flatpm_l10n' ) ?>
				</label>
			</div>
			<div class="input-field col s12 m6" style="margin-bottom:0">
				<div class="background-example" style="background:#FFFFFF"></div>
				<input type="text" id="confirm-insert-interscroller-top-text-color" value="#FFFFFF">
				<label for="confirm-insert-interscroller-top-text-color">
					<?php _e( 'Top text color:', 'flatpm_l10n' ) ?>
				</label>
			</div>
			<div class="input-field col s12 m6" style="margin-bottom:0">
				<div class="background-example" style="background:#CE9FFC"></div>
				<input type="text" id="confirm-insert-interscroller-top-text-background" value="#CE9FFC">
				<label for="confirm-insert-interscroller-top-text-background">
					<?php _e( 'Top text background:', 'flatpm_l10n' ) ?>
				</label>
			</div>

			<div class="input-field col s12" style="margin-bottom:0">
				<input type="text" id="confirm-insert-interscroller-bottom-text" value="">
				<label for="confirm-insert-interscroller-bottom-text">
					<i class="material-icons tooltipped" data-position="top" data-tooltip="<?php esc_attr_e( '<div style="text-align:left">Leave the field blank to disable bottom text<br>In the text, you can use the shortcode <code>{{timer}}</code> to display the scroll lock countdown</div>', 'flatpm_l10n' ); ?>">info_outline</i>
					<?php _e( 'Bottom text:', 'flatpm_l10n' ) ?>
				</label>
			</div>
			<div class="input-field col s12 m6">
				<div class="background-example" style="background:#FFFFFF"></div>
				<input type="text" id="confirm-insert-interscroller-bottom-text-color" value="#FFFFFF">
				<label for="confirm-insert-interscroller-bottom-text-color">
					<?php _e( 'Bottom text color:', 'flatpm_l10n' ) ?>
				</label>
			</div>
			<div class="input-field col s12 m6">
				<div class="background-example" style="background:#7367F0"></div>
				<input type="text" id="confirm-insert-interscroller-bottom-text-background" value="#7367F0">
				<label for="confirm-insert-interscroller-bottom-text-background">
					<?php _e( 'Bottom text background:', 'flatpm_l10n' ) ?>
				</label>
			</div>

			<div class="input-field col s12" style="margin-top:0">
				<textarea class="default" type="text" id="confirm-insert-interscroller-code"></textarea>
			</div>
		</div>

		<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
		<button type="submit" class="waves-effect btn-flat"><?php _e( 'Insert', 'flatpm_l10n' ); ?></button>

		<button type="button" class="waves-effect btn-flat right clear-all-fields"><?php _e( 'Clear All', 'flatpm_l10n' ); ?></button>
	</div>
</form>



<form id="confirm-master-rtb-step-1" class="modal" style="width:600px" tabindex="0">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Code Insertion Assistant.', 'flatpm_l10n' ) ?></h4>
		<p>
			<?php _e( 'FlatPM has determined that you want to insert a Yandex.Metrika, FloorAd, Fullscreen or TopAd.', 'flatpm_l10n' ) ?><br>
			<?php _e( 'Do you want us to help you?', 'flatpm_l10n' ) ?>
		</p>

		<p><button type="button" class="flat_pm_personalization_disabled_helpers modal-close"><?php _e( 'Do not show me this message again (can be enabled in personalization)', 'flatpm_l10n' ) ?></button></p>

		<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
		<button type="submit" class="waves-effect btn-flat confirm-master-rtb-step-1"><?php _e( 'Yes help me!', 'flatpm_l10n' ); ?></button>
	</div>
</form>



<form id="confirm-master-rtb-step-2" class="modal" style="width:600px" tabindex="0">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4>
			<?php _e( 'Cool!', 'flatpm_l10n' ) ?><br>
			<?php _e( 'Thank you for your trust😉', 'flatpm_l10n' ) ?>
		</h4>
		<p><?php _e( 'First, we\'ll set up the "Output options"', 'flatpm_l10n' ) ?></p>

		<button type="submit" class="waves-effect btn confirm-master-rtb-step-2"><?php _e( 'Next step', 'flatpm_l10n' ); ?></button>
	</div>
</form>



<form id="confirm-master-rtb-step-3" class="modal" style="width:600px" tabindex="0">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Second and final step.', 'flatpm_l10n' ) ?></h4>
		<p><?php _e( 'Last, we\'ll set up "Content targeting"', 'flatpm_l10n' ) ?></p>
		<p><?php _e( 'Everything is ready and set up correctly, enjoy 😊', 'flatpm_l10n' ) ?></p>

		<button type="button" class="waves-effect btn modal-close"><?php _e( 'Were happy to help!', 'flatpm_l10n' ); ?></button>
	</div>
</form>