<?php
namespace UiCoreElements;

use Elementor\Plugin;

defined('ABSPATH') || exit();
/**
 * UiCore Utils Functions
 */
class Helper
{

    public static function get_separator()
    {
        return '<span class="uicore-meta-separator"></span>';
    }

    public static function get_taxonomies($custom = true)
    {
        $taxonomies = get_taxonomies(['public' => true], 'objects');
        $exclusions = ['nav_menu', 'link_category', 'post_format']; // Exclude these taxonomies from the list

        $taxonomies = array_filter($taxonomies, function ($taxonomy) use ($exclusions) {
            return !in_array($taxonomy->name, $exclusions);
        });

        $taxonomies = array_map(function ($taxonomy) {
            if('portfolio_category' === $taxonomy->name){
                return 'Portfolio Category';
            }
            return $taxonomy->label;
        }, $taxonomies);

        if ($custom) {
            $taxonomies = array_merge(['custom' => __('Custom Meta', 'uicore-elements')], $taxonomies);
        }

        return $taxonomies;
    }

    static function get_taxonomy($name)
    {
        global $post;

        $categories = get_the_terms( $post->ID, $name );
        if ( ! $categories || is_wp_error( $categories ) ) {
            return false;
        }

        $categories = array_values( $categories );
        foreach ($categories as $t) {
            $term_name[] =
                '<a href="' . get_term_link($t) . '" title="View ' . \esc_attr($t->name) . ' posts">' . esc_html($t->name) . '</a>';
        }
        $category = implode(', ', $term_name);

        return $category;
    }

    static function get_reading_time()
    {
        global $post;
        // get the content
        $the_content = $post->post_content;
        // count the number of words
        $words = str_word_count( wp_strip_all_tags( $the_content ) );
        // rounding off and deviding per 200 words per minute
        $minute = floor( $words / 200 );

        // calculate the amount of time needed to read
        return $minute;
    }

    static function get_site_domain() {
		return str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
	}

    /**
     * Returns the Uicore Elements settings page URL. You may pass a message so it'll be wrapped under a <a> tag.
     *
     * @param string $message Optional. A clickable message to be displayed that'll redirect, in a new tab, to settings page.
     * @return string Uicore Elements settings page URL or an <a> tag HTML with the url and the passed message.
     */
    static function get_admin_settings_url(string $message = '') {
        $url = admin_url( 'options-general.php?page=uicore-elements' );
        return !empty($message) ? '<a href="'.esc_url($url).'" target="_blank">' . esc_html($message) . '</a>' : $url;
    }

    static function register_widget_style($name,$deps=[],$external=false)
    {
        $handle = (!$external ? 'ui-e-' : '' ). $name;
        wp_register_style($handle, UICORE_ELEMENTS_ASSETS . '/css/elements/'.$name.'.css',$deps,UICORE_ELEMENTS_VERSION);
        return $handle;
    }
    static function register_widget_script($name,$deps=[],$external=false)
    {
        $handle = (!$external ? 'ui-e-' : '' ). $name;
        //if name contains / then we need to set a custom path
        if(strpos($name,'/') !== false){
            $path ='';
        }else{
            $path = 'elements/';
        }
        wp_register_script($handle, UICORE_ELEMENTS_ASSETS . '/js/'.$path.$name.'.js',$deps,UICORE_ELEMENTS_VERSION,true);
        return $handle;
    }


    public static function get_related($filter, $number)
    {
        global $post;

        $args = [];

        if ($filter == 'category') {
            $categories = get_the_category($post->ID);

            if ($categories) {
                $category_ids = [];
                foreach ($categories as $individual_category) {
                    $category_ids[] = $individual_category->term_id;
                }

                $args = [
                    'category__in' => $category_ids,
                    'post__not_in' => [$post->ID],
                    'posts_per_page' => $number,
                    'ignore_sticky_posts' => 1,
                ];
            }
        } elseif ($filter == 'tag') {
            $tags = wp_get_post_tags($post->ID);

            if ($tags) {
                $tag_ids = [];
                foreach ($tags as $individual_tag) {
                    $tag_ids[] = $individual_tag->term_id;
                }
                $args = [
                    'tag__in' => $tag_ids,
                    'post__not_in' => [$post->ID],
                    'posts_per_page' => $number,
                    'ignore_sticky_posts' => 1,
                ];
            }
        } else {
            $args = [
                'post__not_in' => [$post->ID],
                'posts_per_page' => $number,
                'orderby' => 'rand',
            ];
        }

        $related_query = new \wp_query($args);

        if ($related_query->have_posts()) {
            return $related_query;
        } else {
            return false;
        }
    }


    /*
    * Get the current post id (used in Theme Builder - UiCore Framework)
    */
    static function get_current_meta_id()
    {
        if(\class_exists('\UiCore\Blog\Frontend') && \UiCore\Blog\Frontend::is_blog() && !is_singular('post')){
            $post_id = get_option('page_for_posts', true);
        }elseif(\class_exists('\UiCore\Portfolio\Frontend') && \UiCore\Portfolio\Frontend::is_portfolio() && !is_singular('portfolio')){
            $post_id = \UiCore\Portfolio\Frontend::get_portfolio_page_id();
        }else{
            $post_id = get_queried_object_id();
        }

        return $post_id;
    }

    /**
     * Return a list of textual html tags for Elementor Controls Options
     */

     public static function get_title_tags($type = null) {

        $tags = [
            'h1'   => 'H1',
            'h2'   => 'H2',
            'h3'   => 'H3',
            'h4'   => 'H4',
            'h5'   => 'H5',
            'h6'   => 'H6',
            'div'  => 'div',
            'span' => 'span',
            'p'    => 'p',
        ];

        return $tags;
    }


    /**
     * Formats a date meta value according to the specified format.
     *
     * @param mixed  $date    The date value to format.
     * @param string $format  The format to use for formatting the date. Can be 'custom' or a predefined format.
     * @param string $custom  The custom format to use if $format is set to 'custom'.
     *
     * @return string  The formatted date value.
     */
    public static function format_date($date, $format, $custom) {

        if ( 'custom' === $format ) {
            $date_format = $custom;
        } else if ('default' === $format ) {
            $date_format = get_option('date_format');
        } else {
            $date_format = $format;
        }

        $value = date_i18n($date_format, $date);

        return wp_kses_post($value);
    }

    /**
     * Sanitizes SVG content, also allowing `post` tags and atts.
     *
     * @param string $svg The raw SVG content to be sanitized.
     * @return string The sanitized SVG content, with only allowed tags and attributes.
     *
     * @since 1.0.2
     */
    public static function esc_svg($svg) {
        $default = wp_kses_allowed_html( 'post' );

        $args = array(
            'svg'   => array(
                'class' => true,
                'aria-hidden' => true,
                'aria-labelledby' => true,
                'role' => true,
                'xmlns' => true,
                'width' => true,
                'height' => true,
                // has to be lowercase
                'viewbox' => true,
                'preserveaspectratio' => true
            ),
            'g'     => array( 'fill' => true ),
            'title' => array( 'title' => true ),
            'path'  => array(
                'd'               => true,
                'fill'            => true
            )
        );
        $allowed_tags = array_merge( $default, $args );

        return wp_kses( $svg, $allowed_tags );
    }

    /**
     * Sanitizes text strings, but allowing some html tags usefull for styling and manipulating texts.
     *
     * @param string $content The content to be sanitized
     * @return string The sanitized string content.
     *
     * @since 1.0.3
     */
    public static function esc_string($content) {

        $allowed_tags = [
            'strong' => array(),
            'em' => array(),
            'b' => array(),
            'i' => array(),
            'u' => array(),
            's' => array(),
            'sub' => array(),
            'sup' => array(),
            'span' => array(),
            'br' => array()
        ];

        return wp_kses( $content, $allowed_tags );
    }

    /**
     * Retrieves the available image sizes.
     *
     * @return array An array of image sizes.
     *
     * @since 1.0.0
     */
    public static function get_images_sizes() {
        $sizes = [];
        foreach (get_intermediate_image_sizes() as $size) {
            $sizes[$size] = $size;
        }
        return $sizes;
    }

    /**
     * @since 1.0.5
     */
    private static function get_element_recursive($elements, $form_id) {

        foreach ($elements as $element) {
            if ($form_id === $element['id']) {
                return $element;
            }

            if (!empty($element['elements'])) {
                $element = self::get_element_recursive($element['elements'], $form_id);

                if ($element) {
                    return $element;
                }
            }
        }

        return false;
    }

    /**
     * Retrieves the settings of a specific widget without relying on transient data.
     *
     * @param int $post_id The ID of the post or page.
     * @param int $widget_id The ID of the widget.
     * @return array|string The settings of the widget, or an error message if the request is invalid.
     *
     * @since 1.0.5
     */
    public static function get_widget_settings($post_id, $widget_id) {

        if (!$post_id || !$widget_id) {
            return false;
        }

        $elementor = Plugin::$instance;
        $pageMeta  = $elementor->documents->get($post_id);

        if (!$pageMeta) {
            return false;
        }
        $metaData = $pageMeta->get_elements_data();
        if (!$metaData) {
            return false;
        }

        $widget_data = self::get_element_recursive($metaData, $widget_id);
        $settings    = [];

        if (is_array($widget_data)) {
            $widget   = $elementor->elements_manager->create_element_instance($widget_data);
            $settings = $widget->get_settings();
        }

        return $settings;
    }

}
