<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUploadedImagesRequest;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Models\ImageUpload;
use App\Services\ImageUploadService;
use Illuminate\View\View;

class ImageUploadController extends Controller
{
    private $image_upload_service;

    public function __construct(ImageUploadService $image_upload_service)
    {
        $this->image_upload_service = $image_upload_service;;
    }

    public function showImage(Business $business, ImageUpload $image_upload)
    {
        return response()->file(storage_path('app/' . $image_upload->image_path), ['Cache-Control' => 'No-Store']);
    }

    public function showImageManager(Business $business) : View
    {
        $image_uploads = $business->imageUploads;

        return view('image-upload.image-manager', [
            'business' => $business,
            'images' => $image_uploads,
            'user_office_remaining_image_uploads' => $image_uploads->count()
        ]);
    }

    public function updateImages(Business $business, UpdateUploadedImagesRequest $request)
    {
        $this->image_upload_service->updateImageUploads($business, $request->validated());

        return back()->with('success', 'Images updated successfully.');
    }
}
