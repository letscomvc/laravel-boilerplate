<?php

namespace App\Http\Api\Controllers\Admin\Role;

use App\Domain\Role\Actions\CreateRoleAction;
use App\Domain\Role\Actions\DeleteRoleAction;
use App\Domain\Role\Actions\RoleData;
use App\Domain\Role\Actions\UpdateRoleAction;
use App\Domain\Shared\Services\LaravelPermissions\Role;
use App\Http\Api\Requests\Admin\RoleRequest;
use App\Http\Api\Resources\Admin\RoleResource;
use App\Http\Shared\Controllers\ResourceController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class RoleController extends ResourceController
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Role::class);

        $group = $request->query('group');
        $name = $request->query('name');

        $roles = Role::query();

        $roles = $roles->when($group, function ($query, $group) {
            return $query->where('group', $group);
        });

        $roles = $roles->when($name, function ($query, $name) {
            return $query->where('name', 'LIKE', "%$name%");
        });

        return pagination($roles)
            ->defaultSort('-created_at')
            ->resource(RoleResource::class);
    }

    public function show(Role $role)
    {
        $this->authorize('view', $role);

        $role->load('permissions');

        return response()->json(RoleResource::make($role));
    }

    public function store(RoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $data = RoleData::validateAndCreate($request->validated());

        $role = app(CreateRoleAction::class)
            ->execute($data);

        return response()->json(RoleResource::make($role), 201);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        $data = RoleData::validateAndCreate($request->validated());

        $role = app(UpdateRoleAction::class)
            ->execute($data, $role);

        return response()->json(RoleResource::make($role));
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        app(DeleteRoleAction::class)
            ->execute($role);

        return response()->noContent();
    }
}
