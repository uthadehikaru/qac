<?php

namespace Database\Seeders;

use App\Models\Certificate;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Certificate::create([
            'id' => 1,
            'name' => 'Sertifikat',
            'template' => '',
            'config' => '',
        ]);
    }
}
