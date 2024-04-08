<?php

namespace App\Domain\Shared\Exceptions;

use Exception;

class InvalidEnumValueException extends Exception
{
    public function __construct($message, $code = 500, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
