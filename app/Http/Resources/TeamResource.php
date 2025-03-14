<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'members' => TeamMemberResource::collection($this->members),
            'location' => $this->location,
            'team_type' => $this->teamType,
            'groups' => TeamGroupResource::collection($this->groups),
        ];
    }
}
