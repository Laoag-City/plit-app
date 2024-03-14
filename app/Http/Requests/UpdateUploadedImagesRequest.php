<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Models\ImageUpload;

class UpdateUploadedImagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(Request $request): array
    {
        $current_image_uploaded = ImageUpload::where([
                ['business_id', '=', $request->business->business_id],
                ['office_id', '=', $request->user()->office->office_id]
            ])->count();

    $remaining_image_uploads = ImageUpload::MAX_UPLOADS - $current_image_uploaded;

        return [
            'supporting_images' => 'bail|sometimes|array|max:' . $current_image_uploaded,
			'supporting_images.*.new' => 'bail|sometimes|image|max:1280',
            'supporting_images.*.remove' => 'bail|sometimes|boolean',

            'additional_images' => 'bail|sometimes|array|max:' . $remaining_image_uploads,
			'additional_images.*' => 'bail|image|max:1280'
        ];
    }

    public function after(Request $request): array
    {
        return [
            function (Validator $validator) use($request) {
                $business_images = $request->business->imageUploads->pluck('image_upload_id');

                if(isset($request->supporting_images) && is_array($request->supporting_images))
                    foreach($request->supporting_images as $key => $image)
                    {
                        if(!$business_images->contains($key))
                            $validator->errors()->add('supporting_images', 'Invalid image array ID. Please try again.');

                        if(isset($image['new']) && isset($image['remove']))
                        {
                            $error = 'An image\'s Change Image and Remove field cannot be present at the same time.';
                            
                            $validator->errors()->add("supporting_images.$key.new", $error);
                            $validator->errors()->add("supporting_images.$key.remove", $error);
                        }
                    }
            }
        ];
    }

    public function messages(): array
    {
        return [
            'supporting_images.*.new.image' => 'The file must be an image.',
            'supporting_images.*.new.max' => 'The image must not be greater than 1280 kilobytes.',
            'supporting_images.*.remove.boolean' => 'The field must be either true or false.',

            'additional_images.*.image' => 'The file(s) must be an image.',
            'additional_images.*.max' => 'The image(s) must not be greater than 1280 kilobytes.'
        ];
    }
}
