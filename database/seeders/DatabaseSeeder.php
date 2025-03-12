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
        if (tenancy()->tenant) {
            $this->call([
                RolePermissionSeeder::class,
                LocationSeeder::class,
                ChurchSeeder::class,
                FamilySeeder::class,
                CommunitySeeder::class,
                MemberSeeder::class,
                ChurchMemberSeeder::class,
                CommunityMemberSeeder::class,
                UserSeeder::class,
                EventSeeder::class,
                AffiliateUserSeeder::class,
            ]);
        }
    }
}
