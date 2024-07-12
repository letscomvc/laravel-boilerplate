<?php

namespace App\Services\Prometheus;

use Illuminate\Http\Response;
use Prometheus\CollectorRegistry;
use Prometheus\Counter;
use Prometheus\Gauge;
use Prometheus\RenderTextFormat;

class PrometheusService
{
    private CollectorRegistry $registry;

    public function __construct()
    {
        $adapter = StorageAdapter::make(config('prometheus.storage'));
        $this->registry = new CollectorRegistry($adapter);
    }

    public function gauge(string $name, string $help = '', $labels = []): Gauge
    {
        return $this->registry
            ->getOrRegisterGauge(config('prometheus.namespace') ?? '', $name, $help, $labels);
    }

    public function counter(string $name, string $help = '', $labels = []): Counter
    {
        return $this->registry
            ->getOrRegisterCounter(config('prometheus.namespace') ?? '', $name, $help, $labels);
    }

    public function toResponse(): Response
    {
        return new Response(
            $this->render(),
            Response::HTTP_OK,
            ['Content-Type' => RenderTextFormat::MIME_TYPE]
        );
    }

    public function wipeStorage(): void
    {
        $this->registry->wipeStorage();
    }

    public function render(): string
    {
        $this->loadExporters();

        return (new RenderTextFormat())
            ->render($this->registry->getMetricFamilySamples());
    }

    private function loadExporters()
    {
        foreach (config('prometheus.exporters', []) as $exporter) {
            $_exporter = new $exporter();
            $_exporter->metrics($this);
            $_exporter->collect();
        }
    }
}
