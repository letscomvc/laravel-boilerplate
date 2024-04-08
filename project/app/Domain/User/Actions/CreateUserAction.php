<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function execute(UserData $data): User
    {

        $dataArray = $data->toArray();

        $dataArray['password'] = Hash::make($dataArray['password']);

        $user = app(User::class)
            ->create($dataArray);

        if ($roles = $data->roles) {
            $user->assignRole($roles);
        }

        return $user;
    }
}
