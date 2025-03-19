<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RolePermissionSeeder::class,
            LocationSeeder::class,
            EntityTypeSeeder::class,
            OrganizationSeeder::class,
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
