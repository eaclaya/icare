<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ChurchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $faker = Faker::create();
        $locations = Location::pluck("id");
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                "name" => $faker->company,
                "nickname" => $faker->company,
                "campus_name" => $faker->company,
                "location_id" => $faker->randomElement($locations),
                "created_at" => now(),
                "updated_at" => now(),
            ];
        }

        Church::insert($data);
    }
}
