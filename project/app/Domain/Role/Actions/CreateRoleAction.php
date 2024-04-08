<?php

namespace App\Domain\Role\Actions;

use App\Domain\Shared\Services\LaravelPermissions\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateRoleAction
{
    public function execute(RoleData $data): Model
    {
        try {
            $data = $data->toArray();

            DB::beginTransaction();

            $role = app(Role::class)
                ->create($data);

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
