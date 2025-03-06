<?php

namespace App\Models\MongoDB;

use MongoDB\Laravel\Eloquent\Model;

class Church extends Model
{
    protected $connection = "mongodb";
    protected $collection = "churches";

    public static function getSchema(): array
    {
        return [
            "name" => "churches",
            "fields" => [
                [
                    "name" => "id",
                    "type" => "string",
                ],
                [
                    "name" => "name",
                    "type" => "string",
                ],
                [
                    "name" => "city",
                    "type" => "string",
                ],
                [
                    "name" => "state",
                    "type" => "string",
                ],
                [
                    "name" => "zip",
                    "type" => "string",
                ],
                [
                    "name" => "families_count",
                    "type" => "int32",
                ],
                [
                    "name" => "members_count",
                    "type" => "int32",
                ],
                [
                    "name" => "location",
                    "type" => "geopoint",
                ],
                [
                    "name" => "created_at",
                    "type" => "int64",
                ],
            ],
            "default_sorting_field" => "created_at",
            "search-parameters" => [
                "query_by" => "name",
            ],
        ];
    }
}
