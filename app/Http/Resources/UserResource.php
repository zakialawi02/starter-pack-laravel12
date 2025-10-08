<?php

namespace App\Http\Resources;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $role = $this->resource->role;
        $roleValue = $role instanceof UserRole ? $role->value : $role;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $roleValue,
            'email_verified_at' => $this->email_verified_at,
            'profile_photo_path' => $this->profile_photo_path,
            'profile_photo_url' => asset($this->profile_photo_path),
            'provider_name' => $this->provider_name,
            'created_at' => $this->created_at,
            'created_at_formatted' => $this->created_at?->format('d M Y'),
        ];
    }
}
