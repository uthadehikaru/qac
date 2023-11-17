<?php

namespace Database\Factories;

use App\Models\Ecourse;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $file = $this->faker->file(storage_path('sample/video'), storage_path('app/public/files'), false);
        return [
            'name' => $this->faker->name(),
            'type' => 'mp4',
            'filename' => 'files/'.$file,
            'size' => $this->faker->numberBetween(100,10000),
            'tablename' => 'table',
            'record_id' => 0,
        ];
    }
}
