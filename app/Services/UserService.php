<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserService
{
	public function add($validated)
	{
		$user = new User;
		$user->name = $validated['name'];
		$user->office_id = $validated['office'];
		$user->username = $validated['username'];
		$user->password =  bcrypt($validated['password']);
		$user->admin = (bool)$validated['user_level'] ? true : false;
		$user->save();
	}

	public function edit(User $user, $validated, $is_current_user = false)
	{
		$user->username = $validated['username'];
		
		if(isset($validated['change_password']))
			$user->password = bcrypt($validated['change_password']);

		if(!$is_current_user && Gate::allows('is-admin'))
		{
			$user->office_id = $validated['office'];
			$user->name = $validated['name'];
			$user->admin = (bool)$validated['user_level'] ? true : false;
		}
		
		$user->save();
	}
}

?>