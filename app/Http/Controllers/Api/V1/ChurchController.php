<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Church;
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
        // $churches = Church::withCount(["members", "families"])
        //     ->when($request->q, function ($query) use ($request) {
        //         $query->where("name", "ILIKE", "%{$request->q}%");
        //     })
        //     ->orderBy("id", "asc")
        //     ->paginate(50);

        // return response()->json($churches);

        $searchParameters = [
            "q" => $request->q ? $request->q : "*",
            "query_by" => "name,city",
            "page" => $request->page ? $request->page : 1,
            "per_page" => 50,
        ];
        if ($request->location) {
            $searchParameters[
                "filter_by"
            ] = "location:({$request->location["lat"]}, {$request->location["lng"]}, {$request->distance} km)";
        }

        $churches = $this->typesense->collections[
            "churches"
        ]->documents->search($searchParameters);

        return response()->json([
            "data" => data_get($churches, "hits.*.document"),
        ]);
    }

    public function match(Request $request)
    {
        $data = $request->validate([
            "name" => ["required", "string"],
            "street_1" => ["required", "string"],
            "state" => ["required", "string"],
            "city" => ["required", "string"],
            "zip" => ["required", "string"],
            "lat" => ["required", "numeric"],
            "lng" => ["required", "numeric"],
        ]);

        $latitude = $request->input("latitude");
        $longitude = $request->input("longitude");
        $name = $request->input("name");

        $churches = Church::where("location", "near", [
            '$geometry' => [
                "type" => "Point",
                "coordinates" => [$longitude, $latitude],
            ],
            '$maxDistance' => 50000,
        ])->get();
    }
}
