<?php
/**
 * Functions
 *
 * @author  YITH
 * @package YITH/Search
 * @version 2.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'yith_wcas_is_fresh_block_installation' ) ) {
	/**
	 * Check if is a fresh installation or the plugin is an update from 1.x to 2.0.0
	 *
	 * @return bool
	 */
	function yith_wcas_is_fresh_block_installation() {
		return ! get_option( 'ywcas_updated_to_v2', false );
	}
}

if ( ! function_exists( 'yith_wcas_user_switch_to_block' ) ) {
	/**
	 * Check if the customer switch from old shortcode to block
	 *
	 * @return bool
	 */
	function yith_wcas_user_switch_to_block() {
		return apply_filters( 'ywcas_user_switch_block', get_option( 'ywcas_user_switch_to_block', false ) );
	}
}

if ( ! function_exists( 'yith_wcas_save_default_shortcode_options' ) ) {
	/**
	 * Change the default values to create shortcodes
	 *
	 * @return void
	 */
	function yith_wcas_save_default_shortcode_options() {
		$shortcodes = YITH_WCAS_Settings::get_instance()->get_shortcodes_list();
		if ( isset( $shortcodes['default'] ) ) {

			$default                                                           = $shortcodes['default']['options'];
			$shortcodes['default']['options']['search-input']['placeholder']   = get_option( 'yith_wcas_search_input_label', $default['search-input']['placeholder'] );
			$shortcodes['default']['options']['search-results']['max-results'] = get_option( 'yith_wcas_posts_per_page', $default['search-results']['max-results'] );

		}

		YITH_WCAS_Settings::get_instance()->update_shortcodes_list( $shortcodes );
	}
}