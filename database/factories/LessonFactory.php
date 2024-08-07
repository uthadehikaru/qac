<?php

namespace Database\Factories;

use App\Models\Ecourse;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ecourses = Ecourse::all()->pluck('id');
        $sections = Section::all()->pluck('id');
        $subject = $this->faker->sentence(3);

        return [
            'lesson_uu' => $this->faker->uuid(),
            'ecourse_id' => $this->faker->randomElement($ecourses),
            'section_id' => $this->faker->randomElement($sections),
            'subject' => $subject,
            'order_no' => $this->faker->numberBetween(0, 10),
            'thumbnail' => 'lessons/qac 1.jpg',
            'description' => $this->faker->sentence(),
        ];
    }
}
