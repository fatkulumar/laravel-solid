<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => [
                'id_role' => $this->id_role,
                'role_name' => $this->role_name
            ],
            'permissions' => [
                'id_permission' => $this->id_permission,
                'permission_name' => $this->permission_name
            ]
        ];
    }
}
