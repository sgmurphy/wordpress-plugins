<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Popup Anything on click
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div id="wpcdt_welcome_tabs" class="wpcdt-vtab-cnt wpcdt_welcome_tabs wpcdt-clearfix">	

	<!-- <h1 class="wpcdt-sf-heading">Boost Your Sales with <span class="wpcdt-sf-blue">Countdown Timer</span></h1> -->

	<div class="wpcdt-deal-offer-wrap">
		<h3 style="font-weight: bold; font-size: 30px; color:#ffef00; text-align:center; margin: 15px 0 5px 0;">Why Invest Time On Free Version?</h3>

		<h3 style="font-size: 18px; text-align:center; margin:0; color:#fff;">Explore Countdown Timer Ultimate Pro with Essential Bundle Free for 5 Days.</h3>			

		<div class="wpcdt-deal-free-offer">
			<a href="<?php echo esc_url( WPCDT_PLUGIN_BUNDLE_LINK ); ?>" target="_blank" class="wpcdt-sf-free-btn"><span class="dashicons dashicons-cart"></span> Try Pro For 5 Days Free</a>
		</div>
	</div>

	<!-- Start - Welcome Box -->
	<div class="wpcdt-sf-welcome-wrap" style="border: 1px solid #ddd; background: #fff;box-shadow: 0 3px 2px rgb(0 0 0 / 5%);padding: 50px; margin-bottom: 1rem;">
		<div class="wpcdt-sf-welcome-inr wpcdt-sf-center">
			<h5 class="wpcdt-sf-content" style="font-size:20px;">You can use it as CountDown for <span class="wpcdt-sf-blue">WebSites, Events and Product launch or as expiry date for Offers and Discounts</span>.</h5> 
			
			<h5 class="wpcdt-sf-content" style="font-size:18px;">The Plugin also works with <span class="wpcdt-sf-blue">WooCommerce and EDD coupons</span> and you can display coupons expiry date.</h5>
			
			<h5 class="wpcdt-sf-content" style="font-size:18px;"><span class="wpcdt-sf-blue">20,000+ </span>websites are using <span class="wpcdt-sf-blue">Countdown Timer </span> to turn their traffic into sales.</h5>
			
			<div style="margin-top: 15px; text-transform: uppercase; text-align:center;">
				<a href="<?php echo esc_url( $wpcdt_add_link ); ?>" class="wpcdt-sf-btn">Launch Countdown Timer With Free Features</a>
			</div>
		</div>
	</div>
	<!-- End - Welcome Box -->

</div>