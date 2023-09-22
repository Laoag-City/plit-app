<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function showAddNewBusiness() : View
    {
        return view('business.add-new-business');
    }

    public function addNewBusiness(Request $request) : RedirectResponse
    {
        return back();
    }
}
