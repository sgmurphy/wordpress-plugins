<?php 
use Codexpert\ThumbPress\Helper;
 ?>
<div id="cx-message-optimize-images" class="cx-message">
	<img src="<?php echo esc_url( plugins_url( 'vendor/codexpert/plugin/src/assets/img/checked.png', THUMBPRESS ) ); ?>">
</div>
<div id="image_sizes-regen-wrap" class="image_sizes-regen-thumbs-panel thumbpress-actions-wrapper">
	<div id="image_sizes-regen-left" class="thumbpress-actions-left">
		<p class="image_sizes-desc">
			<?php _e( 'Since you updated the thumbnails to be generated, images you\'ll upload in the future will generate thumbnails based on your settings. But, what about the ones you already uploaded? Click the button below and it\'ll regenerate thumbnails of your existing images.', 'image-sizes' ); ?>
		</p>
		<label for="image-sizes_regenerate-thumbs-limit">
			<?php _e( 'Number of images to process per request:', 'image-sizes' ) ?>
		</label>
		<input type="number" class="cx-field cx-field-number thumbpress-action-input" id="image-sizes_regenerate-thumbs-limit" name="regen-thumbs-limit" value="10" placeholder="<?php _e( 'Images/request. Default is 50', 'image-sizes' ) ?>" required="">
		<div class="thumbpress-buttons-wrapper">
			<button id="image_sizes-regen-thumbs" class="thumbpress-action-now button-hero button">
				<?php _e( 'Regenerate Now', 'image-sizes' ); ?>
			</button>
			<button id="image_sizes-schedule-regen-thumbs" class="thumbpress-action-background">
				<?php _e( 'Regenerate In Background', 'image-sizes' ); ?>
			</button>
		</div>
		<?php 
			$thumbpress_modules = Helper::get_option( 'thumbpress_modules', 'disable-thumbnails' );

			if ( $thumbpress_modules == 'on' ) {
				?>
				<a href="<?php echo esc_url( add_query_arg( [ 'page' => 'thumbpress' ], admin_url( 'admin.php' ) ) . '#prevent_image_sizes' ); ?>" class="prevent_image_sizes-back button-hero">
					&#10550; <?php _e( 'Go to Disable Thumbnails Settings', 'image-sizes' ); ?>
				</a>
				<?php 
			}
		?>
		
	</div>
	<div class="thumbpress-actions-right">
		<div id="thumbpress-action-now-result" style="display: none;">
			<div class="thumbpress-progress-panel">
				<div class="thumbpress-progress-content" style="width:0%">
					<span>0%</span>
				</div>
			</div>
			<div id="thumbpress-pro-message">
				<p id="cx-processed">
					<span class="dashicons dashicons-yes-alt cx-icon cx-success"></span>
					<?php
					printf(
						__( '%s images processed.', 'thumbpress-pro' ),
						'<span id="processed-count">0</span>',
					);
					?>
				</p>
				<p id="cx-removed">
					<span class="dashicons dashicons-yes-alt cx-icon cx-success"></span>
					<?php
					printf(
						__( '%s images removed.', 'thumbpress-pro' ),
						'<span id="removed-count">0</span>',
					);
					?>
				</p>
				<p id="cx-regenerated">
					<span class="dashicons dashicons-yes-alt cx-icon cx-success"></span>
					<?php
					printf(
						__( '%s images regenerated.', 'thumbpress-pro' ),
						'<span id="regenerated-count">0</span>',
					);
					?>
				</p>
			</div>
		</div>
		<div id="thumbpress-action-no-result" style="display: none;">
			<h3>
				<?php _e( 'No images to regenerate.', 'thumbpress-pro' ); ?>
			</h3>
		</div>
		<?php
		$status 	= thumbpress_get_last_action_status_by_module_name( 'regenerate-thumbnails' );
		$action_id 	= thumbpress_get_last_action_status_by_module_name( 'regenerate-thumbnails', 'action_id' );
		$progress 	= get_option( "thumbpress_regenerate_progress" );
		$title 		= $text = $status_class = $progress_bar = '';

		if( $status == 'in-progress' || $status == 'pending' ) {
			$title 			= __( 'PROCESSING...', 'image-sizes' );
			$text 			= __( 'Your thumbnails are being regenerated. Please wait.', 'image-sizes' );
			$status_class 	= 'processing';
			$progress_bar 	= "<div class='progress'>
			<div class='bar' style='width: " . intval( $progress ) . "%;'>
			<p class='percent'>" . intval( $progress ) . "%</p>
			</div>
			</div>";
		} elseif( $status == 'failed' ) {
			$title 			= __( 'FAILED', 'image-sizes' );
			$text 			= __( 'Your thumbnails could not be regenerated. Please try again.', 'image-sizes' );
			$status_class 	= 'failed';
		} elseif( $status == 'complete' && $progress == 100 ) {
			$title 			= __( 'COMPLETED', 'image-sizes' );
			$text 			= __( 'Your thumbnails have regenerated successfully.', 'image-sizes' );
			$status_class 	= 'complete';
			$progress_bar  	= "<div class='progress'>
			<div class='bar' style='width: " . intval( $progress ) . "%;'>
			<p class='percent'>" . intval( $progress ) . "%</p>
			</div>
			</div>";
		}
		?>
		<div id="thumbress-action-background-result">
			<div id="thumbress-result-image">
				<img src="<?php echo esc_url( plugins_url('modules/convert-images/img/convart-icon.png', THUMBPRESS ) ); ?>">
			</div>
			<?php if ( $title ): ?>
				<h2 class="image_sizes-status <?php echo $status_class; ?>">
					<?php echo esc_html( $title ); ?>
				</h2>
				<?php if ( isset( $progress_bar ) ): ?>
					<?php echo $progress_bar; ?>
				<?php endif; ?>
			<?php endif; ?>
			<p class="image_sizes-desc">
				<?php echo esc_html( $text ); ?>
			</p>
		</div>
	</div>
</div>