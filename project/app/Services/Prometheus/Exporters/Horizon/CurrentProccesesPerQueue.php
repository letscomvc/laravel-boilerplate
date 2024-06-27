<?php

namespace App\Services\Prometheus\Exporters\Horizon;

use App\Services\Prometheus\Contracts\Exporter;
use App\Services\Prometheus\PrometheusService;
use Laravel\Horizon\Contracts\WorkloadRepository;
use Prometheus\Gauge;

class CurrentProccesesPerQueue implements Exporter
{
    private Gauge $gauge;

    public function metrics(PrometheusService $prometheusService)
    {
        $this->gauge = $prometheusService->gauge(
            'horizon_current_processes',
            'Current processes of all queues',
            ['queue']
        );
    }

    public function collect()
    {
        $workloadRepository = app(WorkloadRepository::class);
        $workloads = collect($workloadRepository->get())
            ->sortBy('name')
            ->values();

        $workloads->each(function ($workload) {
            $this->gauge->set($workload['processes'], [$workload['name']]);
        });
    }
}
