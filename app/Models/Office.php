<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\ForSelectFields;

class Office extends Model implements ForSelectFields
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

	public function transformForSelectField() : array
	{
		return $this->all()
					->transform(function($item, $key){
						return [
							'value' => $item->office_id,
							'name' => $item->name
						];
					})->toArray();
	}
}
