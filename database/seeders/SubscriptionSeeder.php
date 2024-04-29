<?php

namespace Database\Seeders;

use App\Models\Ecourse;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Ecourse::all() as $ecourse) {
            Subscription::factory(100)->for($ecourse)->create();
        }
    }
}
