<?php

namespace App\Traits;

trait CacheKeys
{
    public function cacheKeyUpgradeable($suffix = '')
    {
        if ($suffix != '') {
            $suffix = str_start($suffix, ':');
        }

        return sprintf(
            "%s/%s-%s%s",
            $this->getTable(),
            $this->getKey(),
            $this->updated_at->timestamp,
            $suffix
        );
    }

    public function cacheKey($suffix = '')
    {
        if ($suffix != '') {
            $suffix = str_start($suffix, ':');
        }

        return sprintf(
            "%s/%s%s",
            $this->getTable(),
            $this->getKey(),
            $suffix
        );
    }
}
