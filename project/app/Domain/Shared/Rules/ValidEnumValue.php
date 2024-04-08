<?php

namespace App\Domain\Shared\Rules;

use App\Support\Enum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use InvalidArgumentException;

class ValidEnumValue implements ValidationRule
{
    /**
     * @var string
     */
    private $enumClass;

    /**
     * @var bool
     */
    private $strict = false;

    /**
     * @var string|null
     */
    private $failMessage;

    /**
     * Create a new rule instance.
     *
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $enumClass)
    {
        if (! is_subclass_of($enumClass, Enum::class)) {
            $message = 'Enum class ['.$enumClass.'] must be an instance of '.Enum::class;
            throw new InvalidArgumentException($message);
        }

        $this->enumClass = $enumClass;
    }

    /**
     * Set strict type validation
     *
     * @return $this
     */
    public function strict(): self
    {
        $this->strict = true;

        return $this;
    }

    public function withFailMessage(string $message): self
    {
        $this->failMessage = $message;

        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $enumClass = $this->enumClass;
        if (! $enumClass::isValidValue($value, $this->strict)) {
            $fail($this->failMessage ?? 'The '.$attribute.' must be a valid value.');
        }
    }
}
