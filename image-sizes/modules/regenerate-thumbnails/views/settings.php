<?php 
use Codexpert\ThumbPress\Helper;
 ?>
<div id="cx-message-optimize-images" class="cx-message">
	<img src="<?php echo esc_url( plugins_url( 'vendor/codexpert/plugin/src/assets/img/checked.png', THUMBPRESS ) ); ?>">
</div>
<div id="image_sizes-regen-wrap" class="image_sizes-regen-thumbs-panel">
	<div id="image_sizes-regen-left">
		<p class="image_sizes-desc">
			<?php _e( 'Since you updated the thumbnails to be generated, images you\'ll upload in the future will generate thumbnails based on your settings. But, what about the ones you already uploaded? Click the button below and it\'ll regenerate thumbnails of your existing images.', 'image-sizes' ); ?>
		</p>
		<label for="image-sizes_regenerate-thumbs-limit">
			<?php _e( 'Number of images to process per request:', 'image-sizes' ) ?>
		</label>
		<input type="number" class="cx-field cx-field-number" id="image-sizes_regenerate-thumbs-limit" name="regen-thumbs-limit" value="10" placeholder="<?php _e( 'Images/request. Default is 50', 'image-sizes' ) ?>" required="">
		<div id="image_sizes-regen-thumbs-actions">
			<button id="image_sizes-regen-thumbs" class="button button-primary button-hero">
				<?php _e( 'Regenerate Now', 'image-sizes' ); ?>
			</button>
			<button id="image_sizes-schedule-regen-thumbs" class="button button-primary button-hero">
				<?php _e( 'Regenerate In Background', 'image-sizes' ); ?>
			</button>
		</div>

		<?php 
	        $thumbpress_modules = Helper::get_option( 'thumbpress_modules', 'disable-thumbnails' );

	        if ( $thumbpress_modules == 'on' ) {
	            ?>
	            <a href="<?php echo get_site_url() . '/wp-admin/admin.php?page=thumbpress#prevent_image_sizes' ; ?>" class="prevent_image_sizes-back button-hero">&#10550; <?php _e( 'Go to Disable Thumbnails Settings','image-sizes' ) ?></a>
	            <?php 
	        }
		?>
		
	</div>
	<div id="image_sizes-regen-right">
		<div class="image-sizes-progress-panel-wrapper" style="display: none;">
			<div id="image_sizes-message"></div>
		</div>
		<?php
		$status = thumbpress_get_last_action_status_by_module_name( 'regenerate-thumbnails' );
		$title 	= $text = '';

		switch ( $status ) {
			case 'pending':
			$title 			= __( 'PROCESSING...', 'image-sizes' );
			$text 			= __( 'Your thumbnails are being regenerated. Please wait.', 'image-sizes' );
			$status_class 	= 'processing';
			break;
			case 'failed':
			$title 			= __( 'FAILED', 'image-sizes' );
			$text 			= __( 'Your thumbnails could not be regenerated. Please try again.', 'image-sizes' );
			$status_class 	= 'failed';
			break;
			case 'complete':
			$title 			= __( 'COMPLETED', 'image-sizes' );
			$text 			= __( 'Your thumbnails have regenerated successfully.', 'image-sizes' );
			$status_class 	= 'complete';
			break;
			default:
			$status_class 	= 'hidden';
			break;
		}
		?>

		<div id="processing-convert">
			<div id="select-for-convert">
				<img src="<?php echo esc_url( plugins_url('modules/convert-images/img/convart-icon.png', THUMBPRESS ) ); ?>">
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
</div>