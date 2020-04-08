<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait AutoGenerateUuid
{
    protected static $uuidColumn = 'uuid';

    public static function bootAutoGenerateUuid()
    {
        static::creating(static function ($model) {
            $uuidColumn = static::$uuidColumn;
            $model->{$uuidColumn} = (string) Str::uuid();
        });
    }
}
