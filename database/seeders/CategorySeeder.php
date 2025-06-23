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
        $courses = ['Tazkiyatun Nafs', 'Long Life Learning', 'Tadabbur Pemula', 'QAC Tadarus'];
        foreach ($courses as $course) {
            Category::firstOrCreate([
                'type' => 'course',
                'name' => $course,
                'slug' => Str::slug($course),
            ]);
        }

        $events = ['Free Sharing', 'Ngobrolin Quran', 'E-Book'];
        foreach ($events as $event) {
            Category::firstOrCreate([
                'type' => 'event',
                'name' => $event,
                'slug' => Str::slug($event),
            ]);
        }
    }
}
