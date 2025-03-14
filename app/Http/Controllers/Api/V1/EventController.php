<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Church;
use App\Models\Team;
use App\Models\Event;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user()->load('churches', 'groups', 'teams');
        $churches = $user->churches->pluck('name', 'id');
        $groups = $user->groups->pluck('name', 'id');
        $teams = $user->teams->pluck('name', 'id');

        $churchIds = $churches->keys()->toArray();
        $groupIds = $groups->keys()->toArray();
        $teamIds = $teams->keys()->toArray();

        // Combine all the IDs into a single array
        $linkableIds = array_merge($churchIds, $groupIds, $teamIds);

        // Query events that have links to any of these models
        $events = Event::with(['links.linkable', 'user.profile'])
            ->whereHas('links', function ($query) use (
                $churchIds,
                $groupIds,
                $teamIds
            ) {
                $query
                    ->where(function ($q) use ($churchIds) {
                        $q->whereIn('linkable_id', $churchIds)->where(
                            'linkable_type',
                            Church::class
                        );
                    })
                    ->orWhere(function ($q) use ($groupIds) {
                        $q->whereIn('linkable_id', $groupIds)->where(
                            'linkable_type',
                            Group::class
                        );
                    })
                    ->orWhere(function ($q) use ($teamIds) {
                        $q->whereIn('linkable_id', $teamIds)->where(
                            'linkable_type',
                            Team::class
                        );
                    });
            })
            ->orderBy('id', 'asc')
            ->paginate(50);

        return response()->json($events);
    }
}
