<?php

namespace App\Http\Shared\Middlewares;

use App\Services\Prometheus\Facades\Prometheus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MetricsMiddleware
{
    private ?bool $isIgnoringPath = null;

    public function handle(Request $request, \Closure $next): mixed
    {
        rescue(function () use ($request) {
            if (!$this->shouldIgnorePath($request)) {
                Prometheus::counter('http_requests_total', 'Total HTTP requests')
                    ->inc();
            }
        });

        $response = $next($request);

        rescue(function () use ($request, $response) {
            if (!$this->shouldIgnorePath($request)) {
                Prometheus::counter('http_responses_count', 'HTTP responses by code', labels: ['code'])
                    ->inc([$this->getResponseCodeToCounter($response->getStatusCode())]);
            }
        });

        return $response;
    }

    private function shouldIgnorePath(Request $request): bool
    {
        if ($this->isIgnoringPath !== null) {
            return $this->isIgnoringPath;
        }

        $ignoredPaths = config('prometheus.ignored_paths', []);
        foreach ($ignoredPaths as $path) {
            if (Str::is(trim($path, '/'), $request->path())) {
                return $this->isIgnoringPath = true;
            }
        }

        return $this->isIgnoringPath = false;
    }

    /**
     * Get the response code to increment the counter.
     * Transforms the response code to a 3-digit code and gets the first digit.
     * Examples: 200 -> 2xx, 404 -> 4xx, 500 -> 5xx
     *
     * @param  int  $code
     * @return string
     */
    private function getResponseCodeToCounter(int $code): string
    {
        $suffix = 'xx';
        $firstDigit = Str::padLeft($code, 3, '0')[0];

        return $firstDigit . $suffix;
    }
}
