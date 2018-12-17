<?php
namespace App\Repositories;

use App\Models\User;
use App\Repositories\Repository;

class UserRepository extends Repository
{
    protected function getClass()
    {
        return User::class;
    }
}
