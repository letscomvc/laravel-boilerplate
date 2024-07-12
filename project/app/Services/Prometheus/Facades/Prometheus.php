<?php

namespace App\Services\Prometheus\Facades;

use App\Services\Prometheus\PrometheusService;
use Illuminate\Support\Facades\Facade;

class Prometheus extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PrometheusService::class;
    }
}
