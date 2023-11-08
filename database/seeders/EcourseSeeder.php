<?php

namespace Database\Seeders;

use App\Models\Ecourse;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EcourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ecourse::factory(10)->create();
    }
}
