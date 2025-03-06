<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Church;
use App\Models\Community;
use App\Models\Event;
use App\Models\Family;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user = User::first()->load("churches", "families", "communities");
        $churches = $user->churches->pluck("name", "id");
        $families = $user->families->pluck("name", "id");
        $communities = $user->communities->pluck("name", "id");

        $churchIds = $churches->keys()->toArray();
        $familyIds = $families->keys()->toArray();
        $communityIds = $communities->keys()->toArray();

        // Combine all the IDs into a single array
        $linkableIds = array_merge($churchIds, $familyIds, $communityIds);

        // Query events that have links to any of these models
        $events = Event::with(["links.linkable", "user.profile"])
            ->whereHas("links", function ($query) use (
                $churchIds,
                $familyIds,
                $communityIds
            ) {
                $query
                    ->where(function ($q) use ($churchIds) {
                        $q->whereIn("linkable_id", $churchIds)->where(
                            "linkable_type",
                            Church::class
                        );
                    })
                    ->orWhere(function ($q) use ($familyIds) {
                        $q->whereIn("linkable_id", $familyIds)->where(
                            "linkable_type",
                            Family::class
                        );
                    })
                    ->orWhere(function ($q) use ($communityIds) {
                        $q->whereIn("linkable_id", $communityIds)->where(
                            "linkable_type",
                            Community::class
                        );
                    });
            })
            ->orderBy("id", "asc")
            ->paginate(50);

        return response()->json($events);
    }
}
