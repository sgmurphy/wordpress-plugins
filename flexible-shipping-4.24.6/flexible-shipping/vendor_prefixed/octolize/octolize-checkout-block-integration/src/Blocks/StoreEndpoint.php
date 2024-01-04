<?php

namespace FSVendor\Octolize\Blocks;

use Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema;
use Automattic\WooCommerce\StoreApi\Schemas\V1\CheckoutSchema;
use FSVendor\WPDesk\PluginBuilder\Plugin\Hookable;
/**
 * Shipping Workshop Extend Store API.
 */
class StoreEndpoint implements \FSVendor\WPDesk\PluginBuilder\Plugin\Hookable
{
    protected static string $integration_name;
    protected static string $field_name;
    public function __construct(string $integration_name, string $field_name = 'field')
    {
        self::$integration_name = $integration_name;
        self::$field_name = $field_name;
    }
    public function hooks() : void
    {
        \add_action('woocommerce_blocks_loaded', function () {
            if (\function_exists('woocommerce_store_api_register_endpoint_data')) {
                \woocommerce_store_api_register_endpoint_data(['endpoint' => \Automattic\WooCommerce\StoreApi\Schemas\V1\CheckoutSchema::IDENTIFIER, 'namespace' => self::$integration_name, 'data_callback' => [self::class, 'data_callback'], 'schema_callback' => [self::class, 'schema_callback'], 'schema_type' => ARRAY_A]);
                \woocommerce_store_api_register_endpoint_data(['endpoint' => \Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema::IDENTIFIER, 'namespace' => self::$integration_name, 'data_callback' => [self::class, 'data_callback'], 'schema_callback' => [self::class, 'schema_callback'], 'schema_type' => ARRAY_A]);
            }
        });
    }
    public static function data_callback() : array
    {
        return \apply_filters('octolize-checkout-block-integration-' . self::$integration_name . '-data', [self::$field_name => '']);
    }
    public static function schema_callback() : array
    {
        return \apply_filters('octolize-checkout-block-integration-' . self::$integration_name . '-schema', [self::$field_name => ['description' => \__('Field', 'flexible-shipping'), 'type' => ['string'], 'context' => ['view', 'edit'], 'readonly' => \false, 'optional' => \false, 'arg_options' => ['validate_callback' => function ($value) {
            return \true;
        }]]]);
    }
}
