<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;

        return [
            'title' => $title,
            'slug' => Str::slug($title.' '.Str::random(5)),
            'event_at' => $this->faker->dateTime,
            'content' => $this->faker->text,
            'is_public' => $this->faker->boolean,
            'views' => $this->faker->numberBetween(100, 500),
        ];
    }
}
