<?php

namespace Database\Seeders;

use App\Models\Ecourse;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Ecourse::all() as $ecourse)
            Lesson::factory(10)->for($ecourse)->create();
    }
}
