<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Requirement;
use App\Models\Owner;
use App\Models\Business;
use App\Models\Address;
use App\Models\BusinessRequirement;
use App\Models\ImageUpload;
use App\Models\Remark;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BusinessService
{
	protected $request;
	protected $image_upload_service;

	public function __construct(Request $request, ImageUploadService $image_upload_service)
	{
		$this->request = $request;
		$this->image_upload_service = $image_upload_service;
	}

	public function add($validated)
	{
		$requirements = Requirement::where('mandatory', true)->get();

		if($validated['owner_name_selection_id'] == null)
		{
			$owner = new Owner;
			$owner->name = $validated['owner_name'];
			$owner->save();
		}

		$business = new Business;

		$business->owner_id = $validated['owner_name_selection_id'] ? $validated['owner_name_selection_id'] : $owner->owner_id;
		$business->address_id = Address::find($validated['barangay'])->first()->address_id;
		$business->id_no = $validated['business_id_number'];
		$business->name = $validated['business_name'];
		$business->location_specifics = $validated['other_location_info'];

		$business->save();

		foreach($requirements as $requirement)
		{
			$business_requirement = new BusinessRequirement;

			$business_requirement->business_id = $business->business_id;
			$business_requirement->requirement_id = $requirement->requirement_id;
			$business_requirement->complied = false;

			$business_requirement->save();
		}

		if(isset($validated['supporting_images']))
			$this->image_upload_service->saveImageUploads($validated['supporting_images'], $business->business_id);

		/*foreach($validated['supporting_images'] as $image)
		{
			$image_upload = new ImageUpload;
			//save the image

			$path = Storage::putFile($image_upload->getImageUploadDirectory($business->business_id), $image);

			//save the image path to database
			$image_upload->office_id = request()->user()->office_id;
			$image_upload->business_id = $business->business_id;
			$image_upload->image_path = $path;

			$image_upload->save();

			//to-do: accessing image metadata to extract gps location
		}*/

		return $business;
	}

	public function retrieveInfoForChecklist()
	{
		$business = null;

		$mandatory_business_requirements = null;
		$other_offices_other_requirements = null;
		$other_requirement = null;

		$remarks = null;
		$user_office_remarks = null;

		$image_uploads = null;
		$user_office_remaining_image_uploads = null;

		$mandatory_req_for_js = [];
		$other_offices_other_req_for_js = [];
		$other_req_for_js = [];

		if($this->request->bin)
		{
			$business = Business::where('id_no', $this->request->bin)->first();

			if($business != null)
			{
				//requirements
				$mandatory_business_requirements = BusinessRequirement::where('business_id', '=', $business->business_id)
																		->orderBy('requirement_id', 'asc')
																		->with(['requirement' => function(Builder $query){
																			$query->where('mandatory', '=', true);
																		}, 'requirement.office'])->get();

				$other_offices_other_requirements = BusinessRequirement::where('business_id', '=', $business->business_id)
																		->withWhereHas('requirement', function(Builder $query){
																			$query->where([
																				['mandatory', '=', false],
																				['office_id', '<>', Auth::user()->office_id]
																			]);
																		})
																		->with('requirement.office')
																		->get();

				$other_requirement = BusinessRequirement::where('business_id', '=', $business->business_id)
														->withWhereHas('requirement', function(Builder $query){
															$query->where([
																['mandatory', '=', false],
																['office_id', '=', Auth::user()->office_id]
															]);
														})
														->with('requirement.office')
														->first();


				//remarks
				$remarks = Remark::where('business_id', '=', $business->business_id)
								->with(['office'])
								->get();

				//get the remarks of the user's office...
				if($business->inspection_count == 0 || $business->inspection_count == 1)
					$operation = '<';
				else
					$operation = '==';

				$user_office_remarks = $remarks->where('inspection_count', $operation, 2)
												->where('office_id', '==', Auth::user()->office->office_id)
												->first()
												->remarks ?? null;

				//then, the remarks of other offices
				$remarks = $remarks->where('office_id', '!=', Auth::user()->office->office_id);


				//images
				$image_uploads = ImageUpload::where('business_id', '=', $business->business_id)->get();

				if(Gate::allows('pld-personnel-action-only'))
					$user_office_remaining_image_uploads = $image_uploads->where('office_id', '=', Auth::user()->office->office_id)->count();


				//for alpineJS reactivity
				foreach($mandatory_business_requirements as $val)
				{
					$mandatory_req_for_js[$val['requirement_id']] = [
																		'requirement_field_val' => $val['requirement_params_value'],
																		'is_checked' => (bool)$val['complied'],
																		'is_mandatory' => (bool)$val['requirement']['mandatory'],
																		'has_requirement_field' => (bool)$val['requirement']['has_dynamic_params'],
																		'cannot_comply' => true
																	];
				}

				foreach($other_offices_other_requirements as $val)
				{
					$other_offices_other_req_for_js[$val['requirement_id']] = [
																		'requirement_field_val' => $val['requirement']['requirement'],
																		'is_checked' => (bool)$val['complied'],
																		'is_mandatory' => (bool)$val['requirement']['mandatory'],
																		'has_requirement_field' => (bool)$val['requirement']['has_dynamic_params']
																	];
				}

				$other_req_for_js = $other_requirement == null ? [
										'requirement_field_val' => '',
										'is_checked' => false,
										'is_mandatory' => false,
										'has_requirement_field' => false,
										'cannot_comply' => true
									]
									: [
										'requirement_field_val' => $other_requirement->requirement->requirement,
										'is_checked' => (bool)$other_requirement->complied,
										'is_mandatory' => (bool)$other_requirement->requirement->mandatory,
										'has_requirement_field' => (bool)$other_requirement->requirement->has_dynamic_params,
										'cannot_comply' => true
									];
			}
		}

		return [
			'business' => $business,

			'mandatory_business_requirements' => $mandatory_business_requirements,
			'other_offices_other_requirements' => $other_offices_other_requirements,
			'other_requirement' => $other_requirement,

			'remarks' => $remarks,
			'user_office_remarks' => $user_office_remarks,
			
			'image_uploads' => $image_uploads,
			'user_office_remaining_image_uploads' => $user_office_remaining_image_uploads,
			'uploads_disabled' => ImageUpload::MAX_UPLOADS <= $user_office_remaining_image_uploads,

			'mandatory_req_for_js' => $mandatory_req_for_js,
			'other_offices_other_req_for_js' => $other_offices_other_req_for_js,
			'other_req_for_js' => $other_req_for_js
		];
	}

	public function saveBusinessInspectionChecklist($validated, Business $business)
	{
		foreach($validated['requirement'] as $key => $val)
		{
			//$current_inspection_status = $business->getInspectionStatus();
			$business_requirement = $business->businessRequirements->where('requirement_id', $key)->first();
			//dd($validated, $business_requirement);
			if($business_requirement->requirement->has_dynamic_params && isset($val['parameter']))
				$business_requirement->requirement_params_value = $val['parameter'];

			if(isset($val['complied']))
				$business_requirement->complied = true;

			$business_requirement->save();
		}

		if(Gate::allows('pld-personnel-action-only'))
		{
			if(isset($validated['inspection_status']))
				$business->inspection_status = (int)$validated['inspection_status'];

			if(isset($validated['supporting_images']))
				$this->image_upload_service->saveImageUploads($validated['supporting_images'], $business->business_id);

			$business->inspection_date = $validated['initial_inspection_date'];
			$business->re_inspection_date = $validated['reinspection_date'];
			$business->due_date = $validated['due_date'];

			$business->save();
		}

		if($validated['remarks'] != null)
		{
			$remark = Remark::firstOrNew([
				'office_id' => request()->user()->office->office_id,
				'business_id' => $business->business_id, 
				'inspection_count' => (int)$validated['inspection_status']
			]);

			$remark->remarks = $validated['remarks'];
			$remark->save();
		}
	}

	public function isBusinessFullyComplied(Business $business)
	{
		$complied = !$business->businessRequirements->contains(function($item, $key) {
			return $item->complied == false;
		});

		if($complied)
		{
			$business->inspection_status = 4;
			$business->save();
		}

		return $complied;
	}
}

?>