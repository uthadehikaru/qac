<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [1=>'QAC 1.0',2=>'QAC 2.0', 3=>'QAC 3.0'];
        foreach($courses as $level=>$course){
            Course::factory()->create([
                'id'=>$level,
                'name'=>$course,
                'level'=>$level,
            ]);
        }
    }
}
