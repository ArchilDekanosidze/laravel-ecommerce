<?php

namespace Tests\Feature\Controllers\Auth\OTP;

use Mockery;
use App\Models\Otp;
use Tests\TestCase;
use App\Models\User;
use Mockery\MockInterface;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Queue;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use App\Jobs\Notification\Sms\SendSmsWithNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Notification\Sms\Contracts\SmsSender;

class LoginOTPControllerTest extends TestCase
{

    public function test_can_show_login_otp_enter_username_form_for_unAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.login.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_otp_enter_username_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.login.form'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_can_show_login_otp_enter_code_form_for_unAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.login.code.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_otp_enter_code_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.login.code.form'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_validate_required_username(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => null,
        ]);

        $response->assertSessionHasErrors(['username' => __('validation.required', ['attribute' => 'username'])]);
        $this->assertGuest();
    }

    public function test_validate_wrong_username(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => 'wrongUserName',
        ]);
        $response->assertSessionHasErrors(['Credentials' => __('auth.wrong Credentials')]);
        $this->assertGuest();
    }

    public function test_if_code_set_in_session_for_user(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => $user->email,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $this->assertEquals($user->email, session('username'));
        $this->assertNotNull($code);
    }

    public function test_redirect_user_to_code_form_for_login_with_otp_for_unAuthenticated_user(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => $user->email,
        ]);

        $response->assertRedirect(route('auth.otp.login.code.form'));
        $response->assertSessionHas('success', __('auth.Code Sent'));
        $this->assertGuest();
    }


    public function test_validate_required_code(): void
    {

        $response = $this->post(route('auth.otp.login.code'), [
            'code' => ''
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);

        $this->assertGuest();
    }

    public function test_validate_digits_code(): void
    {

        $response = $this->post(route('auth.otp.login.code'), [
            'code' => 'abcd'
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);

        $this->assertGuest();
    }

    public function test_validate_four_char_code(): void
    {

        $response = $this->post(route('auth.otp.login.code'), [
            'code' => '123456'
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);

        $this->assertGuest();
    }



    public function test_validate_invalid_code(): void
    {

        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => $user->email,
        ]);

        $response = $this->post(route('auth.otp.login.code'), [
            'code' => '1234'
        ]);
        $response->assertSessionHasErrors(['invalidCode' => __('validation.code is invalid.')]);

        $this->assertGuest();
    }



    public function test_if_deleted_token_after_confirm(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => $user->email,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.code'), [
            'code' =>  $code->code
        ]);

        $code = Otp::find(session('code_id'));

        $this->assertNull($code);
    }




    public function test_if_email_verified_automatic(): void
    {
        $user = User::factory()->unverifiedEmail()->unverifiedMobile()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => $user->email,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.code'), [
            'code' =>  $code->code
        ]);

        $user = User::findOrFail($user->id);

        $this->assertNotNull($user->email_verified_at);
    }

    public function test_if_mobile_verified_automatic(): void
    {
        $user = User::factory()->unverifiedEmail()->unverifiedMobile()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => $user->mobile,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.code'), [
            'code' =>  $code->code
        ]);

        $user = User::findOrFail($user->id);

        $this->assertNotNull($user->mobile_verified_at);
    }



    public function test_if_user_can_login_with_otp(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => $user->email,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.code'), [
            'code' =>  $code->code
        ]);

        $this->assertAuthenticated();
    }


    public function test_if_user_can_resend_otp_code_login(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => $user->email,
        ]);

        $code_id = session('code_id');

        $response = $this->get(route('auth.otp.login.resend'));
        $new_code_id = $code_id + 1;
        $code = Otp::findOrFail($new_code_id);

        $this->assertNotNull($code);
        $this->assertGuest();
    }

    public function test_if_user_can_login_with_otp_with_rememberToken(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => $user->email,
            'remember' => true
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.code'), [
            'code' =>  $code->code
        ]);

        $this->assertAuthenticated();
        $this->assertNotNull(auth()->user()->remember_token);
    }

    public function test_if_user_can_login_with_otp_without_rememberToken(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => $user->email,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.code'), [
            'code' =>  $code->code
        ]);

        $this->assertAuthenticated();
        $this->assertNull(auth()->user()->remember_token);
    }


    /*

    public function test_farazSmsInTestMode(): void
    {
        // $user = User::factory()->state(['mobile' => '09120919921'])->create();
        // $user = User::factory()->create();
        $user = User::find(51);
        Queue::fake();


        // $mock = $this->mock(SmsProvider::class, function (MockInterface $mock) {
        //     $mock->shouldReceive('send')->once();
        // });

        $response = $this->post(route('auth.otp.login.send.token'), [
            'username' => $user->mobile,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $this->assertEquals($user->mobile, session('username'));
        $this->assertNotNull($code);

        // $this->instance(
        //     SmsProvider::class,
        //     Mockery::mock(SmsProvider::class, function (MockInterface $mock) {
        //         $mock->shouldReceive('send')->once();
        //     })
        // );
        Queue::assertPushed(SendSmsWithNumber::class);
    }
    */
}
