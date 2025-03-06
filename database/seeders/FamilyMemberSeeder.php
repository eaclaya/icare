<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilyMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $families = Family::doesntHave("familyMembers")->pluck("id");

        $members = Member::doesntHave("user")->pluck("id");

        $data = [];

        foreach ($families as $family) {
            $data[] = [
                "family_id" => $family,
                "member_id" => $members->random(),
            ];
            $data[] = [
                "family_id" => $family,
                "member_id" => $members->random(),
            ];
        }

        \DB::table("family_member")->insert($data);
    }
}
