<?php
function accron_slider_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Slider Section Panel
	=========================================*/
	$wp_customize->add_panel(
		'accron_frontpage_sections', array(
			'priority' => 32,
			'title' => esc_html__( 'Frontpage Sections', 'clever-fox' ),
		)
	);
	
	$wp_customize->add_section(
		'slider_setting', array(
			'title' => esc_html__( 'Slider Section', 'clever-fox' ),
			'panel' => 'accron_frontpage_sections',
			'priority' => 1,
		)
	);


	//Slider Documentation Link
	class WP_slider_Customize_Control extends WP_Customize_Control {
	public $type = 'new_menu';

	   function render_content()
	   
	   {
	   ?>
			<h3><?php _e('Section Documentation','clever-fox'); ?></h3>
			<p><a href="#" target="_blank" style="background-color:#0083E3; color:#fff;display: flex;align-items: center;justify-content: center;text-decoration: none;   font-weight: 600;padding: 15px 10px;"><?php _e('Click Here','clever-fox');?></a></p>
			
		<?php
	   }
	}
	
	// Slider Doc Link // 
	$wp_customize->add_setting( 
		'slider_doc_link' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);

	$wp_customize->add_control(new WP_slider_Customize_Control($wp_customize,
	'slider_doc_link' , 
		array(
			'label'          => __( 'Slider Documentation Link', 'clever-fox' ),
			'section'        => 'slider_setting',
			'type'           => 'radio',
			'description'    => __( 'Slider Documentation Link', 'clever-fox' ), 
		) 
	) );
	
	// slider Contents
	$wp_customize->add_setting(
		'slider_content_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'slider_content_head',
		array(
			'type' => 'hidden',
			'label' => __('Contents','clever-fox'),
			'section' => 'slider_setting',
		)
	);	

	// Hide / Show 
	$wp_customize->add_setting(
		'slider_hs'
			,array(
			'default'     	=> '1',	
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'slider_hs',
		array(
			'type' => 'checkbox',
			'label' => __('Hide / Show','clever-fox'),
			'section' => 'slider_setting',
		)
	);
	
	// Slider Title
	$wp_customize->add_setting(
	'accron_slide_title', 
	array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default' =>  '20 Years Of Successful Business Consulting'
    ));
	
	$wp_customize->add_control( 
		'accron_slide_title', 
		array(
			'label'      => __( 'Title', 'clever-fox' ),
			'section'    => 'slider_setting',
		)
	);
	
	// Slider Subtitle
	$wp_customize->add_setting(
	'accron_slide_subtitle', 
	array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default' =>  'Your Business Innovative Strategies For Success'
    ));
	
	$wp_customize->add_control( 
		'accron_slide_subtitle', 
		array(
			'label'      => __( 'Subtitle', 'clever-fox' ),
			'section'    => 'slider_setting',
		)
	);
	
	// Slider Button
	$wp_customize->add_setting(
	'accron_slide_button', 
	array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default' =>  'Our Service'
    ));
	
	$wp_customize->add_control( 
		'accron_slide_button', 
		array(
			'label'      => __( 'Button Label', 'clever-fox' ),
			'section'    => 'slider_setting',
		)
	);
	
	// Slider Link
	$wp_customize->add_setting(
	'accron_slide_link', 
	array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default' =>  '#'
    ));
	
	$wp_customize->add_control( 
		'accron_slide_link', 
		array(
			'label'      => __( 'Button Url', 'clever-fox' ),
			'section'    => 'slider_setting',
		)
	);
	
	// Slider Text
	$wp_customize->add_setting(
	'accron_slide_text', 
	array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default' =>  __('It is a long established fact that a reader will be distracted by readable content of a page when looking at its layout. The point of using Lorem ipsum','clever-fox')
    ));
	
	$wp_customize->add_control( 
		'accron_slide_text', 
		array(
			'label'      => __( 'Description', 'clever-fox' ),
			'section'    => 'slider_setting',
		)
	);
	
	// Slider Image
	$wp_customize->add_setting(
	'accron_slide_image', 
	array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default' =>  esc_url(CLEVERFOX_PLUGIN_URL. 'inc/accron/images/slider/slider-img1.jpg')
    ));
	
	$wp_customize->add_control( 
	new WP_Customize_Image_Control( $wp_customize ,
			'accron_slide_image', 
			array(
				'label'      => __( 'Background Image', 'clever-fox' ),
				'section'    => 'slider_setting',
			)
	));
}

add_action( 'customize_register', 'accron_slider_setting' );