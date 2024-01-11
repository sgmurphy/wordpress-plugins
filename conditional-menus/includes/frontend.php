<?php

class Themify_Conditional_Menus_Frontend {

    public static function init() {
        add_filter( 'wp_nav_menu_args', [ __CLASS__, 'wp_nav_menu_args' ] );
        add_filter( 'theme_mod_nav_menu_locations', [ __CLASS__, 'theme_mod_nav_menu_locations' ], 99 );
    }

    /**
     * Check if an item is visible for the current context
     *
     * @return bool
     */
    public static function check_visibility( $logic ) {
        $query_object = get_queried_object();
        $query_object_id = get_queried_object_id();

        // Logged-in check
        if( isset( $logic['general']['logged'] ) ) {
            if( ! is_user_logged_in() ) {
                return false;
            }
            unset( $logic['general']['logged'] );
            if( empty( $logic['general'] ) ) {
                unset( $logic['general'] );
            }
        }

        // User role check
        if ( ! empty( $logic['roles'] )
            // check if *any* of user's role(s) matches
            && ! count( array_intersect( wp_get_current_user()->roles, array_keys( $logic['roles'], true ) ) )
        ) {
            return false; // bail early.
        }
        unset( $logic['roles'] );

        if ( ! empty( $logic ) ) {
            if ( ( isset( $logic['general']['home'] ) && is_front_page())
                || ( isset( $logic['general']['404'] ) &&  is_404() )
                || ( isset( $logic['general']['page'] ) &&  is_page() &&  ! is_front_page() )
                || ( isset( $logic['general']['single'] ) && is_single() )
                || ( isset( $logic['general']['search'] )  && is_search() )
                || ( isset( $logic['general']['author'] ) && is_author() )
                || ( isset( $logic['general']['category'] ) && is_category())
                || ( isset($logic['general']['tag']) && is_tag() )
                || ( isset($logic['general']['date']) && is_date() )
                || ( isset($logic['general']['year'])  && is_year())
                || ( isset($logic['general']['month']) && is_month())
                || ( isset($logic['general']['day']) && is_day())
                || ( is_singular() && isset( $logic['general'][$query_object->post_type] ) && $query_object->post_type !== 'page' && $query_object->post_type !== 'post' )
                || ( is_tax() && isset( $logic['general'][$query_object->taxonomy] ) )
                || ( is_post_type_archive() && isset( $logic['general'][ $query_object->name . '_archive' ] ) )
            ) {
                return true;
            } else { // let's dig deeper into more specific visibility rules
                if ( ! empty( $logic['tax'] ) ) {
                    if (is_singular()){
                        if ( ! empty( $logic['has_term'] ) ) {
                            foreach ( $logic['has_term'] as $taxonomy_key => $assigned_terms ) {
                                $post_terms = get_the_terms( get_the_ID(), $taxonomy_key );
                                if ( $post_terms !== false && ! is_wp_error( $post_terms ) && is_array( $post_terms ) ) {
                                    $post_terms = wp_list_pluck( $post_terms, 'term_id' );
                                    if ( array_intersect( $assigned_terms, $post_terms ) ) {
                                        return true;
                                    }
                                }
                            }
                        }
                    } else {
                        foreach ( $logic['tax'] as $tax => $terms ) {
                            if ( ( $tax === 'category' && is_category( $terms ) )
                                || ( $tax === 'post_tag' && is_tag( $terms ) )
                                || ( is_tax( $tax, $terms ) )
                            ) {
                                return true;
                            }
                        }
                    }
                }

                if ( ! empty( $logic['post_type'] ) ) {
                    foreach ( $logic['post_type'] as $post_type => $posts ) {
                        if (
                            // Post single
                            ( $post_type === 'post' && is_single( $posts ) )
                            // Page view
                            || ( $post_type === 'page' && (
                                is_page( $posts )
                                || ( ! is_front_page() && is_home() &&  in_array( get_option( 'page_for_posts' ), $posts,true ) ) // check for Posts page
                                || ( class_exists( 'WooCommerce' ) && function_exists( 'is_shop' ) && is_shop() && in_array( wc_get_page_id( 'shop' ), $posts )  ) // check for WC Shop page
                            ) )
                            // Custom Post Types single view check
                            || ( is_singular( $post_type ) && in_array( $query_object_id, $posts,true ) )
                            // for all posts of a post type.
                            || ( is_singular( $post_type ) && get_post_type() === $post_type && in_array( 'E_ALL', $posts ) )
                        ) {
                            return true;
                        }
                    }
                }

                if ( Themify_Conditional_Menus_Utils::is_woocommerce_active() && isset( $logic['wc'] ) ) {
                    foreach( array_keys( $logic['wc'] ) as $endpoint ) {
                        if ( is_wc_endpoint_url( $endpoint ) ) {
                            return true;
                        }
                    }
                }
            }
            return false;
        }

        return true;
    }

    public static function theme_mod_nav_menu_locations( $locations = array() ) {
        if ( ! empty( $locations ) ) {
            $menu_assignments = Themify_Conditional_Menus_Data::get_data();
            foreach ( $locations as $location => $menu_id ) {
                if ( empty( $menu_assignments[$location] ) ) continue;

                $menus = $menu_assignments[$location];

                if ( is_array( $menus ) ) {
                    foreach ( $menus as $id => $new_menu ) {
                        if ( empty( $new_menu['menu'] ) || empty( $new_menu['conditions'] ) ) {
                            continue;
                        }
                        if ( self::check_visibility( $new_menu['conditions'] ) ) {
                            if ( $new_menu[ 'menu' ] == 0 ) {
                                unset( $locations[$location] );
                            } else {
                                $locations[$location] = $new_menu[ 'menu' ];
                            }
                        }
                    }
                }
            }
        }

        return $locations;
    }

    /**
     * Where magic happens.
     * Filters wp_nav_menu_args to dynamically swap parameters sent to it to change what menu displayed.
     *
     * @return array
     */
    public static function wp_nav_menu_args( $args ) {
        $menu_assignments = Themify_Conditional_Menus_Data::get_data();
        if (
            ! isset( $args['menu'] ) // if $args['menu'] is set, bail. Only swap menus in nav menu locations.
            && ! empty( $args['theme_location'] ) && isset( $menu_assignments[ $args['theme_location'] ] )
        ) {
            if ( is_array( $menu_assignments[$args['theme_location']] ) ) {
                foreach ( $menu_assignments[$args['theme_location']] as $id => $new_menu ) {
                    if ( is_array( $new_menu['conditions'] ) && self::check_visibility( $new_menu['conditions'] ) ) {
                        if ( $new_menu[ 'menu' ] == 0 ) {
                            add_filter( 'pre_wp_nav_menu', [ __CLASS__, 'disable_menu' ], 10, 2 );
                            $args['echo'] = false;
                        } else {
                            $args['menu'] = $new_menu[ 'menu' ];
                            /* reset theme_location arg, add filter for 3rd party plugins */
                            $args['theme_location'] = apply_filters( 'conditional_menus_theme_location', '', $new_menu, $args );
                        }
                    }
                }
            }
        }

        return $args;
    }

    public static function disable_menu( $output, $args ) {
        remove_filter( 'pre_wp_nav_menu', [ __CLASS__, 'disable_menu' ], 10, 2 );

        return '';
    }
}