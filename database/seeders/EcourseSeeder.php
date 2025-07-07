<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Ecourse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EcourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        copy(public_path('images\QAC 1.0.jpg'), public_path('storage\ecourses\qac 1.jpg'));
        foreach(Course::all() as $course) {
            Ecourse::firstOrCreate([
                'course_id' => $course->id,
            ],[
                'title' => $course->name,
                'slug' => Str::slug($course->name),
                'thumbnail' => 'ecourses/qac 1.jpg',
                'is_only_active_batch' => true,
            ]);
        }
    }
}
