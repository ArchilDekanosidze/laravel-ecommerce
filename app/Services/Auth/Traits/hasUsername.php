<?php
namespace App\Services\Auth\Traits;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait hasUsername
{
    public function isUsernameAnEmail($username)
    {
        return filter_var($username, FILTER_VALIDATE_EMAIL);
    }

    public function isUsernameAnMobile($username)
    {
        $username = ltrim($username, '+');
        return preg_match('/[0-9]+$/', $username);
    }

    public function isUsernameValid($username)
    {
        return $this->isUsernameAnEmail($username) || $this->isUsernameAnMobile($username);
    }

    protected function isValidCredentials(Request $request)
    {
        return Auth::validate(['email' => $request->username, 'password' => $request->password]) ||
        Auth::validate(['mobile' => $request->username, 'password' => $request->password]);
    }

    protected function isUserExists($username)
    {
        return User::where('email', $username)->first() || User::where('mobile', $username)->first();
    }

    protected function isOtherUserExists($username)
    {
        $currentUser = Auth::user();
        return User::where([['email', $username], ['email', '!=', $currentUser->email]])->first() ||
        User::where([['mobile', $username], ['mobile', '!=', $currentUser->mobile]])->first();
    }

    protected function SendUserNameisNotValidResponse()
    {
        $errorText = 'your username is not an email or phone number';
        return back()->withErrors(['username' => $errorText]);
    }

    protected function SendCredentialsFailedResponse()
    {
        $errorText = 'wrong Credentials';
        return back()->withErrors(['Credentials' => $errorText]);
    }

    protected function SendUserAlreadyExistsResponse()
    {
        $errorText = 'user already exists';
        return back()->withErrors(['Credentials' => $errorText]);
    }

    protected function SendOtherUserExistsMobileResponse()
    {
        $errorText = 'There is another user with this mobile number. please select a different username';
        return back()->withErrors(['username' => $errorText]);
    }

    protected function SendOtherUserExistsEmailResponse()
    {
        $errorText = 'There is another user with this email. please select a different username';
        return back()->withErrors(['username' => $errorText]);
    }

    protected function SendNotValidMobileNumberResponse()
    {
        $errorText = 'Your mobile number is not valid';
        return back()->withErrors(['username' => $errorText]);
    }

    protected function SendNotValidEmailResponse()
    {
        $errorText = 'Your email is not valid';
        return back()->withErrors(['username' => $errorText]);
    }
}
