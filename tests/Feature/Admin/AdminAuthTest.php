<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_sign_in_and_out(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'password' => 'secret-pass']);

        $this->post(route('admin.login'), ['email' => $admin->email, 'password' => 'secret-pass'])
            ->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);

        $this->get(route('admin.dashboard'))->assertOk()->assertSee('Dashboard');

        $this->post(route('admin.logout'))->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_non_admin_users_cannot_sign_in_or_open_the_console(): void
    {
        $user = User::factory()->create(['is_admin' => false, 'password' => 'secret-pass']);

        $this->post(route('admin.login'), ['email' => $user->email, 'password' => 'secret-pass'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->actingAs($user)->get(route('admin.boats'))->assertForbidden();
    }

    public function test_wrong_password_is_rejected(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'password' => 'secret-pass']);

        $this->post(route('admin.login'), ['email' => $admin->email, 'password' => 'wrong'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
