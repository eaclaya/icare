<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Family;
use App\Models\Group;
use App\Models\GroupType;
use App\Models\Pet;
use App\Models\Team;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $faker = Faker::create();

        $types = GroupType::pluck('id');
        $families = Family::pluck('id');
        $pets = Pet::pluck('id');

        for ($i = 0; $i < 100; $i++) {
            $index = $faker->numberBetween(0, 1);
            $groupableType = '';
            $collection = [];
            if ($index === 0) {
                $groupableType = Family::class;
                $collection = $families;
            } else {
                $groupableType = Pet::class;
                $collection = $pets;
            }

            $data[] = [
                'name' => $faker->lastName,
                'group_type_id' => $faker->randomElement($types),
                'groupable_id' => $faker->randomElement($collection),
                'groupable_type' => $groupableType,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Group::insert($data);

    }
}
