<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use App\Providers\RouteServiceProvider;
use App\Jobs\Notification\Email\SendEmail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerificationControllerTest extends TestCase
{
    //auth.email.send.verification

    public function test_can_redirect_send_verification_email_for_UnAuthenticated_users(): void
    {
        $response = $this->get(route('auth.email.send.verification'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_redirect_if_email_already_is_verified(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.email.send.verification'));

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_can_send_verification_email_for_Authenticated_users(): void
    {
        Queue::fake();

        $user = User::factory()->unverifiedEmail()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.email.send.verification'));

        $response->assertSessionHas(['success' => __('auth.verification Email Sent')]);
        Queue::assertPushed(SendEmail::class);
    }
}
