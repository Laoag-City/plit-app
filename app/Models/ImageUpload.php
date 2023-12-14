<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageUpload extends Model
{
	use HasFactory;

	protected $primaryKey = 'image_upload_id';
	const MAX_UPLOADS = 5;

	public function office()
	{
		return $this->belongsTo(Office::class, 'office_id', 'office_id');
	}

	public function business()
	{
		return $this->belongsTo(Business::class, 'business_id', 'business_id');
	}

	public function getImageUploadDirectory($business_id)
	{
		return "businesses/$business_id";
	}
}
