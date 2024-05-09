<div id="cx-message-convert-images" class="cx-message">
	<img src="<?php echo esc_url( plugins_url( 'vendor/codexpert/plugin/src/assets/img/checked.png', THUMBPRESS ) ); ?>">
</div>
<div>
	<div class="convert_images" id="convert_images">
	<div class="image_sizes-detect">
		<div id="info-icon" class="info-icon">
			<img class="info-img" src="<?php echo esc_url( plugins_url( 'modules/convert-images/img/info.png', THUMBPRESS ) ); ?>">
			<p><?php echo esc_html__( "Alert! Please note that all the images on your website will be converted to WebP format and you cannot undo this action later. Do not take this action unless you're sure about it. If you want to convert a specific image, you can do it from media library." ); ?></p>
		</div>
		<div class="image_sizes-detect-panel">
			<h3>
				<?php _e( 'Convert All Existing Images on Your Website', 'image-sizes' ); ?>
			</h3>
			<button id="thumbpress-convert-all" class="image-sizes-detect-button button button-hero button-primary" type="button"><?php echo esc_html__( 'Convert All', 'image-sizes' ); ?></button>
		</div>
	</div>

	<?php
	$status = thumbpress_get_last_action_status_by_module_name( 'convert-images' );

	$title 	= $text = '';

	switch ( $status ) {
		case 'pending':
			$title 			= __( 'PROCESSING...', 'image-sizes' );
			$text 			= __( 'Your images are being converted to WebP format. Please wait.', 'image-sizes' );
			$status_class 	= 'processing';
			break;
		case 'failed':
			$title 			= __( 'FAILED', 'image-sizes' );
			$text 			= __( 'Image conversion to WebP was unsuccessful. Please try again.', 'image-sizes' );
			$status_class 	= 'failed';
			break;
		case 'complete':
			$title 			= __( 'COMPLETED', 'image-sizes' );
			$text 			= __( 'Your images have been successfully converted to WebP.', 'image-sizes' );
			$status_class 	= 'complete';
			break;
		default:
			$status_class 	= 'hidden';
			break;
	}
	?>
	<div id="processing-convert">
		<div id="select-for-convert">
			<img src="<?php echo esc_url( plugins_url( 'modules/convert-images/img/convart-icon.png', THUMBPRESS ) ); ?>">
		</div>
		<?php if ( $title ): ?>
			<h2 class="image_sizes-status <?php echo $status_class; ?>">
				<?php echo esc_html( $title ); ?>
			</h2>
		<?php endif; ?>
		<p class="image_sizes-desc">
			<?php echo esc_html( $text ); ?>
		</p>
	</div>
</div>