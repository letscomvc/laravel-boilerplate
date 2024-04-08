<?php

namespace Tests\Unit\Domain\Role\Actions;

use App\Domain\Role\Actions\RoleData;
use App\Domain\Role\Actions\SyncRolePermissionsAction;
use App\Domain\Role\Actions\UpdateRoleAction;
use App\Domain\Shared\Services\LaravelPermissions\Role;
use Tests\Cases\TestCaseUnit;

class UpdateRoleActionTest extends TestCaseUnit
{
    public function test_should_create_role()
    {
        $data = RoleData::from([
            'name' => 'Role Name',
        ]);

        $roleMock = $this->createPartialMock(Role::class, ['update']);
        $roleMock->expects($this->once())
            ->method('update')
            ->willReturn(true);

        (new UpdateRoleAction())->execute($data, $roleMock);
    }

    public function test_should_create_role_with_permissions()
    {
        $data = RoleData::from([
            'name' => 'Role Name',
            'permission_ids' => [1, 2, 3],
        ]);

        $roleMock = $this->createPartialMock(Role::class, ['update']);
        $roleMock->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $this->mock(SyncRolePermissionsAction::class)
            ->expects('execute')
            ->with([1, 2, 3], \Mockery::type(Role::class));

        (new UpdateRoleAction())->execute($data, $roleMock);
    }
}
