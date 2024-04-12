<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatisticTypeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'view' => [
                'nullable',
                Rule::in(['no_inspections', 
                        'initial_inspections', 
                        're_inspections', 
                        'for_closures', 
                        'complied', 
                        'expired', 
                        'inspection_today', 
                        're_inspection_today', 
                        'due_from_today'
                ])
            ]
        ];
    }
}
