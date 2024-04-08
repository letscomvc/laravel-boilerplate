<?php

namespace App\Domain\User\Policies;

use App\Domain\User\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('users view any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $requestUser): bool
    {
        return $user->can('users view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('users create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $requestUser): bool
    {
        return $user->can('users update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $requestUser): bool
    {
        return $user->can('users delete');
    }
}
