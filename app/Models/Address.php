<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\ForSelectFields;

class Address extends Model implements ForSelectFields
{
	use HasFactory;

	protected $primaryKey = 'address_id';

	public function businesses()
	{
		return $this->hasMany(Business::class, 'address_id', 'address_id');
	}

	public function transformForSelectField() : array
	{
		return $this->all()
					->transform(function($item, $key){
						return [
							'value' => $item->address_id,
							'name' => $item->brgy
						];
					})->toArray();
	}
}
