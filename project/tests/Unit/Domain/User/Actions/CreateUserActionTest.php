<?php

namespace Tests\Unit\Domain\User\Actions;

use App\Domain\Role\Enums\RoleGroupEnum;
use App\Domain\User\Actions\CreateUserAction;
use App\Domain\User\Actions\UserData;
use App\Domain\User\Models\User;
use Tests\Cases\TestCaseUnit;

class CreateUserActionTest extends TestCaseUnit
{
    public function test_should_create_user()
    {
        $data = UserData::from([
            'email' => 'test@hotmail.com',
            'password' => '123456',
            'group' => RoleGroupEnum::CLIENT,
            'roles' => ['client'],
        ]);

        $userMock = $this->createMock(User::class);
        $userMock->expects($this->once())
            ->method('assignRole')
            ->with(['client']);

        $this->mock(User::class, function ($mock) use ($userMock) {
            $mock->shouldReceive('create')->andReturn($userMock);
        });

        (new CreateUserAction())->execute($data);
    }
}
