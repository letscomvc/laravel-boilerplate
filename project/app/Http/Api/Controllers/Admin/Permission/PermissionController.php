<?php

namespace App\Http\Api\Controllers\Admin\Permission;

use App\Domain\Shared\Services\LaravelPermissions\Permission;
use App\Support\PermissionsHelper;
use Database\Seeders\data\PermissionsAndRoles;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PermissionController
{
    use AuthorizesRequests;

    public function __invoke(Request $request)
    {
        $this->authorize('viewAny', Permission::class);

        $group = $request->query('group');

        $permissionList = match ($group) {
            'admin' => PermissionsAndRoles::getAdminPermissions(),
            'client' => PermissionsAndRoles::getClientPermissions(),
            default => throw new \InvalidArgumentException("Invalid role type: $group", 400),
        };

        $flattenPermissions = PermissionsHelper::getFlattenPermissions($permissionList);

        $permissions = app(Permission::class)
            ->whereIn('name', $flattenPermissions)
            ->select('id', 'name')
            ->get()
            ->toArray();

        $formattedPermissions = PermissionsHelper::getPermissionsByGroup($permissions);

        return response()->json($formattedPermissions);
    }
}
