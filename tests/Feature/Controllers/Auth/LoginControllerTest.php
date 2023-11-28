<?php

namespace Tests\Feature\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Otp;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Auth\OTPLogin;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    
    public function test_can_show_login_form_for_unAuthenticated_users(): void
    {
        $response = $this->get(route('auth.login.form'));

        $response->assertStatus(200);
    }        

    public function test_can_redirect_login_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.login.form'));

        $response->assertRedirect(RouteServiceProvider::HOME);
    }    

    public function test_validate_required_username(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.login'), [
            'username' => null,
            'password' => $user->password,
        ]);
        $response->assertSessionHasErrors(['username' => __('validation.required', ['attribute' => 'username'])]);
        $this->assertGuest();
    }   

    public function test_validate_required_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.login'), [
            'username' => $user->email,
            'password' => null,
        ]);

        $response->assertSessionHasErrors(['password' => __('validation.required', ['attribute' => 'password'])]);
        $this->assertGuest();
    }        

    public function test_validate_fail_username_is_not_email_or_phoneNumber(): void
    {
        $response = $this->post(route('auth.login'), [
            'username' => 'username',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors(['username' => __('auth.your username is not an email or phone number')]);
        $this->assertGuest();
    }     

    public function test_validate_success_username_is_an_email(): void
    {
        $response = $this->post(route('auth.login'), [
            'username' => 'test@gmail.com',
            'password' => 'password',
        ]);
        $response->assertSessionDoesntHaveErrors(['username' => __('auth.your username is not an email or phone number')]);
        $this->assertGuest();
    }

    public function test_validate_success_username_is_an_mobile(): void
    {
        $response = $this->post(route('auth.login'), [
            'username' => '012919191',
            'password' => 'password',
        ]);
        $response->assertSessionDoesntHaveErrors(['username' => __('auth.your username is not an email or phone number')]);
        $this->assertGuest();
    }             
    
    public function test_lock_out_response(): void
    {
        $loginController = new LoginController(new OTPLogin(new Request));
        
        $maxAttempts = $loginController->maxAttempts();
        for ($i=0; $i < $maxAttempts; $i++) { 
            $response = $this->post(route('auth.login'), [
                'username' => 'test@gmail.com',
                'password' => 'password',
            ]);
        }

        $response = $this->post(route('auth.login'), [
            'username' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['throttle']);
    }
   
    public function test_lock_out_response_sleep_time(): void
    {
        $loginController = new LoginController(new OTPLogin(new Request));
        $maxAttempts = $loginController->maxAttempts();
        $decayMinutes = $loginController->decayMinutes();


        for ($i=0; $i < $maxAttempts; $i++) { 
            $response = $this->post(route('auth.login'), [
                'username' => 'test@gmail.com',
                'password' => 'password',
            ]);
        }

        $response = $this->post(route('auth.login'), [
            'username' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $this->travel($decayMinutes)->minutes();

        $response = $this->post(route('auth.login'), [
            'username' => 'test@gmail.com',
            'password' => 'password',
        ]);
        $response->assertSessionDoesntHaveErrors(['throttle']);

        Carbon::setTestNow();
    }

    public function test_wrong_credentials(): void
    {
        $response = $this->post(route('auth.login'), [
            'username' => 'emailtest22@gmail.com',
            'password' => 'passwordTest',
        ]);
        $response->assertSessionHasErrors(['Credentials' => __('auth.wrong Credentials')]);
        $this->assertGuest();
    }
    
    public function test_login_user_if_user_dosent_have_two_factor(): void
    {
        $user = User::factory()->create();
        $response = $this->post(route('auth.login'), [
            'username' => $user->email,
            'password' => 1234,
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticated();
    }

    public function test_login_user_if_user_dosent_have_two_factor_with_remember_me(): void
    {
        $user = User::factory()->create();
        $response = $this->post(route('auth.login'), [
            'username' => $user->email,
            'password' => 1234,
            'remember' => true
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticated();
        $this->assertNotNull(auth()->user()->remember_token);
    }

    public function test_login_user_if_user_dosent_have_two_factor_without_remember_me(): void
    {
        $user = User::factory()->create();
        $response = $this->post(route('auth.login'), [
            'username' => $user->email,
            'password' => 1234,
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticated();
        $this->assertNull(auth()->user()->remember_token);
    }

    public function test_if_two_factor_code_set_in_session_for_user_with_two_factor_activated(): void
    {
        $user = User::factory()->hasTwoFactor()->create();

        $response = $this->post(route('auth.login'), [
            'username' => $user->email,
            'password' => 1234,
        ]);
        $code = Otp::findOrFail(session('code_id'));
        $this->assertEquals( $user->email, session('username'));
        $this->assertNotNull($code);
    } 

    public function test_redirect_user_to_two_factor_form_if_user_has_two_factor(): void
    {
        $user = User::factory()->hasTwoFactor()->create();

        $response = $this->post(route('auth.login'), [
            'username' => $user->email,
            'password' => 1234,
        ]);
        $response->assertRedirect(route('auth.otp.login.two.factor.code.form'));
        $this->assertGuest();                                                        
    } 
    
    public function test_if_user_can_logout(): void
    {
        $user = User::factory()->hasTwoFactor()->create();
        $this->actingAs($user);
  
        $response = $this->get(route('auth.logout'));
        $this->assertGuest();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }        
}
