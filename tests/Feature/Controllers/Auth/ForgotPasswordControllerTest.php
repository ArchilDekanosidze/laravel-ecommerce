<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordControllerTest extends TestCase
{
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
        $user = User::factory()->create();

        $response = $this->post(route('auth.password.forget'), [
            'email' => $user->email
        ]);
        $response->assertSessionHas(['success' => __('auth.resetLinkSent')]);
        $this->assertGuest();
    } 
}
