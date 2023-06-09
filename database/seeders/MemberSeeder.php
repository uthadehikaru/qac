<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Member::factory()->count(100)
        ->for(\App\Models\User::factory())
        ->create();
    }
}
