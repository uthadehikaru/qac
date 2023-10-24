<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ecourse>
 */
class EcourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        $price = $this->faker->numberBetween(100000, 500000);
        return [
            'title' => $title,
            'slug' => Str::slug($title.' '.Str::random(5)),
            'description'=> $this->faker->text,
            'thumbnail' => $this->faker->image(),
            'price' => $price,
            'price_sell' => $price-$this->faker->numberBetween(100000, $price),
            'views' => $this->faker->numberBetween(0, 1000),
            'published_at' => $this->faker->boolean(70)?$this->faker->dateTimeThisYear():null,
        ];
    }

    public function published(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => $this->faker->dateTimeThisYear(),
            ];
        });
    }
}
