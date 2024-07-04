<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Helpers
 */

namespace AdTribes\PFP\Helpers;

/**
 * Helper methods class.
 *
 * @since 13.3.3
 */
class Helper {

    /**
     * Get plugin data.
     *
     * @since 13.3.3
     * @access public
     *
     * @param string|null $key       The plugin data key.
     * @param bool        $markup    If the returned data should have HTML markup applied. Default false.
     * @param bool        $translate If the returned data should be translated. Default false.
     * @return string[]|string
     */
    public static function get_plugin_data( $key = null, $markup = false, $translate = false ) {

        $plugin_data = get_plugin_data( WOOCOMMERCESEA_FILE, $markup, $translate );

        if ( null !== $key ) {
            return $plugin_data[ $key ] ?? '';
        }

        return $plugin_data;
    }

    /**
     * Get the current plugin version.
     *
     * @since 13.3.3
     * @access public
     *
     * @param bool $markup        Optional. If the returned data should have HTML markup applied.
     *                            Default true.
     * @param bool $translate     Optional. If the returned data should be translated. Default true.
     * @return string
     */
    public static function get_plugin_version( $markup = true, $translate = true ) {

        return self::get_plugin_data( 'Version', $markup, $translate );
    }

    /**
     * Loads admin template.
     *
     * @since 13.3.3
     * @access public
     *
     * @param string $name Template name relative to `templates` directory.
     * @param bool   $load Whether to load the template or not.
     * @param bool   $once Whether to use require_once or require.
     * @return string
     */
    public static function load_template( $name, $load = false, $once = true ) {

        //phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
        $template = WOOCOMMERCESEA_PATH . 'templates/' . rtrim( $name, '.php' ) . '.php';
        if ( ! file_exists( $template ) ) {
            return '';
        }

        if ( $load ) {
            if ( $once ) {
                require_once $template;
            } else {
                require $template;
            }
        }

        //phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
        return $template;
    }

    /**
     * Checks required plugins if they are active.
     *
     * @since 13.3.3
     * @access public
     *
     * @return array List of plugins that are not active.
     */
    public static function missing_required_plugins() {

        $i       = 0;
        $plugins = array();

        $required_plugins = array(
            'woocommerce/woocommerce.php',
        );

        foreach ( $required_plugins as $plugin ) {
            if ( ! is_plugin_active( $plugin ) ) {
                $plugin_name                  = explode( '/', $plugin );
                $plugins[ $i ]['plugin-key']  = $plugin_name[0];
                $plugins[ $i ]['plugin-base'] = $plugin;
                $plugins[ $i ]['plugin-name'] = str_replace(
                    'Woocommerce',
                    'WooCommerce',
                    ucwords( str_replace( '-', ' ', $plugin_name[0] ) )
                );
            }

            ++$i;
        }

        return $plugins;
    }

    /**
     * Utility function that determines if a plugin is active or not.
     *
     * @since 13.3.4
     * @access public
     *
     * @param string $plugin_basename Plugin base name. Ex. woocommerce/woocommerce.php.
     * @return boolean True if active, false otherwise.
     */
    public static function is_plugin_active( $plugin_basename ) {
        // Makes sure the plugin is defined before trying to use it.
        if ( ! function_exists( 'is_plugin_active' ) ) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        return is_plugin_active( $plugin_basename );
    }

    /**
     * Utility function that determines if a plugin is installed or not.
     *
     * @since 13.3.4
     * @access public
     *
     * @param string $plugin_basename Plugin base name. Ex. woocommerce/woocommerce.php.
     * @return boolean True if active, false otherwise.
     */
    public static function is_plugin_installed( $plugin_basename ) {
        $plugin_file_path = trailingslashit( WP_PLUGIN_DIR ) . plugin_basename( $plugin_basename );
        return file_exists( $plugin_file_path );
    }

    /**
     * Utility function that determines if the current page is a Product Feed Pro page or not.
     *
     * @since 13.3.4
     * @access public
     *
     * @return boolean True if pfp page, false otherwise.
     */
    public static function is_pfp_page() {
        $screen      = get_current_screen();
        $is_pfp_page = strpos( $screen->id, 'product-feed-pro' ) !== false;
        return apply_filters( 'pfp_is_pfp_page', $is_pfp_page );
    }

    /**
     * Utility function that determines if the lite notice bar should be shown or not.
     *
     * @since 13.3.4
     * @access public
     *
     * @return boolean True if lite notice bar should be shown, false otherwise.
     */
    public static function is_show_notice_bar_lite() {
        $show = false;
        if ( self::is_pfp_page() ) {
            $show = true;
        }
        return apply_filters( 'pfp_show_notice_bar_lite', $show );
    }

    /**
     * Check if a submenu is registered.
     *
     * @since 13.3.4
     * @access public
     *
     * @param string $menu_slug    The menu slug.
     * @param string $submenu_slug The submenu slug.
     * @return boolean
     */
    public static function is_submenu_registered( $menu_slug, $submenu_slug ) {
        global $submenu;

        if ( ! isset( $submenu[ $menu_slug ] ) ) {
            return false;
        }

        foreach ( $submenu[ $menu_slug ] as $submenu_item ) {
            if ( $submenu_slug === $submenu_item[2] ) {
                return true;
            }
        }

        return false;
    }
}
