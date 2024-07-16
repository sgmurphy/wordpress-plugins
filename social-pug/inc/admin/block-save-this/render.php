<?php
/**
 *
 * $attributes (array): The block attributes.
 * $content (string): The block default content.
 * $block (WP_Block): The block instance.
 *
 */
use Mediavine\Grow\View_Loader;

$heading 			= isset($attributes['heading']) ? $attributes['heading'] : 'Would you like to save this?';
$message 			= isset($attributes['message']) ? $attributes['message'] : 'Enter your email and we\'ll send it straight to your inbox.';
$buttontext 		= isset($attributes['buttontext']) ? $attributes['buttontext'] : 'Save';
$showImage 			= isset($attributes['showImage']) ? $attributes['showImage'] : false;
$imageURL 			= isset($attributes['imageURL']) ? $attributes['imageURL'] : '';
$imageAlt			= isset($attributes['imageAlt']) ? $attributes['imageAlt'] : '';
//$buttoncolor		= $attributes['buttoncolor'];
$afterForm 			= isset($attributes['afterForm']) ? $attributes['afterForm'] : 'By clicking save, you agree to receive emails.';
$block_content 		= '';

if ( ! empty( $heading ) && ! is_admin() ) {

	global $post;
	$postURL 		= get_the_permalink($post->ID);
	$postTitle 		= get_the_title($post->ID);

	$block_content = '<div ' . get_block_wrapper_attributes() . '>';
	
	if ( $showImage ) $block_content .= '<div class="hubbub-save-this-image-wrapper"><img data-pin-nopin="true" class="hubbub-save-this-image" src="' . $imageURL . '" alt="' . $imageAlt . '" /></div>';

	$block_content .= '<div class="hubbub-save-this-form-wrapper"><h3 class="hubbub-save-this-heading">' . $heading . '</h3>
	<div class="hubbub-save-this-message"><p>' . $message . '</p></div>
	<div>
	<form name="hubbub-save-this-form" method="post" action="">
		<input type="text" placeholder="Email Address" name="hubbub-save-this-emailaddress" id="hubbub-save-this-emailaddress" class="hubbub-block-save-this-text-control" />
		<input type="hidden" name="hubbub-save-this-posturl" id="hubbub-save-this-posturl" value="' . esc_attr($postURL) .'" />
		<input type="hidden" name="hubbub-save-this-posttitle" id="hubbub-save-this-posttitle" value="' . esc_attr($postTitle) .'" />
		<input type="submit" value=' . esc_attr($buttontext) . ' class="hubbub-block-save-this-submit-button" name="hubbub-block-save-this-submit-button" id="hubbub-block-save-this-submit-button" />
	</form>
	</div>
	<div class="hubbub-save-this-afterform"><p><small>' . $afterForm . '</small></p></div>
	</div></div>';
} else {
	$block_content = '<div ' . get_block_wrapper_attributes() . '>Error</div>';
}

// Display the rendered output
// Allow plugins to hook in and filter this if they'd like
echo wp_kses( apply_filters( 'dpsp_output_block_save_this', $block_content ), View_Loader::get_allowed_tags() ); // (This get_allowed_tags adds form elements to wp_kses)