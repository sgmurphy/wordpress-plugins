<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace SolidWP\Mail\StellarWP\Validation\Rules;

use Closure;
use SolidWP\Mail\StellarWP\Validation\Config;
use SolidWP\Mail\StellarWP\Validation\Contracts\ValidatesOnFrontEnd;
use SolidWP\Mail\StellarWP\Validation\Contracts\ValidationRule;
use SolidWP\Mail\StellarWP\Validation\Exceptions\ValidationException;

/**
 * @since 1.0.0
 */
class Max implements ValidationRule, ValidatesOnFrontEnd
{
    /**
     * @var int
     */
    private $size;

    /**
     * @since 1.0.0
     */
    public function __construct(int $size)
    {
        if ($size <= 0) {
            Config::throwInvalidArgumentException('Max validation rule requires a non-negative value');
        }

        $this->size = $size;
    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public static function id(): string
    {
        return 'max';
    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public static function fromString(string $options = null): ValidationRule
    {
        if (!is_numeric($options)) {
            Config::throwInvalidArgumentException('Max validation rule requires a numeric value');
        }

        return new self((int)$options);
    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @throws ValidationException
     */
    public function __invoke($value, Closure $fail, string $key, array $values)
    {
        if (is_int($value) || is_float($value)) {
            if ($value > $this->size) {
                $fail(sprintf(__('%s must be less than or equal to %d', '%TEXTDOMAIN%'), '{field}', $this->size));
            }
        } elseif (is_string($value)) {
            if (mb_strlen($value) > $this->size) {
                $fail(sprintf(__('%s must be less than or equal to %d characters', '%TEXTDOMAIN%'), '{field}', $this->size));
            }
        } else {
            Config::throwValidationException("Field value must be a number or string");
        }
    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function serializeOption(): int
    {
        return $this->size;
    }

    /**
     * @since 1.0.0
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function size(int $size)
    {
        if ($size <= 0) {
            Config::throwInvalidArgumentException('Max validation rule requires a non-negative value');
        }

        $this->size = $size;
    }
}
