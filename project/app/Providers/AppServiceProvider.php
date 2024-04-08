<?php

namespace App\Providers;

use App\Domain\Role\Policies\PermissionPolicy;
use App\Domain\Role\Policies\RolePolicy;
use App\Domain\Shared\Services\LaravelPermissions\Permission;
use App\Domain\Shared\Services\LaravelPermissions\Role;
use App\Domain\User\Models\User;
use App\Domain\User\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
    }
}
