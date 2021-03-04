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
            'name'=>'Member 1',
            'title'=>'job title',
            'message'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sagittis turpis at purus fermentum placerat. Nullam at justo ut sem eleifend viverra. Proin vehicula at sapien non dignissim.',
        ];
        $testimonials[] = [
            'name'=>'Member 2',
            'title'=>'job title',
            'message'=>'Nulla facilisi. Curabitur eu nisi magna. Phasellus mollis vel sapien sit amet fermentum. Cras mattis iaculis scelerisque. Suspendisse quis nisi est. Nulla facilisi.',
        ];
        $testimonials[] = [
            'name'=>'Member 3',
            'title'=>'job title',
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
    }
}
