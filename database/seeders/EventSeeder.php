<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\Team;
use App\Models\Event;
use App\Models\Group;
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
        $groups = Group::orderBy('id', 'desc')->take(100)->pluck('id', 'id');
        $teams = Team::orderBy('id', 'desc')->take(100)->pluck('id', 'id');
        $locations = Location::orderBy('id', 'desc')->take(100)->pluck('id', 'id');
        $users = User::orderBy('id', 'desc')->take(100)->pluck('id', 'id');

        $now = now()->format('Y-m-d H:i:s');;
        foreach (range(1, 100) as $index) {
            $data = [];
            $lastEvent = Event::latest('id')->first();
            foreach (range(1,1000) as $index) {
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
                    'location_id' => $faker->randomElement($locations),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            Event::insert($data);

            $data = Event::query()
                ->when($lastEvent, function ($query) use ($lastEvent) {
                    $query->where('id', '>', $lastEvent->id);
                })
                ->get('id')
                ->map(function ($event) use (
                    $groups,
                    $teams,
                    $faker
                ) {
                    $index = $faker->numberBetween(0, 1);
                    $linkableType = '';
                    $collection = [];
                    if ($index === 0) {
                        $linkableType = "App\Models\Group";
                        $collection = $groups;
                    } else {
                        $linkableType = "App\Models\Team";
                        $collection = $teams;
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
