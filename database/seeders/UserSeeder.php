<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\Member;
use App\Models\Role;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $roles = Role::where('name', 'volunteer')->pluck('id');
        $lastUser = User::latest('id')->first();
        $now = now()->format('Y-m-d H:i:s');
        $users = Member::query()
            ->orderBy('id', 'desc')
            ->take(100)
            ->get()
            ->map(function ($member) use ($now) {

                return [
                    'member_id' => $member->id,
                    'name' => "{$member->first_name} {$member->last_name}",
                    'email' => $member->email,
                    'password' => '$2y$12$eo/yY.R4V7hbdB.kwawQ5eUVC1DxTjjPOlsvEYsaxijWSfDWtPtne', // password
                    'created_at' => $now,
                ];
            });

        try {
            User::insert($users->toArray());

            $users = User::query()
                ->when($lastUser, function ($query) use ($lastUser) {
                    return $query->where('id', '>', $lastUser->id);
                })
                ->pluck('id');

            $data = [];

            foreach ($users as $user) {

                $randomRole = $faker->randomElement($roles);
                $data[] = [
                    'role_id' => $randomRole,
                    'entity_id' => $user,
                    'entity_type' => User::class,
                ];

            }

            DB::table('assigned_roles')->insert($data);
        } catch (\Exception $e) {}

    }
}
