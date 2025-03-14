<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntityTypeSeeder extends Seeder
{

    protected $teamTypes = [
        ['name' => 'Community'],
        ['name' => 'FAM'],
    ];

    protected $groupTypes = [
        ['name' => 'Family'],
        ['name' => 'Pet'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::table('team_types')->insert($this->teamTypes);
            DB::table('group_types')->insert($this->groupTypes);
        } catch (\Exception $e) {
        }

    }
}
