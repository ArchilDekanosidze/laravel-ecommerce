<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryUpdateRequest extends FormRequest
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
        return [
            'name' => 'required|min:2|max:120',
            'description' => 'required|min:5|max:500',
            'image' => 'image|mimes:png,jpg,jpeg,gif',
            'status' => 'required|numeric|in:0,1',
            'show_in_menu' => 'required|numeric|in:0,1',
            'tags' => 'required',
            'parent_id' => 'nullable|exists:product_categories,id',
        ];
    }
}
