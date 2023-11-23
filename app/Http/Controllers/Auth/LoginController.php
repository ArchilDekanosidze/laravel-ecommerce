<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\Auth\OTPLogin;
use App\Services\Auth\Traits\hasOTP;
use App\Services\Auth\Traits\hasUsername;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */
    use AuthenticatesUsers;
    use hasOTP;
    use hasUsername;

    protected $maxAttempts = 1;
    protected $decayMinutes = 2;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OTPLogin $otp)
    {
        $this->middleware('guest')->except('logout');
        $this->otp = $otp;
    }

    public function ShowloginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validateUserNameForm($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        if (!$this->isUsernameValid($request->username)) {
            return $this->SendUserNameisNotValidResponse();
        }

        if (!$this->isValidCredentials($request)) {
            $this->incrementLoginAttempts($request);
            return $this->SendCredentialsFailedResponse();
        }

        $user = $this->getUser($request);

        if ($user->hasTwoFactor()) {
            $response = $this->otp->requestCode();
            return $response == $this->otp::CODE_SENT
            ? $this->SendTokenSuccessResponse()
            : $this->SendTokenFailedResponse();
        }
        Auth::login($user, $request->remember);
        return $this->SendLoginSuccessResponse();
    }

    protected function validateUserNameForm(Request $request)
    {
        $request->validate(
            [
                'username' => ['required'],
                'password' => ['required'],
            ]
        );
    }

    protected function getUser($request)
    {
        $user = User::where('email', $request->username)->first();
        if (empty($user)) {
            $user = User::where('mobile', $request->username)->first();
        }
        return $user;
    }

    protected function SendTokenSuccessResponse()
    {
        return redirect()->route('auth.otp.login.two.factor.code.form');
    }

    protected function SendLoginSuccessResponse()
    {
        session()->regenerate();
        return redirect()->intended();
    }

    protected function validateForm(Request $request)
    {
        return true;
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            'throttle' => [trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }
}
