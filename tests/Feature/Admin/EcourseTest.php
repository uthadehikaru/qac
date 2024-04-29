<?php

namespace Tests\Feature\Admin;

use App\Models\Ecourse;
use App\Models\User;
use Tests\TestCase;

class EcourseTest extends TestCase
{
    public function test_admin_can_list_ecourse(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Ecourse::factory(4)->published()->create();
        $this->actingAs($admin)->get(route('admin.ecourses.index'))
            ->assertSuccessful();
    }
}
