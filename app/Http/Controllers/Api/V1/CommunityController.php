<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunityResource;
use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Community::withCount(['members'])
            ->with(['location'])
            ->when($request->q, function ($query) use ($request) {
                $query->whereLike('name', "%{$request->q}%");
            });

        // Check if the user has access to view all communities
        if (! $user->can('view communities')) {
            $communityIds = $user->communities->filter(function ($community) use ($user) {
                return $user->can('view communities', $community);
            })->pluck('id');

            $query = $query->whereIn('id', $communityIds);
        }

        $communities = $query->orderBy('id', 'asc')->paginate(50);

        return CommunityResource::collection($communities);
    }
}
