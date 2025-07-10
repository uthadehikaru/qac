<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Ecourse;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EcourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Course::all() as $course) {
            copy(public_path('images/qac lite.png'), public_path('storage/ecourses/'.$course->name.'.png'));
            $ecourse = Ecourse::updateOrCreate([
                'course_id' => $course->id,
            ],[
                'title' => $course->name,
                'slug' => Str::slug($course->name),
                'thumbnail' => 'ecourses/'.$course->name.'.png',
                'is_only_active_batch' => true,
            ]);

            for($i=1; $i<=4; $i++) {
                $section = Section::where('order_no', $i)->first();
                $lesson = Lesson::updateOrCreate([
                    'ecourse_id' => $ecourse->id,
                    'order_no' => $i,
                ],[
                    'section_id' => $section->id,
                    'lesson_uu' => Str::uuid(),
                    'subject' => $course->name . ' lesson ' . $i,
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.',
                ]);

                // Add media thumbnail to lesson
                if(!$lesson->getFirstMedia('thumbnail')) {
                $lesson->addMedia(public_path('images/qac lite.png'))
                    ->preservingOriginal()
                    ->toMediaCollection('thumbnail', 'public');
                }

                // Add media video to lesson
                if(!$lesson->getFirstMedia('videos')) {
                    $lesson->addMedia(public_path('storage/sample.mp4'))
                        ->preservingOriginal()
                        ->toMediaCollection('videos', 'public');
                }
            }
        }
    }
}
