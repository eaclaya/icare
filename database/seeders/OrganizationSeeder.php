<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\OrganizationType;
use App\Models\Location;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $faker = Faker::create();
        $locations = Location::pluck('id');
        $organizationTypes = OrganizationType::pluck('id');
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'name' => $faker->company,
                'nick' => $faker->company,
                'campus' => $faker->company,
                'website' => $faker->url,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'location_id' => $faker->randomElement($locations),
                'organization_type_id' => $faker->randomElement($organizationTypes),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Organization::insert($data);
    }
}
