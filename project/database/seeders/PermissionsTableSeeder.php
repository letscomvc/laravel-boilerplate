<?php

namespace Database\Seeders;

use App\Support\PermissionsHelper;
use Database\Seeders\data\PermissionsAndRoles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = PermissionsAndRoles::getPermissions();
        $flattenPermissions = PermissionsHelper::getFlattenPermissions($permissions);

        $this->createPermissions($flattenPermissions);
        $this->dropUndeclaredPermissions($flattenPermissions);
    }

    private function createPermissions($flattenPermissions)
    {
        foreach ($flattenPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    private function dropUndeclaredPermissions($flattenPermissions)
    {
        Permission::whereNotIn('name', $flattenPermissions)
            ->delete();
    }
}
