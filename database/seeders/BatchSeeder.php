<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            1=>['1','2','3','4','5','6','7','8','9','Bantim 2','banut','Benhil','Cibubur','Cinere','Kemang','Mom & Kids','Pekayon','Pondok Indah 2','Rawa Belong','RS Suyoto'],
            2=>['1','2','3','4','5','6'],
            3=>['1'],
        ];
        foreach($courses as $course_id=>$batches){
            foreach($batches as $batch){
                Batch::create([
                    'course_id'=>$course_id,
                    'name'=>$batch,
                ]);
            }
        }
    }
}