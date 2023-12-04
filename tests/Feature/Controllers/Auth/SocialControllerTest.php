<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SocialControllerTest extends TestCase
{
    //auth.login.provider.redirect

    public function test_can_socialite_redirectToProvider_unAuthenticated_users(): void
    {
        $driver = 'google';
        Socialite::shouldReceive('driver->redirect')
            ->andReturn('mocked_redirect_url');
        $response = $this->get(route('auth.login.provider.redirect', ['provider' => $driver]));

        $response->assertOk();
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

    public function test_can_login_socialite_callback(): void
    {
        $user = User::factory()->create();
        Socialite::shouldReceive('driver->user')
            ->andReturn([
                'id' => $user->id,
                'name' => 'testName',
                'email' => $user->email,
            ]);

        $driver = 'google';


        $response = $this->get(route('auth.login.provider.callback', ['provider' => $driver]));

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_can_register_socialite_callback(): void
    {
        $user = User::factory()->make();
        Socialite::shouldReceive('driver->user')
            ->andReturn([
                'id' => $user->id,
                'name' => 'testName',
                'email' => $user->email,
            ]);

        $driver = 'google';


        $response = $this->get(route('auth.login.provider.callback', ['provider' => $driver]));
        $this->assertDatabaseHas('users', ['email' => $user->email]);

        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
