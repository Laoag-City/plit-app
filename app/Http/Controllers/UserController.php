<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditMyAccountRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    private $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function showMyAccount(): View
    {
        return view('user.my-account');
    }

    public function editMyAccount(EditMyAccountRequest $request)
    {
        $this->user_service->edit(request()->user(), $request->validated(), true);

        return back()->with('success', 'Your account info has been updated successfully.');
    }
}
