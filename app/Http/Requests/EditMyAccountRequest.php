<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditMyAccountRequest extends FormRequest
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
            'username' => [
                'bail',
                'required',
                'string',
                'max:25',
                Rule::unique('users', 'username')->ignore(request()->user()->user_id, 'user_id')
            ],
            'old_password' => 'bail|nullable|required_with:new_password|current_password',
            'new_password' => 'bail|nullable|string|min:6|max:15|confirmed'
        ];
    }
}
