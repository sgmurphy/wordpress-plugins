<?php 
use Codexpert\ThumbPress\Helper;
$status 			= thumbpress_get_last_action_status_by_module_name( 'convert-images' );
$action_id 			= thumbpress_get_last_action_status_by_module_name( 'convert-images', 'action_id' );
$_progress 			= get_option( "thumbpress_convert_progress" ) ?? 0;
$processed_count	= get_option( "thumbpress_convert_total_processd" ) ?? 0;
$converted_count 	= get_option( "thumbpress_convert_total_converted" ) ?? 0;
$progress 			= round( $_progress );
$show_failed 		= $show_no_process = $show_no_results = $show_process = 'none';
$message 			= $background_color = '';
$last_schedule_time = get_option( 'convert_last_completed_time' );
$time_format 		= 'g:i a F j, Y';
$completed_time 	= $last_schedule_time ? date_i18n( $time_format, $last_schedule_time ) : '';

if( in_array( $status, [ 'in-progress', 'pending', 'complete' ] ) ) {
	$show_process = 'flex';
}
elseif( $status == 'failed' ) {
	$show_failed = 'flex';
	$background_color = '#F63D3F0D';
	
}else{
	$show_no_process = 'block';
}
if( $status == "complete" && $processed_count == 0 ) {
	$show_no_results = "flex";
	$show_process 	 = 'none';
}
if( in_array( $status, [ 'in-progress', 'pending' ] ) ) {
	$message = __( 'Converting Images to WebP in Background', 'thumbpress-pro' );
}
if( $status == 'complete' ) {
	$message = sprintf(
		__( 'Converting Images to WebP in background was completed %s', 'thumbpress-pro' ),
		esc_html( $completed_time )
	);
}
if ( $status == 'failed' ) {
	$message = __( 'Converting Images to WebP in Background Failed.', 'thumbpress-pro' );
}
?>
<div id="cx-message-convert-images" class="cx-message">
	<img src="<?php echo esc_url( plugins_url( 'vendor/codexpert/plugin/src/assets/img/checked.png', THUMBPRESS ) ); ?>">
</div>
<div class="thumbpress-submenu">
	<div class="thumbpress-actions-wrapper">
		<div class="thumbpress-actions-left">
			<div id="info-icon" class="info-icon">
				<img class="info-img" src="<?php echo esc_url( plugins_url( 'modules/detect-unused-image/img/info.png', THUMBPRESS_PRO ) ); ?>">
				<p>
					<?php _e( "Convert to WebP is a highly server-dependent feature and the converting process may timeout if you process a large number of images. You may need to work on your server side to solve the issues if you face any when using this feature. Also keep in mind that once you convert your images to WebP, you can never undo it.", 'thumbpress-pro' ); ?>
				</p>
			</div>
			<label for="thumbpress-convert-limit">
				<?php _e( 'Number of images to process per request:', 'image-sizes' ) ?>
			</label>
			<input type="number" class="cx-field cx-field-number thumbpress-action-input" id="thumbpress-convert-limit" name="regen-thumbs-limit" value="10" placeholder="<?php _e( 'Images/request. Default is 50', 'image-sizes' ) ?>" required="">
			<div class="thumbpress-buttons-wrapper">
				<button id="thumbpress-convert-now" class="thumbpress-action-now" type="button">
					<?php echo esc_html__( 'Convert Now', 'image-sizes' ); ?>
				</button>
				<button id="thumbpress-convert-background" class="thumbpress-action-background" type="button">
					<?php echo esc_html__( 'Convert in Background', 'image-sizes' ); ?>
				</button>
			</div>
		</div>
		<div class="thumbpress-actions-right" style="background-color:<?php esc_attr_e( $background_color ); ?>">
			<p class="thumbpress-processs-message" style="display: <?php esc_attr_e( $show_process ); ?>;">
				<?php esc_html_e( $message ); ?>
			</p>
			<div id="thumbpress-action-result" style="display: <?php esc_attr_e( $show_process ); ?>;">
				<div class="thumbpress-progress-content">
					<div class="thumbpress-progressbar" data-content="<?php esc_attr_e( $progress ) ?>" style="--value: <?php esc_attr_e( $progress ) ?>"></div>
				</div>
				<div id="thumbpress-pro-message">
					<p id="cx-processed">
						<span class="dashicons dashicons-yes-alt cx-icon cx-success"></span>
						<?php
						printf(
							__( 'Processed %s images', 'thumbpress-pro' ),
							'<span id="processed-count">' . esc_html( $processed_count ) . '</span>'
						);
						?>
					</p>
					<p id="cx-converted">
						<span class="dashicons dashicons-yes-alt cx-icon cx-success"></span>
						<?php
						printf(
							__( 'Converted %s images.', 'thumbpress-pro' ),
							'<span id="converted-count">' . esc_html( $converted_count ) . '</span>'
						);
						?>
					</p>
				</div>
			</div>
			<div class="thumbpress-action-no-process" style="display: <?php esc_attr_e( $show_no_process ); ?>">
				<img src="<?php echo esc_url( plugins_url( 'assets/img/no-action.png', THUMBPRESS ) ); ?>" alt="no-action">
				<p>
					<?php _e('Please click the button to start detecting images.','thumbpress-pro'); ?>
				</p>
			</div>
			<div class="thumbpress-action-no-result" style="display: <?php esc_attr_e( $show_no_results ); ?>">
				<img src="<?php echo esc_url( plugins_url( 'assets/img/no-images.png', THUMBPRESS ) ); ?>" alt="no-action">
				<p>
					<?php _e('You have no images to convert please upload new images.','thumbpress-pro'); ?>
				</p>
			</div>
			<div class="thumbpress-action-failed" style="display: <?php esc_attr_e( $show_failed ); ?>;">
				<img src="<?php echo esc_url( plugins_url( 'assets/img/failed-action.png', THUMBPRESS ) ); ?>" alt="failed-action">
				<p class='failed-warning'>
					<?php _e( 'Something went wrong!.', 'thumbpress-pro' ); ?>
				</p>
				<p class='failed-message'>
					<?php _e( 'Your backgroud action failed please try again..', 'thumbpress-pro' ); ?>
				</p>
			</div>
			<?php
			?>
		</div>
	</div>
</div>