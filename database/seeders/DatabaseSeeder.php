<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@qacjakarta.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role'=>'admin',
        ]);

        if(env('APP_ENV')!='production'){
            $user = \App\Models\User::create([
                'name' => 'Member',
                'email' => 'member@qacjakarta.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'role'=>'member',
            ]);

            \App\Models\Member::create([
                'user_id' => $user->id,
                'full_name' => 'Member QAC',
                'gender' => 'pria',
                'phone' => '081112341234',
                'address' => 'Jakarta, Indonesia',
                'city' => 'Jakarta',
                'instagram' => 'memberqac',
            ]);
        }
    }
}
