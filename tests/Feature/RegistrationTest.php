<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Course;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Database\Seeders\LocationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LocationSeeder::class);
    }

    public function test_registration_screen_can_be_rendered()
    {
        $current = CarbonImmutable::now();
        $batch = Batch::factory()->for(Course::factory())->create([
            'registration_start_at' => $current->subWeek(),
            'registration_end_at' => $current->addWeek(),
            'start_at' => $current->addWeeks(2),
            'end_at' => $current->addWeeks(3),
        ]);

        $response = $this->get(route('register', ['course_id'=>$batch->course_id]));

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $current = CarbonImmutable::now();
        $batch = Batch::factory()->for(Course::factory())->create([
            'registration_start_at' => $current->subWeek(),
            'registration_end_at' => $current->addWeek(),
            'start_at' => $current->addWeeks(2),
            'end_at' => $current->addWeeks(3),
        ]);

        $response = $this->post(route('register', ['batch_id'=>$batch->id]), [
            'name' => 'Test User',
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '08123412341234',
            'gender' => 'pria',
            'session' => '',
            'address' => 'test',
            'village_id' => '1101010001',
            'zipcode' => '12345',
            'profesi' => 'profesi',
            'pendidikan' => 'pendidikan',
            'instagram' => '',
            'batch_id' => $batch->id,
            'course_id' => $batch->course_id,
            'term_condition'=>1,
        ]);

        $this->assertAuthenticated();
    }
}
