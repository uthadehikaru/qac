<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['pria', 'wanita']),
            'phone' => $this->faker->e164PhoneNumber(),
        ];
    }
}
