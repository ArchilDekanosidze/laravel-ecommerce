<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\Otp;
use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTwoFactorControllerTest extends TestCase
{
    
    public function test_can_show_login_otp_enter_code_form_for_unAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.login.two.factor.code.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_otp_enter_code_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.login.two.factor.code.form'));
        $response->assertRedirect(RouteServiceProvider::HOME);

    }
        

    public function test_validate_required_code(): void
    {

        $response = $this->post(route('auth.otp.login.two.factor.code'),[
            'code' => ''
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
        
        $this->assertGuest();      
    }

    public function test_validate_digits_code(): void
    {

        $response = $this->post(route('auth.otp.login.two.factor.code'),[
            'code' => 'abcd'
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
        
        $this->assertGuest();      
    }

    public function test_validate_four_char_code(): void
    {

        $response = $this->post(route('auth.otp.login.two.factor.code'),[
            'code' => '123456'
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
        
        $this->assertGuest();      
    }
    


    public function test_validate_invalid_code(): void
    {
        $user = User::factory()->hasTwoFactor()->create();

        $response = $this->post(route('auth.login'), [
            'username' => $user->email,
            'password' => 1234,
        ]);
        
        $response = $this->post(route('auth.otp.login.two.factor.code'),[
            'code' => '1234'
        ]);
        $response->assertSessionHasErrors(['invalidCode' => __('validation.code is invalid.')]);
        
        $this->assertGuest();      
    }


    public function test_if_deleted_token_after_confirm(): void
    {
        $user = User::factory()->hasTwoFactor()->create();

        $response = $this->post(route('auth.login'), [
            'username' => $user->email,
            'password' => 1234,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.two.factor.code'),[
            'code' => $code->code
        ]);

        $code = Otp::find(session('code_id'));

        $this->assertNull($code);
    }

    


    public function test_if_email_verified_automatic(): void
    {
        $user = User::factory()->hasTwoFactor()->unverifiedEmail()->unverifiedMobile()->create();

        $response = $this->post(route('auth.login'), [
            'username' => $user->email,
            'password' => 1234,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.two.factor.code'),[
            'code' => $code->code
        ]);

        $user = User::findOrFail($user->id);

        $this->assertNotNull($user->email_verified_at);
    }

    public function test_if_mobile_verified_automatic(): void
    {
        $user = User::factory()->hasTwoFactor()->unverifiedEmail()->unverifiedMobile()->create();

        $response = $this->post(route('auth.login'), [
            'username' => $user->mobile,
            'password' => 1234,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.two.factor.code'),[
            'code' => $code->code
        ]);

        $user = User::findOrFail($user->id);

        $this->assertNotNull($user->mobile_verified_at);
    }


    public function test_if_user_can_login_with_otp(): void
    {
        $user = User::factory()->hasTwoFactor()->create();

        $response = $this->post(route('auth.login'), [
            'username' => $user->mobile,
            'password' => 1234,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.two.factor.code'),[
            'code' => $code->code
        ]);
        $this->assertAuthenticated();
    }
    

    public function test_if_user_can_resend_otp_code_login(): void
    {
        $user = User::factory()->hasTwoFactor()->create();

        $response = $this->post(route('auth.login'), [
            'username' => $user->mobile,
            'password' => 1234,
        ]);

        $code_id = session('code_id');

        $response = $this->get(route('auth.otp.login.two.factor.resend'));
        $new_code_id = $code_id + 1;
        $code = Otp::findOrFail($new_code_id);

        $this->assertNotNull($code);
        $this->assertGuest();      

    }

    public function test_if_user_can_login_with_otp_with_rememberToken(): void
    {
        $user = User::factory()->hasTwoFactor()->create();

        $response = $this->post(route('auth.login'), [
            'username' => $user->email,
            'password' => 1234,
            'remember' => true
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.two.factor.code'),[
            'code' => $code->code
        ]);

        $this->assertNotNull(auth()->user()->remember_token);
        $this->assertAuthenticated();
    }

    public function test_if_user_can_login_with_otp_without_rememberToken(): void
    {
        $user = User::factory()->hasTwoFactor()->create();

        $response = $this->post(route('auth.login'), [
            'username' => $user->mobile,
            'password' => 1234,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $response = $this->post(route('auth.otp.login.two.factor.code'),[
            'code' => $code->code
        ]);

        $this->assertAuthenticated();
        $this->assertNull(auth()->user()->remember_token);
    }
    
}
