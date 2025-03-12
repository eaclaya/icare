<?php

namespace Database\Seeders;

use App\Models\Affiliate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Church;
use App\Models\Community;
use App\Models\Location;
use App\Models\Member;
use App\Models\Role;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AffiliateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $affiliates = Affiliate::pluck('id');
        $users = User::pluck('id');

        foreach ($affiliates as $affiliate) {
            $data = $users->map(fn ($user)  => ['user_id' => $user, 'tenant_id'=> $affiliate]);

            DB::table('tenant_user')->insert($data->toArray());
        }

    }
}
