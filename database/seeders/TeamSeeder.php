<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Location;
use App\Models\TeamType;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $faker = Faker::create();
        $types = TeamType::pluck('id');
        $locations = Location::pluck('id');

        for ($i = 0; $i < 1000; $i++) {
            $data[] = [
                'name' => $faker->name,
                'description' => $faker->name,
                'team_type_id' => $faker->randomElement($types),
                'location_id' => $faker->randomElement($locations),
            ];
        }

        DB::table('teams')->insert($data);
    }
}
