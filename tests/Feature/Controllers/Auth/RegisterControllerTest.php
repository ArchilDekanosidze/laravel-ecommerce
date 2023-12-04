<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use App\Jobs\Notification\Sms\SendSmsWithNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\Notification\Email\SendEmailWithMailAddress;

class RegisterControllerTest extends TestCase
{
    //auth.register.form

    public function test_can_show_register_form_for_unAuthenticated_users(): void
    {
        $response = $this->get(route('auth.register.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_show_register_form_for_unAuthenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.register.form'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    //auth.register

    public function test_redirect_register_method_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('auth.register'), [
            'username' => $user->email,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_validate_required_username(): void
    {
        $response = $this->post(route('auth.register'), [
            'username' => null,
        ]);

        $response->assertSessionHasErrors(['username' => __('validation.required', ['attribute' => 'username'])]);
        $this->assertGuest();
    }



    public function test_validate_confirmed_password(): void
    {
        $response = $this->post(route('auth.register'), [
            'username' => 'testTesTe@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password not confirmed'
        ]);
        $response->assertSessionHasErrors(['password' => __('validation.confirmed', ['attribute' => 'password'])]);
        $this->assertGuest();
    }

    public function test_validate_required_password(): void
    {
        $response = $this->post(route('auth.register'), [
            'username' => 'testTesTe@gmail.com',
            'password' => '',
            'password_confirmation' => ''
        ]);

        $response->assertSessionHasErrors(['password' => __('validation.password is not valid')]);
        $this->assertGuest();
    }

    public function test_validate_string_password(): void
    {

        $response = $this->post(route('auth.register'), [
            'username' => 'testTesTe@gmail.com',
            'password' => 123456789,
            'password_confirmation' => 123456789
        ]);

        $response->assertSessionHasErrors(['password' => __('validation.password is not valid')]);
        $this->assertGuest();
    }

    public function test_validate_min_eight_password(): void
    {

        $response = $this->post(route('auth.register'), [
            'username' => 'testTesTe@gmail.com',
            'password' => '1234',
            'password_confirmation' => '1234'
        ]);

        $response->assertSessionHasErrors(['password' => __('validation.password is not valid')]);
        $this->assertGuest();
    }

    public function test_validate_invalid_username(): void
    {

        $response = $this->post(route('auth.register'), [
            'username' => 'testTesT',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ]);
        $response->assertSessionHasErrors(['username' => __('auth.your username is not an email or phone number')]);
        $this->assertGuest();
    }

    public function test_validate_user_already_exists_by_email(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.register'), [
            'username' => $user->email,
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ]);
        $response->assertSessionHasErrors(['Credentials' => __('auth.user already exists')]);
        $this->assertGuest();
    }

    public function test_validate_user_already_exists_by_mobile(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.register'), [
            'username' => $user->mobile,
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ]);
        $response->assertSessionHasErrors(['Credentials' => __('auth.user already exists')]);
        $this->assertGuest();
    }

    public function test_if_it_can_create_user_with_email(): void
    {
        Event::fake();

        $username = fake()->safeEmail();
        $response = $this->post(route('auth.register'), [
            'username' => $username,
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ]);

        $this->assertDatabaseHas('users', ['email' => $username]);
        Event::assertDispatched(UserRegistered::class, 1);
    }

    public function test_if_it_can_create_user_with_mobile(): void
    {
        Event::fake();

        $username = fake()->numerify('##########');
        $response = $this->post(route('auth.register'), [
            'username' => $username,
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ]);

        $this->assertDatabaseHas('users', ['mobile' => $username]);
        Event::assertDispatched(UserRegistered::class, 1);
    }

    public function test_if_it_can_login_after_creat_user(): void
    {
        Event::fake();
        $username = fake()->safeEmail();
        $response = $this->post(route('auth.register'), [
            'username' => $username,
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ]);
        $this->assertAuthenticated();
        Event::assertDispatched(UserRegistered::class, 1);
    }

    public function test_if_it_can_fire_user_register_evenet_after_register_is_done(): void
    {
        Event::fake();
        $username = fake()->safeEmail();
        $response = $this->post(route('auth.register'), [
            'username' => $username,
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ]);
        Event::assertDispatched(UserRegistered::class, 1);
    }

    public function test_if_it_can_redirect_to_home_with_message_after_creat_user(): void
    {
        Event::fake();
        $username = fake()->safeEmail();
        $response = $this->post(route('auth.register'), [
            'username' => $username,
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ]);
        $response->assertRedirect(RouteServiceProvider::HOME);
        Event::assertDispatched(UserRegistered::class, 1);
    }
}
