<?php

namespace App\Domain\User\Actions;

use App\Domain\Role\Enums\RoleGroupEnum;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UserData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string|Optional $name,

        #[Nullable, StringType, In([RoleGroupEnum::ADMIN, RoleGroupEnum::CLIENT])]
        public ?string $group,

        #[Required, StringType, Email]
        public string|Optional $email,

        #[Required, StringType]
        public string|Optional $password,

        #[Nullable, ArrayType]
        public array|Optional $roles,
    ) {
    }
}
