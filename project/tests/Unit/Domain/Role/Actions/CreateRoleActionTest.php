<?php

namespace Tests\Unit\Domain\Role\Actions;

use App\Domain\Role\Actions\CreateRoleAction;
use App\Domain\Role\Actions\RoleData;
use App\Domain\Role\Actions\SyncRolePermissionsAction;
use App\Domain\Shared\Services\LaravelPermissions\Role;
use Tests\Cases\TestCaseUnit;

class CreateRoleActionTest extends TestCaseUnit
{
    public function test_should_create_role()
    {
        $data = RoleData::from([
            'name' => 'Role Name',
        ]);

        $this->mock(Role::class)
            ->expects('create')
            ->andReturns(new Role());

        (new CreateRoleAction())->execute($data);
    }

    public function test_should_create_role_with_permissions()
    {
        $data = RoleData::from([
            'name' => 'Role Name',
            'permission_ids' => [1, 2, 3],
        ]);

        $this->mock(Role::class)
            ->expects('create')
            ->andReturns(new Role());

        $this->mock(SyncRolePermissionsAction::class)
            ->expects('execute')
            ->with([1, 2, 3], \Mockery::type(Role::class));

        (new CreateRoleAction())->execute($data);
    }
}
