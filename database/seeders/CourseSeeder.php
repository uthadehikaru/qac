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
        $courses = [1=>'QAC 1.0',2=>'QAC 2.1', 3=>'QAC 2.2'];
        foreach($courses as $level=>$course){
            Course::create([
                'id'=>$level,
                'name'=>$course,
                'description'=>'',
                'fee'=>0,
                'level'=>$level,
            ]);
        }
    }
}
