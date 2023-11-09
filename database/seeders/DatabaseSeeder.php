<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::firstOrCreate([
            'email' => 'admin@qacjakarta.id',
            'role'=>'admin',
        ],[
            'name' => 'Admin',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $seeders = [
            SystemSeeder::class,
            CourseSeeder::class,
            BatchSeeder::class,
        ];

        $sql = ['provinces','districts','regencies','villages'];
        foreach($sql as $q){
            $path = base_path('database/indonesia/'.$q.'.sql');
            DB::unprepared(file_get_contents($path));
            $this->command->info($q.' table seeded!');
        }

        if(config('app.env','local')){
            $seeders[] = EventSeeder::class;
            $seeders[] = UserSeeder::class;
            $seeders[] = CertificateSeeder::class;
            $seeders[] = SectionSeeder::class;
            $seeders[] = EcourseSeeder::class;
            $seeders[] = LessonSeeder::class;
            //$seeders[] = SubscriptionSeeder::class;
        }

        $this->call($seeders);
    }
}
