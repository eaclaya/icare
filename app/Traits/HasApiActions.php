<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasApiActions
{
    protected $actions = [
        'show',
        'edit',
        'delete',
        // 'invite'
    ];


    protected function getResourceName()
    {
        return Str::plural(Str::snake(class_basename($this)));
    }

    public function getActions(): array
    {
        $result = [];
        $user = auth()->user();

        $resource = $this->getResourceName();

        foreach ($this->actions as $key => $val) {
            $action = $val;
            $url = null;
            $label = $action;
            $event = null;

            $permission = null;

            if (is_array($val)) {
                $action = $key;
                $url = $val['url'] ?? null;
                $label = $val['label'] ?? action;
                $event = $val['event'] ?? null;
                $permission = $val['permission'] ?? $permission;
            }

            $permission ??=  $action;
            $label = Str::title($label);
            $httpAction = $action === 'delete' ? 'destroy' : $action;
            $url ??= route("{$resource}.{$httpAction}", $this->id);


            if ($user->can($permission, get_class($this)) || $user->can($permission, $this)) {
                $result[] = [
                    'id' => $action,
                    'label' => __($label),
                    'url' => $url,
                    'event' => $event,
                ];
            }

        }
        return $result;
    }
}
