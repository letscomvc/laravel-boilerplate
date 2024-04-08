<?php

namespace App\Http\Api\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => output_date_format($this->created_at),
            'updated_at' => output_date_format($this->updated_at),
        ];
    }
}
