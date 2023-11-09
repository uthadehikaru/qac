<?php

namespace Database\Seeders;

use App\Models\Ecourse;
use App\Models\Lesson;
use App\Models\Member;
use App\Models\Section;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EcourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ecourses = Ecourse::factory(10)->create();
        foreach($ecourses as $ecourse){
            $members = Member::inRandomOrder()->take(5)->get();
            foreach($members as $member){
                Subscription::factory()->create([
                    'ecourse_id' => $ecourse->id,
                    'member_id' => $member->id,
                ]);
            }
        }
    }
}
