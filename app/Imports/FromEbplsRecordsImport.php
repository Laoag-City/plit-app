<?php

namespace App\Imports;

use App\Models\Address;
use App\Models\Business;
use App\Models\Owner;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class FromEbplsRecordsImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /*
        To execute this class, run the following code below through Artisan's Tinker CLI:
        Maatwebsite\Excel\Facades\Excel::import(new App\Imports\FromEbplsRecordsImport, storage_path('app/BusinessMasterlist-09-18-2023.xlsx'));
    */

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row)
        {
            //skip rows that has a 0 or 2 cell content in exclusion column
            if($row['exclusion'] !== 0 && $row['exclusion'] != 2)
            {
                //barangay filtering
                $is_brgy = preg_match("/([0-9]+)(-[A-C])?/", $row['barangay'], $matches);
                $is_market = Str::contains($row['barangay'], ['Market', 'Complex']);

                if($is_brgy)
                    $address = Address::where('brgy_no', $matches[0])->first();

                elseif($is_market)
                    $address = Address::where('brgy_no', '16')->first();

                else
                    dd('Something went wrong. Check barangay column.');

                $owner = Owner::where('name', $row['name_of_owner'])->first();

                if($owner == null)
                {
                    $owner =  new Owner;
                    $owner->name = $row['name_of_owner'];
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
                $business->id_no = $row['business_identification_no'];
                $business->name = $row['business_name'];
                $business->location_specifics = $row['location_of_business'];
                $business->save();
            }
        }
    }
}
