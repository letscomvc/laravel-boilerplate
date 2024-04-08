<?php

namespace App\Domain\Role\Policies;

use App\Domain\User\Models\User;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('permissions view any');
    }
}
