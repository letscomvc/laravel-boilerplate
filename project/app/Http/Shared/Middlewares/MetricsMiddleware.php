<?php

namespace App\Http\Shared\Middlewares;

use App\Services\Prometheus\Facades\Prometheus;
use App\Support\HttpLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MetricsMiddleware
{
    public function handle(Request $request, \Closure $next): mixed
    {
        rescue(function () use ($request) {
            Prometheus::counter('http_requests', 'Total HTTP requests')
                ->inc();
        });

        $response = $next($request);

        rescue(function () use ($request, $response) {
            Prometheus::counter('http_responses', 'HTTP responses by code', labels: ['code'])
                ->inc([$this->getResponseCodeToCounter($response->getStatusCode())]);
        });

        return $response;
    }

    private function getResponseCodeToCounter(int $code): string
    {
        return Str::padLeft($code, 3, '0')[0] . 'xx';
    }
}
