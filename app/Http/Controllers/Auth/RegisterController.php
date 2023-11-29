<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\Password;
use App\Rules\PasswordRule;
use App\Services\Auth\Traits\hasUsername;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */
    use RegistersUsers;
    use hasUsername;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function ShowRegisterationForm()
    {
        return view('auth.sign-up');
    }

    public function register(Request $request)
    {
        $this->validateForm($request);
        if (!$this->isUsernameValid($request->username)) {
            return $this->SendUserNameisNotValidResponse();
        }

        if ($this->isUserExists($request->username)) {
            return $this->SendUserAlreadyExistsResponse();
        }

        $user = $this->create($request->all());

        Auth::login($user);
        event(new UserRegistered($user));
        return $this->SendRegisterSuccessResponse();
    }

    protected function validateForm(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['confirmed', new PasswordRule()],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $username = $data['username'];

        $user = new User();
        if ($this->isUsernameAnEmail($username)) {
            $user->email = $username;
        }
        if ($this->isUsernameAnMobile($username)) {
            $user->mobile = $username;
        }
        $user->password = Hash::make($data['password']);
        $user->created_at = now();

        $user->save();
        return $user;
    }

    protected function SendRegisterSuccessResponse()
    {
        session()->regenerate();
        return redirect($this->redirectTo)->with('success', 'Please verify your email');
    }
}
