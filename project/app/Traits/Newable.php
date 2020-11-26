<?php

namespace App\Traits;

trait Newable
{
    /**
     * Returns a instance of current class.
     *
     * @return static
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * Returns a resolved instance of current class.
     *
     * @return static
     */
    public static function resolve(): self
    {
        static $resolvesInsideContainer;

        if ($resolvesInsideContainer === null) {
            $resolvesInsideContainer = function_exists('app');
        }

        if ($resolvesInsideContainer) {
            return app(static::class, func_get_args());
        }

        return new static(...func_get_args());
    }
}
