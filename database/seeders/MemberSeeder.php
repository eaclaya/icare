<?php

namespace Database\Seeders;


use App\Models\Location;
use App\Models\Member;
use App\Models\Role;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Silber\Bouncer\BouncerFacade as Bouncer;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $faker = Faker::create();
        $locations = Location::pluck('id');
        $lastMember = Member::orderBy('id', 'desc')->first();
        $roles = Role::pluck('name');
        $avatars = [
            'https://d9jhi50qo719s.cloudfront.net/k63/samples/pju_800.JPG?240729124942',
            'https://d9jhi50qo719s.cloudfront.net/k63/samples/pju_800.JPG?240729124942',
            'https://img.freepik.com/free-vector/smiling-redhaired-boy-illustration_1308-176664.jpg',
            'https://img.freepik.com/free-vector/young-girl-with-curly-hair_1308-176615.jpg',
            'https://www.aidemos.info/wp-content/uploads/2023/05/avatar_for_social_app_realistic_female_98944746-c433-464d-8e6c-e44ee6b6c03e.webp',
            'https://www.aidemos.info/wp-content/uploads/2023/05/3D_art_for_game_avatar_profile_4093a9b2-07b4-40b5-99e4-ac8adffccb71-1.webp',
            'https://www.aidemos.info/wp-content/uploads/2023/05/anime_style_animated_man_avatar_based_on_a_teacher_9ca04317-af62-4499-bbb0-787ca6460a6d.webp',
            'https://www.aidemos.info/wp-content/uploads/2023/05/An_avatar_of_a_smart_man_with_glasses_and_a_mustache_w_5c41acac-d69c-4981-987d-7321c3b5ca5f.webp',
        ];

        for ($i = 0; $i < 100; $i++) {
            $row = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'dob' => $faker->date,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'location_id' => $faker->randomElement($locations),
                'url_avatar' => $faker->randomElement($avatars),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $data[] = $row;
        }

        DB::table('members')->insert($data);

        $members = Member::when($lastMember, function ($query) use ($lastMember) {
            $query->where('id', '>', $lastMember->id);
        })
            ->get();


        foreach ($members as $member) {
            Bouncer::assign($faker->randomElement($roles))->to($member);
        }

    }
}
