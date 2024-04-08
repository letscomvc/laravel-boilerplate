<?php

namespace Tests\Feature\Admin\User;

use App\Domain\Role\Enums\RoleGroupEnum;
use App\Domain\User\Models\User;
use App\Http\Api\Controllers\Admin\User\UserController;
use Tests\Cases\TestCaseFeature;

class UserTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsAdmin();
        $this->useActionsFromController(UserController::class);
    }

    private function getUserResourceStructure(): array
    {
        return [
            'id',
            'name',
            'email',
            'group',
            'created_at',
            'updated_at',
        ];
    }

    public function test_should_return_users()
    {
        User::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getUserResourceStructure()],
            ]);
    }

    public function test_should_return_one_user()
    {
        $user = User::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $user->id))
            ->assertOk()
            ->assertJsonStructure($this->getUserResourceStructure());
    }

    public function test_should_create_user_when_valid_data_atual()
    {
        $response = $this->postJson($this->controllerAction('store'), [
            'name' => 'User Test',
            'email' => 'teste@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'group' => RoleGroupEnum::ADMIN,
            'roles' => ['admin'],
        ])
            ->assertCreated()
            ->assertJsonStructure(
                $this->getUserResourceStructure()
            );

        $id = $response->offsetGet('id');

        $user = User::find($id);
        $this->assertSame('User Test', $user->name);
        $this->assertSame('teste@gmail.com', $user->email);
        $this->assertSame(RoleGroupEnum::ADMIN, $user->group);
        $this->assertTrue($user->hasRole('admin'));
    }

    public function test_should_not_create_user_with_invalid_password_confirmation()
    {
        $this->postJson($this->controllerAction('store'), [
            'name' => 'User Test',
            'email' => 'teste@gmail.com',
            'password' => '123456',
            'password_confirmation' => '121212',
        ])
            ->assertJsonValidationErrors(['password']);
    }

    public function test_should_update_user_when_valid_data()
    {
        $user = User::factory()
            ->client()
            ->create();

        $this->putJson($this->controllerAction('update', $user->id), [
            'name' => 'User Test',
            'email' => 'teste@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'group' => RoleGroupEnum::CLIENT,
            'roles' => ['client'],
        ])
            ->assertOk()
            ->assertJsonStructure(
                $this->getUserResourceStructure()
            );

        $user->refresh();
        $this->assertSame('User Test', $user->name);
        $this->assertSame('teste@gmail.com', $user->email);
        $this->assertSame(RoleGroupEnum::CLIENT, $user->group);
        $this->assertTrue($user->hasRole('client'));
    }

    public function test_should_update_user_without_passing_password_as_an_argument()
    {
        $user = User::factory()
            ->create();

        $this->putJson($this->controllerAction('update', $user->id), [
            'name' => 'User Test',
            'email' => 'teste@gmail.com',
            'group' => RoleGroupEnum::CLIENT,
            'roles' => ['client'],
        ])
            ->assertOk()
            ->assertJsonStructure(
                $this->getUserResourceStructure()
            );

        $user->refresh();
        $this->assertSame('User Test', $user->name);
        $this->assertSame('teste@gmail.com', $user->email);
        $this->assertNotNull($user->password);
    }

    public function test_should_delete_user_when_valid_data()
    {
        $user = User::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $user->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_should_not_create_user_using_same_email_when_is_not_deleted()
    {
        $user = User::factory()
            ->create();

        $this->postJson($this->controllerAction('store'), [
            'name' => 'User Test',
            'email' => $user->email,
            'password' => '123456',
            'password_confirmation' => '123456',
            'group' => RoleGroupEnum::CLIENT,
            'roles' => ['client'],
        ])
            ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseMissing('users', [
            'name' => 'User Test',
            'email' => $user->email,
        ]);
    }
}
