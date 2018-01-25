<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
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
            'created_at' => format_date($this->created_at),

            'links' => [
                'edit' => $this->when(true, route('users.edit', $this->id)),
                'show' => $this->when(true, route('users.show', $this->id)),
                'destroy' => $this->when(true, route('users.destroy', $this->id)),
            ],
        ];
    }
}
