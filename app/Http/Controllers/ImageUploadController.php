<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Models\ImageUpload;

class ImageUploadController extends Controller
{

    public function showImage(Business $business, ImageUpload $image_upload)
    {
        return response()->file(storage_path('app/' . $image_upload->image_path));
    }
}
