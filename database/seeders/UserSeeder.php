<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\Member;
use App\Models\Role;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $lastUser = User::orderBy('id', 'desc')->first();
        $churches = Church::pluck('id');
        $roles = Role::pluck('id');

        $users = Member::with('churches')
            ->orderBy('id', 'desc')
            ->take(100)
            ->get()
            ->map(function ($member) use (&$churches) {
                if (isset($churches[$member->id]) === false) {
                    $churches[$member->id] = [];
                }
                $churches[$member->id] = $member->churches->map(fn ($church) => ['church_id' => $church->id, 'church_type' => $church->church_type])->toArray();

                return [
                    'member_id' => $member->id,
                    'name' => "{$member->first_name} {$member->last_name}",
                    'email' => $member->email,
                    'password' => '$2y$12$eo/yY.R4V7hbdB.kwawQ5eUVC1DxTjjPOlsvEYsaxijWSfDWtPtne', // password
                ];
            });

        User::insert($users->toArray());

        $users = User::with(['churches'])
            ->when($lastUser, function ($query) use ($lastUser) {
                return $query->where('id', '>', $lastUser->id);
            })
            ->get();

        $data = [];

        foreach ($users as $user) {
            foreach ($user->churches as $church) {
                $randomRole = $faker->randomElement($roles);
                $data[] = [
                    'role_id' => $randomRole,
                    'entity_id' => $user->id,
                    'entity_type' => User::class,
                    'scope' => $church->id,
                ];
            }
        }

        \DB::table('assigned_roles')->insert($data);
    }
}
