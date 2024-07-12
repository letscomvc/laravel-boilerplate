<?php

namespace App\Services\Prometheus\Exporters\Horizon;

use App\Services\Prometheus\Contracts\Exporter;
use App\Services\Prometheus\PrometheusService;
use Laravel\Horizon\Contracts\MasterSupervisorRepository;
use Prometheus\Gauge;

class CurrentMasterSupervisors implements Exporter
{
    private Gauge $gauge;

    public function metrics(PrometheusService $prometheusService)
    {
        $this->gauge = $prometheusService->gauge(
            'horizon_current_mastersupervisors',
            'Number of mastersupervisors'
        );
    }

    public function collect()
    {
        $number = count(app(MasterSupervisorRepository::class)->all());
        $this->gauge->set($number);
    }
}
