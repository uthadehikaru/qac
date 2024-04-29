<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;

        return [
            'name' => $title,
            'description' => $this->faker->text(),
            'fee' => $this->faker->numberBetween(100000, 200000),
            'level' => 1,
            'is_active' => 1,
        ];
    }
}
