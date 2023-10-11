<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewBusinessRequest;
use App\Models\Address;
use App\Models\Business;
use App\Models\Owner;
use App\Models\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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

        foreach($validated['supporting_images'] as $image)
        {
            $image_upload = new ImageUpload;
            //save the image

            $path = Storage::putFile($image_upload->getImageUploadDirectory($business->business_id), $image);

            //save the image path to database
            $image_upload->user_id = request()->user()->user_id;
            $image_upload->business_id = $business->business_id;
            $image_upload->image_path = $path;

            $image_upload->save();

            //to-do: accessing image metadata to extract gps location
        }

        return redirect(route('checklist'));
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
        $requirements = null;

        if($request->bin)
        {
            $business = Business::where('id_no', $request->bin)
                                ->with(['business_requirements', 'business_requirements.requirement'])
                                ->first();
        }

        return view('business.inspection-checklist', [
            'business' => $business
        ]);
    }
}
