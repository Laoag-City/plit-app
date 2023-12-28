<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
	use HasFactory;

	protected $primaryKey = 'requirement_id';
	protected $non_mandatory_prefix = 'Others - ';

	public function businessRequirements()
	{
		return $this->hasMany(BusinessRequirement::class, 'requirement_id', 'requirement_id');
	}

	public function office()
	{
		return $this->belongsTo(Office::class, 'office_id', 'office_id');
	}

	public function getParams()
	{
		if($this->has_dynamic_params)
		{
			$matches = null;
			
			//get all params in curly braces with number
			preg_match_all("/{(\d)}/", $this->requirement, $matches, PREG_PATTERN_ORDER);

			return ['param' => $matches[0][0], 'loc' => strpos($this->requirement, $matches[0][0])];
		}

		return null;
	}
}
