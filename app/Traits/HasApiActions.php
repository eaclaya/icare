<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasApiActions
{
    public function getActions(): array
    {
        $actions = [];
        $user = auth()->user();

        $modelName = Str::plural(Str::snake(class_basename($this)));

        if ($user->can("edit {$modelName}") || $user->can("edit {$modelName}", $this)) {
            $actions[] = [
                'id' => 'edit',
                'label' => __('Edit'),
                'url' => route("{$modelName}.edit", $this->id),
            ];
        }

        if ($user->can("delete {$modelName}") || $user->can("delete {$modelName}", $this)) {
            $actions[] = [
                'id' => 'delete',
                'label' => __('Delete'),
                'url' => route("{$modelName}.destroy", $this->id),
            ];
        }

        return $actions;
    }
}
