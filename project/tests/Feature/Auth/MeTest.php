<?php

namespace Tests\Feature\Auth;

use App\Http\Api\Controllers\Auth\MeController;
use Tests\Cases\TestCaseFeature;

class MeTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->login();

        $this->useActionsFromController(MeController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'name', 'email', 'created_at', 'updated_at',
        ];
    }

    public function test_should_show_me()
    {
        $this->getJson($this->controllerAction())
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }
}
