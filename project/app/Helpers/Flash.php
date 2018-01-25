<?php

namespace App\Helpers;

class Flash
{
    public static $messages;

    public static function success($message)
    {
        static::create('success', $message);
    }
    public static function info($message)
    {
        static::create('info', $message);
    }
    public static function warning($message)
    {
        static::create('warning', $message);
    }
    public static function error($message)
    {
        static::create('error', $message);
    }

    public static function create($type, $messages)
    {
        if (! is_array($messages)) {
            $messages = [$messages];
        }

        static::$messages[$type] = static::$messages[$type] ?? [];
        static::$messages[$type] = array_merge(static::$messages[$type], $messages);

        foreach(static::$messages as $key => $messages) {
            \Session::flash($key, $messages);
        }
    }
}
