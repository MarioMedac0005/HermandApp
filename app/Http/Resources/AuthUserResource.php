<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,

            'panel' => $this->panel,

            'avatar'       => $this->navbar_avatar,
            'organization' => $this->navbar_organization,

            'roles' => $this->getRoleNames(),

            'permissions' => [
                'can_access_admin' => $this->hasRole('admin'),
            ],
        ];
    }
}
