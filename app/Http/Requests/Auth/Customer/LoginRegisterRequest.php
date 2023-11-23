<?php

namespace App\Http\Requests\Auth\Customer;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class LoginRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        $route = Route::current();

        if($route->getName() == 'auth.customers.login-register')
        {
            return [
                'id' => 'required|min:11|max:64|regex:/^[a-zA-Z0-9_.@\+]*$/',
             ];
        }
        elseif($route->getName() == 'auth.customers.login-confirm')
        {
            return [
                'otp' => 'required|min:6|max:6',
             ];
        }

    }


    public function attributes(){
        return [
            'id' => 'ایمیل یا شماره موبایل'
        ];
    }
}