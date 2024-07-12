<?php

namespace App\Http\Shared\Controllers;

use App\Services\Prometheus\Facades\Prometheus;

class MetricsController
{
    public function __invoke()
    {
        return Prometheus::toResponse();
    }
}
