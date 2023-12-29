<?php

namespace App\Services;

use App\Models\ImageUpload;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
	public function saveImageUploads($uploads, $business_id)
	{
		foreach($uploads as $image)
		{
			$image_upload = new ImageUpload;
			//save the image

			$path = Storage::putFile($image_upload->getImageUploadDirectory($business_id), $image);

			//save the image path to database
			$image_upload->office_id = request()->user()->office_id;
			$image_upload->business_id = $business_id;
			$image_upload->image_path = $path;

			$image_upload->save();

			//to-do: accessing image metadata to extract gps location
		}

		return true;
	}
}

?>