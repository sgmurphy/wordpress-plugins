<?php
function accron_cta_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	CTA  Section
	=========================================*/
	$wp_customize->add_section(
		'cta_setting', array(
			'title' => esc_html__( 'Call to Action Section', 'clever-fox' ),
			'priority' => 6,
			'panel' => 'accron_frontpage_sections',
		)
	);

	//Cta Documentation Link
	class WP_cta_Customize_Control extends WP_Customize_Control {
	public $type = 'new_menu';

	   function render_content()
	   
	   {
	   ?>
			<h3><?php _e('Section Documentation','clever-fox'); ?></h3>
			<p><a href="#" target="_blank" style="background-color:#0083E3; color:#fff;display: flex;align-items: center;justify-content: center;text-decoration: none;   font-weight: 600;padding: 15px 10px;"><?php _e('Click Here','clever-fox');?></a></p>
			
		<?php
	   }
	}
	
	// Cta Doc Link // 
	$wp_customize->add_setting( 
		'cta_doc_link' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);

	$wp_customize->add_control(new WP_cta_Customize_Control($wp_customize,
	'cta_doc_link' , 
		array(
			'label'          => __( 'Cta Documentation Link', 'clever-fox' ),
			'section'        => 'cta_setting',
			'type'           => 'radio',
			'description'    => __( 'Cta Documentation Link', 'clever-fox' ), 
		) 
	) );
	
	// CTA Call Section // 
		
	$wp_customize->add_setting(
		'cta_call_contents'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'cta_call_contents',
		array(
			'type' => 'hidden',
			'label' => __('Content','clever-fox'),
			'section' => 'cta_setting',
		)
	);
	
	
	// Hide / Show 
	$wp_customize->add_setting(
		'cta_hs'
			,array(
			'default'     	=> '1',	
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'cta_hs',
		array(
			'type' => 'checkbox',
			'label' => __('Hide / Show','clever-fox'),
			'section' => 'cta_setting',
		)
	);
	
	// CTA Call Text // 
	$wp_customize->add_setting(
    	'accron_cta_phone_number',
    	array(
	        'default'			=> __('+70 975 975 70','clever-fox'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'accron_cta_phone_number',
		array(
		    'label'   => __('Phone Number','clever-fox'),
		    'section' => 'cta_setting',
			'type'           => 'text',
		)  
	);
	
	// CTA Call Text // 
	$wp_customize->add_setting(
    	'accron_cta_whatsapp_number',
    	array(
	        'default'			=> __('+70 975 975 70','clever-fox'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'accron_cta_whatsapp_number',
		array(
		    'label'   => __('WhatsApp Number','clever-fox'),
		    'section' => 'cta_setting',
			'type'           => 'text',
		)  
	);
	
	
	// CTA Content Section // 
	$wp_customize->add_setting(
		'cta_contents'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 3,
		)
	);
	
	
	// icon // 
	$wp_customize->add_setting(
    	'accron_cta_call_icon',
    	array(
	        'default' => 'fa-phone',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 4,
		)
	);	

	$wp_customize->add_control(new Accron_Icon_Picker_Control($wp_customize, 
		'accron_cta_call_icon',
		array(
		    'label'   		=> __('Call Icon','clever-fox'),
		    'section' 		=> 'cta_setting',
			'iconset' => 'fa',
			
		))  
	);	
	
	$wp_customize->add_setting(
    	'accron_cta_whatsapp_icon',
    	array(
	        'default' => 'fa-whatsapp',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 4,
		)
	);	

	$wp_customize->add_control(new Accron_Icon_Picker_Control($wp_customize, 
		'accron_cta_whatsapp_icon',
		array(
		    'label'   		=> __('WhatsApp Icon','clever-fox'),
		    'section' 		=> 'cta_setting',
			'iconset' => 'fa',
			
		))  
	);	
	
	
	// CTA Title // 
	$wp_customize->add_setting(
    	'accron_cta_title',
    	array(
	        'default'			=> __('Want To Work With Us ?','clever-fox'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 4,
		)
	);	
	
	$wp_customize->add_control( 
		'accron_cta_title',
		array(
		    'label'   => __('Title','clever-fox'),
		    'section' => 'cta_setting',
			'type'           => 'text',
		)  
	);
	
	// CTA Description // 
	$wp_customize->add_setting(
    	'accron_cta_description',
    	array(
	        'default'			=> __('Meet Our People. See Our Work. Join Our Team','clever-fox'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 6,
		)
	);	
	
	$wp_customize->add_control( 
		'accron_cta_description',
		array(
		    'label'   => __('Description','clever-fox'),
		    'section' => 'cta_setting',
			'type'           => 'textarea',
		)  
	);
	
	// Button // 	
	$wp_customize->add_setting(
		'cta_btn'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 7,
		)
	);

	$wp_customize->add_control(
	'cta_btn',
		array(
			'type' => 'hidden',
			'label' => __('Button','clever-fox'),
			'section' => 'cta_setting',
		)
	);
	
	$wp_customize->add_setting(
    	'accron_cta_btn_lbl',
    	array(
			'default' 			=> esc_html__('Contact With Us','clever-fox'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_url',
			'priority' => 9,
		)
	);	
	
	$wp_customize->add_control( 
		'accron_cta_btn_lbl',
		array(
		    'label'   => __('Title','clever-fox'),
		    'section' => 'cta_setting',
			'type'           => 'text',
		)  
	);
	
	$wp_customize->add_setting(
    	'accron_cta_btn_link',
    	array(
			'default' 			=> '#',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_url',
			'priority' => 9,
		)
	);	
	
	$wp_customize->add_control( 
		'accron_cta_btn_link',
		array(
		    'label'   => __('Link','clever-fox'),
		    'section' => 'cta_setting',
			'type'           => 'text',
		)  
	);
	
	
	$wp_customize->add_setting(
    	'accron_cta_video_url',
    	array(
			'default' 			=> esc_url('https://www.youtube.com/watch?v=b5Jyqzm5idw'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_url',
			'priority' => 9,
		)
	);	
	
	$wp_customize->add_control( 
		'accron_cta_video_url',
		array(
		    'label'   => __('Play Button Link','clever-fox'),
		    'section' => 'cta_setting',
			'type'           => 'text',
		)  
	);
	
	
	// CTA Background // 	
	$wp_customize->add_setting(
		'cta_bg_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 13,
		)
	);

	$wp_customize->add_control(
	'cta_bg_head',
		array(
			'type' => 'hidden',
			'label' => __('Background','clever-fox'),
			'section' => 'cta_setting',
		)
	);
	
    $wp_customize->add_setting( 
    	'accron_cta_bg_setting' , 
    	array(
			'default' 			=> esc_url(CLEVERFOX_PLUGIN_URL. 'inc/accron/images/bg-cta.jpg'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_url',	
			'priority' => 14,
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'accron_cta_bg_setting' ,
		array(
			'label'          => __( 'Background Image', 'clever-fox' ),
			'section'        => 'cta_setting',
		) 
	));

	$wp_customize->add_setting( 
		'accron_cta_bg_position' , 
			array(
			'default' => 'fixed',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_select',
			'priority' => 15,
		) 
	);
	
	$wp_customize->add_control(
		'accron_cta_bg_position' , 
			array(
				'label'          => __( 'Image Position', 'clever-fox' ),
				'section'        => 'cta_setting',
				'type'           => 'radio',
				'choices'        => 
				array(
					'fixed'=> __( 'Fixed', 'clever-fox' ),
					'scroll' => __( 'Scroll', 'clever-fox' )
			)  
		) 
	);

}

add_action( 'customize_register', 'accron_cta_setting' );

// CTA selective refresh
function accron_ata_section_partials( $wp_customize ){
	
	// accron_cta_call_icon
	$wp_customize->selective_refresh->add_partial( 'accron_cta_call_icon', array(
		'selector'            => '.cta-section-1 .cta-content .cta-info-wrap .widget-contact .contact-icon ',
		'settings'            => 'accron_cta_call_icon',
		'render_callback'  => 'accron_accron_cta_btn_lbl_render_callback',
	) );
	
	// accron_cta_btn_lbl
	$wp_customize->selective_refresh->add_partial( 'accron_cta_btn_lbl', array(
		'selector'            => '.cta-content a',
		'settings'            => 'accron_cta_btn_lbl',
		'render_callback'  => 'accron_accron_cta_btn_lbl_render_callback',
	) );
	
	// accron_cta_phone_number
	$wp_customize->selective_refresh->add_partial( 'accron_cta_phone_number', array(
		'selector'            => '.cta-section-1 .cta-content .cta-info-wrap .widget-contact .contact-info p a',
		'settings'            => 'accron_cta_phone_number',
		'render_callback'  => 'accron_accron_cta_phone_number_render_callback',
	) );
	
	// accron_cta_title
	$wp_customize->selective_refresh->add_partial( 'accron_cta_title', array(
		'selector'            => '.cta-content h3',
		'settings'            => 'accron_cta_title',
		'render_callback'  => 'accron_accron_cta_title_render_callback',
	) );
	
	// accron_cta_description
	$wp_customize->selective_refresh->add_partial( 'accron_cta_description', array(
		'selector'            => '.cta-content p',
		'settings'            => 'accron_cta_description',
		'render_callback'  => 'accron_accron_cta_description_render_callback',
	) );
	}

add_action( 'customize_register', 'accron_ata_section_partials' );

// accron_cta_title
function accron_accron_cta_title_render_callback() {
	return get_theme_mod( 'accron_cta_title' );
}


// accron_cta_description
function accron_accron_cta_description_render_callback() {
	return get_theme_mod( 'accron_cta_description' );
}

// accron_cta_btn_lbl
function accron_accron_cta_btn_lbl_render_callback() {
	return get_theme_mod( 'accron_cta_btn_lbl' );
}

// accron_cta_phone_number
function accron_accron_cta_phone_number_render_callback() {
	return get_theme_mod( 'accron_cta_phone_number' );
}
