<?php

namespace Tests\Feature\Controllers\Auth\OTP;

use App\Models\Otp;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use App\Jobs\Notification\Sms\SendSmsWithNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\Notification\Email\SendEmailWithMailAddress;


class RegisterOTPControllerTest extends TestCase
{
    //auth.otp.register.form

    public function test_can_show_register_otp_enter_username_form_for_unAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.register.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_otp_register_enter_username_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.register.form'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    //auth.otp.register.send.token

    public function test_can_redirect_otp_register_send_token_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.register.send.token'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_validate_required_username(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => null,
        ]);

        $response->assertSessionHasErrors(['username' => __('validation.required', ['attribute' => 'username'])]);
        $this->assertGuest();
    }

    public function test_validate_email_exits(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => $user->email,
        ]);
        $response->assertSessionHasErrors(['Credentials' => __('validation.username already exist or is invalid')]);
        $this->assertGuest();
    }

    public function test_validate_mobile_exits(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => $user->mobile,
        ]);
        $response->assertSessionHasErrors(['Credentials' => __('validation.username already exist or is invalid')]);
        $this->assertGuest();
    }

    public function test_validate_wrong_username(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => 'abcd',
        ]);
        $response->assertSessionHasErrors(['Credentials' => __('validation.username already exist or is invalid')]);
        $this->assertGuest();
    }

    public function test_register_if_code_set_in_session_for_user_by_email(): void
    {
        Queue::fake();

        $username = fake()->safeEmail();
        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => $username
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $this->assertEquals($username, session('username'));
        $this->assertNotNull($code);
        Queue::assertPushed(SendEmailWithMailAddress::class);
    }

    public function test_register_if_code_set_in_session_for_user_by_mobile(): void
    {
        Queue::fake();

        $username = fake()->numerify('##########');
        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => $username
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $this->assertEquals($username, session('username'));
        $this->assertNotNull($code);
        Queue::assertPushed(SendSmsWithNumber::class);
    }

    public function test_register_redirect_user_to_code_form_for_register_with_otp(): void
    {
        Queue::fake();

        $username = fake()->safeEmail();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => $username,
        ]);

        $response->assertRedirect(route('auth.otp.register.code.form'));
        $response->assertSessionHas('success', __('auth.Code Sent'));
        $this->assertGuest();
        Queue::assertPushed(SendEmailWithMailAddress::class);
    }

    //auth.otp.register.code.form

    public function test_can_show_register_otp_code_form_for_unAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.register.code.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_otp_register_enter_code_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.register.code.form'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    //auth.otp.register.code

    public function test_can_redirect_otp_register_enter_code_method_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.register.code'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_validate_required_code(): void
    {

        $response = $this->post(route('auth.otp.register.code'), [
            'code' => ''
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);

        $this->assertGuest();
    }

    public function test_validate_digits_code(): void
    {

        $response = $this->post(route('auth.otp.register.code'), [
            'code' => 'abcd'
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);

        $this->assertGuest();
    }

    public function test_validate_four_char_code(): void
    {

        $response = $this->post(route('auth.otp.register.code'), [
            'code' => '123456'
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);

        $this->assertGuest();
    }


    public function test_register_validate_invalid_code(): void
    {
        Queue::fake();

        $username = fake()->safeEmail();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' =>  $username,
        ]);

        $response = $this->post(route('auth.otp.register.code'), [
            'code' => '1234'
        ]);
        $response->assertSessionHasErrors(['invalidCode' => __('validation.code is invalid.')]);

        $this->assertGuest();
        Queue::assertPushed(SendEmailWithMailAddress::class);
    }

    public function test_if_deleted_token_after_confirm(): void
    {
        Queue::fake();

        $username = fake()->safeEmail();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' =>  $username,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.register.code'), [
            'code' =>  $code->code
        ]);

        $code = Otp::find(session('code_id'));

        $this->assertNull($code);
        Queue::assertPushed(SendEmailWithMailAddress::class);
    }

    public function test_if_email_verified_automatic(): void
    {
        Queue::fake();

        $username = fake()->safeEmail();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => $username,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.register.code'), [
            'code' =>  $code->code
        ]);

        $user = User::where(['email' => $username])->firstOrFail();

        $this->assertNotNull($user->email_verified_at);
        $this->assertNull($user->mobile_verified_at);
        Queue::assertPushed(SendEmailWithMailAddress::class);
    }

    public function test_if_mobile_verified_automatic(): void
    {
        Queue::fake();

        $username = fake()->numerify('##########');

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => $username,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.register.code'), [
            'code' =>  $code->code
        ]);

        $user = User::where(['mobile' => $username])->firstOrFail();

        $this->assertNotNull($user->mobile_verified_at);
        $this->assertNull($user->email_verified_at);
        Queue::assertPushed(SendSmsWithNumber::class);
    }

    public function test_if_user_can_register_with_otp(): void
    {
        Queue::fake();

        $username = fake()->safeEmail();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => $username,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.register.code'), [
            'code' =>  $code->code
        ]);

        $this->assertDatabaseHas('users', ['email' => $username]);
        $this->assertAuthenticated();
        Queue::assertPushed(SendEmailWithMailAddress::class);
    }

    public function test_if_user_can_register_with_otp_with_rememberToken(): void
    {
        Queue::fake();

        $username = fake()->safeEmail();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => $username,
            'remember' => true
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.register.code'), [
            'code' =>  $code->code
        ]);

        $this->assertAuthenticated();
        $this->assertNotNull(auth()->user()->remember_token);
        Queue::assertPushed(SendEmailWithMailAddress::class);
    }

    public function test_if_user_can_register_with_otp_without_rememberToken(): void
    {
        Queue::fake();

        $username = fake()->safeEmail();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => $username,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.register.code'), [
            'code' =>  $code->code
        ]);

        $this->assertAuthenticated();
        $this->assertNull(auth()->user()->remember_token);
        Queue::assertPushed(SendEmailWithMailAddress::class);
    }

    //auth.otp.register.resend

    public function test_can_redirect_register_resent_otp_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.register.resend'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_if_user_can_resend_otp_code_register(): void
    {
        Queue::fake();

        $username = fake()->safeEmail();

        $response = $this->post(route('auth.otp.register.send.token'), [
            'username' => $username,
        ]);

        $code_id = session('code_id');

        $response = $this->get(route('auth.otp.register.resend'));
        $new_code_id = $code_id + 1;
        $code = Otp::findOrFail($new_code_id);

        $this->assertNotNull($code);
        $this->assertGuest();
        Queue::assertPushed(SendEmailWithMailAddress::class);
    }
}
