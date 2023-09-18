<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthenticationController extends Controller
{
    public function showLogin() : View
    {
        return view('login');
    }

    public function authenticate(Request $request) : RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        $validator->validate();

        $validator->after(function($validator) use ($request){
            if(!Auth::attempt(['username' => $request->username, 'password' => $request->password]))
                    //Since the following error is owned by username and password field and we don't want individual error messages for both fields, 
                    //just put a non-existing field name named compound_error.
                    $validator->errors()->add('compound_error', 'You entered an invalid login credential.');
        });

        $validator->validate();

        return redirect('home');
    }

    public function logOut() : RedirectResponse
    {
        Auth::logout();
        return back();
    }
}
