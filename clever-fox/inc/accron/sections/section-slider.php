 <!--===// Start: Slider
    =================================--> 
<?php  
	$slider_hs 						= get_theme_mod('slider_hs','1');
	$accron_slide_image				= get_theme_mod('accron_slide_image', esc_url(CLEVERFOX_PLUGIN_URL. 'inc/accron/images/slider/slider-img1.jpg'));
	$accron_slide_title				= get_theme_mod('accron_slide_title',__('20 Years Of Successful Business Consulting'));
	$accron_slide_subtitle			= get_theme_mod('accron_slide_subtitle',__('Your Business Innovative Strategies For Success','clever-fox'));
	$accron_slide_button			= get_theme_mod('accron_slide_button',__('Our Service','clever-fox'));
	$accron_slide_link				= get_theme_mod('accron_slide_link','#');
	if($slider_hs=='1'){
?>	
<!--===// Start: Slider
=====================-->
	<section class="slider-section slider-one imgarrow">
        <div id="carouselExampleInterval" class="carousel slide carousel-fade">
            <div class="carousel-inner">				
					<div class="carousel-item active">
						<div class="slide-main-item">
							<?php if ( ! empty( $accron_slide_image ) ) : ?>
								<img src="<?php echo esc_url($accron_slide_image); ?>" class="d-block w-100" alt="<?php echo esc_attr__('Image','clever-fox'); ?>">
							<?php endif; ?>	
							<div class="slider-content">
								<div class="container">
									<div class="carousel-caption col-lg-8 mx-auto">
										<?php if ( ! empty( $accron_slide_title ) ) : ?>
											<span class="firstword1">
												<span class="firstword"><?php echo esc_html($accron_slide_title); ?></span>
												<span class="sub-effect"></span>
											</span>
										<?php endif; ?>
										<?php if ( ! empty( $accron_slide_subtitle ) ) : ?>
											<h1  class="lastword">
												<?php echo esc_html($accron_slide_subtitle); ?>	
											</h1> 
										<?php endif; ?>
										
										<?php if ( ! empty( $accron_slide_button ) ) : ?>
											<a href="<?php echo esc_url( $accron_slide_link ); ?>" target="_blank" rel="nofollow" class="main-btn bg"> <?php echo esc_html( $accron_slide_button ); ?> </a>
										<?php endif; ?>										
									</div>
								</div>
							</div>
						</div>
					</div>
            </div>            
        </div>
    </section>
<?php } ?>
<!-- End: Slider
=======================-->