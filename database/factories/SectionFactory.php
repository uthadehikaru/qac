<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word();
        return [
            'name' => $name,
            'order_no' => $this->faker->numberBetween(0,10),
            'thumbnail' => 'sections/'.$this->faker->image(storage_path('app/public/sections'), 600, 400, null, false, false, $name, true),
        ];
    }
}
