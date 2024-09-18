<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Traits\Singleton_Trait;

/**
 * Product_Feed_Attributes class.
 *
 * @since 13.3.7
 */
class Product_Feed_Attributes extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Product feed default attributes.
     *
     * @since 13.3.7
     * @access public
     *
     * @var array
     */
    public $default_attributes = array(
        'Main attributes'          => array(
            'id'                          => 'Product Id',
            'sku'                         => 'SKU',
            'sku_id'                      => 'SKU_ID (Facebook)',
            'parent_sku'                  => 'SKU parent variable product',
            'sku_item_group_id'           => 'SKU_ITEM_GROUP_ID (Facebook)',
            'wc_post_id_product_id'       => 'Wc_post_id_product_id (Facebook)',
            'title'                       => 'Product name',
            'title_slug'                  => 'Product name slug',
            'title_hyphen'                => 'Product name hyphen',
            'mother_title'                => 'Product name parent product',
            'mother_title_hyphen'         => 'Product name parent product hyphen',
            'title_lc'                    => 'Product name lowercase',
            'title_lcw'                   => 'Product name uppercase first characters',
            'description'                 => 'Product description',
            'short_description'           => 'Product short description',
            'raw_description'             => 'Unfiltered product description',
            'raw_short_description'       => 'Unfiltered product short description',
            'mother_description'          => 'Product description parent product',
            'mother_short_description'    => 'Product short description parent product',
            'link'                        => 'Link',
            'link_no_tracking'            => 'Link without parameters',
            'variable_link'               => 'Product variable link',
            'add_to_cart_link'            => 'Add to cart link',
            'cart_link'                   => 'Cart link',
            'non_local_image'             => 'Non local image',
            'product_type'                => 'Product Type',
            'content_type'                => 'Content Type',
            'exclude_from_catalog'        => 'Excluded from catalog',
            'exclude_from_search'         => 'Excluded from search',
            'exclude_from_all'            => 'Excluded from all (hidden)',
            'total_product_orders'        => 'Total product orders',
            'featured'                    => 'Featured',
            'tax_status'                  => 'Tax status',
            'tax_class'                   => 'Tax class',
            'vat'                         => 'VAT',
            'currency'                    => 'Currency',
            'categories'                  => 'Category',
            'raw_categories'              => 'Category (not used for mapping)',
            'google_category'             => 'Google category (for rules and filters only)',
            'category_link'               => 'Category link',
            'category_path'               => 'Category path',
            'category_path_short'         => 'Category path short',
            'category_path_skroutz'       => 'Category path Skroutz',
            'one_category'                => 'Yoast / Rankmath primary category',
            'nr_variations'               => 'Number of variations',
            'nr_variations_stock'         => 'Number of variations on stock',
            'yoast_gtin8'                 => 'Yoast WooCommerce GTIN8',
            'yoast_gtin12'                => 'Yoast WooCommerce GTIN12',
            'yoast_gtin13'                => 'Yoast WooCommerce GTIN13',
            'yoast_gtin14'                => 'Yoast WooCommerce GTIN14',
            'yoast_isbn'                  => 'Yoast WooCommerce ISBN',
            'yoast_mpn'                   => 'Yoast WooCommerce MPN',
            'condition'                   => 'Condition',
            'purchase_note'               => 'Purchase note',
            'availability'                => 'Availability',
            'availability_date_plus1week' => 'Availability date + 1 week',
            'availability_date_plus2week' => 'Availability date + 2 weeks',
            'availability_date_plus3week' => 'Availability date + 3 weeks',
            'availability_date_plus4week' => 'Availability date + 4 weeks',
            'availability_date_plus5week' => 'Availability date + 5 weeks',
            'region_id'                   => 'Region Id',
            'stock_status'                => 'Stock Status WooCommerce',
            'quantity'                    => 'Quantity [Stock]',
            'virtual'                     => 'Virtual',
            'downloadable'                => 'Downloadable',
            'publication_date'            => 'Feed publication date and time',
            'price'                       => 'Price',
            'regular_price'               => 'Regular price',
            'sale_price'                  => 'Sale price',
            'net_price'                   => 'Price excl. VAT',
            'net_price_rounded'           => 'Price excl. VAT rounded',
            'net_regular_price'           => 'Regular price excl. VAT',
            'net_regular_price_rounded'   => 'Regular price excl. VAT rounded',
            'net_sale_price'              => 'Sale price excl. VAT',
            'net_sale_price_rounded'      => 'Sale price excl. VAT rounded',
            'price_forced'                => 'Price incl. VAT front end',
            'regular_price_forced'        => 'Regular price incl. VAT front end',
            'sale_price_forced'           => 'Sale price incl. VAT front end',
            'sale_price_start_date'       => 'Sale start date',
            'sale_price_end_date'         => 'Sale end date',
            'sale_price_effective_date'   => 'Sale price effective date',
            'rounded_price'               => 'Price rounded',
            'rounded_regular_price'       => 'Regular price rounded',
            'rounded_sale_price'          => 'Sale price rounded',
            'system_price'                => 'System price',
            'system_net_price'            => 'System price excl. VAT',
            'system_net_sale_price'       => 'System sale price excl. VAT',
            'system_net_regular_price'    => 'System regular price excl. VAT',
            'system_regular_price'        => 'System regular price',
            'system_sale_price'           => 'System sale price',
            'vivino_price'                => 'Pinterest / TikTok / Vivino price',
            'vivino_sale_price'           => 'Pinterest / TikTok / Vivino sale price',
            'vivino_regular_price'        => 'Pinterest / TikTok / Vivino regular price',
            'vivino_net_price'            => 'Pinterest / TikTok / Vivino price excl. VAT',
            'vivino_net_regular_price'    => 'Pinterest / TikTok / Vivino regular price excl. VAT',
            'vivino_net_sale_price'       => 'Pinterest / TikTok / Vivino sale price excl. VAT',
            'non_geo_wcml_price'          => 'Non GEO WCML price',
            'mm_min_price'                => 'Mix & Match minimum price',
            'mm_min_regular_price'        => 'Mix & Match minimum regular price',
            'mm_max_price'                => 'Mix & Match maximum price',
            'mm_max_regular_price'        => 'Mix & Match maximum regular price',
            'separator_price'             => 'Separator price',
            'separator_regular_price'     => 'Separator regular price',
            'separator_sale_price'        => 'Separator sale price',
            'discount_percentage'         => 'Discount percentage',
            'item_group_id'               => 'Item group ID',
            'weight'                      => 'Weight',
            'width'                       => 'Width',
            'height'                      => 'Height',
            'length'                      => 'Length',
            'shipping'                    => 'Shipping',
            'shipping_price'              => 'Shipping cost',
            'lowest_shipping_costs'       => 'Lowest shipping costs',
            'shipping_label'              => 'Shipping class slug',
            'shipping_label_name'         => 'Shipping class name',
            'visibility'                  => 'Visibility',
            'rating_total'                => 'Total rating',
            'rating_average'              => 'Average rating',
            'amount_sales'                => 'Amount of sales',
            'product_creation_date'       => 'Product creation date',
            'days_back_created'           => 'Product days back created',
        ),
        'Image attributes'         => array(
            'image'              => 'Main image',
            'image_all'          => 'Main image simple and variations',
            'feature_image'      => 'Featured image',
            'image_1'            => 'Additional image 1',
            'image_2'            => 'Additional image 2',
            'image_3'            => 'Additional image 3',
            'image_4'            => 'Additional image 4',
            'image_5'            => 'Additional image 5',
            'image_6'            => 'Additional image 6',
            'image_7'            => 'Additional image 7',
            'image_8'            => 'Additional image 8',
            'image_9'            => 'Additional image 9',
            'image_10'           => 'Additional image 10',
            'non_local_image'    => 'Non local image',
            'all_images'         => 'All images (comma separated)',
            'all_gallery_images' => 'All gallery images (comma separated)',
            'all_images_kogan'   => 'All images Kogan (pipe separated)',
        ),
        'Google category taxonomy' => array(
            'google_category' => 'Google category',
        ),
        'Other fields'             => array(
            'product_tag'       => 'Product tags',
            'product_tag_space' => 'Product tags space',
            'menu_order'        => 'Menu order',
            'reviews'           => 'Reviews',
            'review_rating'     => 'Review rating',
            'author'            => 'Author',
            'installment'       => 'Installment',
            'product_detail 1'  => 'Product detail 1',
            'product_detail 2'  => 'Product detail 2',
            'product_detail 3'  => 'Product detail 3',
            'product_detail 4'  => 'Product detail 4',
            'product_detail 5'  => 'Product detail 5',
            'product_detail 6'  => 'Product detail 6',
            'product_detail 7'  => 'Product detail 7',
            'product_detail 8'  => 'Product detail 8',
            'product_detail 9'  => 'Product detail 9',
            'product_detail 10' => 'Product detail 10',
            'product_highlight' => 'Product highlight',
            'consumer_notice_1' => 'Consumer notice 1',
            'consumer_notice_2' => 'Consumer notice 2',
            'consumer_notice_3' => 'Consumer notice 3',
            'static_value'      => 'Static value',
        ),
    );

    /**
     * Product feed attributes.
     *
     * @since 13.3.7
     * @access public
     *
     * @var array
     */
    public $attributes = array();

    /**
     * Dynamic attributes.
     *
     * @since 13.3.7
     * @access public
     *
     * @var array
     */
    public $dynamic_attributes = array();

    /**
     * Custom attributes.
     *
     * @since 13.3.7
     * @access public
     *
     * @var array
     */
    public $custom_attributes = array();

    /**
     * Constructor.
     *
     * @since 13.3.7
     * @access public
     */
    public function construct() {
    }

    /**
     * Get the product attributes.
     *
     * @since 13.3.7
     * @access public
     *
     * @return array
     */
    public function get_attributes() {
        $dynamic_attributes = $this->get_dynamic_attributes();
        $custom_attributes  = $this->get_custom_attributes();

        $this->attributes = array_merge(
            $this->default_attributes,
            array( 'Added Custom Attributes' => $custom_attributes ),
            array( 'Dynamic attributes' => $dynamic_attributes )
        );

        /**
         * Filter the product feed attributes.
         *
         * @since 13.3.7
         * @param array $this->attributes The product feed attributes.
         */
        return apply_filters( 'adt_product_feed_attributes', $this->attributes );
    }

    /**
     * Get dynamic attributes.
     *
     * This method is used to get the dynamic attributes of all products.
     *
     * @since 13.3.7
     * @access public
     *
     * @return array
     */
    public function get_dynamic_attributes() {
        $dynamic_attributes = array();
        $exclude_taxonomies = array(
            'portfolio_category',
            'portfolio_skills',
            'portfolio_tags',
            'nav_menu',
            'post_format',
            'slide-page',
            'element_category',
            'template_category',
            'portfolio_category',
            'portfolio_skills',
            'portfolio_tags',
            'faq_category',
            'slide-page',
            'category',
            'post_tag',
            'nav_menu',
            'link_category',
            'post_format',
            'product_type',
            'product_visibility',
            'product_cat',
            'product_shipping_class',
            'product_tag',
        );

        $taxonomies = get_taxonomies( array(), 'objects' );
        $taxonomies = array_diff_key( $taxonomies, array_flip( $exclude_taxonomies ) );

        // Det custom taxonomy values for a product.
        if ( ! empty( $taxonomies ) ) {
            foreach ( $taxonomies as $tax ) {
                $dynamic_attributes[ $tax->name ] = $tax->label;
            }
        }
        return apply_filters( 'adt_product_feed_dynamic_attributes', $dynamic_attributes );
    }

    /**
     * Get custom attributes.
     *
     * This method is used to get the custom attributes of all products.
     * We will store the custom attributes in a transient for 24 hours.
     * The data is used for Field Mapping and Feed Filters Rules.
     *
     * @access public
     * @since 13.3.7
     *
     * @return array
     */
    public function get_custom_attributes() {
        $custom_attributes = get_transient( ADT_TRANSIENT_CUSTOM_ATTRIBUTES );
        if ( $custom_attributes ) {
            return $custom_attributes;
        }

        $custom_attributes             = array();
        $products_meta_key             = $this->get_products_meta_keys_for_custom_attributes();
        $product_variations_attributes = $this->get_product_variations_attributes_for_custom_attributes();
        $temp_custom_attributes        = array_merge( $products_meta_key, $product_variations_attributes );

        /**
         * Loop through the custom attributes and add them to the array.
         * The name for the custom attribute is the meta key with the first letter capitalized.
         * The key for the custom attribute is 'custom_attributes_' . $meta_key.
         */
        if ( ! empty( $temp_custom_attributes ) ) {
            foreach ( $temp_custom_attributes as $attribute ) {
                $key                       = 'custom_attributes_' . $attribute;
                $name                      = ucfirst( trim( str_replace( '_', ' ', $attribute ) ) );
                $custom_attributes[ $key ] = $name;
            }
        }

        set_transient( ADT_TRANSIENT_CUSTOM_ATTRIBUTES, $custom_attributes, 60 * 60 * 24 );

        /**
         * Filter the custom attributes.
         *
         * @since 13.3.7
         * @param array $custom_attributes The custom attributes.
         */
        return apply_filters( 'adt_product_feed_custom_attributes', $custom_attributes );
    }

    /**
     * Get products meta keys for custom attributes.
     *
     * This method is used to get the meta keys of all products.
     * Excluding the '_product_attributes' meta key, which we process separately.
     * The data is used for Field Mapping and Feed Filters Rules.
     *
     * @access protected
     * @since 13.3.7
     *
     * @return array
     */
    protected function get_products_meta_keys_for_custom_attributes() {
        global $wpdb;
        $show_only_basis_attributes = get_option( 'add_woosea_basic', 'no' );
        $limit_clause               = 'yes' === $show_only_basis_attributes ? 'LIMIT 1' : '';

        $query = "SELECT DISTINCT pm.meta_key
            FROM 
                {$wpdb->postmeta} as pm
            JOIN (
                SELECT ID
                FROM {$wpdb->posts}
                WHERE post_type = 'product'
                    AND post_status = 'publish'
                ORDER BY post_date DESC
                $limit_clause
            ) AS p ON pm.post_id = p.ID
            WHERE pm.meta_key NOT IN ('_product_attributes')
        ";

        $custom_attributes = $wpdb->get_col( $query ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        return $custom_attributes ? $custom_attributes : array();
    }

    /**
     * Get product variations attributes for custom attributes.
     *
     * This method is used to get the attributes of all product variations.
     * The reason why we dont get from the taxonomy is because the attributes are not always saved in the taxonomy.
     * The data is used for Field Mapping and Feed Filters Rules.
     *
     * @access protected
     * @since 13.3.7
     *
     * @return array
     */
    protected function get_product_variations_attributes_for_custom_attributes() {
        global $wpdb;
        $product_variations_attributes = array();
        $show_only_basis_attributes    = get_option( 'add_woosea_basic', 'no' );
        $limit_clause                  = 'yes' === $show_only_basis_attributes ? 'LIMIT 1' : '';

        $query = "SELECT DISTINCT pm.meta_value
            FROM 
                {$wpdb->postmeta} as pm
            JOIN (
                SELECT ID
                FROM {$wpdb->posts}
                WHERE post_type = 'product'
                    AND post_status = 'publish'
                ORDER BY post_date DESC
                $limit_clause
            ) AS p ON pm.post_id = p.ID
            WHERE pm.meta_key='_product_attributes'
        ";

        $result = $wpdb->get_col( $query ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

        foreach ( $result as $value ) {
            $product_variations_attributes = array_merge( $product_variations_attributes, array_keys( maybe_unserialize( $value ) ) );
        }

        $product_variations_attributes = array_unique( $product_variations_attributes );

        return $product_variations_attributes ? $product_variations_attributes : array();
    }


    /***************************************************************************
     * Helper functions
     * **************************************************************************
     */

    /**
     * Get the channel countries.
     *
     * @since 13.3.7
     * @access public
     *
     * @return array
     */
    public static function get_channel_countries() {
        $channel_countries = array();
        $channel_configs   = include WOOCOMMERCESEA_PATH . 'includes/I18n/legacy_channel_statics.php';

        foreach ( $channel_configs as $key => $val ) {
            if ( 'All countries' !== $key && 'Custom Feed' !== $key ) {
                array_push( $channel_countries, $key );
            }
        }
        return $channel_countries;
    }

    /**
     * Get the channels.
     *
     * @since 13.3.7
     * @access public
     *
     * @param string $country The country (legacy).
     *
     * @return array
     */
    public static function get_channels( $country = '' ) {
        $channels        = array();
        $channel_configs = include WOOCOMMERCESEA_PATH . 'includes/I18n/legacy_channel_statics.php';

        // Get the generic channels.
        $channels = array_merge( $channels, $channel_configs['Custom Feed'], $channel_configs['All countries'] );

        if ( ! empty( $country ) ) {
            // Get the relevant country channels.
            $channels = isset( $channel_configs[ $country ] ) ? array_merge( $channels, $channel_configs[ $country ] ) : $channels;
        }

        return $channels;
    }

    /***************************************************************************
     * AJAX Actions
     * **************************************************************************
     */

    /**
     * Get the attributes for the product feed.
     *
     * This method is used to get the attributes for the product feed.
     * The attributes are used for Field Mapping and Feed Filters Rules.
     * The data returned is defined by the type parameter.
     *
     * @since 13.3.7
     * @access public
     */
    public function ajax_get_attributes() {
        check_ajax_referer( 'woosea_ajax_nonce', 'security' );

        if ( ! Product_Feed_Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You do not have permission to manage product feed.', 'woo-product-feed-pro' ) );
        }

        $response   = array();
        $attributes = $this->get_attributes();
        if ( empty( $attributes ) ) {
            wp_send_json_error( __( 'No attributes found.', 'woo-product-feed-pro' ) );
        }

        if ( isset( $_POST['channel_hash'] ) ) {
            $channel_hash = sanitize_text_field( $_POST['channel_hash'] );
            $channel_data = Product_Feed_Helper::get_channel_from_legacy_channel_hash( $channel_hash );

            if ( empty( $channel_data ) ) {
                wp_send_json_error( __( 'No channel data found.', 'woo-product-feed-pro' ) );
            }

            // Check if file exists.
            $channel_file_path = WOOCOMMERCESEA_CHANNEL_CLASS_ROOT_PATH . 'class-' . $channel_data['fields'] . '.php';
            if ( ! file_exists( $channel_file_path ) ) {
                wp_send_json_error( __( 'Channel file not found.', 'woo-product-feed-pro' ) );
            }

            // Include the channel file.
            require $channel_file_path;

            $channel_class_name = 'WooSEA_' . $channel_data['fields'];
            $channel_class      = new $channel_class_name();
            $channel_attributes = $channel_class->get_channel_attributes();

            $response = array(
                'field_options'     => $channel_attributes,
                'attribute_options' => $attributes,
            );

            if ( 'html' === $_REQUEST['type'] ) {
                foreach ( $response as $key => $attributes ) {
                    ob_start();
                    include WOOCOMMERCESEA_VIEWS_ROOT_PATH . 'ajax/view-attributes-dropdown.php';
                    $response[ $key ] = ob_get_clean();
                }
            }
        } else {
            $response = $attributes;

            if ( 'html' === $_REQUEST['type'] ) {
                ob_start();
                include WOOCOMMERCESEA_VIEWS_ROOT_PATH . 'ajax/view-attributes-dropdown.php';
                $response = ob_get_clean();
            }
        }

        wp_send_json_success( $response );
    }

    /**
     * Run the class
     *
     * @codeCoverageIgnore
     * @since 13.3.7
     */
    public function run() {
        add_action( 'wp_ajax_woosea_ajax_get_attributes', array( $this, 'ajax_get_attributes' ) );
    }
}
