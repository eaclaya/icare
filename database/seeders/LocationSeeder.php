<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'name' => $faker->streetAddress,
                'street' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip' => $faker->postcode,
                'country' => $faker->country,
                'lat' => $faker->latitude,
                'lng' => $faker->longitude,
            ];
        }

        DB::table('locations')->insert($data);
    }
}
