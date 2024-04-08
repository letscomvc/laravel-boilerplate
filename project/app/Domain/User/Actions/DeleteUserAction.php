<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;

class DeleteUserAction
{
    public function execute(User $user): bool
    {
        return $user->delete();
    }
}
