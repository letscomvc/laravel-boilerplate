<?php

namespace Tests\Feature\Admin\Role;

use App\Domain\Role\Enums\RoleGroupEnum;
use App\Domain\Shared\Services\LaravelPermissions\Role;
use App\Http\Api\Controllers\Admin\Role\RoleController;
use Tests\Cases\TestCaseFeature;

class RoleTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsAdmin();
        $this->useActionsFromController(RoleController::class);
    }

    private function getRoleResourceStructure(): array
    {
        return [
            'id', 'name', 'group', 'created_at', 'updated_at',
        ];
    }

    public function test_should_list_roles()
    {
        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonStructure([
                'data' => ['*' => $this->getRoleResourceStructure()],
            ])
            ->assertJsonCount(Role::all()->count(), 'data');
    }

    public function test_should_list_one_role()
    {
        $role = Role::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $role->id))
            ->assertOk()
            ->assertJsonStructure($this->getRoleResourceStructure());
    }

    public function test_should_create_admin_role_when_data_is_valid()
    {
        $data = [
            'name' => 'Perfil',
            'group' => RoleGroupEnum::ADMIN,
        ];

        $this->postJson($this->controllerAction('store'), $data)
            ->assertCreated()
            ->assertJsonStructure($this->getRoleResourceStructure());

        $this->assertDatabaseHas('roles', [
            'name' => $data['name'],
            'guard_name' => 'web',
            'group' => $data['group'],
        ]);
    }

    public function test_should_create_client_role_when_data_is_valid()
    {
        $data = [
            'name' => 'Perfil',
            'group' => RoleGroupEnum::CLIENT,
        ];

        $this->postJson($this->controllerAction('store'), $data)
            ->assertCreated()
            ->assertJsonStructure($this->getRoleResourceStructure());

        $this->assertDatabaseHas('roles', [
            'name' => $data['name'],
            'guard_name' => 'web',
            'group' => $data['group'],
        ]);
    }

    public function test_should_not_create_role_when_already_exists()
    {
        Role::factory()->create([
            'name' => 'Perfil',
        ]);

        $data = [
            'name' => 'Perfil',
            'group' => RoleGroupEnum::ADMIN,
        ];

        $this->postJson($this->controllerAction('store'), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_should_update_role_when_data_is_valid()
    {
        $role = Role::factory()
            ->create([
                'name' => 'Perfil',
            ]);

        $data = [
            'name' => 'Perfil2',
            'group' => $role->group,
        ];

        $this->putJson($this->controllerAction('update', $role->id), $data)
            ->assertOk()
            ->assertJsonStructure($this->getRoleResourceStructure());

        $this->assertDatabaseHas('roles', [
            'name' => $data['name'],
            'guard_name' => 'web',
            'group' => $data['group'],
        ]);
    }

    public function test_should_delete_role_when_data_is_valid()
    {
        $role = Role::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $role->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('roles', [
            'name' => $role->name,
            'guard_name' => 'web',
        ]);
    }
}
