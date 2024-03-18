<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Models\Owner;
use Illuminate\Validation\Rule;

class EditBusinessRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
			'business_id_number' => [
                'bail',
                'required',
                'string',
                'min:14',
                'max:20',
                Rule::unique('businesses', 'id_no')->ignore($request->business->business_id, 'business_id')
            ],
			'business_name' => 'bail|required|string|max:250',
			'owner_name' => 'bail|required|string|max:200',
			'owner_name_selection_id' => 'bail|nullable|exists:owners,owner_id',
			'barangay' => 'bail|required|exists:addresses,address_id',
			'other_location_info' => 'bail|nullable|string:max:200',
            'coordinates' => [
				'bail',
				'nullable',
				'regex:/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/'
			],
		];
    }

    public function after(Request $request): array
	{
		$rules = [];

		if($request->owner_name_selection_id != null)
			$rules = [
				function (Validator $validator) use($request)
				{
					$owner = Owner::where([
						['name', '=', $request->owner_name],
						['owner_id', '=', $request->owner_name_selection_id]
					])->first();

					if(!$owner)
						$validator->errors()->add('owner_name', 'Invalid owner selection. Please try again.');
				}
			];

		return $rules;
	}

    public function messages(): array
	{
		return [
			'coordinates.regex' => 'Invalid coordinates. Please try again.'
		];
	}
}
