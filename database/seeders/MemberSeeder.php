<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'member_code' => Member::generateMemberCode(),
                'name' => 'Budi Santoso',
                'email' => 'budi@email.com',
                'phone' => '08123456789',
                'address' => 'Jl. Merdeka No. 10',
                'join_date' => now()
            ],
            [
                'member_code' => 'MBR00002',
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@email.com',
                'phone' => '08987654321',
                'address' => 'Jl. Sudirman No. 5',
                'join_date' => now()->subDays(30)
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}