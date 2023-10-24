<?php

namespace Tests\Feature;

use App\Models\Ecourse;
use App\Services\EcourseService;
use Tests\TestCase;

class EcourseTest extends TestCase
{
    public function test_table_ecourse(): void
    {
        $ecourse = Ecourse::factory()->create();
        $this->assertDatabaseCount('ecourses', 1);

        $ecourse->delete();
        $this->assertDatabaseCount('ecourses', 0);
    }

    public function test_user_can_see_ecourses_on_homepage(): void
    {
        Ecourse::factory(4)->published()->create();
        $this->assertDatabaseCount('ecourses', 4);

        $courses = (new EcourseService)->latestEcourses()->pluck('title')->toArray();

        $this->get(route('home'))
        ->assertSeeText('Online Courses')
        ->assertSeeInOrder($courses);
    }

    public function test_user_can_see_ecourse_detail(): void
    {
        $ecourse = Ecourse::factory()->published()->create();

        $this->get(route('ecourses.show', $ecourse->slug))
        ->assertSeeText($ecourse->title)
        ->assertSeeText($ecourse->description);
    }

    public function test_user_cannot_see_unpublished_ecourse(): void
    {
        $ecourse = Ecourse::factory()->create(['published_at'=>null]);

        $this->get(route('ecourses.show', $ecourse->slug))
        ->assertNotFound();
    }
}
