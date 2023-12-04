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



class ProfileTwoFactorControllerTest extends TestCase
{
    public function test_can_show_toggle_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.toggle.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_show_toggle_form_for_UnAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.profile.two.factor.toggle.form'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_if_code_set_in_session_for_user_email(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForEmail'));

        $code = Otp::findOrFail(session('code_id'));

        $this->assertEquals($user->email, session('username'));
        $this->assertNotNull($code);
        $response->assertRedirect(route('auth.otp.profile.two.factor.code.form'));
        $response->assertSessionHas(['success' => __('auth.Code Sent')]);
    }

    public function test_redirect_user_send_token_for_email_if__unAuthenticated_user(): void
    {
        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForEmail'));

        $response->assertRedirect(route('auth.login'));
    }

    public function test_if_code_set_in_session_for_user_mobile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForMobile'));

        $code = Otp::findOrFail(session('code_id'));

        $this->assertEquals($user->mobile, session('username'));
        $this->assertNotNull($code);
        $response->assertRedirect(route('auth.otp.profile.two.factor.code.form'));
        $response->assertSessionHas(['success' => __('auth.Code Sent')]);
    }

    public function test_redirect_user_send_token_for_mobile_if__unAuthenticated_user(): void
    {
        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForMobile'));

        $response->assertRedirect(route('auth.login'));
    }

    public function test_can_show_enter_code_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.code.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_show_enter_code_form_for_UnAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.profile.two.factor.code.form'));
        $response->assertRedirect(route('auth.login'));
    }
    public function test_validate_required_code(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForMobile'));
        $response = $this->post(route('auth.otp.profile.two.factor.code'), [
            'code' => ''
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
    }

    public function test_validate_digits_code(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForMobile'));
        $response = $this->post(route('auth.otp.profile.two.factor.code'), [
            'code' => 'abcd'
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
    }

    public function test_validate_four_char_code(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForMobile'));
        $response = $this->post(route('auth.otp.profile.two.factor.code'), [
            'code' => '123456'
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
    }

    public function test_validate_invalid_code(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForMobile'));

        $response = $this->post(route('auth.otp.profile.two.factor.code'), [
            'code' => '1234'
        ]);
        $response->assertSessionHasErrors(['invalidCode' => __('validation.code is invalid.')]);
    }

    public function test_code_confirmed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForMobile'));

        $code = Otp::find(session('code_id'));
        $response = $this->post(route('auth.otp.profile.two.factor.code'), [
            'code' => $code->code,
        ]);

        $user = User::find($user->id);

        $response->assertSessionHas(['success' => __('auth.Two Factor Activated')]);
        $response->assertRedirect(route('auth.otp.profile.two.factor.toggle.form'));
        $this->assertEquals($user->has_two_factor, 1);
    }

    public function test_if_deleted_token_after_confirm(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForMobile'));

        $code = Otp::find(session('code_id'));
        $response = $this->post(route('auth.otp.profile.two.factor.code'), [
            'code' => $code->code,
        ]);

        $code = Otp::find(session('code_id'));

        $this->assertNull($code);
    }

    public function test_if_email_verified_automatic(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForEmail'));

        $code = Otp::find(session('code_id'));
        $response = $this->post(route('auth.otp.profile.two.factor.code'), [
            'code' => $code->code,
        ]);

        $user = User::findOrFail($user->id);

        $this->assertNotNull($user->email_verified_at);
    }

    public function test_if_mobile_verified_automatic(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForMobile'));

        $code = Otp::find(session('code_id'));
        $response = $this->post(route('auth.otp.profile.two.factor.code'), [
            'code' => $code->code,
        ]);

        $user = User::findOrFail($user->id);

        $this->assertNotNull($user->mobile_verified_at);
    }

    public function test_if_user_can_resend_otp_code_login(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.sendTokenForMobile'));


        $code_id = session('code_id');

        $response = $this->get(route('auth.otp.profile.two.factor.resend'));
        $new_code_id = $code_id + 1;
        $code = Otp::findOrFail($new_code_id);

        $this->assertNotNull($code);
    }

    public function test_if_user_can_deactive_two_factor(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.two.factor.deactivate'));
        $user = User::findOrFail($user->id);
        $this->assertEquals($user->has_two_factor, 0);
    }
}
