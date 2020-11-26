<?php

namespace App\Support;

class CacheManager
{
    /**
     * Resolve o resultado de uma chave de cache e retorna seu valor.
     *
     * @param  string|callable  $key  Chave de cache
     * @param  string  $ttl  Tempo de duração do cache. Ver guia de formatos
     * relativos em http://php.net/manual/pt_BR/datetime.formats.relative.php
     * @param  callable  $value  Valor a ser criado cache
     * @param  array  $tags  Marcações para a chave de cache
     * @return mixed
     */
    public function remember(
        $key,
        string $ttl,
        callable $value,
        array $tags = []
    ) {
        $applicationCacheIsEnabled = config('cache.enable_application_cache');

        if (!$applicationCacheIsEnabled) {
            return value($value);
        }

        $key = (string) value($key);
        $ttl = $this->resolveTTL($ttl);

        if (!empty($tags)) {
            return cache()
                ->tags($tags)
                ->remember($key, $ttl, $value);
        }

        return cache()->remember($key, $ttl, $value);
    }

    /**
     * Armazena valor em cache forçando reescrita.
     *
     * @param  string|callable  $key  Chave de cache
     * @param  mixed  $value  Valor a ser criado cache
     * @param  string  $ttl  Tempo de duração do cache. Ver guia de formatos
     * relativos em http://php.net/manual/pt_BR/datetime.formats.relative.php
     * @param  array  $tags  Marcações para a chave de cache
     * @return mixed
     */
    public function put(
        $key,
        $value,
        string $ttl,
        array $tags = []
    ) {
        $key = (string) value($key);
        $ttl = $this->resolveTTL($ttl);

        if (!empty($tags)) {
            return cache()
                ->tags($tags)
                ->put($key, $value, $ttl);
        }

        return cache()->put($key, $value, $ttl);
    }

    /**
     *  Faz cache de um resultado apenas durante a requisição atual.
     *
     * @param  string|callable  $key  Chave de cache
     * @param  callable  $value  Valor a ser criado cache
     * @return mixed
     */
    public function requestCache($key, callable $value)
    {
        $requestCacheIsEnabled = config('cache.enable_application_request_cache');
        if (!$requestCacheIsEnabled) {
            return value($value);
        }

        $key = (string) value($key);
        $ttl = $this->resolveTTL('1 minute');

        return cache()
            ->driver('array')
            ->remember($key, $ttl, $value);
    }

    /**
     * Converte o TTL de string para um objeto de intervalo de data.
     *
     * @param  string  $ttl  Tempo de duração do cache. Ver guia de formatos
     * relativos em http://php.net/manual/pt_BR/datetime.formats.relative.php
     * @return \DateInterval      TTL convertido
     */
    private function resolveTTL(string $ttl)
    {
        return \DateInterval::createFromDateString($ttl);
    }
}
