<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\Community;
use App\Models\Family;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $faker = Faker::create();
        $families = Family::pluck("id", "id");
        $locations = Location::pluck("id", "id");

        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                "name" => $faker->name,
                "description" => $faker->name,
                "type" => $faker->randomElement([
                    "Nuclear",
                    "Extended",
                    "Single Parent",
                ]),
                "family_id" => $faker->randomElement($families),
                "location_id" => $faker->randomElement($locations),
            ];
        }

        DB::table("communities")->insert($data);
    }
}
