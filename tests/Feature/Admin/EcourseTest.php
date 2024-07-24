<?php

namespace Tests\Feature\Admin;

use App\Models\Course;
use App\Models\Ecourse;
use App\Models\User;
use Tests\TestCase;

class EcourseTest extends TestCase
{
    public function test_admin_can_list_ecourse(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('admin.ecourses.index'))
            ->assertSuccessful();
    }

    public function test_admin_can_create_ecourse(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('admin.ecourses.create'))
            ->assertSee('Buat Online Course');
    }

    public function test_admin_can_store_ecourse(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $course = Course::factory()->create();
        $data = Ecourse::factory()->make([
            'course_id' => $course->id,
        ])->toArray();
        $this->actingAs($admin)->post(route('admin.ecourses.store', $data))
            ->assertStatus(302);
    }

    public function test_admin_can_edit_ecourse(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ecourse = Ecourse::factory()->published()->create();
        $this->actingAs($admin)->get(route('admin.ecourses.edit', $ecourse->id))
            ->assertSee('Ubah Online Course');
    }

    public function test_admin_can_update_ecourse(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $course = Course::factory()->create();
        $ecourse = Ecourse::factory()->create([
            'course_id' => $course->id,
        ]);
        $data = [
            'description' => 'update description',
            '_method' => 'PUT',
            '_token' => csrf_token(),
        ];
        $this->actingAs($admin)->post(route('admin.ecourses.update', $ecourse->id), $data)
            ->assertStatus(302);
    }
}
