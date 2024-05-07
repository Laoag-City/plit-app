<?php

namespace App\Imports;

use App\Models\Address;
use App\Models\Business;
use App\Models\Owner;
use App\Models\Requirement;
use App\Models\BusinessRequirement;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class FromEbplsRecordsImport implements ToCollection, WithHeadingRow
{
	use Importable;

	/*
		To execute this class, paste the excel file in the project's root folder, name it BusinessMasterlist.xlsx, and run the following code below through Artisan's Tinker CLI:
			Maatwebsite\Excel\Facades\Excel::import(new App\Imports\FromEbplsRecordsImport, base_path('BusinessMasterlist.xlsx'));

		The excel file to be imported must be sorted from latest to earliest Permit No's year prefix and must have all the following columns:
			Business Identification No
			Permit No
			Business Name
			Name of Owner - if not present, concatenate the individual name fields of the owner to create this field
			Location of Business
			Barangay - must contain the barangay number
	*/

	/**
	* @param Collection $collection
	*/
	public function collection(Collection $rows)
	{
		$requirements = Requirement::where('mandatory', true)->get();
		
		foreach($rows as $row)
		{
			//remove possible trailing whitespaces
			$business_identification_no = Str::of($row['business_identification_no'])->squish();
			$barangay = Str::of($row['barangay'])->squish();
			$location_of_business = Str::of($row['location_of_business'])->squish();
			$name_of_owner = Str::of($row['name_of_owner'])->squish();
			$business_name = Str::of($row['business_name'])->squish();

			$business = Business::where('id_no', $business_identification_no)->first();
			
			//check if current row is a duplicate BIN
			if($business != null)
				continue;

			//barangay filtering
			$has_brgy_no = preg_match("/([0-9]+)(-[A-C])?/", $barangay, $matches);
			$is_market = Str::contains($barangay, ['Market', 'Complex']);

			if($has_brgy_no)
			{
				$address = Address::where('brgy_no', $matches[0])->first();

				if($address == null)
					continue;
			}

			elseif($is_market)
				$address = Address::where('brgy_no', '16')->first();

			else
				continue;

			$owner = Owner::where('name', $name_of_owner)->first();

			if($owner == null)
			{
				$owner =  new Owner;
				$owner->name = $name_of_owner;
				$owner->save();
			}

			/*
				$classification = Classification::where('line_of_business', $row['nature_of_businessdescription'])->first();

				if($classification == null)
				{
					$classification = new Classification;
					$classification->line_of_business = $row['nature_of_businessdescription'];
					$classification->save();
				}
			*/

			$business = new Business;
			$business->owner_id = $owner->owner_id;
			$business->address_id = $address->address_id; 
			//$business->classification_id = $classification->classification_id;
			$business->id_no = $business_identification_no;
			$business->name = $business_name;
			$business->location_specifics = $location_of_business;
			$business->save();

			foreach($requirements as $requirement)
			{
				$business_requirement = new BusinessRequirement;

				$business_requirement->business_id = $business->business_id;
				$business_requirement->requirement_id = $requirement->requirement_id;
				$business_requirement->complied = false;

				$business_requirement->save();
			}
		}
	}
}
