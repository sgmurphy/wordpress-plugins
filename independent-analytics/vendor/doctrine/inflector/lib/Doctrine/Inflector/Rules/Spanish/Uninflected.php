<?php

declare (strict_types=1);
namespace IAWPSCOPED\Doctrine\Inflector\Rules\Spanish;

use IAWPSCOPED\Doctrine\Inflector\Rules\Pattern;
/** @internal */
final class Uninflected
{
    /** @return Pattern[] */
    public static function getSingular() : iterable
    {
        yield from self::getDefault();
    }
    /** @return Pattern[] */
    public static function getPlural() : iterable
    {
        yield from self::getDefault();
    }
    /** @return Pattern[] */
    private static function getDefault() : iterable
    {
        (yield new Pattern('lunes'));
        (yield new Pattern('rompecabezas'));
        (yield new Pattern('crisis'));
    }
}
