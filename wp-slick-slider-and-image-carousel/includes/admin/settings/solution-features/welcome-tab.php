<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package WP Slick Slider and Image Carousel
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div id="wpsisac_welcome_tabs" class="wpsisac-vtab-cnt wpsisac_welcome_tabs wpsisac-clearfix">
	
	<div class="wpsisac-deal-offer-wrap">
		<h3 style="font-weight: bold; font-size: 30px; color: red; text-align:center; margin: 15px 0 5px 0;">Why invest time for the free version?</h3>

		<h3 style="font-size: 18px; text-align:center; margin:0;">Immediately Explore Slick Slider Pro with Essential Bundle Free for 5 Days.</h3>			

		<div class="wpsisac-deal-free-offer">
			<a href="<?php echo esc_url( WPSISAC_PRO_FREE_5_day_LINK ); ?>" target="_blank" class="wpsisac-sf-btn"><span class="dashicons dashicons-cart"></span> Try Free For 5 Days</a>
		</div>
	</div>

	<!-- Start - Welcome Box -->
	<div class="wpsisac-sf-welcome-wrap" style="padding: 30px;border-radius: 10px;border: 1px solid #e5ecf6;">
		<div class="wpsisac-sf-welcome-inr wpsisac-sf-center">
			<h1 class="wpsisac-sf-heading" style="font-size: 25px; margin: 20px 0;">Showcase your <span class="wpsisac-sf-blue">images</span> associated with your business with slick slider</h1>
			<h5 class="wpsisac-sf-content" style="font-size: 20px; margin: 20px 0;">Experience <span class="wpsisac-sf-blue">5 Layouts</span>, <span class="wpsisac-sf-blue">90+ stunning designs</span>. Build and display responsive slick image sliders/carousels to  increase website engagement.</h5>
			<h5 class="wpsisac-sf-content" style="font-size: 18px; margin: 20px 0;"><span class="wpsisac-sf-blue">20,000+ </span>websites are using <span class="wpsisac-sf-blue">Slick Slider</span>.</h5>
		</div>
		<div style=" text-transform: uppercase; text-align:center;">
			<a href="<?php echo esc_url( $wpsisac_add_link ); ?>" class="wpsisac-sf-btn">Launch Slick Slider With Free Features</a>
		</div>
	</div>
	<!-- End - Welcome Box -->
	
</div>