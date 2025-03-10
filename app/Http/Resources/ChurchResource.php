<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChurchResource extends JsonResource
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
            'location' => $this->location,
            'families_count' => $this->families_count,
            'communities_count' => $this->communities_count,
            'actions' => $this->getActions()
        ];
    }

    protected function getActions(): array
    {
        $actions = [];
        $user = auth()->user();

        if ($user->can('edit churches', $this->resource)) {
            $actions[] = [
                'id' => 'edit',
                'label' => __('Edit'),
                'url' => route('churches.edit', $this->id),
            ];
        }

        if ($user->can('delete churches', $this->resource)) {
            $actions[] = [
                'id' => 'delete',
                'label' => __('Delete'),
                'url' => route('churches.destroy', $this->id),
            ];
        }

        return $actions;
    }
}
