<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChurchMemberRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $churches = Church::pluck('id');

    }
}
