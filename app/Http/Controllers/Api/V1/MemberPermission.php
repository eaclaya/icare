<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Silber\Bouncer\Database\Ability;

class MemberPermission extends Controller
{
    public function index(Request $request)
    {
        // Define resources and their actions
        $resources = [
            'churches' => ['create', 'view', 'edit', 'delete'],
            'communities' => ['create', 'view', 'edit', 'delete', 'approve'],
            'families' => ['create', 'view', 'edit', 'delete', 'notify'],
            'events' => ['create', 'view', 'edit', 'delete', 'notify'],
        ];

        $user = auth()->user();

        $permissions = [];

        foreach ($resources as $resource => $actions) {
            // Global Access
            $globalAccess = [
                'permissions' => [],
            ];
            foreach ($actions as $action) {
                if ($user->can("{$action} {$resource}")) {
                    $globalAccess['permissions'][] = $action;
                }
            }

            $globalAccess['actions'] = $this->getFormattedActions($actions, $globalAccess['permissions']);

            // Scoped Access
            $scopedAccess = [];

            if ($instances = $user->getRelationValue($resource))
            {
                foreach ($instances as $instance) {
                    $instancePermissions = [];
                    $entityId = $instance->id;
                    $entity_type = get_class($instance);

                    foreach ($actions as $action) {
                        if ($user->can("{$action} {$resource}", $instance)) {
                            $instancePermissions[] = $action;
                        }
                    }

                    $scopedAccess[] = [
                        'name' => $instance->name, // Assuming the instance has a 'name' attribute
                        'entity_id' => $entityId,
                        'entity_type' => $entity_type,
                        'permissions' => $instancePermissions,
                        'actions' => $this->getFormattedActions($actions, $instancePermissions)
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
                'scoped' =>  $scopedPermissions
            ];
        }

        foreach ($updatedPermissions as $resource => $permissions) {
            foreach ($permissions['global'] as $action) {
                $ability = "{$action['id']} {$resource}";
                if ($action['enabled']) {
                    $user->allow($ability);
                } else {
                    $user->disallow($ability);
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
        foreach ($actions as $action) {
            $result[$action] = [
                'id' => $action,
                'name' => Str::title($action),
                'enabled' => in_array($action, $permissions)
            ];
        }
        return $result;
    }
}
