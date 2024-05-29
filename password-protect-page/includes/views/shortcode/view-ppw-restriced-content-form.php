<?php
/**
 * PPWP Restricted Content Form
 */
?>
<div class="[PPW_FORM_CLASS] ppw-pcp-container" id="[PPW_FORM_ID]">
	<form method="post" autocomplete="off" action="[PPW_CURRENT_URL]" target="_top" class="post-password-form ppw-form ppw-pcp-password-form" data-submit="[PPW_AUTH]">
		<div class="ppw-headline ppw-pcp-pf-headline">[PPWP_FORM_HEADLINE]</div>
		<div class="ppw-description ppw-pcp-pf-desc">[PPWP_FORM_INSTRUCTIONS]</div>
		[PPWP_FORM_ABOVE_PASSWORD_INPUT]
		<p class="ppw-input">
			<input type="hidden" value="[AREA]" name="area" />
			<label class="ppw-pcp-password-label">[PPWP_FORM_PASSWORD_LABEL] <input placeholder="[PPW_PLACEHOLDER]" type="password" tabindex="1" name="[PPW_AUTH]" class="ppw-password-input ppw-pcp-pf-password-input" autocomplete="new-password">
			</label>
			<input class="ppw-page" type="hidden" value="[PPW_PAGE]" />[PPW_CHECKBOX]
			[SHORTCODE_DESC_ABOVE_BTN]
			<?php do_action('ppw_pcp_pf_desc_above_btn') ?>
			<input name="submit" type="submit" data-loading="[PPW_BUTTON_LOADING]" class="ppw-submit ppw-pcp-pf-submit-btn" value="[PPW_BUTTON_LABEL]"/>
		</p>
		[PPW_RECAPTCHA_INPUT]
		<div class="ppw-pcp-pf-desc-below-form">[SHORTCODE_DESC_BELOW_FORM]</div>
		[PPWP_FORM_BELOW_PASSWORD_INPUT]
		<div class="ppw-error ppw-pcp-pf-error-msg" style="color: <?php echo esc_attr( PPW_Constants::PPW_ERROR_MESSAGE_COLOR ); ?>">
			[PPW_ERROR_MESSAGE]
		</div>
	</form>
</div>
