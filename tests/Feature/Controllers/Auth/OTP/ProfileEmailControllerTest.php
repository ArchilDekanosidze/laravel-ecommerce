<?php

namespace Tests\Feature\Controllers\Auth\OTP;

use App\Models\Otp;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\Notification\Email\SendEmailWithMailAddress;



class ProfileEmailControllerTest extends TestCase
{
    // otp.profile.email.form

    public function test_can_change_email_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.mobile.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_change_email_for_UnAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.profile.mobile.form'));
        $response->assertRedirect(route('auth.login'));
    }

    //otp.profile.email

    public function test_if_other_user_exists_with_this_email(): void
    {
        $user1 = User::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('auth.otp.profile.email'), [
            'email' => $user1->email
        ]);

        $response->assertSessionHasErrors(['username' => __('auth.There is another user with this email. please select a different username')]);
    }

    public function test_fail_is_username_not_a_email(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('auth.otp.profile.email'), [
            'mobile' => 'hamemme'
        ]);
        $response->assertSessionHasErrors(['username' => __('auth.Your email is not valid')]);
    }

    public function test_if_code_set_in_session_for_user_email(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $newEmail = fake()->safeEmail();

        $response = $this->post(route('auth.otp.profile.email'), [
            'email' => $newEmail,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $this->assertNotNull($code);
        $response->assertRedirect(route('auth.otp.profile.email.code.form'));
        $response->assertSessionHas(['success' => __('auth.Code Sent')]);
    }

    //otp.profile.email.code.form

    public function test_can_show_confirm_code_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.email.code.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_show_confirm_code_form_for_UnAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.profile.email.code.form'));
        $response->assertRedirect(route('auth.login'));
    }

    //otp.profile.email.code

    public function test_validate_required_code(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $newEmail = fake()->safeEmail();

        $response = $this->post(route('auth.otp.profile.email'), [
            'email' => $newEmail,
        ]);

        $response = $this->post(route('auth.otp.profile.email.code'), [
            'code' => '',
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
    }

    public function test_validate_digits_code(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $newEmail = fake()->safeEmail();

        $response = $this->post(route('auth.otp.profile.email'), [
            'email' => $newEmail,
        ]);

        $response = $this->post(route('auth.otp.profile.email.code'), [
            'code' => 'abvd',
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
    }

    public function test_validate_four_char_code(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $newEmail = fake()->safeEmail();

        $response = $this->post(route('auth.otp.profile.email'), [
            'email' => $newEmail,
        ]);

        $response = $this->post(route('auth.otp.profile.email.code'), [
            'code' => '123456',
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
    }

    public function test_validate_invalid_code(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user);
        $newEmail = fake()->safeEmail();

        $response = $this->post(route('auth.otp.profile.email'), [
            'email' => $newEmail,
        ]);

        $response = $this->post(route('auth.otp.profile.email.code'), [
            'code' => '1234',
        ]);

        $response->assertSessionHasErrors(['invalidCode' => __('validation.code is invalid.')]);
    }

    public function test_code_confirmed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $newEmail = fake()->safeEmail();

        $response = $this->post(route('auth.otp.profile.email'), [
            'email' => $newEmail,
        ]);

        $code = Otp::find(session('code_id'));


        $response = $this->post(route('auth.otp.profile.email.code'), [
            'code' => $code->code,
        ]);

        $user = User::find($user->id);

        $response->assertSessionHas(['success' => __('auth.Your email changed succeefully')]);
        $response->assertRedirect(route('customer.profiles.profile'));
        $this->assertEquals($user->email, $newEmail);
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_if_deleted_token_after_confirm(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $newEmail = fake()->safeEmail();

        $response = $this->post(route('auth.otp.profile.email'), [
            'email' => $newEmail,
        ]);

        $code = Otp::find(session('code_id'));


        $response = $this->post(route('auth.otp.profile.email.code'), [
            'code' => $code->code,
        ]);

        $code = Otp::find(session('code_id'));

        $this->assertNull($code);
    }

    //otp.profile.mobile.resend

    public function test_if_user_can_resend_otp_code_login(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $newEmail = fake()->safeEmail();

        $response = $this->post(route('auth.otp.profile.email'), [
            'email' => $newEmail,
        ]);

        $code_id = session('code_id');

        $response = $this->get(route('auth.otp.profile.email.resend'));
        $new_code_id = $code_id + 1;
        $code = Otp::findOrFail($new_code_id);

        $this->assertNotNull($code);
    }
}
