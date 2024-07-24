<?php
/**
 * @license MIT
 *
 * Modified by impress-org on 24-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Give\Vendors\Faker\Provider\mn_MN;

class PhoneNumber extends \Give\Vendors\Faker\Provider\PhoneNumber
{
    protected static $formats = [
        '9#######',
        '8#######',
        '7#######',
        '3#####',
    ];
}
