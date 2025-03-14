<?php

namespace App\Http\Controllers;

use App\FamilyStructure;
use App\Http\Resources\GroupCollectionResource;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\GroupType;
use App\Models\Location;
use App\Models\User;
use App\PetType;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Group::with(['groupType', 'groupable.location'])
            ->when($request->q, function ($query) use ($request) {
                $query->whereLike('name', "%{$request->q}%");
            });

        // Check if the user has access to view all groups
        if (! $user->can('view', Group::class)) {
            $groupIds = $user->groups->filter(function ($group) use ($user) {
                return $user->can('view', $group);
            })->pluck('id');

            $query = $query->whereIn('id', $groupIds);
        }

        $groups = $query->orderBy('id', 'asc')->paginate(50);

        return GroupCollectionResource::collection($groups);
    }

    public function create(Request $request)
    {
        $groupTypes = GroupType::all();
        $familyStructures = FamilyStructure::pluck();
        $petTypes = PetType::pluck();
        $users = User::pluck('name', 'id')->toArray();

        return response()->json([
            'fields' => [
                'group_type_id' => [
                    'id' => 'group_type_id',
                    'type' => 'select',
                    'label' => 'Group Type',
                    'options' => $groupTypes->pluck('name', 'id'),
                    'required' => true,
                    'value' => $groupTypes->first()->id,
                ],
                'structure' => [
                    'id' => 'structure',
                    'type' => 'select',
                    'label' => 'Structure',
                    'options' => $familyStructures,
                    'required' => true,
                    'value' => array_key_first($familyStructures),
                    'depends_on' => [
                        'field' => 'group_type_id',
                        'value' => $groupTypes->first(function ($val) { return $val->name === 'Family'; })->id,
                    ],
                ],
                'pet_type' => [
                    'id' => 'pet_type',
                    'type' => 'select',
                    'label' => 'Pet Type',
                    'options' => $petTypes,
                    'required' => true,
                    'value' => array_key_first($petTypes),
                    'depends_on' => [
                        'field' => 'group_type_id',
                        'value' => $groupTypes->first(function ($val) { return $val->name === 'Pet'; })->id,
                    ],
                ],
                'dob' => [
                    'id' => 'dob',
                    'label' => 'Birthday',
                    'type' => 'date',
                    'required' => true,
                    'depends_on' => [
                        'field' => 'group_type_id',
                        'value' => $groupTypes->first(function ($val) { return $val->name === 'Pet'; })->id,
                    ],
                ],
                'primary_contact_id' => [
                    'id' => 'primary_contact_id',
                    'label' => 'Primary Contact',
                    'type' => 'select',
                    'options' => $users,
                    'required' => true,
                    'value' => array_key_first($users),
                ]
            ]
        ]);
    }

    public function edit(Request $request, Group $group)
    {
        $group = $group->load(['members', 'groupType', 'teams.members', 'groupable.location', 'teams.teamType']);

        return response()->json([
            'group' => new GroupResource($group)
        ]);
    }

    public function store(Request $request)
    {
        $groupType = GroupType::findOrFail($request->group_type_id);
        $groupableType = "App\\Models\\{$groupType->name}";
        $data = $request->all();

        $location = Location::create($request->location);
        $data['location_id'] = $location->id;
        $model = $groupableType::create($data);

        $data['groupable_id'] = $model->id;
        $data['groupable_type'] = $groupableType;
        $group = Group::create($data);

        return $this->edit($request, $group);
    }
}
