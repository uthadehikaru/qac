<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Ecourse;
use Illuminate\Database\Seeder;

class EcourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        copy(public_path('images\QAC 1.0.jpg'), public_path('storage\ecourses\qac 1.jpg'));
        Ecourse::factory(5)->published()->create();
        $courses = Course::all();
        foreach ($courses as $course) {
            Ecourse::factory()->unpublished()->for($course)->create(['title' => $course->name]);
        }
    }
}
