<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamCollectionResource;
use App\Http\Resources\TeamResource;
use App\Models\Group;
use App\Models\GroupTeam;
use App\Models\Member;
use App\Models\Role;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade as Bouncer;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Team::withCount(['members'])
            ->with(['location'])
            ->when($request->q, function ($query) use ($request) {
                $query->whereLike('name', "%{$request->q}%");
            });


        // Check if the user has access to view all teams
        if (! $user->can('view', Team::class)) {

            $teamsThroughGroups = $user->groups
                ->flatMap(function ($group) {
                    return $group->teams;
                })
                ->pluck('id');

            $ownedGroups = $user->teams
                ->filter(function ($team) use ($user) {
                    return $user->can('view', $team);
                })
                ->pluck('id');

            $teamIds = [...$teamsThroughGroups->toArray(), ...$ownedGroups->toArray()];

            $query = $query->whereIn('id', $teamIds);
        }

        $teams = $query->orderBy('id', 'asc')->paginate(20);

        return TeamCollectionResource::collection($teams);
    }

    public function edit(Request $request, Team $team)
    {
        $team = $team->load(['groups.members', 'members', 'groups.groupType']);

        return response()->json([
            'team' => new TeamResource($team)
        ]);
    }

    public function saveTeamGroup(Request $request, Team $team)
    {
        $team->groups()->syncWithoutDetaching(['group_id' => $request->group_id]);

        $group = Group::with(['members.user'])->findOrFail($request->group_id);

        $schema = Role::roleAbilitiesSchema();

        foreach ($group->members as $member) {
            $user = $member->user;

            if (empty($user)) { continue; }

            foreach ($schema[Team::class] as $role => $actions) {
                if ($role === 'Volunteer') {
                    foreach ($actions as $action) {
                        $user->allow($action, $team);
                    }
                    break;
                }
            }
        }


        return $this->edit($request, $team);
    }

    public function removeTeamGroup(Request $request, Team $team, Group $group)
    {
        GroupTeam::where('team_id', $team->id)
            ->where('group_id', $group->id)
            ->delete();

        return $this->edit($request, $team);
    }

    public function saveTeamMember(Request $request, Team $team)
    {

        TeamMember::firstOrCreate(
            [ 'team_id' => $team->id, 'member_id' => $request->member_id ],
            [
                'role' => $request->role,
            ]
        );

        $member = Member::find($request->member_id);

        if ($user = $member->user) {
            $schema = Role::roleAbilitiesSchema();

            foreach ($schema[Team::class] as $role => $actions) {
                if ($role === $request->role) {
                    foreach ($actions as $action) {
                        $user->allow($action, $team);
                    }
                    break;
                }
            }
        }

        return $this->edit($request, $team);
    }


    public function removeTeamMember(Request $request, Team $team, Member $member)
    {

        $teamMember = TeamMember::where('team_id', $team->id)
            ->where('member_id', $member->id)
            ->firstOrFail();

        $currentRole = $teamMember->role;
        $teamMember->delete();

        if ($user = $member->user) {
            $schema = Role::roleAbilitiesSchema();

            foreach ($schema[Team::class] as $role => $actions) {
                if ($role === $currentRole) {
                    foreach ($actions as $action) {
                        $user->disallow($action, $team);
                    }
                    break;
                }
            }
        }

        return $this->edit($request, $team);
    }
}
