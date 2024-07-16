/**
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';

/**
 *
 * @param {Object} props            Properties passed to the function.
 * @param {Object} props.attributes Available block attributes.
 *
 * @return {Element} Element to render.
 */
export default function save( { attributes } ) {
	const { heading, message, buttontext, showImage, imageURL, imageAlt, afterForm } = attributes;

	return <div { ...useBlockProps.save() }>
		{ showImage && (
			<div class="hubbub-save-this-image-wrapper"><img class="hubbub-save-this-image" src={ imageURL } alt={ imageAlt } /></div>
		) }
		<div class="hubbub-save-this-form-wrapper">
			<RichText.Content tagName="h3" className="hubbub-save-this-heading" value={ heading } />
			<RichText.Content tagName="div" className="hubbub-save-this-message" value={ message } />
			<div>
			<form name="hubbub-save-this-form" method="post" action="">
				<input placeholder="Email Address" name="hubbub-save-this-emailaddress" id="hubbub-save-this-emailaddress" class="hubbub-block-save-this-text-control" />
				<input type="submit" value={buttontext} class="hubbub-block-save-this-submit-button" />
			</form>
			</div>
			<RichText.Content tagName="div" className="hubbub-save-this-afterform" value={ afterForm } />
		</div>
	</div>;
}