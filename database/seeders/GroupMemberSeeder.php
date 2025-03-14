<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GroupMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = Group::doesntHave('members')->pluck('id');
        $members = Member::doesntHave('user')->pluck('id');
        $faker = Faker::create();

        $data = [];

        foreach ($groups as $family) {
            $data[] = [
                'group_id' => $family,
                'member_id' => $members->random(),
                'role' => $faker->randomElement([
                    'Parent',
                    'Children',
                    'Other'
                ]),
            ];
        }

        DB::table('group_member')->insert($data);
    }
}
