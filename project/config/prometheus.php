<?php

return [
    /**
     * The namespace to use for the metrics.
     */
    'namespace' => env('PROMETHEUS_NAMESPACE', 'app'),

    /**
     * The storage adapter to use for Prometheus. Supported: memory, redis.
     */
    'storage' => env('PROMETHEUS_STORAGE', \App\Services\Prometheus\StorageAdapter::REDIS),

    /**
     * The connection to use for the Redis storage adapter.
     * This should be a valid connection from the `database.redis` configuration.
     */
    'redis' => [
        'connection' => 'prometheus',
    ],

    /**
     * The exporters to load and collect metrics from.
     */
    'exporters' => [
//        \App\Services\Prometheus\Exporters\Horizon\JobsPerMinute::class,
//        \App\Services\Prometheus\Exporters\Horizon\CurrentMasterSupervisors::class,
//        \App\Services\Prometheus\Exporters\Horizon\CurrentWorkload::class,
//        \App\Services\Prometheus\Exporters\Horizon\CurrentProccesesPerQueue::class,
//        \App\Services\Prometheus\Exporters\Horizon\FailedJobsPerHour::class,
//        \App\Services\Prometheus\Exporters\Horizon\HorizonStatus::class,
//        \App\Services\Prometheus\Exporters\Horizon\RecentJobs::class,
    ],

    /**
     * The paths to ignore when collecting metrics.
     */
    'ignored_paths' => [
        '/telescope*',
        '/horizon*',
        '/metrics',
        '/api/health-check',
    ],
];
