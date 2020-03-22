<?php

namespace App\Support;

class Flash
{
    /** @var array */
    private $messages = [];

    /** @var bool */
    private $reflashed = false;

    /**
     * @return $this
     */
    public function reflash()
    {
        if ($this->reflashed) {
            return $this;
        }

        app('session')->reflash();
        $this->reflashed = true;

        return $this;
    }

    /**
     * @param $message
     * @return $this
     */
    public function success($message)
    {
        return $this->create('success', $message);
    }

    /**
     * @param $message
     * @return $this
     */
    public function info($message)
    {
        return $this->create('info', $message);
    }

    /**
     * @param $message
     * @return $this
     */
    public function warning($message)
    {
        return $this->create('warning', $message);
    }

    /**
     * @param $message
     * @return $this
     */
    public function error($message)
    {
        return $this->create('error', $message);
    }

    /**
     * @param  string  $type
     * @param  array|string  $messages
     * @return $this
     */
    public function create(string $type, $messages)
    {
        $messages = (array) $messages;

        $this->messages[$type] = array_merge($this->messages[$type] ?? [], $messages);
        $this->messages[$type] = array_unique($this->messages[$type]);

        foreach ($this->messages as $key => $messages) {
            app('session')->flash($key, $messages);
        }

        return $this;
    }
}
