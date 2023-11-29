<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordControllerTest extends TestCase
{
    public function test_can_show_reset_password_form_for_unAuthenticated_users(): void
    {
        $response = $this->get(route('auth.password.reset.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_reset_password_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.password.reset.form'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_validate_required_email(): void
    {
        $user = User::factory()->create();
        
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        $response = $this->post(route('auth.password.reset'),[
            'email' => '',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'token' => $token,
        ]);

        $response->assertSessionHasErrors(['email' => __('validation.required', ['attribute' => 'email'])]);
        
        $this->assertGuest();      
    }

    public function test_validate_string_email(): void
    {
        $user = User::factory()->create();
        
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        $response = $this->post(route('auth.password.reset'),[
            'email' => 1223331,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'token' => $token,
        ]);

        $response->assertSessionHasErrors(['email' => __('validation.string', ['attribute' => 'email'])]);
        
        $this->assertGuest();      
    }

    public function test_validate_should_be_email(): void
    {
        $user = User::factory()->create();
        
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        $response = $this->post(route('auth.password.reset'),[
            'email' => 'test123',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'token' => $token,
        ]);

        $response->assertSessionHasErrors(['email' => __('validation.email', ['attribute' => 'email'])]);
        
        $this->assertGuest();      
    }

    public function test_validate_max_255_email(): void
    {
        $user = User::factory()->create();
        
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        $response = $this->post(route('auth.password.reset'),[
            'email' => Str::random(255) . '@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'token' => $token,
        ]);

        $response->assertSessionHasErrors(['email' => __('validation.max.string', ['attribute' => 'email', 'max' => 255])]);
        
        $this->assertGuest();      
    }

    public function test_validate_should_exists_email(): void
    {
        $user = User::factory()->create();
        $username = fake()->safeEmail();
        
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        $response = $this->post(route('auth.password.reset'),[
            'email' => $username ,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'token' => $token,
        ]);

        $response->assertSessionHasErrors(['email' => __('validation.exists', ['attribute' => 'email'])]);
        
        $this->assertGuest();      
    }

    /******* */
    public function test_validate_confirmed_password(): void
    {

        $user = User::factory()->create();
        
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        $response = $this->post(route('auth.password.reset'),[
            'email' => $user->email ,
            'password' => '12345678',
            'password_confirmation' => 'not confirmed',
            'token' => $token,
        ]);

        $response->assertSessionHasErrors(['password' => __('validation.confirmed', ['attribute' => 'password'])]);
        $this->assertGuest();
    }  

    public function test_validate_required_password(): void
    {
        $user = User::factory()->create();
        
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        $response = $this->post(route('auth.password.reset'),[
            'email' => $user->email ,
            'password' => '',
            'password_confirmation' => '',
            'token' => $token,
        ]);


        $response->assertSessionHasErrors(['password' => __('validation.password is not valid')]);
        $this->assertGuest();
    }  

    public function test_validate_string_password(): void
    {
        $user = User::factory()->create();
        
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        $response = $this->post(route('auth.password.reset'),[
            'email' => $user->email ,
            'password' => 123456789,
            'password_confirmation' => 123456789,
            'token' => $token,
        ]);

        $response->assertSessionHasErrors(['password' => __('validation.password is not valid')]);
        $this->assertGuest();
    }  

    public function test_validate_min_eight_password(): void
    {
        $user = User::factory()->create();
        
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        $response = $this->post(route('auth.password.reset'),[
            'email' => $user->email ,
            'password' => '1234',
            'password_confirmation' => '1234',
            'token' => $token,
        ]);

        $response->assertSessionHasErrors(['password' => __('validation.password is not valid')]);
        $this->assertGuest();
    }

    public function test_validate_required_token(): void
    {
        $user = User::factory()->create();
        
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        $response = $this->post(route('auth.password.reset'),[
            'email' => $user->email ,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'token' => '',
        ]);


        $response->assertSessionHasErrors(['token' => __('validation.required', ['attribute' => 'token'])]);
        $this->assertGuest();
    }  

    public function test_validate_string_token(): void
    {
        $user = User::factory()->create();
        
        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        $response = $this->post(route('auth.password.reset'),[
            'email' => $user->email ,
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'token' => 123456789,
        ]);

        $response->assertSessionHasErrors(['token' => __('validation.string', ['attribute' => 'token'])]);
        $this->assertGuest();
    }  

}
