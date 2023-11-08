<?php

namespace Database\Seeders;

use App\Models\Ecourse;
use App\Models\File;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Ecourse::all() as $ecourse){
            $lessons = Lesson::factory(10)->for($ecourse)->create();
            foreach($lessons as $lesson){
                File::factory()->create([
                    'tablename' => 'lessons',
                    'record_id' => $lesson->id,
                ]);
            }
        }
    }
}
