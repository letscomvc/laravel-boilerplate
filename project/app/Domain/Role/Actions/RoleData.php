<?php

namespace App\Domain\Role\Actions;

use App\Domain\Role\Enums\RoleGroupEnum;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class RoleData extends Data
{
    public function __construct(
        #[Required, StringType, Min(3), Max(255)]
        public string $name,

        #[Nullable, StringType, In([RoleGroupEnum::ADMIN, RoleGroupEnum::CLIENT])]
        public ?string $group,

        #[Nullable, ArrayType]
        public ?array $permission_ids,

        #[Nullable, StringType]
        public ?string $guard_name = 'web',
    ) {
    }
}
