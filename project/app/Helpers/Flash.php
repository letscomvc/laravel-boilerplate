<?php

namespace App\Helpers;

class Flash
{
    private $messages;

    public function success($message)
    {
        $this->create('success', $message);
    }

    public function info($message)
    {
        $this->create('info', $message);
    }

    public function warning($message)
    {
        $this->create('warning', $message);
    }

    public function error($message)
    {
        $this->create('error', $message);
    }

    public function create($type, $messages)
    {
        if (! is_array($messages)) {
            $messages = [$messages];
        }

        $this->messages[$type] = $this->messages[$type] ?? [];
        $this->messages[$type] = array_merge($this->messages[$type], $messages);

        foreach ($this->messages as $key => $messages) {
            \Session::flash($key, $messages);
        }
    }
}
