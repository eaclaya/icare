<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\Community;
use App\Models\Event;
use App\Models\Family;
use App\Models\Location;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $churches = Church::pluck('id', 'id');
        $families = Family::pluck('id', 'id');
        $communities = Community::pluck('id', 'id');
        $locations = Location::pluck('id', 'id');
        $users = User::pluck('id', 'id');

        for ($i = 0; $i < 10; $i++) {
            $data = [];
            for ($j = 0; $j < 1000; $j++) {
                $data[] = [
                    'name' => $faker->word,
                    'user_id' => $faker->randomElement($users),
                    'type' => $faker->randomElement([
                        'meal',
                        'babysitting',
                        'transportation',
                    ]),
                    'description' => $faker->paragraph,
                    'location' => $faker->streetAddress,
                    'contact_name' => $faker->firstName,
                    'contact_phone' => $faker->phoneNumber,
                    'timezone' => $faker->timezone,
                    'max_size' => $faker->numberBetween(1, 10),
                    'location_id' => $faker->randomElement($locations),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Event::insert($data);

            $data = Event::get('id')->map(function ($event) use (
                $churches,
                $families,
                $communities,
                $faker
            ) {
                $index = $faker->numberBetween(0, 2);
                $linkableType = '';
                $collection = [];
                if ($index === 0) {
                    $linkableType = "App\Models\Church";
                    $collection = $churches;
                } elseif ($index === 1) {
                    $linkableType = "App\Models\Family";
                    $collection = $families;
                } else {
                    $linkableType = "App\Models\Community";
                    $collection = $communities;
                }

                return [
                    'event_id' => $event->id,
                    'linkable_id' => $faker->randomElement($collection),
                    'linkable_type' => $linkableType,
                ];
            });

            DB::table('event_links')->insert($data->toArray());
        }
    }
}
