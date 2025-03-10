<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CommunityMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $communities = Community::pluck('id');

        $communityMembers = Member::query()
            ->select('id', 'email', 'first_name', 'last_name')
            ->get()
            ->map(function ($member) use ($communities, $faker) {
                return [
                    'member_id' => $member->id,
                    'community_id' => $faker->randomElement($communities),
                    'role' => $faker->randomElement([
                        'Team Leader',
                        'Volunteer',
                        'Meal Provider',
                    ]),
                ];
            });

            DB::table('community_member')->insert($communityMembers->toArray());
    }
}
