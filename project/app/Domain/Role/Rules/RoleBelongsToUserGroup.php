<?php

namespace App\Domain\Role\Rules;

use App\Domain\Shared\Services\LaravelPermissions\Role;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RoleBelongsToUserGroup implements ValidationRule
{
    /**
     * @var bool
     */
    private $strict = false;

    protected $userGroup;

    /**
     * @var string|null
     */
    private $failMessage;

    /**
     * Create a new rule instance.
     *
     * @param  string  $enumClass
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($userGroup = null)
    {
        $this->userGroup = $userGroup;
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
        $role = Role::where('name', $value)->first();

        if (! $role || $role->group !== $this->userGroup) {
            $fail($this->failMessage ?? 'The '.$attribute.' must be from the same group as the user.');
        }
    }
}
