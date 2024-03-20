<?php

namespace App\Services;

use App\Models\Owner;

class OwnerService
{
	public function edit(Owner $owner, $validated)
	{
		$owner->name = $validated['owner_name'];
		$owner->save();
	}
}

?>