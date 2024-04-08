<?php

namespace Tests\Unit\Domain\User\Actions;

use App\Domain\User\Actions\DeleteUserAction;
use App\Domain\User\Models\User;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class DeleteUserActionTest extends TestCaseUnit
{
    public function test_should_delete_user()
    {
        $user = $this->partialMock(User::class, function (MockInterface $mock) {
            $mock->expects('delete')
                ->andReturns(true);
        });

        (new DeleteUserAction())->execute($user);
    }
}
