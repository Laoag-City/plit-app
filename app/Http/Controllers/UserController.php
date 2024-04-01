<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewUserRequest;
use App\Http\Requests\EditMyAccountRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\Office;
use App\Models\User;
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

    public function showUserDashboard(): View
    {
        return view('user.user-dashboard', [
            'users' => User::with(['office'])->get(),
            'offices' => (new Office)->transformForSelectField()
        ]);
    }

    public function addNewUser(AddNewUserRequest $request)
    {
        $this->user_service->add($request->validated());

        return back()->with('success', 'New user added successfully.');
    }

    public function showEditUser(User $user): View
    {
        return view('user.edit-user', [
            'user' => $user,
            'offices' => (new Office)->transformForSelectField()
        ]);
    }

    public function editUser(EditUserRequest $request, User $user)
    {
        $this->user_service->edit($user, $request->validated(), false);

        return back()->with('success', 'User info updated successfully.');
    }

    public function removeUser(User $user)
    {
        $user->delete();
        return back();
    }
}
