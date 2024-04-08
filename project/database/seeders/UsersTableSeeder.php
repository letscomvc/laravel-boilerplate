<?php

namespace Database\Seeders;

use App\Domain\User\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->admin()
            ->create([
                'name' => 'Test User Admin',
                'email' => 'admin@admin.com',
                'password' => '12345678',
            ]);

        User::factory()
            ->client()
            ->create([
                'name' => 'Test User Client',
                'email' => 'client@client.com',
                'password' => '12345678',
            ]);
    }
}
