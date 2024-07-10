<?php

namespace App\Services\Prometheus\Exporters\Horizon;

use App\Services\Prometheus\Contracts\Exporter;
use App\Services\Prometheus\PrometheusService;
use Laravel\Horizon\Contracts\MasterSupervisorRepository;
use Prometheus\Gauge;

class HorizonStatus implements Exporter
{
    private const INACTIVE = -1;
    private const PAUSED = 0;
    private const RUNNING = 1;

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
        $status = self::INACTIVE;
        if ($masters = app(MasterSupervisorRepository::class)->all()) {
            $status = collect($masters)
                ->contains(fn ($master) => $master->status === 'paused')
                ? self::PAUSED
                : self::RUNNING;
        }
        $this->gauge->set($status);
    }
}
