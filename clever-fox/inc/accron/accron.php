<?php
/**
 * @package Accron
 */

require CLEVERFOX_PLUGIN_DIR . 'inc/accron/extras.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/accron/dynamic-style.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/accron/features/accron-slider.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/accron/features/accron-service.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/accron/features/accron-features.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/accron/features/accron-cta.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/accron/features/accron-typography.php';

if ( ! function_exists( 'cleverfox_accron_frontpage_sections' ) ) :
	function cleverfox_accron_frontpage_sections() {	
		require CLEVERFOX_PLUGIN_DIR . 'inc/accron/sections/section-slider.php';
		require CLEVERFOX_PLUGIN_DIR . 'inc/accron/sections/section-service.php';
		require CLEVERFOX_PLUGIN_DIR . 'inc/accron/sections/section-features.php';
		require CLEVERFOX_PLUGIN_DIR . 'inc/accron/sections/section-cta.php';
    }
	add_action( 'accron_sections', 'cleverfox_accron_frontpage_sections' );
endif;

function accron_customize_remove( $wp_customize ) {
	$wp_customize->remove_control('accron_slide_text');
}
add_action( 'customize_register', 'accron_customize_remove' );

/*Define default Values */
set_theme_mod('tlh_mobile_title',__('Call Us','clever-fox'));
set_theme_mod('tlh_mobile_icon','fa-phone');
set_theme_mod('tlh_mobile_number',__('+70 975 975 70','clever-fox'));
set_theme_mod('tlh_contct_icon','fa-location-arrow');
set_theme_mod('tlh_email_title',__('Write Us','clever-fox'));
set_theme_mod('tlh_email_icon','fa-envelope');
set_theme_mod('tlh_email',__('email@company.com','clever-fox'));
set_theme_mod('tlh_office_hours_icon',__('fa-clock','clever-fox'));
set_theme_mod('tlh_office_hours_title',__('Office Hours','clever-fox'));
set_theme_mod('tlh_office_hours',__('New York, London','clever-fox'));
set_theme_mod('tlh_btn_lbl',__('Buy Now','clever-fox'));
set_theme_mod('tlh_appointment_btn_lbl',__('Make Appointment','clever-fox'));
set_theme_mod('tlh_address_title',__('Address','clever-fox'));
set_theme_mod('tlh_contact_address',__('50 Wallstreet,USA','clever-fox'));
set_theme_mod('tlh_gallery_text',__('Instagram Gallery','clever-fox'));
set_theme_mod('tlh_about_text',__('About','clever-fox'));
set_theme_mod('tlh_about_desc',__('There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour or at randomised words which don"t look even slightly believable.','clever-fox'));
set_theme_mod('tlf_mobile_title',__('Call Us','clever-fox'));
set_theme_mod('tlf_mobile_icon','fa-phone');
set_theme_mod('tlf_mobile_number',__('+70 975 975 70','clever-fox'));
set_theme_mod('tlf_contct_icon','fa-location-arrow');
set_theme_mod('tlf_email_title',__('Write Us','clever-fox'));
set_theme_mod('tlf_email_icon','fa-envelope');
set_theme_mod('tlf_email',__('email@company.com','clever-fox'));
set_theme_mod('tlf_address_title',__('Address','clever-fox'));
set_theme_mod('tlf_contact_address',__('50 Wallstreet,USA','clever-fox'));