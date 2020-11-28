<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->toIso8601String(),

            'links' => [
                'edit' => route('users.edit', $this->id),
                'show' => route('users.show', $this->id),
                'destroy' => route('users.destroy', $this->id),
            ],
        ];
    }
}
