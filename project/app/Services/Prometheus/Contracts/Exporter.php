<?php

namespace App\Services\Prometheus\Contracts;

use App\Services\Prometheus\PrometheusService;

interface Exporter
{
    public function metrics(PrometheusService $prometheusService);

    public function collect();
}
