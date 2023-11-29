<?php

namespace Tests\Feature\Controllers\Auth\OTP;

use App\Models\Otp;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordOTPControllerTest extends TestCase
{
    public function test_can_show_login_otp_enter_code_form_for_unAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.password.code.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_otp_enter_code_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.password.code.form'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }


    

    public function test_validate_required_code(): void
    {
        $user = User::factory()->create();
        $response = $this->post(route('auth.otp.password.code'),[
            'username' => $user->email,
            'code' => '',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
        
        $this->assertGuest();      
    }

    public function test_validate_digits_code(): void
    {
        $user = User::factory()->create();
        $response = $this->post(route('auth.otp.password.code'),[
            'username' => $user->email,
            'code' => 'abcd',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
        
        $this->assertGuest();      
    }

    public function test_validate_four_char_code(): void
    {
        $user = User::factory()->create();
        $response = $this->post(route('auth.otp.password.code'),[
            'username' => $user->email,
            'code' => '123456',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
        
        $this->assertGuest();      
    }
    


    public function test_validate_invalid_code(): void
    {

        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->email,
        ]);
        
        $response = $this->post(route('auth.otp.password.code'),[
            'username' => $user->email,
            'code' => '1234',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertSessionHasErrors(['invalidCode' => __('validation.code is invalid.')]);
        
        $this->assertGuest();      
    }

    public function test_validate_required_username(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->email,
        ]);

        $code = Otp::findOrFail(session('code_id'));
        $response = $this->post(route('auth.otp.password.code'),[
            'username' => '',
            'code' => $code->code,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response->assertSessionHasErrors(['username' => __('validation.required', ['attribute' => 'username'])]);
        
        $this->assertGuest();      
    }

    public function test_validate_confirmed_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->email,
        ]);
        $code = Otp::findOrFail(session('code_id'));
        $response = $this->post(route('auth.otp.password.code'), [
            'username' => $user->email,
            'code' => $code->code,
            'password' => 'password',
            'password_confirmation' => 'password not confirmed'
        ]);
        $response->assertSessionHasErrors(['password' => __('validation.confirmed', ['attribute' => 'password'])]);
        $this->assertGuest();
    }  

    public function test_validate_required_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->email,
        ]);

        $code = Otp::findOrFail(session('code_id'));
        $response = $this->post(route('auth.otp.password.code'), [
            'username' => $user->email,
            'code' => $code->code,
            'password' => '',
            'password_confirmation' => ''
        ]);

        $response->assertSessionHasErrors(['password' => __('validation.password is not valid')]);
        $this->assertGuest();
    }  

    public function test_validate_string_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->email,
        ]);

        $code = Otp::findOrFail(session('code_id'));
        $response = $this->post(route('auth.otp.password.code'), [
            'username' => $user->email,
            'code' => $code->code,
            'password' => 123456789,
            'password_confirmation' => 123456789
        ]);

        $response->assertSessionHasErrors(['password' => __('validation.password is not valid')]);
        $this->assertGuest();
    }  

    public function test_validate_min_eight_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->email,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.password.code'), [
            'username' => $user->email,
            'code' => $code->code,
            'password' => '1234',
            'password_confirmation' => '1234'
        ]);

        $response->assertSessionHasErrors(['password' => __('validation.password is not valid')]);
        $this->assertGuest();
    }

    public function test_if_deleted_token_after_confirm(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->email,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.password.code'),[
            'username' => $user->email,
            'code' => $code->code,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $code = Otp::find(session('code_id'));

        $this->assertNull($code);
    }
    

    public function test_if_email_verified_automatic(): void
    {
        $user = User::factory()->unverifiedEmail()->unverifiedMobile()->create();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->email,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.password.code'),[
            'username' => $user->email,
            'code' => $code->code,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $user = User::findOrFail($user->id);

        $this->assertNotNull($user->email_verified_at);
    }

    public function test_if_mobile_verified_automatic(): void
    {
        $user = User::factory()->unverifiedEmail()->unverifiedMobile()->create();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->mobile,
        ]);
        
        $code = Otp::findOrFail(session('code_id'));
        
        $response = $this->post(route('auth.otp.password.code'), [
            'username' => $user->mobile,
            'code' => $code->code,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
             

        $user = User::findOrFail($user->id);

        $this->assertNotNull($user->mobile_verified_at);
    }



    public function test_if_user_can_reset_password_with_otp(): void
    {
        $user = User::factory()->unverifiedEmail()->unverifiedMobile()->create();
        $newPass = '12345678';

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->email,
        ]);
        
        $code = Otp::findOrFail(session('code_id'));
        
        $response = $this->post(route('auth.otp.password.code'), [
            'username' => $user->email,
            'code' => $code->code,
            'password' => $newPass,
            'password_confirmation' => $newPass
        ]);
             

        $user = User::findOrFail($user->id);

        $this->assertTrue(Hash::check($newPass, $user->password));
    }


    public function test_if_user_can_resend_otp_code_login(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.otp.password.send.token'), [
            'username' => $user->email,
        ]);

        $code_id = session('code_id');

        $response = $this->get(route('auth.otp.password.resend'));
        $new_code_id = $code_id + 1;
        $code = Otp::findOrFail($new_code_id);

        $this->assertNotNull($code);
        $this->assertGuest();      

    }
    
}
