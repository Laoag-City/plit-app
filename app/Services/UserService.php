<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserService
{
	public function edit(User $user, $validated, $is_current_user = false)
	{
		$user->username = $validated['username'];
		
		if(isset($validated['new_password']))
			$user->password = bcrypt($validated['new_password']);

		if(!$is_current_user && Gate::allows('pld-personnel-action-only'))
		{
			$user->office_id = $validated['office_id'];
			$user->name = $validated['name'];
		}
		
		$user->save();
	}
}

?>