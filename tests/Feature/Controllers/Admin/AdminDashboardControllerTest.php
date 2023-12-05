<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDashboardControllerTest extends TestCase
{
    //auth.login.form

    public function test_can_show_admin_dashboard_for_unAuthenticated_user(): void
    {
        $response = $this->get(route('admin.home'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_can_show_admin_dashboard_for_Authenticated_user_but_not_admin(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.home'));

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_can_redirect_admin_dashboard_for_Authenticated_admin(): void
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.home'));
        $response->assertStatus(200);
    }
}
