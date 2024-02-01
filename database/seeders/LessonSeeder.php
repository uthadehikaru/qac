<?php

namespace Database\Seeders;

use App\Models\Ecourse;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $check = copy(public_path('images\QAC 1.0.jpg'), public_path('storage\lessons\qac 1.jpg'));
        foreach(Ecourse::all() as $ecourse){
            foreach(Section::all() as $section){
                $lessons = Lesson::factory(2)->for($ecourse)->for($section)->create();
                foreach($lessons as $lesson){
                    $path = storage_path('sample/video/lesson.mp4');
                    $lesson->addMedia($path)->preservingOriginal()->toMediaCollection('videos');
                }
            }
        }
    }
}
