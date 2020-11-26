<?php

namespace Database\Seeders;

use App\Support\PermissionsHelper;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    private function getPermissions()
    {
        return [
            'users' => ['index', 'create', 'edit', 'destroy'],
            'base test',
        ];
    }

    /**
     * Run the seed.
     *
     * @return void
     */
    public function run()
    {
        $permissions = $this->getPermissions();
        $permissions = PermissionsHelper::getFlattenPermissions($permissions);
        foreach ($permissions as $permission) {
            $model = Permission::firstOrNew(['name' => $permission]);
            $model->save();
        }
    }
}
