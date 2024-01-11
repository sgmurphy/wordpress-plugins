<?php

class Themify_Conditional_Menus_Data {

    public static function get_raw() : array {
        static $options = null;
        if ( $options === null ) {
            $options = get_theme_mod( 'themify_conditional_menus', array() );
            $options = wp_parse_args( $options, get_nav_menu_locations() );
        }

		return $options;
	}

    public static function get_data() {
        static $options = null;
        if ( $options === null ) {
            $cache_key = 'tf_conditions_menu_' . Themify_Conditional_Menus_Utils::get_current_language();
            $options = get_theme_mod( $cache_key );
            if ( ! is_array( $options ) ) {
                $options = self::get_raw();
                $options = self::update( $options );
                set_theme_mod( $cache_key, $options ); /* cache the data */
            }
        }

        return $options;
    }

    public static function update( $old_data ) {
        $new_data = [];
        $translate = ! Themify_Conditional_Menus_Utils::is_default_language();

        foreach ( $old_data as $menu_slug => $overrides ) {
            if ( ! is_array( $overrides ) ) {
                continue;
            }
            foreach ( $overrides as $index => $conditional_menu ) {
                $conditions = $conditional_menu['condition'];
                if ( ! empty( $conditions ) ) {
                    parse_str( $conditions, $conditions );
                    if ( empty( $conditions ) ) {
                        continue;
                    }

                    $new_data[ $menu_slug ][ $index ]['menu'] = $conditional_menu['menu'];

                    if ( isset( $conditions['roles'] ) ) {
                        $new_data[ $menu_slug ][ $index ]['conditions']['roles'] = $conditions['roles'];
                    }
                    if ( isset( $conditions['general'] ) ) {
                        $new_data[ $menu_slug ][ $index ]['conditions']['general'] = $conditions['general'];
                    }
                    if ( isset( $conditions['wc'] ) ) {
                        $new_data[ $menu_slug ][ $index ]['conditions']['wc'] = $conditions['wc'];
                    }
                    if ( isset( $conditions['post_type'] ) ) {
                        foreach ( $conditions['post_type'] as $post_type => $posts ) {
                            $posts = array_keys( $posts );
                            $posts = array_map( [ 'Themify_Conditional_Menus_Data', 'get_post_id_by_slug' ], $posts, array_fill( 0, count( $posts ), $post_type ) );
                            $posts = array_filter( $posts );

                            if ( $translate ) {
                                $posts = array_map( [ 'Themify_Conditional_Menus_Utils', 'maybe_translate_object' ], $posts, array_fill( 0, count( $posts ), $post_type ) );
                            }

                            if ( ! empty( $posts ) ) {
                                $new_data[ $menu_slug ][ $index ]['conditions']['post_type'][ $post_type ] = $posts;
                            }
                        }
                    }
                    if ( isset( $conditions['tax']['category_single'] ) ) { /* Has Term conditions */
                        foreach ( $conditions['tax']['category_single'] as $tax => $terms ) {
                            $terms = array_keys( $terms );
                            $terms = array_map( [ 'Themify_Conditional_Menus_Data', 'get_term_id_by_slug' ], $terms, array_fill( 0, count( $terms ), $tax ) );
                            $terms = array_filter( $terms );

                            if ( $translate ) {
                                $terms = array_map( [ 'Themify_Conditional_Menus_Utils', 'maybe_translate_object' ], $terms, array_fill( 0, count( $terms ), $tax ) );
                            }

                            if ( ! empty( $terms ) ) {
                                $new_data[ $menu_slug ][ $index ]['conditions']['has_term'][ $tax ] = $terms;
                            }
                        }
                        unset( $conditions['tax']['category_single'] );
                    }
                    if ( isset( $conditions['tax'] ) ) { /* Term archive conditions */
                        foreach ( $conditions['tax'] as $tax => $terms ) {
                            $terms = array_keys( $terms );
                            $terms = array_map( [ 'Themify_Conditional_Menus_Data', 'get_term_id_by_slug' ], $terms, array_fill( 0, count( $terms ), $tax ) );
                            $terms = array_filter( $terms );

                            if ( $translate ) {
                                $terms = array_map( [ 'Themify_Conditional_Menus_Utils', 'maybe_translate_object' ], $terms, array_fill( 0, count( $terms ), $tax ) );
                            }

                            if ( ! empty( $terms ) ) {
                                $new_data[ $menu_slug ][ $index ]['conditions']['tax'][ $tax ] = $terms;
                            }
                        }
                    }
                }
            }
        }

        return $new_data;
    }

    private static function get_term_id_by_slug( $slug, $taxonomy ) {
        if ( ! taxonomy_exists( $taxonomy ) ) {
            return false;
        }

        $translate = ! Themify_Conditional_Menus_Utils::is_default_language();
        $current_lang = Themify_Conditional_Menus_Utils::get_current_language();
        $default_lang = Themify_Conditional_Menus_Utils::get_default_language();

        $args = array(
            'fields' => 'ids',
            'number' => 1,
            'taxonomy' => $taxonomy,
            'update_term_meta_cache' => false,
            'orderby' => 'none',
            'suppress_filter' => true,
            'slug' => (string) $slug,
        );

        /* before retrieving IDs, switch to default language */
        if ( $translate ) {
            do_action( 'wpml_switch_language', $default_lang );
        }
        if ( defined( 'POLYLANG_VERSION' ) ) {
            $args['lang'] = Themify_Conditional_Menus_Utils::get_default_language();
        }

        $terms = get_terms($args);

        if ( $translate ) {
            do_action( 'wpml_switch_language', $current_lang );
        }

        if (is_wp_error($terms) || empty($terms)) {
            return false;
        }

        return $terms[0];
    }

    private static function get_post_id_by_slug( $slug, $post_type ) {
        $result = get_page_by_path( $slug, OBJECT, $post_type );
        if ( $result ) {
            return $result->ID;
        }
    }
}