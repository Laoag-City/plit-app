<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
	use HasFactory;

	protected $primaryKey = 'office_id';

	public function users()
	{
		return $this->hasMany(User::class, 'office_id', 'office_id');
	}

	public function requirements()
	{
		return $this->hasMany(Requirement::class, 'office_id', 'office_id');
	}

	public function imageUploads()
	{
		return $this->hasMany(ImageUpload::class, 'office_id', 'office_id');
	}

	public function remarks()
	{
		return $this->hasMany(Remark::class, 'office_id', 'office_id');
	}
}
