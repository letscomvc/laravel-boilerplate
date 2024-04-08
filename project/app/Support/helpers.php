<?php

if (! function_exists('current_user')) {
    /**
     * Retorna uma instância do usuário corrente.
     *
     * @return \App\Domain\Account\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    function current_user(): ?App\Domain\User\Models\User
    {
        return auth()->user();
    }
}

if (! function_exists('pagination')) {
    /**
     * Retorna uma instância do builder de paginação.
     */
    function pagination($subject): App\Support\PaginationBuilder
    {
        return \App\Support\PaginationBuilder::for($subject);
    }
}

if (! function_exists('array_keys_as')) {
    /**
     * Renomeia as chaves de um array.
     *
     * @param  array  $data  Array a ser renomeado
     * @param  array  $keysFromTo  Chaves a serem renomeadas
     */
    function array_keys_as(array $data, array $keysFromTo): array
    {
        foreach ($keysFromTo as $oldKey => $newKey) {
            if (array_key_exists($oldKey, $data)) {
                $data[$newKey] = $data[$oldKey];
                unset($data[$oldKey]);
            }
        }

        return $data;
    }
}

if (! function_exists('iso8601')) {
    function iso8601($date): ?string
    {
        if (! $date) {
            return null;
        }

        return (new \Carbon\Carbon($date))->toIso8601String();
    }
}

if (! function_exists('output_date_format')) {
    function output_date_format($date): ?string
    {
        return iso8601($date);
    }
}
