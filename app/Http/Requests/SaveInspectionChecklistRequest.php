<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Business;
use App\Models\ImageUpload;
use App\Models\Requirement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class SaveInspectionChecklistRequest extends FormRequest
{
	protected $business;

	public function __construct(Business $business)
	{
		$this->business = $business;
	}
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
		$inspection_status_rules = '';
		$coordinates_rules = '';
		$initial_inspection_date_rules = '';
		$reinspection_date_rules = '';
		$due_date_rules = '';
		$remaining_image_uploads = 0;

		//fields with authorization checks
		if(Gate::allows('pld-personnel-action-only'))
		{
			$inspection_status_rules = 'bail|sometimes|in:1,2,3';

			$coordinates_rules = [
				'bail',
				'nullable',
				'regex:/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/'
			];

			$initial_inspection_date_rules = 'bail|nullable|date';

			if($request->reinspection_date != null)
				$initial_inspection_date_rules .= '|before:reinspection_date';

			$reinspection_date_rules = 'bail|nullable|date|after:initial_inspection_date';
			
			$due_date_rules = 'bail|required|date';

			$current_image_uploaded = ImageUpload::where([
										['business_id', '=', $this->business->business_id],
										['office_id', '=', $request->user()->office->office_id]
									])->count();

			$remaining_image_uploads = ImageUpload::MAX_UPLOADS - $current_image_uploaded;
		}

		return [
			'requirement' => 'bail|nullable|array',
			'requirement.*.parameter' => 'bail|nullable|integer|min:1|max:9999',
			'requirement.*.complied' => 'sometimes|bail|accepted',

			'other_requirement' => 'bail|nullable|string|max:150',
			'other_requirement_complied' => 'sometimes|bail|accepted',

			'inspection_status' => $inspection_status_rules,

			'coordinates' => $coordinates_rules,

			'initial_inspection_date' => $initial_inspection_date_rules,
			'reinspection_date' => $reinspection_date_rules,

			'due_date' => $due_date_rules,
			
			'remarks' => 'bail|nullable|string|max:150',
			
			'supporting_images' => 'bail|sometimes|array|max:' . $remaining_image_uploads,
			'supporting_images.*' => 'bail|image|max:1280'
		];
	}

	public function after(Request $request): array
	{
		return [
			function (Validator $validator) use($request) {
				$requirement_is_array = is_array($request->requirement);

				//check each requirements if user is authorized to it
				if($requirement_is_array)
					foreach($request->requirement as $key => $value)
					{
						$requirement = Requirement::find($key);

						if($requirement != null)
						{
							if(Gate::denies('owns-requirement', $requirement))
								$validator->errors()->add("requirement.{$key}", "Requirement {$key} is not applicable for current user.");
						}

						else
							$validator->errors()->add("requirement.{$key}", "Requirement {$key} is not a valid requirement.");
					}

				if(Gate::allows('pld-personnel-action-only'))
				{
					if($request->reinspection_date != null && $request->initial_inspection_date == null)
						$validator->errors()->add('reinspection_date', 'Reinspection Date field requires the Initial Inspection Date field to be present.');

					//if business has complied to all requirements but user unchecked a requirement, make inspection status a required field
					if($this->business->inspection_count == 4)
					{
						$user_office_requirements = $this->business->businessRequirements->where('requirement.office_id', Auth::user()->office_id)->where('requirement.mandatory', true);
						$inspection_status_is_not_set = !isset($request->inspection_status);

						if($requirement_is_array)
						{
							foreach($user_office_requirements as $requirement)
							{
								$requirement_is_not_complied = !isset($request->requirement[$requirement->requirement_id]['complied']);

								if($requirement_is_not_complied && $inspection_status_is_not_set)
								{
									$validator->errors()->add('inspection_status', 'The Inspection Status field is required.');
									break;
								}
							}
						}

						elseif(!$requirement_is_array && $user_office_requirements->count() > 0 && $inspection_status_is_not_set)
							$validator->errors()->add('inspection_status', 'The Inspection Status field is required.');

						//dd($request->all(), $request->requirement, $user_office_requirements);
					}
				}
			}
		];
	}
}
