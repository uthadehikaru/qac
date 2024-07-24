<?php

namespace Tests\Feature;

use App\Models\Ecourse;
use App\Models\Lesson;
use App\Models\Member;
use App\Models\Order;
use App\Models\Section;
use App\Models\System;
use App\Models\User;
use App\Services\EcourseService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Mail;
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

    public function test_guest_can_see_ecourses_on_homepage(): void
    {
        Ecourse::factory(4)->published()->create();
        $this->assertDatabaseCount('ecourses', 4);

        $courses = (new EcourseService)->latestEcourses()->pluck('title')->toArray();

        $this->get(route('home'))
            ->assertSeeText('Online Courses')
            ->assertSeeInOrder($courses);
    }

    public function test_guest_can_see_ecourse_detail(): void
    {
        $ecourse = Ecourse::factory()->has(Lesson::factory(3)->for(Section::factory()))->published()->create();
        $lessons = $ecourse->lessons->pluck('subject')->toArray();

        $this->get(route('ecourses.show', $ecourse->slug))
            ->assertSeeText($ecourse->title)
            ->assertSeeText($ecourse->description)
            ->assertSeeTextInOrder($lessons);
    }

    public function test_user_can_see_ecourse_video(): void
    {
        $member = Member::factory()->for(User::factory()->create(['role'=>'member']))->create();
        Order::factory()->for($member)->create([
            'start_date' => CarbonImmutable::now()->subMonth(),
            'end_date' => CarbonImmutable::now()->addMonth(),
            'verified_at' => CarbonImmutable::now(),
        ]);
        $ecourse = Ecourse::factory()->has(Lesson::factory(3)->for(Section::factory()))->published()->create();
        $lesson = $ecourse->lessons->first();

        $this->actingAs($member->user)->get(route('member.ecourses.lessons', [$ecourse->slug, $lesson->section->id]))
        ->assertSee($lesson->subject);
    }

    public function test_user_cannot_see_unpublished_ecourse(): void
    {
        $ecourse = Ecourse::factory()->create(['published_at' => null]);

        $this->get(route('ecourses.show', $ecourse->slug))
            ->assertNotFound();
    }

    public function test_user_can_checkout_ecourse(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        System::create([
            'key' => 'subscription_fee',
            'value' => '30000',
            'is_array' => false,
        ]);

        $this->actingAs($user)->get(route('checkout'))
            ->assertSuccessful();

        $this->actingAs($user)->post(route('checkout'), ['months' => 2])
            ->assertRedirect(route('member.orders.index'));

        $this->assertDatabaseCount('orders', 1);

        $this->actingAs($user)->get(route('member.orders.index'))
            ->assertSeeInOrder(['30.000', '2', '60.000'])
            ->assertSuccessful();
    }

    public function test_guest_cannot_checkout_ecourse(): void
    {
        $this->get(route('checkout'))
            ->assertRedirect('login');
    }
}
