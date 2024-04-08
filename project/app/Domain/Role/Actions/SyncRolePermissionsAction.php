<?php

namespace App\Domain\Role\Actions;

use App\Domain\Shared\Services\LaravelPermissions\Role;

class SyncRolePermissionsAction
{
    public function execute(array $permissionIds, Role $role): void
    {
        $role->syncPermissions($permissionIds);
    }
}
