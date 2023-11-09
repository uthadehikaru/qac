<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = ['Introduction','Textbooks & Resources','Homework & Course Planner','Week 1','Week 2'];
        foreach($sections as $no=>$section)
            Section::factory()->create(['order_no'=>$no,'name'=>$section]);
    }
}
