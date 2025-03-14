<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamMemberResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name'=> $this->last_name,
            'name' => $this->first_name . ' ' . $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'url_avatar' => $this->url_avatar,
            'role' => $this->pivot->role
        ];
    }
}
