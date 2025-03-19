<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Event;
use App\Models\Group;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $roles = Bouncer::role()->count();
        $abilities = Bouncer::ability()->count();
        if ($roles > 0 && $abilities > 0) {
            return;
        }

        // Create Roles
        $superadmin = Bouncer::role()->create([
            'name' => 'superadmin',
            'title' => 'Super Administrator',
        ]);

        $admin = Bouncer::role()->create([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        $teamLeader = Bouncer::role()->create([
            'name' => 'team leader',
            'title' => 'Team Leader',
        ]);

        $volunteer = Bouncer::role()->create([
            'name' => 'volunteer',
            'title' => 'Volunteer',
        ]);

        // Create Abilities (Permissions)
        $resources = [
            'groups' => Group::class, 'teams' => Team::class, 'events' => Event::class, 'organizations' => Organization::class,
        ];

        foreach ($resources as $resource => $model) {
            Bouncer::ability()->create(['name' => "create", 'entity_type' => $model]);
            Bouncer::ability()->create(['name' => "view", 'entity_type' => $model]);
            Bouncer::ability()->create(['name' => "edit", 'entity_type' => $model]);
            Bouncer::ability()->create(['name' => "delete", 'entity_type' => $model]);
        }

        // Assign Abilities to Roles
        // Superadmin has all abilities
        Bouncer::allow('superadmin')->to('*');

        // Admin has all abilities except for tenants
        foreach ($resources as $resource => $model) {
            Bouncer::allow('admin')->to("view", $model);
            Bouncer::allow('admin')->to("create", $model);
                Bouncer::allow('admin')->to("edit", $model);
            if ($resource !== 'organizations') {
                Bouncer::allow('admin')->to("delete", $model);
            }
        }

    }
}
