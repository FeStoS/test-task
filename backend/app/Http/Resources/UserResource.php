<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $this->resource->loadMissing('role:id,name');

        return [
            'id'          => $this->id,
            'email'       => $this->email,
            'name'        => $this->name,
            'last_name'   => $this->last_name,
            'first_name'  => $this->first_name,
            'middle_name' => $this->middle_name,
            'role'        => $this->role ? ['id' => $this->role->id, 'name' => $this->role->name] : null,
        ];
    }
}
