<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $teams = Team::latest('id')->take(100)->pluck('id');
        $lastMember = Member::latest('id')->first();

        $teamMembers = Member::query()
            ->select('id', 'email', 'first_name', 'last_name')
            ->when($lastMember, function ($query) use ($lastMember) {
                $query->where('id', '>', $lastMember->id);
            })
            ->get()
            ->map(function ($member) use ($teams, $faker) {
                return [
                    'member_id' => $member->id,
                    'team_id' => $faker->randomElement($teams),
                    'role' => $faker->randomElement([
                        'Team Leader',
                        'Volunteer',
                    ]),
                ];
            });
            try {
                DB::table('team_member')->insert($teamMembers->toArray());
            } catch (\Exception $e) {}

    }
}
