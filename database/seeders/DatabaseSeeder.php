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

        $seeders = [
            SystemSeeder::class,
            CourseSeeder::class,
            BatchSeeder::class,
            EventSeeder::class,
        ];

        if(config('app.env','local')){
            $seeders[] = UserSeeder::class;
        }

        $this->call($seeders);
    }
}
