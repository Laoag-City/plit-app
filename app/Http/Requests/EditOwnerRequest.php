<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditOwnerRequest extends FormRequest
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
            'owner_name' => 'bail|required|string|max:200'
        ];
    }
}
