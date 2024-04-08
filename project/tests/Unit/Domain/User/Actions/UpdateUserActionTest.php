<?php

namespace Tests\Unit\Domain\User\Actions;

use App\Domain\Role\Enums\RoleGroupEnum;
use App\Domain\User\Actions\UpdateUserAction;
use App\Domain\User\Actions\UserData;
use App\Domain\User\Models\User;
use Tests\Cases\TestCaseUnit;

class UpdateUserActionTest extends TestCaseUnit
{
    public function test_should_update_user()
    {
        $user = $this->createPartialMock(User::class, ['update']);
        $user->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $data = UserData::from([
            'name' => 'User Test',
            'email' => 'test@gmail.com',
            'group' => RoleGroupEnum::CLIENT,
            'password' => '123456',
        ]);

        (new UpdateUserAction())->execute($user, $data);
    }

    public function test_should_update_user_without_password()
    {
        $user = $this->createPartialMock(User::class, ['update']);
        $user->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $data = UserData::from([
            'name' => 'User Test',
            'email' => 'test@gmail.com',
            'group' => RoleGroupEnum::CLIENT,
        ]);

        (new UpdateUserAction())->execute($user, $data);
    }

    public function test_should_update_user_passing_different_role()
    {
        $data = UserData::from([
            'name' => 'User Test',
            'email' => 'test@hotmail.com',
            'password' => '123456',
            'group' => RoleGroupEnum::CLIENT,
            'roles' => ['client'],
        ]);

        $userMock = $this->createMock(User::class);
        $userMock->expects($this->once())
            ->method('syncRoles')
            ->with(['client']);

        $userMock->expects($this->once())
            ->method('update')
            ->willReturn(true);

        (new UpdateUserAction())->execute($userMock, $data);
    }
}
