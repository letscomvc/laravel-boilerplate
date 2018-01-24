<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $this->mapDefaultWebRoutes();

        $this->mapUnauthenticatedWebRoutes();

        $this->mapAuthenticatedWebRoutes();

        $this->mapPaginationRoutes();

        $this->mapAjaxRoutes();
    }

    protected function mapDefaultWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    protected function mapUnauthenticatedWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/unauthenticated.php'));
    }

    protected function mapAuthenticatedWebRoutes()
    {
        Route::middleware(['web', 'auth'])
             ->namespace($this->namespace)
             ->group(base_path('routes/web/authenticated.php'));
    }

    protected function mapPaginationRoutes()
    {
        Route::middleware(['web', 'auth'])
             ->namespace($this->namespace)
             ->prefix('pagination')
             ->group(base_path('routes/web/pagination.php'));
    }

    protected function mapAjaxRoutes()
    {
        Route::middleware(['web', 'auth'])
             ->namespace($this->namespace)
             ->prefix('ajax')
             ->group(base_path('routes/web/ajax.php'));
    }
    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $this->mapApiV1Routes();
    }

    protected function mapApiV1Routes()
    {
        $namespace = $this->namespace . '\Api\v1';

        Route::prefix('api/v1')
             ->middleware('api')
             ->middleware('auth:api')
             ->namespace($namespace)
             ->group(base_path('routes/api/v1/authenticated.php'));

        Route::prefix('api/v1')
             ->middleware('api')
             ->middleware('auth:api')
             ->namespace($namespace)
             ->group(base_path('routes/api/v1/unauthenticated.php'));
    }
}
