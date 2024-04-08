<?php

namespace Database\Seeders;

use App\Support\PermissionsHelper;
use Database\Seeders\data\PermissionsAndRoles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = PermissionsAndRoles::getRoles();

        foreach ($profiles as $profile => $data) {
            $role = Role::updateOrCreate([
                'name' => $profile,
                'guard_name' => 'web',
            ], [
                'group' => $data['group'],
            ]);

            $rolePermissions = PermissionsHelper::getFlattenPermissions($data['permissions']);
            $role->syncPermissions($rolePermissions);
        }
    }
}
