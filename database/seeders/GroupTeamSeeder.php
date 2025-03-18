<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = Team::latest('id')->take(1000)->pluck('id');

        $groups = Group::latest('id')->take(1000)->pluck('id');

        $data = [];

        foreach ($groups as $group) {
            $data[] = [
                'group_id' => $group,
                'team_id' => $teams->random(),
            ];
        }
        try {
            DB::table('group_team')->insert($data);
        } catch (\Exception $e) {}

    }
}
