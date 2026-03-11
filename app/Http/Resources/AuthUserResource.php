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
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            
            'panel' => $this->panel,
            'brotherhood_id' => $this->brotherhood_id,
            'band_id' => $this->band_id,

            'avatar' => $this->navbar_avatar,
            'organization' => $this->navbar_organization,

            'roles' => $this->getRoleNames()->first(),

            'band' => $this->whenLoaded('band'),
            'brotherhood' => $this->whenLoaded('brotherhood', function () {
                return [
                    'id' => $this->brotherhood->id,
                    'name' => $this->brotherhood->name,
                    'processions' => $this->brotherhood->processions->map(function ($procession) {
                        return [
                            'id' => $procession->id,
                            'name' => $procession->name,
                            'checkout_time' => $procession->checkout_time,
                            'checkin_time' => $procession->checkin_time,
                        ];
                    }),
                ];
            }),

            'permissions' => [
                'can_access_admin' => $this->hasRole('admin'),
            ],
        ];
    }
}
