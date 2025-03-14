<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'group_type_id' => $this->group_type_id,
            'name' => $this->name,
            'members' => GroupMemberResource::collection($this->members),
            'location' => $this->groupable?->location,
            'groupable' => $this->groupable,
            'teams' => TeamResource::collection($this->teams),
        ];
    }
}
