<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $check = copy(public_path('images\QAC 1.0.jpg'), public_path('storage\sections\qac 1.jpg'));
        $sections = ['Perkenalan', 'Teks dan Sumber', 'Tugas dan Rencana Kelas', 'Pekan 1', 'Pekan 2'];
        foreach ($sections as $no => $section) {
            Section::factory()->create(['order_no' => $no, 'name' => $section]);
        }
    }
}
