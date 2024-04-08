<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UpgradeSeeder extends Seeder
{
    /**
     * Will always be invoked when upgrade the application (php artisan upgrade).
     * Every seeder invoked here must be written considering multiple executions.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
        ]);
    }
}
