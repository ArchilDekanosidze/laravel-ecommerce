<?php

namespace Tests\Feature\Controllers\Auth\OTP;

use App\Models\Otp;
use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\Notification\Email\SendEmailWithMailAddress;



class ForgotPasswordOTPControllerTest extends TestCase
{
    public function test_can_show_forgot_password_otp_enter_username_form_for_unAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.password.forget.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_forgot_password_otp_enter_username_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.password.forget.form'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_validate_required_username(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => null,
        ]);

        $response->assertSessionHasErrors(['username' => __('validation.required', ['attribute' => 'username'])]);
        $this->assertGuest();
    }

    public function test_validate_email_exits(): void
    {
        $username = fake()->safeEmail();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $username,
        ]);
        $response->assertSessionHasErrors(['Credentials' => __('auth.wrong Credentials')]);
        $this->assertGuest();
    }

    public function test_validate_mobile_exits(): void
    {
        $username = fake()->numerify('##########');

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' =>  $username,
        ]);
        $response->assertSessionHasErrors(['Credentials' => __('auth.wrong Credentials')]);
        $this->assertGuest();
    }

    public function test_if_code_set_in_session_for_user_by_email(): void
    {
        $user = User::factory()->create();
        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->email
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $this->assertEquals($user->email, session('username'));
        $this->assertNotNull($code);
    }

    public function test_if_code_set_in_session_for_user_by_mobile(): void
    {
        $user = User::factory()->create();
        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->mobile
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $this->assertEquals($user->mobile, session('username'));
        $this->assertNotNull($code);
    }
}
