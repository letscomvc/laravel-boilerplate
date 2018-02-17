<?php

namespace App\Traits;

trait CacheKeys
{
    private function cacheKeyUpgradeable($type = '')
    {
        if ($type != '') {
            $type = str_start($type, ':');
        }

        return sprintf(
            "%s/%s-%s%s",
            $this->getTable(),
            $this->getKey(),
            $this->updated_at->timestamp,
            $type
        );
    }

    private function cacheKey($type = '')
    {
        if ($type != '') {
            $type = str_start($type, ':');
        }

        return sprintf(
            "%s/%s%s",
            $this->getTable(),
            $this->getKey(),
            $type
        );
    }
}
