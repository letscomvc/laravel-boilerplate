<?php

namespace App\Services\Prometheus\Exporters\Horizon;

use App\Services\Prometheus\Contracts\Exporter;
use App\Services\Prometheus\PrometheusService;
use Laravel\Horizon\Contracts\MasterSupervisorRepository;
use Prometheus\Gauge;

class HorizonStatus implements Exporter
{
    private Gauge $gauge;

    public function metrics(PrometheusService $prometheusService)
    {
        $this->gauge = $prometheusService->gauge(
            'horizon_status',
            'The status of Horizon, -1 = inactive, 0 = paused, 1 = running'
        );
    }

    public function collect()
    {
        $status = -1;
        if ($masters = app(MasterSupervisorRepository::class)->all()) {
            $status = collect($masters)->contains(function ($master) {
                return $master->status === 'paused';
            }) ? 0 : 1;
        }
        $this->gauge->set($status);
    }
}
