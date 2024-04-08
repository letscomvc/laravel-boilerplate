<?php

namespace App\Domain\Role\Exceptions;

use Exception;

class RoleHasUsersException extends Exception
{
    protected $message = 'Role has users';

    protected $code = 422;
}
