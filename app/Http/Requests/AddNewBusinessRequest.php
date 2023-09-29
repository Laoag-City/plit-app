<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddNewBusinessRequest extends FormRequest
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
            'business_id_number' => 'bail|required|string|unique:businesses,business_id_number',
            'business_name' => 'bail|required|string',
            'owner_name' => 'bail|required|string',
            'barangay' => 'bail|required|exists:addresses,brgy',
            'line_of_business' => 'bail|required',
            'another_line_of_business' => 'bail|nullable|boolean',
            'supporting_image' => 'bail|array',
            'supporting_image.*' => 'bail|nullable|image'
        ];
    }
}
