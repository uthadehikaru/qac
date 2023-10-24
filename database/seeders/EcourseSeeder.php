<?php

namespace Database\Seeders;

use App\Models\Ecourse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EcourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ecourse::factory(20)->create();
    }
}
