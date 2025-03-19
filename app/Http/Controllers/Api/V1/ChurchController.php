<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChurchResource;
use App\Models\Organization;
use Illuminate\Http\Request;
use Typesense\Client as TypesenseClient;

class ChurchController extends Controller
{
    protected $typesense;

    public function __construct(TypesenseClient $typesense)
    {
        $this->typesense = $typesense;
    }

    public function index(Request $request)
    {
        $user = auth()->user()->load('teams.churches');

        $query = Organization::withCount(['members', 'teams'])
            ->with(['location'])
            ->when($request->q, function ($query) use ($request) {
                $query->whereLike('name', "%{$request->q}%");
            });

        // Check if the user has access to view all churches
        if (! $user->can('view', Organization::class)) {
            $churchIds = $user->teams->pluck('churches')
                ->flatten()
                ->unique('id')
                ->values()
                ->filter(function ($church) use ($user) {
                    return $user->can('view', $church);
                })
                ->pluck('id');

            $query = $query->whereIn('id', $churchIds);
        }

        $churches = $query->orderBy('id', 'asc')->paginate(50);

        return ChurchResource::collection($churches);

        // TYPESENSE TEST: ENABLE THIS IF YOU WANT TO COMPARE RESPONSE TIMES VS ELOQUENT

        // $searchParameters = [
        //     'q' => $request->q ? $request->q : '*',
        //     'query_by' => 'name,city',
        //     'page' => $request->page ? $request->page : 1,
        //     'per_page' => 50,
        // ];
        // if ($request->location) {
        //     $searchParameters[
        //         'filter_by'
        //     ] = "location:({$request->location['lat']}, {$request->location['lng']}, {$request->distance} km)";
        // }

        // $churches = $this->typesense->collections[
        //     'churches'
        // ]->documents->search($searchParameters);

        // return response()->json([
        //     'data' => data_get($churches, 'hits.*.document'),
        // ]);
    }


    public function invite(Request $request, Organization $church)
    {
        $data = [
            'church' => $church,
            'callback' => [
                'url' => route('invitations.store'),
                'method' => 'POST',
                'data' => [
                    'invitable_id' => $church->id,
                    'invitable_type' => Organization::class,
                ]
            ]
        ];

        return response()->json($data);
    }
}
