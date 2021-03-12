<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\System;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testimonials[] = [
            'name'=>'Andrew - Freelancer',
            'title'=>'QAC 1',
            'message'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sagittis turpis at purus fermentum placerat. Nullam at justo ut sem eleifend viverra. Proin vehicula at sapien non dignissim.',
        ];
        $testimonials[] = [
            'name'=>'Diana - Apoteker',
            'title'=>'QAC 2.1',
            'message'=>'Nulla facilisi. Curabitur eu nisi magna. Phasellus mollis vel sapien sit amet fermentum. Cras mattis iaculis scelerisque. Suspendisse quis nisi est. Nulla facilisi.',
        ];
        $testimonials[] = [
            'name'=>'Laila - Dosen',
            'title'=>'QAC 2.2',
            'message'=>'In at tristique tellus. Vestibulum porttitor orci vitae arcu porttitor venenatis. Quisque a aliquet lorem, vitae efficitur purus. Interdum et malesuada fames ac ante ipsum primis in faucibus.',
        ];

        System::create([
            'key'=>'testimonials',
            'value'=>json_encode($testimonials),
            'is_array'=>true,
        ]);

        $faqs = [];
        for($i=1;$i<=10;$i++){
            $faqs[] = [
                'title'=>'Question '.$i,
                'message'=>'In at tristique tellus. Vestibulum porttitor orci vitae arcu porttitor venenatis. Quisque a aliquet lorem, vitae efficitur purus. Interdum et malesuada fames ac ante ipsum primis in faucibus.',
            ];    
        }
        
        System::create([
            'key'=>'faqs',
            'value'=>json_encode($faqs),
            'is_array'=>true,
        ]);

        System::create([
            'key'=>'whatsapp',
            'value'=>'62895423485054',
            'is_array'=>false,
        ]);
    }
}
