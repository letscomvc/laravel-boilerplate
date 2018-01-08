<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    private $admin_role_name = 'admin';

    /**
     * Run the seed.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::firstOrCreate([
            'name' => $this->admin_role_name,
            'guard_name' => 'web',
        ]);

        $all_permissions = Permission::all();
        $admin_role->syncPermissions($all_permissions);
    }
}
