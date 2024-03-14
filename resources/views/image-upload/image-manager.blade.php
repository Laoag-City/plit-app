<x-layout>
	<x-slot:title>Manage Images</x-slot>

	<x-navigations.business-pages-links :business="$business"></x-navigations.business-pages-links>

	<form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data" x-data="imageFields">
		@csrf
		@method('put')

		@if($errors->any())
			<x-displays.alert class="alert-error">
				<b>There are errors in the form you submitted.</b>
			</x-displays.alert>
		@elseif(session('success'))
			<x-displays.alert class="alert-success">
				<b>{{ session('success') }}</b>
			</x-displays.alert>
		@endif

		@foreach($images as $image)
			<div class="flex flex-wrap items-center justify-evenly gap-6 bg-gray-300 rounded-lg lg:mx-auto lg:w-3/4 px-6 py-4 my-6">
				<div class="avatar">
					<div class="w-52 rounded-lg">
						<img src="{{ route('image', ['business' => $business->business_id, 'image_upload' => $image->image_upload_id]) }}"/>
					</div>
				</div>

				<x-forms.file-input-field 
					label="Change Image"
					:name="'supporting_images[' . $image->image_upload_id . '][new]'"
					file-types="image/png, image/jpeg"
					camera="environment"
					:error="$errors->first('supporting_images.' . $image->image_upload_id . '.new')"
					js-bind="resetPairedField"
				/>

				<x-forms.checkbox-field
					label="Remove"
					:name="'supporting_images[' . $image->image_upload_id . '][remove]'"
					:checked="old('supporting_images[' . $image->image_upload_id . '][new]') ? true : false"
					:error="$errors->first('supporting_images.' . $image->image_upload_id . '.remove')"
					js-bind="resetPairedField"
				/>
			</div>
		@endforeach

		@if($user_office_remaining_image_uploads < App\Models\ImageUpload::MAX_UPLOADS)
			<x-forms.file-input-field 
				:label="'Add Images (' . $user_office_remaining_image_uploads . ' / ' . App\Models\ImageUpload::MAX_UPLOADS . ')'"
				name="additional_images[]"
				file-types="image/png, image/jpeg"
				camera="environment"
				class="lg:mx-auto lg:w-3/4"
				:error="collect([$errors->first('additional_images'), $errors->first('additional_images.*')])->first(fn($val, $key) => $val != '')"
				:multiple="true"
			/>
		@endif

		<div class="divider mt-6 mb-16"></div> 

		<x-actions.button
			text="Submit Image Updates"
			class="btn-primary btn-outline btn-block lg:w-3/4 mx-auto"
		/>
	</form>

	@pushOnce('scripts')
		<script>
			document.addEventListener('alpine:init', () => {
				Alpine.data('imageFields', () => ({
					resetPairedField: {
						['@change']($event){
							let trigger = $event.target.name;
							let index = trigger.match(/\d+/)[0];
							let is_new = trigger.includes('new');
							let is_remove = trigger.includes('remove');

							if(is_new)
								document.querySelector('[name="supporting_images[' + index + '][remove]"]').checked = false;

							else if(is_remove)
								document.querySelector('[name="supporting_images[' + index + '][new]"]').value = '';
						}
					}
				}));
			})
		</script>
	@endPushOnce
</x-layout>