<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewBusinessRequest;
use App\Http\Requests\ValidateBinRequest;
use App\Http\Requests\SaveInspectionChecklistRequest;
use App\Models\Address;
use App\Models\Business;
use App\Services\BusinessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
	private $business_service;

	public function __construct(BusinessService $business_service)
	{
		$this->business_service = $business_service;
	}

	public function showAddNewBusiness() : View
	{
		return view('business.add-new-business', [
			'addresses' => (new Address)->transformForSelectField()
		]);
	}

	public function addNewBusiness(AddNewBusinessRequest $request) : RedirectResponse
	{
		$business = $this->business_service->add($request->validated());

		return redirect()->route('checklist', ['bin' => $business->id_no]);
	}

	public function getBusinesses(Request $request) : View
	{
		$businesses = new Business;
		
		if($request->search_by != null || $request->search != null)
			Validator::make($request->all(), [
				'search_by' => 'bail|required_with:search|in:business_name,business_id_no,owner_name,brgy',
				'search' => 'bail|required_with:search_by|string'
			])->validate();

		return view('business.get-businesses', [
			'businesses' => $businesses->paginate(100)
		]);
	}

	public function getChecklist() : View
	{
		return view('business.inspection-checklist', $this->business_service->retrieveInfoForChecklist());
	}

	public function saveChecklist(Request $request)
	{
		//validate BIN first...
		app(ValidateBinRequest::class);

		$business = Business::where('id_no', $request->bin)->first();

		//then validate the inspection checklist
		$request = app(SaveInspectionChecklistRequest::class, ['business' => $business]);
		
		$this->business_service->saveBusinessInspectionChecklist($request->validated(), $business);
	}
}
