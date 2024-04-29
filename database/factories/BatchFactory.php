<?php

namespace Database\Factories;

use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BatchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Batch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        $start = Carbon::createFromDate($this->faker->dateTimeThisYear());

        return [
            'course_id' => 0,
            'name' => $title,
            'description' => $title,
            'sessions' => '',
            'registration_start_at' => $start,
            'registration_end_at' => $start->addWeek(),
            'start_at' => $start->addWeek(),
            'end_at' => $start->addWeek(),
            'certificate_id' => null,
        ];
    }
}
