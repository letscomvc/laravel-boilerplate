<?php

namespace App\Providers;

use App\Support\CollectionMacros;
use Illuminate\Support\ServiceProvider;

class CollectionMacrosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        CollectionMacros::register();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
