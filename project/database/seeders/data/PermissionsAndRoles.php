<?php

namespace Database\Seeders\data;

use App\Domain\Role\Enums\RoleGroupEnum;
use Illuminate\Support\Collection;

class PermissionsAndRoles
{
    private static function getPermissionsValues()
    {
        return fn ($key) => static::getPermissions()
            ->get($key)
            ->values();
    }

    public static function getRoles(): array
    {
        return [
            'admin' => [
                'group' => RoleGroupEnum::ADMIN,
                'permissions' => self::getAdminPermissions(),
            ],

            'client' => [
                'group' => RoleGroupEnum::CLIENT,
                'permissions' => self::getClientPermissions(),
            ],
        ];
    }

    public static function getPermissions(): Collection
    {
        return collect([
            'users' => static::crud(),
            'roles' => static::crud(),
            'permissions' => collect([
                'view any',
            ]),
        ]);
    }

    private static function crud(array $except = []): Collection
    {
        return collect(['view', 'view any', 'create', 'update', 'delete'])
            ->except($except);
    }

    public static function getClientPermissions(): array
    {
        $permissions = static::getPermissionsValues();

        return [];
    }

    public static function getAdminPermissions(): array
    {
        $permissions = static::getPermissionsValues();

        return [
            'users' => $permissions('users'),
            'roles' => $permissions('roles'),
            'permissions' => $permissions('permissions'),
        ];
    }
}
