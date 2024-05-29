<?php
/**
 *  Dynamic CSS
 *
 * @package    Smart_Post_Show
 * @subpackage Smart_Post_Show/public
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout_preset = isset( $layout['pcp_layout_preset'] ) ? $layout['pcp_layout_preset'] : '';
$section_title = isset( $view_options['section_title'] ) ? $view_options['section_title'] : false;

// Section Title.
if ( $section_title ) {
	$section_title_margin        = isset( $view_options['section_title_margin'] ) && is_array( $view_options['section_title_margin'] ) ? $view_options['section_title_margin'] : array(
		'top'    => '0',
		'right'  => '0',
		'bottom' => '30',
		'left'   => '0',
	);
	$section_title_margin_top    = (int) $section_title_margin ['top'] > 0 ? $section_title_margin ['top'] . 'px' : 0;
	$section_title_margin_right  = (int) $section_title_margin['right'] > 0 ? $section_title_margin['right'] . 'px' : 0;
	$section_title_margin_bottom = (int) $section_title_margin['bottom'] > -50 ? (int) $section_title_margin['bottom'] . 'px' : 0;
	$section_title_margin_left   = (int) $section_title_margin['left'] > 0 ? $section_title_margin['left'] . 'px' : 0;
	$_section_title_color        = isset( $view_options['section_title_typography']['color'] ) ? $view_options['section_title_typography']['color'] : '#111';
	$custom_css                 .= "#poststuff #sp_pcp_display .sp-pcp-section .pcp-section-title, #pcp_wrapper-{$pcp_id} .pcp-section-title{color: {$_section_title_color };margin: {$section_title_margin_top} {$section_title_margin_right} {$section_title_margin_bottom} {$section_title_margin_left}}";
}
$margin_between_post      = isset( $view_options['margin_between_post']['all'] ) ? (int) $view_options['margin_between_post']['all'] : 20;
$margin_between_post_half = $margin_between_post / 2;
$custom_css              .= "#pcp_wrapper-{$pcp_id} .sp-pcp-row{ margin-right: -{$margin_between_post_half}px;margin-left: -{$margin_between_post_half}px;}#pcp_wrapper-{$pcp_id} .sp-pcp-row [class*='sp-pcp-col-']{padding-right: {$margin_between_post_half}px;padding-left: {$margin_between_post_half}px;padding-bottom: {$margin_between_post}px;}";

/**
 * Style for each slide/post.
 */
$post_sorter = isset( $view_options['post_content_sorter'] ) ? $view_options['post_content_sorter'] : '';

// Post Title.
if ( isset( $post_sorter['pcp_post_title']['show_post_title'] ) && $post_sorter['pcp_post_title']['show_post_title'] ) {
	$_post_title_typography = isset( $view_options['post_title_typography'] ) && is_array( $view_options['post_title_typography'] ) ? $view_options['post_title_typography'] : array(
		'color'       => '#111',
		'hover_color' => '#e1624b',
	);
	$custom_css            .= ".pcp-wrapper-{$pcp_id} .sp-pcp-title a {color: {$_post_title_typography['color']};display: inherit;} .pcp-wrapper-{$pcp_id} .sp-pcp-title a:hover {color: {$_post_title_typography['hover_color']};}";
}

// Post Content.
$pcp_post_content  = isset( $post_sorter['pcp_post_content'] ) ? $post_sorter['pcp_post_content'] : '';
$show_post_content = isset( $pcp_post_content['show_post_content'] ) ? $pcp_post_content['show_post_content'] : '';
if ( $show_post_content ) {
	$_post_content_color = isset( $view_options['post_content_typography']['color'] ) ? $view_options['post_content_typography']['color'] : '#444';
	$custom_css         .= ".pcp-wrapper-{$pcp_id} .sp-pcp-post-content{color: {$_post_content_color}; }";
}

if ( 'carousel_layout' === $layout_preset ) {
	include SP_PC_PATH . '/public/dynamic-css/carousel-css.php';
}

// Post inner padding.
$post_content_orientation = isset( $view_options['post_content_orientation'] ) ? $view_options['post_content_orientation'] : 'default';
if ( 'overlay' !== $post_content_orientation ) {
	$_post_inner_padding       = SP_PC_Functions::pcp_metabox_value( 'post_inner_padding_property', $view_options );
	$post_inner_padding_unit   = $_post_inner_padding['unit'];
	$post_inner_padding_top    = $_post_inner_padding['top'] > 0 ? $_post_inner_padding['top'] . $post_inner_padding_unit : '0';
	$post_inner_padding_right  = $_post_inner_padding['right'] > 0 ? $_post_inner_padding['right'] . $post_inner_padding_unit : '0';
	$post_inner_padding_bottom = $_post_inner_padding['bottom'] > 0 ? $_post_inner_padding['bottom'] . $post_inner_padding_unit : '0';
	$post_inner_padding_left   = $_post_inner_padding['left'] > 0 ? $_post_inner_padding['left'] . $post_inner_padding_unit : '0';
	$custom_css               .= "#pcp_wrapper-{$pcp_id} .sp-pcp-post {padding: {$post_inner_padding_top} {$post_inner_padding_right} {$post_inner_padding_bottom} {$post_inner_padding_left};}";
}

// Post border.
$_post_border      = $view_options['post_border'];
$post_border_width = isset( $_post_border['all'] ) ? (int) $_post_border['all'] : '0';
$post_border_style = $_post_border['style'];
$post_border_color = $_post_border['color'];
if ( 'none' !== $post_border_style ) {
	$custom_css .= "#pcp_wrapper-{$pcp_id} .sp-pcp-post {border: {$post_border_width}px {$post_border_style} {$post_border_color};}";
}

// Post background color.
$post_background_property    = SP_PC_Functions::pcp_metabox_value( 'post_background_property', $view_options );
$post_border_radius_property = SP_PC_Functions::pcp_metabox_value( 'post_border_radius_property', $view_options );
$custom_css                 .= "#pcp_wrapper-{$pcp_id} .sp-pcp-post {border-radius: {$post_border_radius_property['all']}px;}";
if ( ! in_array( $post_content_orientation, array( 'overlay', 'overlay-box' ), true ) ) {
	$custom_css .= "#pcp_wrapper-{$pcp_id} .sp-pcp-post{background-color: {$post_background_property};}";
}

/**
 * Post Thumbnail CSS.
 */
$post_thumb_css = $post_sorter['pcp_post_thumb'];

// Post Meta.
$_post_meta_color       = isset( $view_options['post_meta_typography']['color'] ) ? $view_options['post_meta_typography']['color'] : '#888';
$_post_meta_hover_color = isset( $view_options['post_meta_typography']['hover_color'] ) ? $view_options['post_meta_typography']['hover_color'] : '#e1624b';
$custom_css            .= ".pcp-wrapper-{$pcp_id} .sp-pcp-post-meta li,.pcp-wrapper-{$pcp_id} .sp-pcp-post-meta ul,.pcp-wrapper-{$pcp_id} .sp-pcp-post-meta li a{color: {$_post_meta_color};}";
$custom_css            .= ".pcp-wrapper-{$pcp_id} .sp-pcp-post-meta li a:hover{color: {$_post_meta_hover_color};}";

// Post ReadMore Settings.
$post_content_settings = isset( $post_sorter['pcp_post_content'] ) ? $post_sorter['pcp_post_content'] : '';
$show_read_more        = isset( $post_content_settings['show_read_more'] ) ? $post_content_settings['show_read_more'] : '';
if ( $show_read_more ) {
	$_button_color = $post_content_settings['readmore_color_button'];
	$custom_css   .= "#pcp_wrapper-{$pcp_id} .pcp-readmore-link{ background: {$_button_color['bg']}; color: {$_button_color['standard']}; border-color: {$_button_color['border']}; } #pcp_wrapper-{$pcp_id} .pcp-readmore-link:hover { background: {$_button_color['hover_bg']}; color: {$_button_color['hover']}; border-color: {$_button_color['hover_border']}; }";
}

// Pagination CSS and Live filter CSS.
$show_pagination = isset( $view_options['show_post_pagination'] ) ? $view_options['show_post_pagination'] : '';
if ( $show_pagination ) {
	$pagination_btn_color = $view_options['pcp_pagination_btn_color'];
	$custom_css          .= "#pcp_wrapper-{$pcp_id} .pcp-post-pagination .page-numbers.current, #pcp_wrapper-{$pcp_id} .pcp-post-pagination a.active , #pcp_wrapper-{$pcp_id} .pcp-post-pagination a:hover{ color: {$pagination_btn_color['text_acolor']}; background: {$pagination_btn_color['active_background']}; border-color: {$pagination_btn_color['border_acolor']}; }#pcp_wrapper-{$pcp_id} .pcp-post-pagination .page-numbers, .pcp-post-pagination a{ background: {$pagination_btn_color['background']}; color:{$pagination_btn_color['text_color']}; border-color: {$pagination_btn_color['border_color']}; }";
}
