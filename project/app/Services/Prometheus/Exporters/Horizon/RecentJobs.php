<?php

namespace App\Services\Prometheus\Exporters\Horizon;

use App\Services\Prometheus\Contracts\Exporter;
use App\Services\Prometheus\PrometheusService;
use Laravel\Horizon\Contracts\JobRepository;
use Prometheus\Gauge;

class RecentJobs implements Exporter
{
    private Gauge $gauge;

    public function metrics(PrometheusService $prometheusService)
    {
        $this->gauge = $prometheusService->gauge(
            'horizon_recent_jobs',
            'The number of recent jobs'
        );
    }

    public function collect()
    {
        $this->gauge->set(app(JobRepository::class)->countRecent());
    }
}
