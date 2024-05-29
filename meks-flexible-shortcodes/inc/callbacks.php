<?php

/* Column shortcodes */
if ( !function_exists( 'mks_columns_sc' ) ) :
    function mks_columns_sc( $atts, $content, $tag ) {

        global $mks_shortcodes_use_bootstrap;
        $defaults = array(
            'class' => '',
            'bootstrap' => false
        );
        $atts = shortcode_atts( $defaults, $atts );
        $class = esc_attr( $atts['class'] );
        $bootstrap = (bool) $atts['bootstrap'];
        
        if( $tag == 'mks_col'){
            $mks_shortcodes_use_bootstrap = $bootstrap;
        }

        if ( $mks_shortcodes_use_bootstrap ) {
            $tag = mks_generate_bootstrap_classes($tag);
        }

        $output = '<div class="'.esc_attr($tag).' '.$class.'">' . do_shortcode( $content ) . '</div>';
        return $output;
    }
endif;


/* Button shortcode */
if ( !function_exists( 'mks_button_sc' ) ) :
    function mks_button_sc( $atts, $content, $tag ) {
        $defaults = array(
            'size' => 'large',
            'style' => 'rounded',
            'title' => '',
            'url' => '#',
            'target' => '_self',
            'icon' => '',
            'bg_color' => '#000000',
            'txt_color' => '#ffffff',
            'icon_type' => 'fa',
            'nofollow' => 0
        );
        $atts = shortcode_atts( $defaults, $atts );
        
        $size = esc_attr( $atts['size'] );
        $style = esc_attr( $atts['style'] );
        $title = esc_html( $atts['title'] );
        $url = esc_url( $atts['url'] );
        $target = esc_attr( $atts['target'] );
        $icon = esc_attr( $atts['icon'] );
        $bg_color = esc_attr( $atts['bg_color'] );
        $txt_color = esc_attr( $atts['txt_color'] );
        $icon_type = esc_attr( $atts['icon_type'] );
        $nofollow = (bool) $atts['nofollow'];
        
        $inl_style = 'style="color: '.$txt_color.'; background-color: '.$bg_color.';"';
        $icon_type = ( $icon_type == 'fa' ) ? 'fa ' : '';
        $icon = $icon ? '<i class="'.$icon_type.$icon.'"></i>' : '';
        $nofollow = $nofollow ? 'rel="nofollow"' : '';
        $output = '<a class="mks_button mks_button_'.$size.' '.$style.'" href="'.$url.'" target="'.$target.'" '.$inl_style.' '.$nofollow.'>' . $icon . $title . '</a>';
        return $output;
    }
endif;


/* Dropcap shortcode */
if ( !function_exists( 'mks_dropcap_sc' ) ) :
    function mks_dropcap_sc( $atts, $content, $tag ) {
        $defaults = array(
            'style' => 'letter',
            'size'=> 52,
            'bg_color' => '#ffffff',
            'txt_color' => '#000000'
        );
        $atts = shortcode_atts( $defaults, $atts );
        
        $apply_bg_color = true;
        switch ( $atts['style'] ) {
            case 'letter': $class = 'mks_dropcap_letter'; $apply_bg_color = false; break;
            case 'square': $class = 'mks_dropcap'; break;
            case 'circle': $class = 'mks_dropcap mks_dropcap_circle'; break;
            case 'rounded': $class = 'mks_dropcap mks_dropcap_rounded'; break;
            default: $class = 'mks_dropcap_letter'; break;
        }
        
        $style = 'style="font-size: '.absint( $atts['size'] ).'px; color: '.esc_attr( $atts['txt_color'] ).'; ';
        if ( $apply_bg_color ) {
            $style .= 'background-color: '.esc_attr( $atts['bg_color'] ).';';
        }
        $style .= '"';

        $output = '<span class="'.esc_attr($class).'" '.$style.'>' . $content . '</span>';
       
        return $output;
    }
endif;


/* Pullquote shortcode */
if ( !function_exists( 'mks_pullquote_sc' ) ) :
    function mks_pullquote_sc( $atts, $content, $tag ) {
        $defaults = array(
            'align' => 'left',
            'width' => 300,
            'size' => 24,
            'bg_color' => '#000000',
            'txt_color' => '#ffffff'
        );
        $atts = shortcode_atts( $defaults, $atts );
        
        $output = '<div class="mks_pullquote mks_pullquote_'.esc_attr($atts['align']).'" style="width:'.absint( $atts['width'] ).'px; font-size: '.$atts['size'].'px; color: '.esc_attr($atts['txt_color']).'; background-color:'.esc_attr($atts['bg_color']).';">' . do_shortcode( $content ) . '</div>';
        return $output;
    }
endif;


/* Separator shortcode */
if ( !function_exists( 'mks_separator_sc' ) ) :
    function mks_separator_sc( $atts, $content, $tag ) {
        $defaults = array(
            'height' => 2,
            'style' => 'solid'
        );
        $atts = shortcode_atts( $defaults, $atts );
        
        if ( $atts['style'] == 'blank' ) {
            $inl_css = 'style="height: '.absint( $atts['height'] ).'px;"';
        } else {
            $inl_css = 'style="border-bottom: '.absint( $atts['height'] ).'px '.esc_attr($atts['style']).';"';
        }
        $output = '<div class="mks_separator" '.$inl_css.'>' . $content . '</div>';
        return $output;
    }
endif;


/* Highlight shortcode */
if ( !function_exists( 'mks_highlight_sc' ) ) :
    function mks_highlight_sc( $atts, $content, $tag ) {
        $defaults = array(
            'color' => '#ffffff'
        );
        $atts = shortcode_atts( $defaults, $atts );
        
        $output = '<span class="mks_highlight" style="background-color: '.esc_attr($atts['color']).'">' . $content . '</span>';
        return $output;
    }
endif;

/* Social Icon Shortcode */
if ( !function_exists( 'mks_social_sc' ) ) :
    function mks_social_sc( $atts, $content, $tag ) {
        $defaults = array(
            'icon' => '',
            'style'=> 'square',
            'size' => 48,
            'url' => '',
            'target' => '_blank'
        );
        $atts = shortcode_atts( $defaults, $atts );
        
        $target = $atts['target'] == '_blank' ?  'target="'. esc_attr($atts['target']) .'" rel="noopener"' : 'target="'.esc_attr($atts['target']).'"';
        $output = '<a href="'.esc_url($atts['url']).'" class="mks_ico '.esc_attr($atts['icon']).'_ico '.esc_attr($atts['style']).'" '.$target.' style="width: '.absint( $atts['size'] ).'px; height: '.absint( $atts['size'] ).'px;">'.esc_attr($atts['icon']).'</a>';
        return $output;
    }
endif;


/* Icon Shortcode */
if ( !function_exists( 'mks_icon_sc' ) ) :
    function mks_icon_sc( $atts, $content, $tag ) {
        extract( shortcode_atts(  array( 'icon' => '', 'type' => 'fa', 'color' => '#000000' ), $atts ) );
        $class = ( $type == 'fa' ) ? $type.' ' : '';
        $output = '<i class="'.esc_attr($class.$icon).'" style="color: '.esc_attr($color).'"></i>';
        return $output;
    }
endif;


/* Progress Bar Shortcode */
if ( !function_exists( 'mks_progressbar_sc' ) ) :
    function mks_progressbar_sc( $atts, $content, $tag ) {
        extract( shortcode_atts(  array( 'name' => '', 'level' => '', 'value' => 80, 'color' => '#000000', 'height' => 20, 'style' => '' ), $atts ) );
        $output = '<div class="mks_progress_bar">';
        if ( !empty( $name ) || !empty( $level ) ) {
            $output .= '<div class="mks_progress_label">'.$name.'<span class="mks_progress_name">'.$level.'</span></div>';
        }
        $output .= '<div class="mks_progress_level '.esc_attr($style).'" style="height: '.absint( $height ).'px; background-color: '.mks_hex2rgba( $color, '0.5' ).';"><div class="mks_progress_level_set" style="width: '.absint( $value ).'%; background-color: '.esc_attr($color).';"></div></div>';
        $output .= '</div>';

        return $output;
    }
endif;


/* Accordion Wrap Shortcode */
if ( !function_exists( 'mks_accordion_sc' ) ) :
    function mks_accordion_sc( $atts, $content, $tag ) {
        $output = '<div class="mks_accordion">'.do_shortcode( $content ).'</div>';
        return $output;
    }
endif;

/* Accordion Item Shortcode */
if ( !function_exists( 'mks_accordion_item_sc' ) ) :
    function mks_accordion_item_sc( $atts, $content, $tag ) {
        extract( shortcode_atts(  array( 'title' => 'Title' ), $atts ) );

        $output = '<div class="mks_accordion_item">
            <div class="mks_accordion_heading">'.esc_html($title).'<i class="fa fa-plus"></i><i class="fa fa-minus"></i></div>
                <div class="mks_accordion_content">'.do_shortcode( $content ).'</div>
            </div>';
        return $output;
    }
endif;

/* Toggle Shortcode */
if ( !function_exists( 'mks_toggle_sc' ) ) :
    function mks_toggle_sc( $atts, $content, $tag ) {
        extract( shortcode_atts(  array( 'title' => 'Title', 'state'=> '' ), $atts ) );

        $active = $state == 'open' ? ' mks_toggle_active': '';

        $output = '<div class="mks_toggle'.esc_attr($active).'">
            <div class="mks_toggle_heading">'.esc_html($title).'<i class="fa fa-plus"></i><i class="fa fa-minus"></i></div>
                <div class="mks_toggle_content">'.do_shortcode( $content ).'</div>
            </div>';
        return $output;
    }
endif;

/* Tabs Wrap Shortcode */
if ( !function_exists( 'mks_tabs_sc' ) ) :
    function mks_tabs_sc( $atts, $content, $tag ) {
        extract( shortcode_atts(  array( 'nav' => 'horizontal', 'state'=> '' ), $atts ) );
        $output = '<div class="mks_tabs '.esc_attr($nav).'"><div class="mks_tabs_nav"></div>'.do_shortcode( $content ).'</div>';
        return $output;
    }
endif;

/* Accordion Item Shortcode */
if ( !function_exists( 'mks_tab_item_sc' ) ) :
    function mks_tab_item_sc( $atts, $content, $tag ) {
        extract( shortcode_atts(  array( 'title' => 'Title' ), $atts ) );

        $output = '<div class="mks_tab_item"><div class="nav">'.esc_html($title).'</div>'.do_shortcode( $content ).'</div>';
        return $output;
    }
endif;