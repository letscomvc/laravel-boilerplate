<?php

namespace App\Domain\Role\Actions;

use App\Domain\Shared\Services\LaravelPermissions\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UpdateRoleAction
{
    public function execute(RoleData $data, Role $role): Model
    {
        try {
            $data = $data->toArray();

            DB::beginTransaction();

            $role->update($data);

            if (data_get($data, 'permission_ids')) {
                app(SyncRolePermissionsAction::class)
                    ->execute($data['permission_ids'], $role);
            }

            DB::commit();

            return $role;
        } catch (\Exception $exception) {
            DB::rollback();
            throw new \Exception($exception->getMessage());
        }
    }
}
