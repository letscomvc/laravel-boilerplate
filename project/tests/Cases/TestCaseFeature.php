<?php

namespace Tests\Cases;

use App\Domain\User\Models\User;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\CreatesApplication;

abstract class TestCaseFeature extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    protected ?User $currentUser = null;

    protected ?string $currentController = null;

    protected function beforeRefreshingDatabase()
    {
        Event::listen(MigrationsEnded::class, function () {
            $this->artisan('db:seed', ['--class' => PermissionsTableSeeder::class]);
            $this->artisan('db:seed', ['--class' => RolesTableSeeder::class]);

            $this->app->make(\Spatie\Permission\PermissionRegistrar::class)
                ->forgetCachedPermissions();
        });
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Accept' => 'application/json',
            'Origin' => config('app.url') || 'http://localhost:81',
        ]);
    }

    protected function login()
    {
        $this->currentUser = User::factory()
            ->create();

        $this->actingAs($this->currentUser);
        $this->setToken($this->currentUser);

        return $this->currentUser;
    }

    protected function loginAsAdmin()
    {
        $this->currentUser = User::factory()
            ->admin()
            ->create();

        $this->actingAs($this->currentUser);
        $this->setToken($this->currentUser);

        return $this->currentUser;
    }

    protected function loginAsClient()
    {
        $this->currentUser = User::factory()
            ->client()
            ->create();

        $this->actingAs($this->currentUser);
        $this->setToken($this->currentUser);

        return $this->currentUser;
    }

    protected function useActionsFromController(string $controllerClass)
    {
        $this->currentController = $controllerClass;

        return $this;
    }

    protected function controllerAction($action = null, $params = []): ?string
    {
        if (! $action) {
            return action($this->currentController, $params);
        }

        return action([$this->currentController, $action], $params);
    }

    private function setToken(User $user): void
    {
        Sanctum::actingAs($user);
    }
}
