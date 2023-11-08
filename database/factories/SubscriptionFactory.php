<?php

namespace Database\Factories;

use App\Models\Ecourse;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ecourse = Ecourse::inRandomOrder()->take(1)->first();
        $member = Member::inRandomOrder()->take(1)->first();
        return [
            'ecourse_id' => $ecourse->id,
            'member_id' => $member->id,
            'start_date' => $this->faker->dateTimeThisMonth(),
            'end_date' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
