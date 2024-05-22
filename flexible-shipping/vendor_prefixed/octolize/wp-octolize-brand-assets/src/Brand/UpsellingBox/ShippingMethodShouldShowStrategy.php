<?php

namespace FSVendor\Octolize\Brand\UpsellingBox;

use FSVendor\WPDesk\ShowDecision\GetStrategy;
class ShippingMethodShouldShowStrategy extends \FSVendor\WPDesk\ShowDecision\GetStrategy
{
    /**
     * @var string
     */
    private $constant;
    public function __construct(string $method_id)
    {
        parent::__construct([['page' => 'wc-settings', 'tab' => 'shipping', 'section' => $method_id]]);
    }
}
