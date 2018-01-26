<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class CollectionMacrosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('paginate', function ($perPage, $currentPage = null) {
            $currentPage = $currentPage ?? LengthAwarePaginator::resolveCurrentPage();
            $total = $this->count();
            $currentPageItems = $this->slice(($currentPage - 1) * $perPage, $perPage);

            return new LengthAwarePaginator($currentPageItems, $total, $perPage);
        });
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
