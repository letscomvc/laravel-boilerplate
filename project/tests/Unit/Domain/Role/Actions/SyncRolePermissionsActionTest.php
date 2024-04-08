<?php

namespace Tests\Unit\Domain\Role\Actions;

use App\Domain\Role\Actions\SyncRolePermissionsAction;
use App\Domain\Shared\Services\LaravelPermissions\Role;
use Tests\Cases\TestCaseUnit;

class SyncRolePermissionsActionTest extends TestCaseUnit
{
    public function test_should_sync_role_permissions()
    {
        $data = [1, 2, 3];

        $roleMock = $this->createMock(Role::class);
        $roleMock->expects($this->once())
            ->method('syncPermissions')
            ->with($data);

        (new SyncRolePermissionsAction())->execute($data, $roleMock);
    }
}
