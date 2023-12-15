<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewBusinessRequest;
use App\Http\Requests\ValidateBinRequest;
use App\Http\Requests\SaveInspectionChecklistRequest;
use App\Models\Address;
use App\Models\Business;
use App\Models\BusinessRequirement;
use App\Models\Owner;
use App\Models\ImageUpload;
use App\Models\Remark;
use App\Models\Requirement;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class BusinessController extends Controller
{
	public function showAddNewBusiness() : View
	{
		return view('business.add-new-business', [
			'addresses' => (new Address)->transformForSelectField()
		]);
	}

	public function addNewBusiness(AddNewBusinessRequest $request) : RedirectResponse
	{
		$validated = $request->validated();
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

		foreach($validated['supporting_images'] as $image)
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
		}

		return redirect()->route('checklist', ['bin' => $business->id_no]);
	}

	public function getBusinesses(Request $request) : View
	{
		$businesses = new Business;
		
		if($request->search_by != null || $request->search != null)
		{
			Validator::make($request->all(), [
				'search_by' => 'bail|required_with:search|in:business_name,business_id_no,owner_name,brgy',
				'search' => 'bail|required_with:search_by|string'
			])->validate();
		}

		return view('business.get-businesses', [
			'businesses' => $businesses->paginate(100)
		]);
	}

	public function getChecklist(Request $request) : View
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

		if($request->bin)
		{
			$business = Business::where('id_no', $request->bin)->first();

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
																		})->get();

				$other_requirement = BusinessRequirement::where('business_id', '=', $business->business_id)
														->withWhereHas('requirement', function(Builder $query){
															$query->where([
																['mandatory', '=', false],
																['office_id', '=', Auth::user()->office_id]
															]);
														})->first();


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

				/* alternate way of the above code for AlpineJS
				$mandatory_req_for_js = collect($mandatory_business_requirements->toArray())
												->keyBy('requirement_id')
												->map(function($item, $key){
													return [
														'requirement_field_val' => $item['requirement_params_value'],
														'is_checked' => (bool)$item['complied'],
														'is_mandatory' => $item['requirement']['mandatory'],
														'has_requirement_field' => $item['requirement']['has_dynamic_params']
													];
												});

				$other_offices_other_req_for_js = collect($other_offices_other_requirements->toArray())
													->keyBy('requirement_id')
													->map(function($item, $key){
														return [
															'requirement_field_val' => $item['requirement']['requirement'],
															'is_checked' => (bool)$item['complied'],
															'is_mandatory' => $item['requirement']['mandatory'],
															'has_requirement_field' => $item['requirement']['has_dynamic_params']
														];
													})->toJson();

				$other_req_for_js = $other_requirement == null ? collect([])->toJson()
									: collect([
												'requirement_field_val' => $other_requirement->requirement->requirement,
												'is_checked' => (bool)$other_requirement->complied,
												'is_mandatory' => $other_requirement->requirement->mandatory,
												'has_requirement_field' => $other_requirement->requirement->has_dynamic_params
											])->toJson();*/
			}
		}

		return view('business.inspection-checklist', [
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
		]);
	}

	public function saveChecklist()
	{
		//validate BIN first...
		app(ValidateBinRequest::class);
		//then validate the inspection checklist
		$request = app(SaveInspectionChecklistRequest::class);
		
		$validated = $request->validated();
	}
}
