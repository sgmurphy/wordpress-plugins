<?php

class Themify_Conditional_Menus_Utils {

    public static function is_woocommerce_active():bool {
        static $is = null;
        if ( $is === null ) {
            $plugin = 'woocommerce/woocommerce.php';
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            return is_plugin_active( $plugin )
                // validate if $plugin actually exists, the plugin might be active however not installed.
                && is_file(trailingslashit(WP_PLUGIN_DIR) . $plugin);
        }

        return $is;
    }

    public static function is_default_language() : bool {
        static $is = null;
        if ( $is === null ) {
            $is = Themify_Conditional_Menus_Utils::get_current_language() === Themify_Conditional_Menus_Utils::get_default_language();
        }

        return $is;
    }

    public static function get_current_language() : string {
        static $lang = null;
        if ( $lang === null ) {
            if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
                $lang = ICL_LANGUAGE_CODE;
            } elseif ( function_exists( 'qtrans_getLanguage' ) ) {
                $lang = qtrans_getLanguage();
            }
            if ( ! $lang ) {
                $lang = substr( get_locale(), 0, 2 );
            }
            $lang = strtolower( trim( $lang ) );
        }

        return $lang;
    }

    public static function get_default_language() : string {
        static $lang = null;
        if ( $lang === null ) {
            global $sitepress;
            if ( isset( $sitepress ) ) {
                $lang = $sitepress->get_default_language();
            }
            $lang = empty( $lang ) ? substr( get_locale(), 0, 2 ) : $lang;
            $lang = strtolower( trim( $lang ) );
        }

        return $lang;
    }

    public static function maybe_translate_object( $id, $type ) {
        if ( ! empty( $id ) ) {
            if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
                $id = apply_filters( 'wpml_object_id', $id, $type, true );
            } elseif ( defined( 'POLYLANG_VERSION' ) && function_exists( 'pll_get_post' ) ) {
                $translatedpageid = pll_get_post( $id );
                if ( ! empty( $translatedpageid ) && 'publish' === get_post_status( $translatedpageid ) ) {
                    $id = $translatedpageid;
                }
            }
        }

        return $id;
    }
}