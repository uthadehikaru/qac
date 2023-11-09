<?php

namespace Database\Seeders;

use App\Models\Ecourse;
use App\Models\File;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public/files');

        foreach(Ecourse::all() as $ecourse){
            $lessons = Lesson::factory(5)->for($ecourse)->create();
            foreach($lessons as $lesson){
                File::factory()->create([
                    'tablename' => 'lessons',
                    'record_id' => $lesson->id,
                ]);
            }
        }
    }
}
