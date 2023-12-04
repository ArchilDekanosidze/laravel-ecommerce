<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use App\Providers\RouteServiceProvider;
use App\Jobs\Notification\Email\SendEmail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordControllerTest extends TestCase
{


    // auth.password.forget.form

    public function test_can_show_forgot_form_for_unAuthenticated_users(): void
    {
        $response = $this->get(route('auth.password.forget.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_forgot_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.password.forget.form'));

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    //auth.password.forget

    public function test_can_redirect_forgot_password_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('auth.password.forget'), [
            'email' => fake()->safeEmail()
        ]);

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_validate_required_email(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.password.forget'), [
            'email' => null
        ]);
        $response->assertSessionHasErrors(['email' => __('validation.required', ['attribute' => 'email'])]);
        $this->assertGuest();
    }

    public function test_validate_should_be_email(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.password.forget'), [
            'email' => 'testetet'
        ]);
        $response->assertSessionHasErrors(['email' => __('validation.email', ['attribute' => 'email'])]);
        $this->assertGuest();
    }

    public function test_validate_should_exist_email(): void
    {
        $username = fake()->safeEmail();

        $response = $this->post(route('auth.password.forget'), [
            'email' =>  $username
        ]);
        $response->assertSessionHasErrors(['email' => __('validation.exists', ['attribute' => 'email'])]);
        $this->assertGuest();
    }

    public function test_reset_link_sent(): void
    {
        Queue::fake();
        $user = User::factory()->create();
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);

        $token = DB::table('password_reset_tokens')->where('email', $user->email)->first()->token;

        $response->assertSessionHas(['success' => __('auth.resetLinkSent')]);
        $this->assertGuest();
        Queue::assertPushed(SendEmail::class);
        $this->assertNotNull($token);
    }
}
