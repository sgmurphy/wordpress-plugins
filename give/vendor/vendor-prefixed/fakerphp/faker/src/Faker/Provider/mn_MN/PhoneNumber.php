<?php
/**
 * @license MIT
 *
 * Modified by impress-org on 06-March-2024 using Strauss.
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
