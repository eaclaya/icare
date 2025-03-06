<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\Family;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
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
        $churches = Church::pluck("id");
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                "name" => $faker->lastName,
                "type" => $faker->randomElement([
                    "Nuclear",
                    "Extended",
                    "Single Parent",
                ]),
                "structure" => $faker->randomElement([
                    "Traditional",
                    "Blended",
                    "Stepfamily",
                ]),
                "created_at" => now(),
                "updated_at" => now(),
            ];
        }

        Family::insert($data);

        $data = Family::get("id")->map(function ($family) use (
            $churches,
            $faker
        ) {
            return [
                "family_id" => $family->id,
                "church_id" => $faker->randomElement($churches),
                "church_type" => $faker->randomElement([
                    "Home Church",
                    "Serving Church",
                    "Other",
                ]),
            ];
        });

        DB::table("church_family")->insert($data->toArray());
    }
}
