<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SocialControllerTest extends TestCase
{
    //auth.login.provider.redirect

    public function test_can_socialite_rredirectToProvider_unAuthenticated_users(): void
    {
        $driver = 'google';
        $response = $this->get(route('auth.login.provider.redirect', ['provider' => $driver]));

        $response->assertStatus(302);
    }

    public function test_can_redirect_socialite_redirectToProvider_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $driver = 'google';

        $response = $this->get(route('auth.login.provider.redirect', ['provider' => $driver]));

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    //auth.login.provider.callback

    public function test_can_redirect_socialite_callback_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $driver = 'google';

        $response = $this->get(route('auth.login.provider.callback', ['provider' => $driver]));

        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
