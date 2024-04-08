<?php

namespace Tests\Feature\Auth;

use App\Domain\User\Models\User;
use App\Http\Api\Controllers\Auth\LoginController;
use Tests\Cases\TestCaseFeature;

class LoginTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->create(['password' => bcrypt('password')]);

        $this->useActionsFromController(LoginController::class);
    }

    public function test_login_should_success_when_right_credentials()
    {
        $this->postJson($this->controllerAction(), [
            'email' => $this->user->email,
            'password' => 'password',
        ])
            ->assertSuccessful();

        $this->assertAuthenticatedAs($this->user);
    }

    public function test_login_should_fail_when_wrong_credentials()
    {
        $this->post($this->controllerAction(), [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ])
            ->assertStatus(401)
            ->assertJson(['error' => 'Não autorizado.']);
    }
}
