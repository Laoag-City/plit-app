<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Models\ImageUpload;
use Illuminate\View\View;

class ImageUploadController extends Controller
{

    public function showImage(Business $business, ImageUpload $image_upload)
    {
        return response()->file(storage_path('app/' . $image_upload->image_path));
    }

    public function showImageManager(Business $business) : View
    {
        return view('image-upload.image-manager', [
            'business' => $business,
            'images' => $business->imageUploads
        ]);
    }
}
