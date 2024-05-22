<?php

namespace FSVendor\Octolize\Brand\UpsellingBox;

use FSVendor\WPDesk\ShowDecision\ShouldShowStrategy;
class ShippingMethodAndConstantDisplayStrategy implements \FSVendor\WPDesk\ShowDecision\ShouldShowStrategy
{
    /**
     * @var string
     */
    private $method_id;
    /**
     * @var string
     */
    private $constant;
    public function __construct(string $method_id, string $constant)
    {
        $this->constant = $constant;
        $this->method_id = $method_id;
    }
    public function shouldDisplay() : bool
    {
        return (new \FSVendor\Octolize\Brand\UpsellingBox\ConstantShouldShowStrategy($this->constant))->shouldDisplay() && (new \FSVendor\Octolize\Brand\UpsellingBox\ShippingMethodShouldShowStrategy($this->method_id))->shouldDisplay();
    }
}
