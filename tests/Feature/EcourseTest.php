<?php

namespace Tests\Feature;

use App\Models\Ecourse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EcourseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_table_ecourse(): void
    {
        $ecourse = Ecourse::factory()->create();
        $this->assertDatabaseCount('ecourses', 1);

        $ecourse->delete();
        $this->assertDatabaseCount('ecourses', 0);
    }
}
