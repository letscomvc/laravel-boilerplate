<?php

namespace App\Services\Prometheus\Exporters\Horizon;

use App\Services\Prometheus\Contracts\Exporter;
use App\Services\Prometheus\PrometheusService;
use Laravel\Horizon\Contracts\JobRepository;
use Prometheus\Gauge;

class FailedJobsPerHour implements Exporter
{
    private Gauge $gauge;

    public function metrics(PrometheusService $prometheusService)
    {
        $this->gauge = $prometheusService->gauge(
            'horizon_failed_jobs',
            'The number of recently failed jobs'
        );
    }

    public function collect()
    {
        $this->gauge->set(app(JobRepository::class)->countRecentlyFailed());
    }
}
