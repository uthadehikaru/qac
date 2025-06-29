<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = ['Tazkiyatun Nafs', 'Long Life Learning', 'Tadabbur Pemula', 'QAC Tadarus', 'Coming Soon'];
        foreach ($courses as $course) {
            Category::firstOrCreate([
                'name' => $course,
                'slug' => Str::slug($course),
            ],[
                'type' => 'course',
            ]);
        }

        $frees = ['Free Sharing', 'Ngobrolin Quran', 'E-Book'];
        foreach ($frees as $free) {
            Category::firstOrCreate([
                'name' => $free,
                'slug' => Str::slug($free),
            ],[
                'type' => 'event',
            ]);
        }
    }
}
