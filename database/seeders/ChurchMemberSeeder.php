<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Church;
use App\Models\Community;
use App\Models\Location;
use App\Models\Member;
use App\Models\Role;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ChurchMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();
        $churches = Church::pluck('id');

        $churchMembers = Member::query()
            ->select('id', 'email', 'first_name', 'last_name')
            ->get()
            ->map(function ($member) use ($churches, $faker) {
                return [
                    'member_id' => $member->id,
                    'church_id' => $faker->randomElement($churches),
                    'church_type' => $faker->randomElement([
                        'Home Church',
                        'Serving Church',
                        'Other',
                    ]),
                ];
            });

        DB::table('church_member')->insert($churchMembers->toArray());
    }
}
