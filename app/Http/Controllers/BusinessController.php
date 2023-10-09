<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewBusinessRequest;
use App\Models\Address;
use App\Models\Business;
use App\Models\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $business->save();

        //do file upload logic

        return back();
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
}
