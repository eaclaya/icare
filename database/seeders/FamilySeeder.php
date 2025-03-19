<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Family;
use App\Models\Location;
use App\Models\Member;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $faker = Faker::create();
        $locations = Location::pluck('id');
        $members = Member::pluck('id');

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'name' => $faker->company,
                'structure' => $faker->randomElement(['nuclear', 'single_mom', 'single_dad', 'kin']),
                'location_id' => $faker->randomElement($locations),
                'primary_contact_id' => $faker->randomElement($members),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Family::insert($data);

    }
}
