<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompletePhoneTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_redirects_to_phone_form_when_phone_is_empty()
    {
        $user = User::factory()->create();
        $user->member->update(['phone' => '']);

        $response = $this->post('/login', [
            'email_or_phone' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('phone.complete'));
    }

    public function test_member_with_empty_phone_cannot_access_member_pages()
    {
        $user = User::factory()->create();
        $user->member->update(['phone' => '']);

        $response = $this->actingAs($user)->get(route('member.dashboard'));

        $response->assertRedirect(route('phone.complete'));
    }

    public function test_phone_form_can_be_rendered_when_phone_is_empty()
    {
        $user = User::factory()->create();
        $user->member->update(['phone' => '']);

        $response = $this->actingAs($user)->get(route('phone.complete'));

        $response->assertStatus(200);
    }

    public function test_member_can_save_phone_number_and_continue()
    {
        $user = User::factory()->create();
        $user->member->update(['phone' => '']);

        $response = $this->actingAs($user)->post(route('phone.complete.store'), [
            'phone' => '081234567890',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertEquals('6281234567890', $user->member->fresh()->phone);
    }

    public function test_member_with_phone_is_redirected_away_from_phone_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('phone.complete'));

        $response->assertRedirect(route('home'));
    }

    public function test_admin_is_not_redirected_to_phone_form()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get(route('faq'));

        $response->assertOk();
    }
}
