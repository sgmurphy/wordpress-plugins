<?php

/**
 * Get kses ruleset extended to allow svg
 * 
 * @since 6.9.5
 */
function get_kses_with_svg_ruleset() {
    $kses_defaults = wp_kses_allowed_html( 'post' );
    $svg_args = array(
        'svg'    => array(
            'class'           => true,
            'aria-hidden'     => true,
            'aria-labelledby' => true,
            'role'            => true,
            'xmlns'           => true,
            'width'           => true,
            'height'          => true,
            'viewbox'         => true,
            'viewBox'         => true,
        ),
        'g'      => array(
            'fill'            => true,
            'fill-rule'       => true,
            'stroke'          => true,
            'stroke-linejoin' => true,
            'stroke-width'    => true,
            'stroke-linecap'  => true,
        ),
        'title'  => array(
            'title' => true,
        ),
        'path'   => array(
            'd'               => true,
            'fill'            => true,
            'stroke'          => true,
            'stroke-linejoin' => true,
            'stroke-width'    => true,
            'stroke-linecap'  => true,
        ),
        'rect'   => array(
            'width'  => true,
            'height' => true,
            'x'      => true,
            'y'      => true,
            'rx'     => true,
            'ry'     => true,
        ),
        'circle' => array(
            'cx' => true,
            'cy' => true,
            'r'  => true,
        ),
    );
    return array_merge( $kses_defaults, $svg_args );
    // Example usage: wp_kses( $the_svg_icon, get_kses_with_svg_ruleset() );
}

/**
 * Get kses ruleset extended to allow style and script tags
 * 
 * @since 6.9.5
 */
function get_kses_with_style_src_ruleset() {
    $kses_defaults = wp_kses_allowed_html( 'post' );
    $style_script_args = array(
        'style'  => true,
        'script' => array(
            'src' => true,
        ),
    );
    return array_merge( $kses_defaults, $style_script_args );
    // Example usage: wp_kses( $the_html, get_kses_with_style_src_ruleset() );
}

/**
 * Get kses ruleset extended to allow style and script tags
 * 
 * @since 6.9.5
 */
function get_kses_with_style_src_svg_ruleset() {
    $kses_defaults = wp_kses_allowed_html( 'post' );
    $style_script_svg_args = array(
        'style'  => true,
        'script' => array(
            'src' => true,
        ),
        'svg'    => array(
            'class'           => true,
            'aria-hidden'     => true,
            'aria-labelledby' => true,
            'role'            => true,
            'xmlns'           => true,
            'width'           => true,
            'height'          => true,
            'viewbox'         => true,
            'viewBox'         => true,
        ),
        'g'      => array(
            'fill'            => true,
            'fill-rule'       => true,
            'stroke'          => true,
            'stroke-linejoin' => true,
            'stroke-width'    => true,
            'stroke-linecap'  => true,
        ),
        'title'  => array(
            'title' => true,
        ),
        'path'   => array(
            'd'               => true,
            'fill'            => true,
            'stroke'          => true,
            'stroke-linejoin' => true,
            'stroke-width'    => true,
            'stroke-linecap'  => true,
        ),
        'rect'   => array(
            'width'  => true,
            'height' => true,
            'x'      => true,
            'y'      => true,
            'rx'     => true,
            'ry'     => true,
        ),
        'circle' => array(
            'cx' => true,
            'cy' => true,
            'r'  => true,
        ),
    );
    return array_merge( $kses_defaults, $style_script_svg_args );
    // Example usage: wp_kses( $the_html, get_kses_with_style_src_svg_ruleset() );
}

/**
 * Get kses ruleset extended to allow input tags
 * 
 * @since 6.9.5
 */
function get_kses_with_custom_html_ruleset() {
    $kses_defaults = wp_kses_allowed_html( 'post' );
    $custom_html_args = array(
        'input' => array(
            'type'  => true,
            'id'    => true,
            'class' => true,
            'name'  => true,
            'value' => true,
            'style' => true,
        ),
    );
    return array_merge( $kses_defaults, $custom_html_args );
    // Example usage: wp_kses( $the_html, get_kses_with_style_src_ruleset() );
}
