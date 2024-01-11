<?php

class Themify_Conditional_Menus_Admin {

    public static function init() {
        load_plugin_textdomain( 'themify-cm', false, '/languages' );

        if ( wp_doing_ajax() ) {
            add_action( 'wp_ajax_themify_cm_get_conditions', [ __CLASS__, 'ajax_get_conditions' ] );
            add_action( 'wp_ajax_themify_cm_create_inner_page', [ __CLASS__, 'ajax_create_inner_page' ] );
            add_action( 'wp_ajax_themify_cm_parse_conditions', [ __CLASS__, 'ajax_parse_conditions' ] );
        } else {
            add_filter( 'plugin_row_meta', [ __CLASS__, 'themify_plugin_meta' ], 10, 2 );
            add_filter( 'plugin_action_links_conditional-menus/init.php', [ __CLASS__, 'action_links' ] );
            add_action( 'load-nav-menus.php', [ __CLASS__, 'admin_setup' ] );
            add_action( 'admin_menu', [ __CLASS__, 'add_plugin_page' ] );
            add_action( 'wp_delete_nav_menu', [ __CLASS__, 'wp_delete_nav_menu' ] );
        }
    }

    public static function admin_setup() {
        if ( isset( $_GET['action'] ) && 'locations' === $_GET['action'] ) {
            self::save_options();
            if ( ! Themify_Conditional_Menus_Utils::is_default_language() ) {
                add_action( 'after_menu_locations_table', [ __CLASS__, 'after_menu_locations_table' ] );
                return;
            }

            add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin_enqueue' ] );
        }
    }

    static function after_menu_locations_table() {
        echo '<div class="notice notice-warning"><p>', __( 'Note that Themify Conditional Menus are only available in default language. For other languages, they are automatically translated.', 'themify-cm' ), '</p></div>';
    }

    public static function save_options() {
        if ( isset( $_POST['menu-locations'] ) ) {
            $themify_cm = isset( $_POST['themify_cm'] ) ? $_POST['themify_cm'] : array();
            set_theme_mod( 'themify_conditional_menus', $themify_cm );
        }

        if ( isset( $_POST['menu-locations'] ) ) {
            self::clear_cache();
        }
    }

    public static function clear_cache() {
        $theme = get_option( 'stylesheet' );
        $mods = get_option( "theme_mods_{$theme}", [] );
        foreach ( $mods as $key => $value ) {
            if ( str_contains( $key, 'tf_conditions_menu_' ) ) {
                unset( $mods[ $key ] );
            }
        }
        update_option( "theme_mods_{$theme}", $mods );
    }

    public static function ajax_get_conditions() {
        check_ajax_referer( 'themify_cm_nonce', 'nonce' );
        if ( current_user_can( 'edit_theme_options' ) ) {
            include Themify_Conditional_Menus::get_dir() . 'templates/conditions.php';
        }
        die;
    }

    public static function admin_enqueue() {
        global $_wp_registered_nav_menus;
        $version=Themify_Conditional_Menus::get_version();
        $url = Themify_Conditional_Menus::get_url();
        $style = $url . 'assets/admin.css';
        $script = $url . 'assets/admin.js';
        if ( function_exists( 'themify_enque' ) ) {
            $style = themify_enque( $style );
            $script = themify_enque( $script );
        }
        wp_enqueue_style( 'themify-conditional-menus', $style, null, $version );
        wp_enqueue_script( 'themify-conditional-menus', $script, [ 'jquery', 'jquery-ui-tabs' ], $version, true );
        wp_localize_script( 'themify-conditional-menus', 'themify_cm', array(
            'nonce' => wp_create_nonce( 'themify_cm_nonce' ),
            'nav_menus' => array_keys( $_wp_registered_nav_menus ),
            'options' => Themify_Conditional_Menus_Data::get_raw(),
            'lang' => array(
                'conditions' => __( '+ Edit Conditions', 'themify-cm' ),
                'add_assignment' => __( '+ New Conditional Menu', 'themify-cm' ),
                'disable_menu' => __( 'Disable Menu', 'themify-cm' ),
            ),
        ) );
    }

    /**
     * Render pagination for specific page.
     *
     * @param Integer $current_page The current page that needs to be rendered.
     * @param Integer $num_of_pages The number of all pages.
     *
     * @return String The HTML with pagination.
     */
    public static function create_page_pagination( $current_page, $num_of_pages ) {
        $links_in_the_middle = 4;
        $links_in_the_middle_min_1 = $links_in_the_middle - 1;
        $first_link_in_the_middle   = $current_page - floor( $links_in_the_middle_min_1 / 2 );
        $last_link_in_the_middle    = $current_page + ceil( $links_in_the_middle_min_1 / 2 );
        if ( $first_link_in_the_middle <= 0 ) {
            $first_link_in_the_middle = 1;
        }
        if ( ( $last_link_in_the_middle - $first_link_in_the_middle ) != $links_in_the_middle_min_1 ) {
            $last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_min_1;
        }
        if ( $last_link_in_the_middle > $num_of_pages ) {
            $first_link_in_the_middle = $num_of_pages - $links_in_the_middle_min_1;
            $last_link_in_the_middle  = (int) $num_of_pages;
        }
        if ( $first_link_in_the_middle <= 0 ) {
            $first_link_in_the_middle = 1;
        }
        $pagination = '';
        if ( $current_page != 1 ) {
            $pagination .= '<a href="' . ( $current_page - 1 ) . '" class="prev page-numbers ti-angle-left"/>';
        }
        if ( $first_link_in_the_middle >= 3 && $links_in_the_middle < $num_of_pages ) {
            $pagination .= '<a href="1" class="page-numbers">1</a>';

            if ( $first_link_in_the_middle != 2 ) {
                $pagination .= '<span class="page-numbers extend">...</span>';
            }
        }
        for ( $i = $first_link_in_the_middle; $i <= $last_link_in_the_middle; $i ++ ) {
            if ( $i == $current_page ) {
                $pagination .= '<span class="page-numbers current">' . $i . '</span>';
            } else {
                $pagination .= '<a href="' . $i . '" class="page-numbers">' . $i . '</a>';
            }
        }
        if ( $last_link_in_the_middle < $num_of_pages ) {
            if ( $last_link_in_the_middle != ( $num_of_pages - 1 ) ) {
                $pagination .= '<span class="page-numbers extend">...</span>';
            }
            $pagination .= '<a href="' . $num_of_pages . '" class="page-numbers">' . $num_of_pages . '</a>';
        }
        if ( $current_page != $last_link_in_the_middle ) {
            $pagination .= '<a href="' . ( $current_page + $i ) . '" class="next page-numbers ti-angle-right"></a>';
        }

        return $pagination;
    }

    public static function ajax_create_inner_page() {
        check_ajax_referer( 'themify_cm_nonce', 'nonce' );
        if ( ! current_user_can( 'edit_theme_options' ) || empty( $_POST['type'] ) ) {
            die;
        }
        $type = explode( ':', $_POST['type'] );
        $paged = isset( $_POST['paged'] ) ? (int) $_POST['paged'] : 1;
        echo self::create_inner_page( $type[0], $type[1], $paged );
        die;
    }

    public static function ajax_parse_conditions() {
        check_ajax_referer( 'themify_cm_nonce', 'nonce' );
        if ( current_user_can( 'edit_theme_options' ) && ! empty( $_POST['selected'] ) ) {
            parse_str( $_POST['selected'], $selected );
            echo self::parse_conditions( $selected );
        }
        die;
    }

    private static function parse_conditions( $selected ) {
        $output = '';
        foreach ( $selected as $key => $value ) {
            switch ( $key ) {
                case 'general' :
                    if ( isset( $value['home'] ) ) {
                        $output .= '<li data-id="general[home]">' . __( 'Home Page', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['blog'] ) ) {
                        $output .= '<li data-id="general[blog]">' . __( 'Blog Page', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['page'] ) ) {
                        $output .= '<li data-id="general[page]">' . __( 'Page views', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['single'] ) ) {
                        $output .= '<li data-id="general[single]">' . __( 'Single post views', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['search'] ) ) {
                        $output .= '<li data-id="general[search]">' . __( 'Search pages', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['category'] ) ) {
                        $output .= '<li data-id="general[category]">' . __( 'Category archive', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['tag'] ) ) {
                        $output .= '<li data-id="general[tag]">' . __( 'Tag archive', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['author'] ) ) {
                        $output .= '<li data-id="general[author]">' . __( 'Author pages', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['date'] ) ) {
                        $output .= '<li data-id="general[date]">' . __( 'Date archive pages', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['year'] ) ) {
                        $output .= '<li data-id="general[year]">' . __( 'Year based archive', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['month'] ) ) {
                        $output .= '<li data-id="general[month]">' . __( 'Month based archive', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['day'] ) ) {
                        $output .= '<li data-id="general[day]">' . __( 'Day based archive', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['logged'] ) ) {
                        $output .= '<li data-id="general[logged]">' . __( 'logged', 'themify-cm' ) . '</li>';
                    }
                    if ( isset( $value['404'] ) ) {
                        $output .= '<li data-id="general[404]">' . __( '404 page', 'themify-cm' ) . '</li>';
                    }
                    foreach ( get_post_types( array( 'public' => true, 'exclude_from_search' => false, '_builtin' => false ), 'objects' ) as $post_type_key => $post_type_object ) {
                        if ( isset( $value[ $post_type_key ] ) ) {
                            $output .= '<li data-id="general[' . $post_type_key . ']">' . sprintf( __( 'Single %s View', 'themify-cm' ), $post_type_object->labels->singular_name ) . '</li>';
                        }
                        if ( isset( $value[ $post_type_key . '_archive' ] ) ) {
                            $output .= '<li data-id="general[' . $post_type . '_archive]">' . sprintf( __( '%s Archive View', 'themify-cm' ), $post_type_object->labels->singular_name ) . '</li>';
                        }
                    }
                    foreach ( get_taxonomies( array( 'public' => true, '_builtin' => false ), 'objects' ) as $taxonomy_key => $tax ) {
                        if ( isset( $value[ $taxonomy_key ] ) ) {
                            $output .= '<li data-id="general[' . $taxonomy_key . ']">' . sprintf( __( '%s Archive View', 'themify-cm' ), $tax->labels->singular_name ) . '</li>';
                        }
                    }
                    break;

                case 'post_type' :
                    foreach ( $value as $post_type_key => $post_slugs ) {
                        $post_type_object = get_post_type_object( $post_type_key );
                        if ( ! $post_type_object ) {
                            continue;
                        }
                        foreach ( array_keys( $post_slugs ) as $post_path ) {
                            $post = get_page_by_path( $post_path, OBJECT, $post_type_key );
                            if ( $post ) {
                                $url = get_permalink( $post->ID );
                                $output .= '<li data-id="post_type[' . $post_type_key . '][' . $post_path . ']"><span data-cm_tooltip="' . esc_attr( $post_type_object->labels->singular_name ) . '">' . $post->post_title . '</span></li>';
                            }
                        }
                    }
                    break;

                case 'tax' :
                    /* "in-category" options */
                    if ( isset( $value['category_single'] ) ) {
                        foreach ( $value['category_single'] as $taxonomy_key => $term_slugs ) {
                            if ( ! taxonomy_exists( $taxonomy_key ) ) {
                                continue;
                            }
                            foreach ( array_keys( $term_slugs ) as $term_slug ) {
                                $term = get_term_by( 'slug', $term_slug, $taxonomy_key );
                                if ( $term ) {
                                    $output .= "<li data-id='tax[category_single][{$taxonomy_key}][{$term_slug}]'><span data-cm_tooltip='" . esc_attr( sprintf( __( 'Posts with %s term', 'themify-cm' ), $term->name ) ) . "'>{$term->name}</span></li>";
                                }
                            }
                        }
                        unset( $value['category_single'] );
                    }

                    foreach ( $value as $taxonomy_key => $term_slugs ) {
                        $taxonomy_object = get_taxonomy( $taxonomy_key );
                        if ( ! $taxonomy_object ) {
                            continue;
                        }
                        foreach ( array_keys( $term_slugs ) as $term_slug ) {
                            $term = get_term_by( 'slug', $term_slug, $taxonomy_key );
                            if ( $term ) {
                                $url = get_term_link( $term->term_id, $taxonomy_key );
                                $output .= "<li data-id='tax[{$taxonomy_key}][{$term_slug}]'><span data-cm_tooltip='" . esc_attr( sprintf( __( '%s Term Archive', 'themify-cm' ), $taxonomy_object->labels->singular_name ) ) . "'>{$term->name}</span></li>";
                            }
                        }
                    }
                    break;

                case 'wc' :
                    if ( isset( $value['orders'] ) ) {
                        $output .= '<li data-id="wc[orders]"><span>' . __( 'WooCommerce > Orders', 'themify-cm' ) . '</span></li>';
                    }
                    if ( isset( $value['view-order'] ) ) {
                        $output .= '<li data-id="wc[view-order]"><span>' . __( 'WooCommerce > View Order', 'themify-cm' ) . '</span></li>';
                    }
                    if ( isset( $value['downloads'] ) ) {
                        $output .= '<li data-id="wc[downloads]"><span>' . __( 'WooCommerce > Downloads', 'themify-cm' ) . '</span></li>';
                    }
                    if ( isset( $value['edit-account'] ) ) {
                        $output .= '<li data-id="wc[edit-account]"><span>' . __( 'WooCommerce > Edit Account', 'themify-cm' ) . '</span></li>';
                    }
                    if ( isset( $value['edit-address'] ) ) {
                        $output .= '<li data-id="wc[edit-address]"><span>' . __( 'WooCommerce > Addresses', 'themify-cm' ) . '</span></li>';
                    }
                    if ( isset( $value['lost-password'] ) ) {
                        $output .= '<li data-id="wc[lost-password]"><span>' . __( 'WooCommerce > Lost Password', 'themify-cm' ) . '</span></li>';
                    }
                    if ( isset( $value['order-pay'] ) ) {
                        $output .= '<li data-id="wc[order-pay]"><span>' . __( 'WooCommerce > Pay', 'themify-cm' ) . '</span></li>';
                    }
                    if ( isset( $value['order-received'] ) ) {
                        $output .= '<li data-id="wc[order-received]"><span>' . __( 'WooCommerce > Order received', 'themify-cm' ) . '</span></li>';
                    }
                    if ( isset( $value['payment-methods'] ) ) {
                        $output .= '<li data-id="wc[order-pay]"><span>' . __( 'WooCommerce > Payment methods', 'themify-cm' ) . '</span></li>';
                    }
                    break;

                case 'roles' :
                    foreach ( $GLOBALS['wp_roles']->roles as $key => $role ) {
                        if ( isset( $value[ $key ] ) ) {
                            $output .= '<li data-id="roles[' . $key . ']"><span data-cm_tooltip="' . esc_attr__( 'User Roles', 'themify-cm' ) . '">' . $role['name'] . '</span></li>';
                        }
                    }
                    break;
            }
        }

        return '<ul class="themify_cm_conditions">' . $output . '</ul>';
    }

    /**
     * Renders pages, posts types and categories items based on current page.
     *
     * @param string $type The type of items to render.
     *
     * @return string The HTML to render items as HTML and original values.
     */
    public static function create_inner_page( $item_type, $type, $paged = 1 ) : string {
        $posts_per_page = 26;
        $output = '';
        if ( 'post_type' === $item_type ) {
            $query = new WP_Query( array( 'post_type' => $type, 'posts_per_page' => $posts_per_page, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title', 'paged' => $paged ) );
            if ( $query->have_posts() ) {
                $num_of_single_pages = $query->found_posts;
                $num_of_pages        = (int) ceil( $num_of_single_pages / $posts_per_page );
                $output .= '<div class="themify-visibility-items-page themify-visibility-items-page-' . $paged . '">';
                foreach ( $query->posts as $post ) :
                    $post->post_name = self::child_post_name($post);
                    if ( $post->post_parent > 0 ) {
                        $post->post_name = '/' . $post->post_name . '/';
                    }
                    /* note: slugs are more reliable than IDs, they stay unique after export/import */
                    $output .= '<label><input type="checkbox" name="' . esc_attr( 'post_type[' . $type . '][' . $post->post_name . ']' ) . '" /><span data-tooltip="'.get_permalink($post->ID).'">' . esc_html( $post->post_title ) . '</span></label>';
                endforeach;

                if ( $num_of_pages > 1 ) {
                    $output .= '<div class="themify-visibility-pagination">';
                    $output .= self::create_page_pagination( $paged, $num_of_pages );
                    $output .= '</div>';
                }
                $output .= '</div><!-- .themify-visibility-items-page -->';
            }
        } else if ( 'tax' === $item_type || 'in_tax' === $item_type ) {
            $total = wp_count_terms( [ 'taxonomy' => $type, 'hide_empty' => false ] );
            if ( ! is_wp_error( $total ) && ! empty( $total ) ) {
                $prefix = 'tax' === $item_type ? "tax[{$type}]" : "tax[category_single][{$type}]";
                $terms = get_terms( array( 'taxonomy' => $type, 'hide_empty' => false, 'number' => $posts_per_page, 'offset' => ( $paged - 1 ) * $posts_per_page ) );
                $num_of_pages = (int) ceil( $total / $posts_per_page );
                $output .= '<div class="themify-visibility-items-page themify-visibility-items-page-' . $paged . '">';
                foreach ( $terms as $term ) :
                    $data = ' data-slug="'.$term->slug.'"';
                    if ( $term->parent != '0' ) {
                        $parent  = get_term( $term->parent, $type );
                        $data .= ' data-parent="'.$parent->slug.'"';
                    }
                    $output  .= '<label><input'.$data.' type="checkbox" name="' . $prefix . '[' . $term->slug . ']" /><span data-tooltip="'.get_term_link($term).'">' . $term->name . '</span></label>';
                endforeach;
                if ( $num_of_pages > 1 ) {
                    $output .= '<div class="themify-visibility-pagination">';
                    $output .= self::create_page_pagination( $paged, $num_of_pages );
                    $output .= '</div>';
                }
                $output .= '</div><!-- .themify-visibility-items-page -->';
            }
        }

        return $output;
    }

    private static function child_post_name($post) {
        $str = $post->post_name;

        if ( $post->post_parent > 0 ) {
            $parent = get_post($post->post_parent);
            if ( $parent ) {
                $parent->post_name = self::child_post_name($parent);
                $str = $parent->post_name . '/' . $str;
            }
        }

        return $str;
    }

    public static function add_plugin_page() {
        add_management_page(
            __( 'Themify Conditional Menus', 'themify-cm' ),
            __( 'Conditional Menus', 'themify-cm' ),
            'manage_options',
            'conditional-menus',
            [ __CLASS__, 'create_admin_page' ],
            99
        );
    }

    public function create_admin_page() {
        include( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'docs/index.html' );
    }

    /**
     * Remove menu assignments when the menu gets deleted
     *
     * @since 1.0.7
     */
    public static function wp_delete_nav_menu( $menu_id ) {
        $options = get_theme_mod( 'themify_conditional_menus', array() );
        if ( ! empty( $options ) ) {
            foreach ( $options as $location => $assignments ) {
                if ( is_array( $assignments ) && ! empty( $assignments ) ) {
                    foreach ( $assignments as $key => $menu ) {
                        if ( $menu['menu'] == $menu_id ) {
                            unset( $options[$location][$key] );
                        }
                    }
                }
            }
        }
        set_theme_mod( 'themify_conditional_menus', $options );
    }
    
    public static function themify_plugin_meta( $links, $file ) {
        if ( 'conditional-menus/init.php' === $file ) {
            $row_meta = array(
              'changelogs'    => '<a href="' . esc_url( 'https://themify.org/changelogs/' ) . basename( dirname( $file ) ) .'.txt" target="_blank" aria-label="' . esc_attr__( 'Plugin Changelogs', 'themify-cm' ) . '">' . esc_html__( 'View Changelogs', 'themify-cm' ) . '</a>'
            );
     
            return array_merge( $links, $row_meta );
        }
        return (array) $links;
    }

    public static function action_links( $links ) {
        if ( is_plugin_active( 'themify-updater/themify-updater.php' ) ) {
            $tlinks = array(
             '<a href="' . admin_url( 'index.php?page=themify-license' ) . '">'.__('Themify License', 'themify-cm') .'</a>',
             );
        } else {
            $tlinks = array(
             '<a href="' . esc_url('https://themify.me/docs/themify-updater-documentation') . '">'. __('Themify Updater', 'themify-cm') .'</a>',
             );
        }
        return array_merge( $links, $tlinks );
    }
}