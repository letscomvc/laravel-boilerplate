<?php

namespace App\Services\Prometheus;

use Prometheus\Storage\Adapter;
use Prometheus\Storage\InMemory;
use Prometheus\Storage\Redis;

class StorageAdapter
{
    const REDIS = 'redis';
    const MEMORY = 'memory';

    public static function make(string $driver): Adapter
    {
        $drivers = [
            static::REDIS => static::makeRedis(),
            static::MEMORY => static::makeMemory(),
        ];

        if (!isset($drivers[$driver])) {
            throw new \InvalidArgumentException("Unsupported storage adapter: {$driver}");
        }

        return $drivers[$driver];
    }

    private static function makeRedis(): Adapter
    {
        $redisConnection = config('prometheus.redis.connection');
        if (!$redisConnectionData = config("database.redis.$redisConnection")) {
            throw new \InvalidArgumentException("Redis connection not found: {$redisConnection}.");
        }

        $redisConfig = fn ($key) => $redisConnectionData[$key] ?? null;

        Redis::setPrefix($redisConfig('prefix') ?? 'prometheus::');
        return new Redis([
            'host' => $redisConfig('host'),
            'port' => $redisConfig('port'),
            'password' => $redisConfig('password'),
            'database' => (int) $redisConfig('database'),
        ]);
    }

    private static function makeMemory(): Adapter
    {
        return new InMemory();
    }
}
