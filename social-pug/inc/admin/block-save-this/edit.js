import { __ } from '@wordpress/i18n';
import { InspectorControls, BlockControls, MediaReplaceFlow, MediaPlaceholder, MediaUploadCheck, RichText, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, PanelRow, TextControl, Spinner, ToggleControl } from '@wordpress/components';
// import { useSelect } from '@wordpress/data';
// import { useEffect } from 'react';

/**
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { heading, message, buttontext, showImage, imageId, imageURL, imageAlt, afterForm } = attributes;

	const setImageAttributes = (media) => {
		if (!media || !media.url) {
			setAttributes({
				imageURL: null,
				imageId: null,
				imageAlt: null,
			});
			return;
		}
		setAttributes({
			imageURL: media.url,
			imageId: media.id,
			imageAlt: media?.alt,
		});
	};

	return (
		<>
		<BlockControls>
			<MediaReplaceFlow
				mediaId={ imageId }
				mediaUrl={ imageURL }
				allowedTypes={ [ 'image' ] }
				accept="image/*"
				onSelect={ setImageAttributes }
				name={ ! imageURL ? __( 'Add Image', 'social-pug' ) : __( 'Replace Image', 'social-pug' )}
			/>
		</BlockControls>
			<InspectorControls>
				<PanelBody title={ __( 'Save This Settings', 'social-pug' ) }>
				<PanelRow><p>{__('Edit the text directly within the block. Choose "Replace Image" to add your own image.')}</p></PanelRow>
					<ToggleControl 
					label={ __(
						'Show image',
						'social-pug'
					) }
					help={
						showImage
							? __( 'Image is visible. Recommended size: 180px square. Hidden on mobile.', 'social-pug' )
							: __( 'Image is hidden.', 'social-pug' )
					}
					checked={ showImage }
					value={ showImage }
					onChange={ (value) => setAttributes( { showImage: value } ) }
					/>
					<TextControl
					label={ __(
						'Button Text',
						'social-pug'
					) }
					value={ buttontext }
					onChange={ (value) => setAttributes( { buttontext: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
			{ showImage && ! imageURL && 
				<MediaUploadCheck>
					<MediaPlaceholder
						accept="image/*"
						allowedTypes={ ['image'] }
						onSelect={ setImageAttributes }
						multiple={ false }
						handleUpload={ true }
					/>
				</MediaUploadCheck>
			}
			{ showImage && imageURL && <div className="hubbub-save-this-image-wrapper"><img className="hubbub-save-this-image" src={ imageURL } alt={ imageAlt } /></div>}
			<div className="hubbub-save-this-form-wrapper">
				<RichText
						tagName="h3"
						className="hubbub-save-this-heading"
						value={heading}
						placeholder={ __(
							'Would you like to save this?',
							'social-pug'
						) }
						onChange={ (value) => setAttributes( { heading: value } ) }
					/>
				<RichText
						tagName="div"
						className="hubbub-save-this-message"
						value={message}
						placeholder={ __(
							'Enter your email and we\'ll send it straight to your inbox.',
							'social-pug'
						) }
						onChange={ (value) => setAttributes( { message: value } ) }
					/>
				<div>
				<form name="hubbub-save-this-form" method="post" action="">
					<input placeholder="Email Address" name="hubbub-save-this-emailaddress" id="hubbub-save-this-emailaddress" class="hubbub-block-save-this-text-control" />
					<input type="submit" value={buttontext} class="hubbub-block-save-this-submit-button" />
				</form>
				</div>
				<RichText
						tagName="div"
						className="hubbub-save-this-afterform"
						value={afterForm}
						placeholder={ __(
							'By clicking save, you agree to receive emails.',
							'social-pug'
						) }
						onChange={ (value) => setAttributes( { afterForm: value } ) }
					/>
				</div>
			</div>
		</>
	);
}
