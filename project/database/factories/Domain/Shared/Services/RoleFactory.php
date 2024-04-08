<?php

namespace Database\Factories\Domain\Shared\Services;

use App\Domain\Role\Enums\RoleGroupEnum;
use App\Domain\Shared\Services\LaravelPermissions\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'guard_name' => 'web',
            'group' => $this->faker->randomElement([
                RoleGroupEnum::ADMIN, RoleGroupEnum::CLIENT,
            ]),
        ];
    }
}
