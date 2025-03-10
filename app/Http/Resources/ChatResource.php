<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'name' => $this->getChatName(),
            'avatar' => $this->getChatAvatar(),
        ];
    }

    protected function getChatName(): string
    {
        if (! $this->is_group) {
            return $this->users->first(fn ($user) => $user->id != auth()->id())->name;
        }

        return $this->name;
    }

    protected function getChatAvatar(): string
    {

        return $this->users->first(fn ($user) => $user->id != auth()->id())->profile->url_avatar;
    }
}
