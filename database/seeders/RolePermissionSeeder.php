<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('abilities')->delete();
        \DB::table('roles')->delete();

        // Create roles
        $admin = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        $churchManager = Bouncer::role()->firstOrCreate([
            'name' => 'church_manager',
            'title' => 'Church Manager',
        ]);

        $familyManager = Bouncer::role()->firstOrCreate([
            'name' => 'family_manager',
            'title' => 'Family Manager',
        ]);

        $communityManager = Bouncer::role()->firstOrCreate([
            'name' => 'community_manager',
            'title' => 'Community Manager',
        ]);

        // Create abilities
        $manageFamilies = Bouncer::ability()->firstOrCreate([
            'name' => 'manage-families',
            'title' => 'Manage Families',
        ]);

        $manageCommunities = Bouncer::ability()->firstOrCreate([
            'name' => 'manage-communities',
            'title' => 'Manage Communities',
        ]);

        $manageChurches = Bouncer::ability()->firstOrCreate([
            'name' => 'manage-churches',
            'title' => 'Manage Churches',
        ]);

        $manageMembers = Bouncer::ability()->firstOrCreate([
            'name' => 'manage-members',
            'title' => 'Manage Members',
        ]);

        $editChurch = Bouncer::ability()->firstOrCreate([
            'name' => 'edit-church',
            'title' => 'Edit Church',
        ]);

        $deleteChurch = Bouncer::ability()->firstOrCreate([
            'name' => 'delete-church',
            'title' => 'Delete Church',
        ]);

        // Assign abilities to roles
        // Admin has access to everything
        Bouncer::allow($admin)->everything();

        // Church Manager has access to everything except editing/deleting a church
        Bouncer::allow($churchManager)->to($manageFamilies);
        Bouncer::allow($churchManager)->to($manageCommunities);
        Bouncer::allow($churchManager)->to($manageChurches);
        Bouncer::allow($churchManager)->to($manageMembers);
        Bouncer::forbid($churchManager)->to($editChurch);
        Bouncer::forbid($churchManager)->to($deleteChurch);

        // Family Manager has access to their family and members
        Bouncer::allow($familyManager)->to($manageFamilies);
        Bouncer::allow($familyManager)->to($manageMembers);

        // Community Manager has access to their community and the family linked to it
        Bouncer::allow($communityManager)->to($manageCommunities);
        Bouncer::allow($communityManager)->to($manageFamilies);
    }
}
