<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Group;
use App\Models\Church;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberPermission extends Controller
{
    public function index(Request $request)
    {
        // Define resources and their actions
        $resources = [
            'churches' => ['create' => Church::class, 'view' => Church::class, 'edit' => Church::class, 'delete' => Church::class],
            'teams' => ['create' => Team::class, 'view' => Team::class, 'edit' => Team::class, 'delete' => Team::class],
            'groups' => ['create' => Group::class, 'view' => Group::class, 'edit' => Group::class, 'delete' => Group::class],
            'events' => ['create' => Event::class, 'view' => Event::class, 'edit' => Event::class, 'delete' => Event::class],
        ];

        $user = auth()->user();
        $permissions = [];

        foreach ($resources as $resource => $actions) {
            // Global Access
            $globalAccess = [
                'permissions' => [],
            ];
            foreach ($actions as $action => $model) {
                if ($user->can("{$action}", $model)) {
                    $globalAccess['permissions'][] = $action;
                }
            }

            $globalAccess['actions'] = $this->getFormattedActions($actions, $globalAccess['permissions']);

            // Scoped Access
            $scopedAccess = [];

            if ($instances = $user->getRelationValue($resource)) {
                foreach ($instances as $instance) {
                    $instancePermissions = [];
                    $entityId = $instance->id;
                    $entity_type = get_class($instance);

                    foreach ($actions as $action => $model) {
                        if ($user->can("{$action}", $instance)) {
                            $instancePermissions[] = $action;
                        }
                    }

                    $scopedAccess[] = [
                        'name' => $instance->name, // Assuming the instance has a 'name' attribute
                        'entity_id' => $entityId,
                        'entity_type' => $entity_type,
                        'permissions' => $instancePermissions,
                        'actions' => $this->getFormattedActions($actions, $instancePermissions),
                    ];

                }
            }

            // Add to permissions array
            $permissions[$resource] = [
                'global' => $globalAccess,
                'scoped' => $scopedAccess,
            ];
        }

        return response()->json($permissions);
    }

    public function store(Request $request)
    {
        $permissions = $request->get('permissions', []);
        $user = auth()->user();
        $updatedPermissions = [];

        foreach ($permissions as $key => $item) {
            $globalPermissions = collect($item['global']['actions'])->filter(fn ($action) => isset($action['updated_at']))->toArray();
            $scopedPermissions = [];
            foreach ($item['scoped'] as $resource) {
                $actions = collect($resource['actions'])->filter(fn ($action) => isset($action['updated_at']));
                $actions = $actions->map(function ($action) use ($resource) {
                    $action['entity_id'] = $resource['entity_id'];
                    $action['entity_type'] = $resource['entity_type'];

                    return $action;
                })->toArray();

                $scopedPermissions = [...$scopedPermissions, ...$actions];
            }

            $updatedPermissions[$key] = [
                'global' => $globalPermissions,
                'scoped' => $scopedPermissions,
            ];
        }

        foreach ($updatedPermissions as $resource => $permissions) {
            foreach ($permissions['global'] as $action) {
                $ability = "{$action['id']}";
                if ($action['enabled']) {
                    $user->allow($ability, $action['entity_type']);
                } else {
                    $user->disallow($ability, $action['entity_type']);
                }
            }

            foreach ($permissions['scoped'] as $action) {
                $ability = "{$action['id']} {$resource}";
                $modelClass = $action['entity_type'];
                $modelId = $action['entity_id'];
                $model = $modelClass::find($modelId);
                if ($action['enabled']) {
                    $user->allow($ability, $model);
                } else {
                    $user->disallow($ability, $model);
                }
            }
        }
    }

    protected function getFormattedActions($actions, $permissions)
    {
        $result = [];
        foreach ($actions as $action => $model) {
            $result[$action] = [
                'id' => $action,
                'name' => Str::title($action),
                'entity_type' => $model,
                'enabled' => in_array($action, $permissions),
            ];
        }

        return $result;
    }
}
