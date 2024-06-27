<?php

namespace App\Services\Prometheus\Exporters\Horizon;

use App\Services\Prometheus\Contracts\Exporter;
use App\Services\Prometheus\PrometheusService;
use Laravel\Horizon\Contracts\WorkloadRepository;
use Prometheus\Gauge;

class CurrentWorkload implements Exporter
{
    private Gauge $gauge;

    public function metrics(PrometheusService $prometheusService)
    {
        $this->gauge = $prometheusService->gauge(
            'horizon_current_workload',
            'Current workload of all queues',
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
            if ($workload['split_queues']) {
                $workload['split_queues']->each(function ($queue) {
                    $this->gauge->set($queue['length'], [$queue['name']]);
                });

                return;
            }

            $this->gauge->set($workload['length'], [$workload['name']]);
        });
    }
}
