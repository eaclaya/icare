<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ChurchSeeder::class,
            TeamSeeder::class,
            MemberSeeder::class,
            FamilySeeder::class,
            PetSeeder::class,
            GroupSeeder::class,
            TeamMemberSeeder::class,
            GroupMemberSeeder::class,
            GroupTeamSeeder::class,
            UserSeeder::class,
            EventSeeder::class,
        ]);
    }
}
