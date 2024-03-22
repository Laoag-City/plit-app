<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
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
            'name' => 'bail|required|string|min:6|max:100',
            'office' => 'bail|required|exists:offices,office_id',
            'username' => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:25',
                Rule::unique('users', 'username')->ignore(request()->user->user_id, 'user_id')
            ],
            'change_password' => 'bail|nullable|string|min:6|max:15|confirmed',
            'user_level' => 'bail|required|boolean'
        ];
    }
}
