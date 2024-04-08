<?php

namespace Tests\Feature\Admin\Role;

use App\Domain\Role\Enums\RoleGroupEnum;
use App\Domain\Shared\Services\LaravelPermissions\Permission;
use App\Domain\Shared\Services\LaravelPermissions\Role;
use App\Http\Api\Controllers\Admin\Role\RoleController;
use Tests\Cases\TestCaseFeature;

class SyncRolePermissionTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsAdmin();
        $this->useActionsFromController(RoleController::class);
    }

    private function getPermissionsList(): array
    {
        return Permission::where('name', 'LIKE', 'user%')
            ->pluck('id')
            ->toArray();
    }

    public function test_should_sync_permissions_to_role_when_data_is_valid()
    {
        $permissionIds = $this->getPermissionsList();

        $data = [
            'name' => 'Perfil',
            'group' => RoleGroupEnum::ADMIN,
            'permission_ids' => $permissionIds,
        ];

        $response = $this->postJson($this->controllerAction('store'), $data)
            ->assertCreated();

        $responseData = $response->json();
        $roleId = $responseData['id'];

        $role = Role::find($roleId);

        $this->assertTrue($role->hasAllPermissions($permissionIds));
    }

    public function test_should_not_sync_permissions_to_role_when_data_is_invalid()
    {
        $data = [
            'name' => 'Perfil',
            'group' => RoleGroupEnum::CLIENT,
            'permission_ids' => [5000],
        ];

        $this->postJson($this->controllerAction('store'), $data)
            ->assertJsonValidationErrors([
                'permission_ids.0',
            ]);
    }
}
