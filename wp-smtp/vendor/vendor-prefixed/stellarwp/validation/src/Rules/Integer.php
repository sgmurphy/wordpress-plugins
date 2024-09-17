<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace SolidWP\Mail\StellarWP\Validation\Rules;

use Closure;
use SolidWP\Mail\StellarWP\Validation\Contracts\Sanitizer;
use SolidWP\Mail\StellarWP\Validation\Contracts\ValidatesOnFrontEnd;
use SolidWP\Mail\StellarWP\Validation\Contracts\ValidationRule;

class Integer implements ValidationRule, ValidatesOnFrontEnd, Sanitizer
{
    /**
     * @inheritDoc
     */
    public static function id(): string
    {
        return 'integer';
    }

    /**
     * @inheritDoc
     */
    public static function fromString(string $options = null): ValidationRule
    {
        return new self();
    }

    /**
     * @inheritDoc
     */
    public function sanitize($value)
    {
        return (int)$value;
    }

    /**
     * @inheritDoc
     */
    public function serializeOption()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function __invoke($value, Closure $fail, string $key, array $values)
    {
        if (is_bool($value) || false === filter_var($value, FILTER_VALIDATE_INT)) {
            $fail(sprintf(__('%s must be an integer', '%TEXTDOMAIN%'), '{field}'));
        }
    }
}
