 <!--===// Start: Slider
    =================================--> 
<?php  
	$slider_hs 						= get_theme_mod('slider_hs','1');
	$slider 						= get_theme_mod('slider',corpex_get_slider_default());
	$slider_autoplay				= get_theme_mod('slider_autoplay', 'true');
	
	if($slider_hs=='1'){
?>	
<!-- slider -->
    <section class="slider-section slider-one">
        <div id="main-slider" class="carousel slide main-slider" <?php if($slider_autoplay == 'true') {echo 'data-bs-ride="carousel"';} ?> >
            <div class="carousel-inner">
				<?php
					if ( ! empty( $slider ) ) {
					$slider = json_decode( $slider );
					$count = 1;
					foreach ( $slider as $slide_item ) {
						$title = ! empty( $slide_item->title ) ? apply_filters( 'corpex_translate_single_string', $slide_item->title, 'slider section' ) : '';
						$subtitle = ! empty( $slide_item->subtitle ) ? apply_filters( 'corpex_translate_single_string', $slide_item->subtitle, 'slider section' ) : '';
						$button = ! empty( $slide_item->text) ? apply_filters( 'corpex_translate_single_string', $slide_item->text,'slider section' ) : '';
						$link = ! empty( $slide_item->link ) ? apply_filters( 'corpex_translate_single_string', $slide_item->link, 'slider section' ) : '';
						$link2 = ! empty( $slide_item->link2 ) ? apply_filters( 'corpex_translate_single_string', $slide_item->link2, 'slider section' ) : '';
						$video_url = ! empty( $slide_item->video_url ) ? apply_filters( 'corpex_translate_single_string', $slide_item->video_url, 'slider section' ) : '';
						$image = ! empty( $slide_item->image_url ) ? apply_filters( 'corpex_translate_single_string', $slide_item->image_url, 'slider section' ) : '';
						$open_new_tab = ! empty( $slide_item->open_new_tab ) ? apply_filters( 'corpex_translate_single_string',$slide_item->open_new_tab, 'slider section' ) : 'yes';
						$link_follow_nofollow = ! empty( $slide_item->link_follow_nofollow ) ? apply_filters( 'corpex_translate_single_string',$slide_item->link_follow_nofollow, 'slider section' ) : 'nofollow';
						$active_class = ($count==1)?'active':'';
				?>
					<div class="carousel-item <?php echo esc_attr($active_class); ?>">
						<div class="slide-main">
							<?php if ( ! empty( $image ) ) : ?>
								<img src="<?php echo esc_url($image); ?>" class="d-block w-100" alt="<?php echo esc_attr__('Image','clever-fox'); ?>">
							<?php endif; ?>	
							<div class="slider-content">
								<div class="container">
									<div class="content-inner">
										<div class="play-button">
											<a href="<?php echo esc_url($video_url); ?>" class="youtube"><i class="fa fa-play"></i></a>
										</div>
										
										
										
										<?php if ( ! empty( $title ) ) : ?>
											<h1 class="slide-title">
												<?php echo esc_html($title); ?>	
											</h1> 
										<?php endif; ?>
										
										<?php if ( ! empty( $button ) ) : ?>
											<a href="<?php echo esc_url( $link ); ?>" <?php if($open_new_tab== 'yes' || $open_new_tab== '1') { echo "target='_blank'"; } ?> <?php if($link_follow_nofollow=='nofollow') { echo "rel='nofollow'"; } ?> class="main-btn"> <?php echo esc_html( $button ); ?> </a>
										<?php endif; ?>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php $count++; } } ?>               
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#main-slider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden"><?php echo esc_html__('Previous','corpex'); ?></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#main-slider" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden"><?php echo esc_html__('Next','corpex'); ?></span>
            </button>
        </div>
    </section>
    <!-- slider -->
	<?php } ?>