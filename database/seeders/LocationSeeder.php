<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::create([
            'id' => '11',
            'name' => 'ACEH',
        ]);

        Regency::create([
            'id' => '1101',
            'name' => 'KABUPATEN SIMEULUE',
            'province_id' => '11',
        ]);

        District::create([
            'id' => '1101010',
            'name' => 'TEUPAH SELATAN',
            'regency_id' => '1101',
        ]);

        Village::create([
            'id' => '1101010001',
            'name' => 'LATIUNG',
            'district_id' => '1101010',
        ]);
    }
}
