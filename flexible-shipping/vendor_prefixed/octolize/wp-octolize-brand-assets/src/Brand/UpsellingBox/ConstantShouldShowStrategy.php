<?php

namespace FSVendor\Octolize\Brand\UpsellingBox;

use FSVendor\WPDesk\ShowDecision\ShouldShowStrategy;
class ConstantShouldShowStrategy implements \FSVendor\WPDesk\ShowDecision\ShouldShowStrategy
{
    /**
     * @var string
     */
    private $constant;
    public function __construct(string $constant)
    {
        $this->constant = $constant;
    }
    public function shouldDisplay() : bool
    {
        return !\defined($this->constant);
    }
}
