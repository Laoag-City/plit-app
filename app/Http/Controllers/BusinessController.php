<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewBusinessRequest;
use App\Models\Address;
use App\Models\Business;
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

        $business = new Business;

        $business->business_id_number = $validated['business_id_number'];
        $business->business_name = $validated['business_name'];

        $business->save();

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
