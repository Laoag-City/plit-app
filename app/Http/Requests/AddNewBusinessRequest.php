<?php

namespace App\Http\Requests;

use App\Models\ImageUpload;
use App\Models\Owner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

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
	public function rules(Request $request): array
	{
		return [
			'business_id_number' => 'bail|required|string|unique:businesses,id_no|min:14|max:20',
			'business_name' => 'bail|required|string|max:250',
			'owner_name' => 'bail|required|string|max:200',
			'owner_name_selection_id' => 'bail|nullable|exists:owners,owner_id',
			'barangay' => 'bail|required|exists:addresses,address_id',
			'other_location_info' => 'bail|nullable|string:max:200',
			'supporting_images' => 'bail|nullable|array|max:' . ImageUpload::MAX_UPLOADS,
			'supporting_images.*' => 'bail|image|max:1280'
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
}
