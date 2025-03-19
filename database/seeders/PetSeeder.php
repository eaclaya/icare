<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Location;
use App\Models\Member;
use App\Models\Pet;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $faker = Faker::create();
        $locations = Location::pluck('id');
        $members = Member::latest('id')->take(100)->pluck('id');
        $now = now()->format('Y-m-d H:i:s');
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'name' => $faker->company,
                'dob' => $now,
                'pet_type' => $faker->randomElement(['dog', 'cat', 'bunny', 'bird']),
                'location_id' => $faker->randomElement($locations),
                'primary_contact_id' => $faker->randomElement($members),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        Pet::insert($data);

    }
}
