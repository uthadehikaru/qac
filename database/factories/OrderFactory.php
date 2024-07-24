<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => 0,
            'price' => $this->faker->randomDigit(),
            'months' => $this->faker->randomDigit(),
            'total' => $this->faker->randomDigit(),
            'start_date' => $this->faker->dateTimeThisMonth(),
            'end_date' => $this->faker->dateTimeThisMonth(),
            'verified_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
