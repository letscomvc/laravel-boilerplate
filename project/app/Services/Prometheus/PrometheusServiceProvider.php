<?php

namespace App\Services\Prometheus;

use Illuminate\Support\ServiceProvider;

class PrometheusServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PrometheusService::class, function () {
            return new PrometheusService();
        });
    }
}
