<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Requirement;
use App\Models\Owner;
use App\Models\Business;
use App\Models\Address;
use App\Models\BusinessRequirement;
use App\Models\ImageUpload;
use Illuminate\Support\Facades\Storage;

class BusinessService
{
	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
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

		return $business;
	}
}

?>