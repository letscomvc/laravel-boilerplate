<?php

namespace App\Services\Prometheus\Exporters\Horizon;

use App\Services\Prometheus\Contracts\Exporter;
use App\Services\Prometheus\PrometheusService;
use Laravel\Horizon\Contracts\MetricsRepository;
use Prometheus\Gauge;

class JobsPerMinute implements Exporter
{
    protected Gauge $gauge;

    public function metrics(PrometheusService $prometheusService)
    {
        $this->gauge = $prometheusService->gauge(
            'horizon_jobs_per_minute',
            'The number of jobs per minute'
        );
    }

    public function collect()
    {
        $this->gauge->set(app(MetricsRepository::class)->jobsProcessedPerMinute());
    }
}
