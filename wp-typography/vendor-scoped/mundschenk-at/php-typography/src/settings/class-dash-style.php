<?php

/**
 *  This file is part of PHP-Typography.
 *
 *  Copyright 2017-2022 Peter Putzer.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 *  ***
 *
 *  @package mundschenk-at/php-typography
 *  @license http://www.gnu.org/licenses/gpl-2.0.html
 */
namespace WP_Typography\Vendor\PHP_Typography\Settings;

use WP_Typography\Vendor\PHP_Typography\Settings;
use WP_Typography\Vendor\PHP_Typography\U;
/**
 * A factory class for different dash styles.
 *
 * @author Peter Putzer <github@mundschenk.at>
 *
 * @since 5.0.0
 */
abstract class Dash_Style
{
    /**
     * Traditional US dash style (using em dashes).
     */
    const TRADITIONAL_US = 'traditionalUS';
    /**
     * "International" dash style (using en dashes).
     */
    const INTERNATIONAL = 'international';
    /**
     * "International" dash style (using en dashes), Duden-style (without hair spaces).
     */
    const INTERNATIONAL_NO_HAIR_SPACES = 'internationalNoHairSpaces';
    /**
     * Available dash styles.
     *
     * @var array<string,string[]>
     */
    private static $styles = [self::TRADITIONAL_US => [self::PARENTHETICAL => U::EM_DASH, self::PARENTHETICAL_SPACE => U::THIN_SPACE, self::INTERVAL => U::EN_DASH, self::INTERVAL_SPACE => U::THIN_SPACE], self::INTERNATIONAL => [self::PARENTHETICAL => U::EN_DASH, self::PARENTHETICAL_SPACE => ' ', self::INTERVAL => U::EN_DASH, self::INTERVAL_SPACE => U::HAIR_SPACE], self::INTERNATIONAL_NO_HAIR_SPACES => [self::PARENTHETICAL => U::EN_DASH, self::PARENTHETICAL_SPACE => ' ', self::INTERVAL => U::EN_DASH, self::INTERVAL_SPACE => '']];
    /**
     * Interval dash.
     *
     * @internal
     *
     * @var int
     */
    private const INTERVAL = 0;
    /**
     * Interval dash space.
     *
     * @internal
     *
     * @var int
     */
    private const INTERVAL_SPACE = 1;
    /**
     * Parenthetical dash.
     *
     * @internal
     *
     * @var int
     */
    private const PARENTHETICAL = 2;
    /**
     * Parenthetical dash space.
     *
     * @internal
     *
     * @var int
     */
    private const PARENTHETICAL_SPACE = 3;
    /**
     * Creates a new Dashes object in the given style.
     *
     * @since 6.5.0 The $settings parameter has been deprecated.
     *
     * @param string   $style    The dash style.
     * @param Settings $settings The current settings.
     *
     * @return Dashes|null Returns null in case of an invalid $style parameter.
     */
    public static function get_styled_dashes($style, Settings $settings)
    {
        if (isset(self::$styles[$style])) {
            return new Simple_Dashes(self::$styles[$style][self::PARENTHETICAL], self::$styles[$style][self::PARENTHETICAL_SPACE], self::$styles[$style][self::INTERVAL], self::$styles[$style][self::INTERVAL_SPACE]);
        }
        return null;
    }
}
/**
 * A factory class for different dash styles.
 *
 * @author Peter Putzer <github@mundschenk.at>
 *
 * @since 5.0.0
 */
\class_alias('WP_Typography\\Vendor\\PHP_Typography\\Settings\\Dash_Style', 'PHP_Typography\\Settings\\Dash_Style', \false);
