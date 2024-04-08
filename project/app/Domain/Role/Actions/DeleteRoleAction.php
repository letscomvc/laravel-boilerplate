<?php

namespace App\Domain\Role\Actions;

use App\Domain\Role\Exceptions\RoleHasUsersException;
use App\Domain\Shared\Services\LaravelPermissions\Role;

class DeleteRoleAction
{
    public function execute(Role $role): bool
    {
        if ($role->users()->count() > 0) {
            throw new RoleHasUsersException();
        }

        if ((bool) $role->permissions()->count()) {
            $role->permissions()->detach();
        }

        return $role->delete();
    }
}
