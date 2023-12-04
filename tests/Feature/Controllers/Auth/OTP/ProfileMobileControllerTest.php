<?php

namespace Tests\Feature\Controllers\Auth\OTP;

use App\Models\Otp;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use App\Jobs\Notification\Sms\SendSmsWithNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\Notification\Email\SendEmailWithMailAddress;



class ProfileMobileControllerTest extends TestCase
{
    // otp.profile.mobile.form

    public function test_can_change_mobile_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.mobile.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_change_mobile_form_UnAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.profile.mobile.form'));
        $response->assertRedirect(route('auth.login'));
    }

    //otp.profile.mobile

    public function test_can_redirect_change_mobilefor_UnAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.profile.mobile.form'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_if_other_user_exists_with_this_mobile(): void
    {
        $user1 = User::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('auth.otp.profile.mobile'), [
            'mobile' => $user1->mobile
        ]);

        $response->assertSessionHasErrors(['username' => __('auth.There is another user with this mobile number. please select a different username')]);
    }

    public function test_fail_is_username_not_a_mobile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('auth.otp.profile.mobile'), [
            'mobile' => 'de91019'
        ]);
        $response->assertSessionHasErrors(['username' => __('auth.Your mobile number is not valid')]);
    }

    public function test_if_code_set_in_session_for_user_mobile(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $this->actingAs($user);
        $newMobile = fake()->numerify('##########');

        $response = $this->post(route('auth.otp.profile.mobile'), [
            'mobile' => $newMobile,
        ]);

        $code = Otp::findOrFail(session('code_id'));

        $this->assertNotNull($code);
        $response->assertRedirect(route('auth.otp.profile.mobile.code.form'));
        $response->assertSessionHas(['success' => __('auth.Code Sent')]);
        Queue::assertPushed(SendSmsWithNumber::class);
    }

    //otp.profile.mobile.code.form

    public function test_can_show_confirm_code_form_for_Authenticated_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('auth.otp.profile.mobile.code.form'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_show_confirm_code_form_for_UnAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.profile.mobile.code.form'));
        $response->assertRedirect(route('auth.login'));
    }

    //otp.profile.mobile.code

    public function test_can_redirect_confirm_code_method_for_UnAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.profile.mobile.code'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_validate_required_code(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $this->actingAs($user);
        $newMobile = fake()->numerify('##########');

        $response = $this->post(route('auth.otp.profile.mobile'), [
            'mobile' => $newMobile,
        ]);

        $response = $this->post(route('auth.otp.profile.mobile.code'), [
            'code' => '',
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
        Queue::assertPushed(SendSmsWithNumber::class);
    }

    public function test_validate_digits_code(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $this->actingAs($user);
        $newMobile = fake()->numerify('##########');

        $response = $this->post(route('auth.otp.profile.mobile'), [
            'mobile' => $newMobile,
        ]);

        $response = $this->post(route('auth.otp.profile.mobile.code'), [
            'code' => 'abvd',
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
        Queue::assertPushed(SendSmsWithNumber::class);
    }

    public function test_validate_four_char_code(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $this->actingAs($user);
        $newMobile = fake()->numerify('##########');

        $response = $this->post(route('auth.otp.profile.mobile'), [
            'mobile' => $newMobile,
        ]);

        $response = $this->post(route('auth.otp.profile.mobile.code'), [
            'code' => '123456',
        ]);

        $response->assertSessionHasErrors(['code' => __('validation.code is invalid.')]);
        Queue::assertPushed(SendSmsWithNumber::class);
    }

    public function test_validate_invalid_code(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $this->actingAs($user);
        $newMobile = fake()->numerify('##########');

        $response = $this->post(route('auth.otp.profile.mobile'), [
            'mobile' => $newMobile,
        ]);

        $response = $this->post(route('auth.otp.profile.mobile.code'), [
            'code' => '1234',
        ]);

        $response->assertSessionHasErrors(['invalidCode' => __('validation.code is invalid.')]);
        Queue::assertPushed(SendSmsWithNumber::class);
    }

    public function test_code_confirmed(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $this->actingAs($user);
        $newMobile = fake()->numerify('##########');

        $response = $this->post(route('auth.otp.profile.mobile'), [
            'mobile' => $newMobile,
        ]);

        $code = Otp::find(session('code_id'));


        $response = $this->post(route('auth.otp.profile.mobile.code'), [
            'code' => $code->code,
        ]);

        $user = User::find($user->id);

        $response->assertSessionHas(['success' => __('auth.Your mobile number changed succeefully')]);
        $response->assertRedirect(route('customer.profiles.profile'));
        $this->assertEquals($user->mobile, $newMobile);
        $this->assertNotNull($user->mobile_verified_at);
        Queue::assertPushed(SendSmsWithNumber::class);
    }

    public function test_if_deleted_token_after_confirm(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $this->actingAs($user);
        $newMobile = fake()->numerify('##########');

        $response = $this->post(route('auth.otp.profile.mobile'), [
            'mobile' => $newMobile,
        ]);

        $code = Otp::find(session('code_id'));


        $response = $this->post(route('auth.otp.profile.mobile.code'), [
            'code' => $code->code,
        ]);

        $code = Otp::find(session('code_id'));

        $this->assertNull($code);
        Queue::assertPushed(SendSmsWithNumber::class);
    }

    //otp.profile.mobile.resend

    public function test_prfile_mobile_can_redirect_if_resend_request_for_UnAuthenticated_users(): void
    {
        $response = $this->get(route('auth.otp.profile.mobile.resend'));
        $response->assertRedirect(route('auth.login'));
    }

    public function test_if_user_can_resend_otp_code_login(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $this->actingAs($user);
        $newMobile = fake()->numerify('##########');

        $response = $this->post(route('auth.otp.profile.mobile'), [
            'mobile' => $newMobile,
        ]);

        $code_id = session('code_id');

        $response = $this->get(route('auth.otp.profile.mobile.resend'));
        $new_code_id = $code_id + 1;
        $code = Otp::findOrFail($new_code_id);

        $this->assertNotNull($code);
        Queue::assertPushed(SendSmsWithNumber::class);
    }
}
