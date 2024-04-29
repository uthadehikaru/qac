<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        System::firstOrCreate([
            'key' => 'about_1',
        ], [
            'value' => '{"title":"Apa itu QAC?","content":"QAC adalah singkatan dari Qur\'anic Arabic Course."}',
            'is_array' => true,
        ]);

        System::firstOrCreate([
            'key' => 'about_2',
        ], [
            'value' => '{"title":"Apa saja kelas di QAC?","content":"terdiri dari 3 level: level 1 QAC 1.0, level 2 QAC 2.1, level 2 QAC 2.2"}',
            'is_array' => true,
        ]);

        System::firstOrCreate([
            'key' => 'whatsapp',
        ], [
            'value' => '62895423485054',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'waitinglist',
        ], [
            'value' => 0,
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'popup_image',
        ], [
            'value' => '',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'popup_active',
        ], [
            'value' => 0,
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'why1',
        ], [
            'value' => 'Kenapa perlu belajar Bahasa Arab?',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'why2',
        ], [
            'value' => 'Kenapa belajar Bahasa Arab di QAC?',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'whatsapp_ecourse',
        ], [
            'value' => '62811111111',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'subscription_fee',
        ], [
            'value' => '30000',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'ecource_access_month',
        ], [
            'value' => '1',
            'is_array' => false,
        ]);
    }
}
