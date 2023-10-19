<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveInspectionChecklistRequest extends FormRequest
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
            'requirement' => 'bail|nullable|array',
            'requirement.*.complied' => 'bail|nullable|accepted',
            'requirement.*.parameter' => 'bail|nullable|integer|min:1|max:9999',
        ];
    }
}
