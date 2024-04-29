<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()->count(100)
            ->has(\App\Models\Member::factory()->state(function (array $attributes, User $user) {
                return ['full_name' => $user->name];
            }))
            ->create();
    }
}
