<?php

namespace App\Http\Api\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'group' => $this->group,
            'roles' => $this->whenLoaded('roles', function () {
                return $this->getRoleNames();
            }),
            'permissions' => $this->whenLoaded('permissions', function () {
                return $this->getAllPermissions()->pluck('name');
            }),
            'created_at' => output_date_format($this->created_at),
            'updated_at' => output_date_format($this->updated_at),
        ];
    }
}
