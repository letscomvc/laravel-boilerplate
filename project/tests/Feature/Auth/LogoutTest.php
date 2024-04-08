<?php

namespace Tests\Feature\Auth;

use App\Domain\User\Models\User;
use App\Http\Api\Controllers\Auth\LogoutController;
use Tests\Cases\TestCaseFeature;

class LogoutTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->create(['password' => bcrypt('password')]);

        $this->useActionsFromController(LogoutController::class);
    }

    public function test_should_logout_when_user_authenticated()
    {
        $this->actingAs($this->user)
            ->postJson($this->controllerAction())
            ->assertSuccessful();
    }

    public function test_should_not_logout_when_user_not_authenticated()
    {
        $this->postJson($this->controllerAction())
            ->assertUnauthorized();
    }
}
