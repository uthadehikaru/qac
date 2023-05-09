<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;
use Carbon\CarbonImmutable;

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
        
            if(config('app.env','local')){
                Batch::create([
                    'course_id'=>$course_id,
                    'name'=>'Testing',
                    'description'=>'testing',
                    'sessions'=>'testing',
                    'registration_start_at'=>CarbonImmutable::now()->startOfMonth(),
                    'registration_end_at'=>CarbonImmutable::now()->endOfMonth(),
                    'start_at'=>CarbonImmutable::now()->addMonth()->startOfMonth(),
                    'end_at'=>CarbonImmutable::now()->addMonth()->endOfMonth(),
                ]);
            }
        }
    }
}
