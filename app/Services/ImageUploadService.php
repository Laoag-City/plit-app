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

	public function updateImageUploads($business, $request)
	{
		$image_uploads = $business->imageUploads;

		if(isset($request['supporting_images']))
			foreach($request['supporting_images'] as $key => $image)
			{
				$image_upload = $image_uploads->where('image_upload_id', $key)->first();

				if(isset($image['new']))
				{
					Storage::delete($image_upload->image_path);

					$path = Storage::putFile($image_upload->getImageUploadDirectory($business->business_id), $image['new']);

					$image_upload->office_id = request()->user()->office_id;
					$image_upload->image_path = $path;

					$image_upload->save();
				}

				elseif(isset($image['remove']))
				{
					Storage::delete($image_upload->image_path);
					$image_upload->delete();
				}
			}

		if(isset($request['additional_images']))
			$this->saveImageUploads($request['additional_images'], $business->business_id);
	}
}

?>