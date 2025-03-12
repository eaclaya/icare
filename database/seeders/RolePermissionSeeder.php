<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Clear existing roles and abilities
        Bouncer::role()->query()->delete();
        Bouncer::ability()->query()->delete();

        // Create Roles
        $superadmin = Bouncer::role()->create([
            'name' => 'superadmin',
            'title' => 'Super Administrator',
        ]);

        $admin = Bouncer::role()->create([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        $manager = Bouncer::role()->create([
            'name' => 'manager',
            'title' => 'Manager',
        ]);

        $member = Bouncer::role()->create([
            'name' => 'member',
            'title' => 'Member',
        ]);

        // Create Abilities (Permissions)
        $resources = [
            'tenants', 'families', 'communities', 'events', 'churches',
        ];

        foreach ($resources as $resource) {
            Bouncer::ability()->create(['name' => "create {$resource}"]);
            Bouncer::ability()->create(['name' => "view {$resource}"]);
            Bouncer::ability()->create(['name' => "edit {$resource}"]);
            Bouncer::ability()->create(['name' => "delete {$resource}"]);
        }

        // Assign Abilities to Roles
        // Superadmin has all abilities
        Bouncer::allow('superadmin')->to('*');

        // Admin has all abilities except for tenants
        foreach ($resources as $resource) {
            if ($resource !== 'tenants') {
                Bouncer::allow('admin')->to("create {$resource}");
                Bouncer::allow('admin')->to("view {$resource}");
                Bouncer::allow('admin')->to("edit {$resource}");
                Bouncer::allow('admin')->to("delete {$resource}");
            }
        }

        // Manager has limited abilities
        foreach ($resources as $resource) {
            if ($resource !== 'tenants') {
                Bouncer::allow('manager')->to("create {$resource}");
                Bouncer::allow('manager')->to("view {$resource}");
                Bouncer::allow('manager')->to("edit {$resource}");
                if ($resource !== 'churches' && $resource !== 'fams') {
                    Bouncer::allow('manager')->to("delete {$resource}");
                }
            }
        }

        // Member has limited abilities
        Bouncer::allow('member')->to('view volunteers');
        Bouncer::allow('member')->to('view advocates');
        Bouncer::allow('member')->to('create events');
        Bouncer::allow('member')->to('view events');

        // // Assign Roles to Users (Example)
        // $user1 = User::find(1); // Example user
        // Bouncer::assign('Superadmin')->to($user1);

        // $user2 = User::find(2); // Example user
        // Bouncer::assign('Member')->to($user2);

        // // Assign Scoped Permissions (Example)
        // $community1 = Community::find(1);
        // $community2 = Community::find(2);

        // // User 2 has scoped permissions for Community 1
        // Bouncer::allow($user2)->to('view communities', $community1);
        // Bouncer::allow($user2)->to('edit communities', $community1);

        // // User 2 has scoped permissions for Community 2
        // Bouncer::allow($user2)->to('view communities', $community2);
    }
}
