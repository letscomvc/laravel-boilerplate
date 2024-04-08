<?php

namespace App\Http\Api\Resources\Admin;

use App\Support\PermissionsHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray(Request $request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'group' => $this->group,
            'created_at' => output_date_format($this->created_at),
            'updated_at' => output_date_format($this->updated_at),
        ];

        if ($this->relationLoaded('permissions')) {
            $permissions = $this->permissions
                ->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                    ];
                })
                ->toArray();

            $data['permissions'] = PermissionsHelper::getPermissionsByGroup($permissions);
        }

        return $data;
    }
}
