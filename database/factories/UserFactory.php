<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public function configure()
    {
        return $this->afterMaking(function (User $user) {
            if ($user->role == 'member') {
                Member::factory()->make([
                    'user_id' => $user->id,
                    'full_name' => $user->name,
                ]);
            }
        })->afterCreating(function (User $user) {
            if ($user->role == 'member') {
                Member::factory()->create([
                    'user_id' => $user->id,
                    'full_name' => $user->name,
                ]);
            }
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'role' => 'member',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'login_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
