<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Code extends FormRequest
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
    public function rules(): array
    {
        return [
            'code' => ['required', 'numeric', 'digits:4'],
        ];
    }

    public function messages()
    {
        return [
            'code.digits' => __('auth.invalidCode'),
        ];
    }

}
