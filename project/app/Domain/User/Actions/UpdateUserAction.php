<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    public function execute(User $user, UserData $data): User
    {
        $dataArray = $data->toArray();

        if (array_key_exists('password', $dataArray)) {
            $dataArray['password'] = Hash::make($data->password);
        }

        if ($roles = data_get($dataArray, 'roles')) {
            $user->syncRoles($roles);
        }

        $user->refresh();

        $user->update($dataArray);

        return $user;
    }
}
