<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditOwnerRequest;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\OwnerService;

class OwnerController extends Controller
{
	private $owner_service;

	public function __construct(OwnerService $owner_service)
	{
		$this->owner_service = $owner_service;
	}

	public function getOwners(): View
	{
		$owners = new Owner;
		
		return view('owner.get-owners', [
			'owners' => $owners->load(['businesses'])->paginate(100)
		]);
	}

	public function getOwnerInfo(Owner $owner): View
	{
		return view('owner.owner-info', [
			'owner' => $owner,
			'businesses' => $owner->businesses
		]);
	}

	public function showEditOwner(Owner $owner): View
	{
		return view('owner.edit-owner', [
			'owner' => $owner
		]);
	}

	public function editOwner(Owner $owner, EditOwnerRequest $request)
	{
		$this->owner_service->edit($owner, $request->validated());

		return back()->with('success', 'Owner Info updated successfully.');
	}
}
