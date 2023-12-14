<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\SaveInspectionChecklistRequest;
use App\Http\Requests\ValidateBinRequest;

class StoreValidateBinAndInspectionChecklist extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		$formRequests = [
			SaveInspectionChecklistRequest::class,
			ValidateBinRequest::class
		];

		$rules = [];

		foreach ($formRequests as $source)
			$rules = array_merge($rules, (new $source)->rules());

		return $rules;
	}
}
