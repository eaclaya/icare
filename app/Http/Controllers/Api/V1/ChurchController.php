<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChurchResource;
use App\Models\Church;
use App\Models\MongoDB\Church as MongoChurch;
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
        $user = auth()->user();

        $query = tenancy()->tenant->churches()->withCount(['members', 'families'])
            ->with(['location'])
            ->when($request->q, function ($query) use ($request) {
                $query->whereLike('name', "%{$request->q}%");
            });

        // Check if the user has access to view all churches
        if (! $user->can('view churches')) {
            $churchIds = $user->churches->filter(function ($church) use ($user) {
                return $user->can('view churches', $church);
            })->pluck('id');

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

    public function match(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'street_1' => ['required', 'string'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'zip' => ['required', 'string'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
        ]);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $name = $request->input('name');

        $churches = MongoChurch::where('location', 'near', [
            '$geometry' => [
                'type' => 'Point',
                'coordinates' => [$longitude, $latitude],
            ],
            '$maxDistance' => 50000,
        ])->get();
    }

    public function invite(Request $request, Church $church)
    {
        $data = [
            'church' => $church,
            'callback' => [
                'url' => route('invitations.store'),
                'method' => 'POST',
                'data' => [
                    'invitable_id' => $church->id,
                    'invitable_type' => Church::class,
                ]
            ]
        ];

        return response()->json($data);
    }
}
