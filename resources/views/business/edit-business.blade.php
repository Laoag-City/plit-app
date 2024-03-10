<x-layout>
	<x-slot:title>Edit Business Info</x-slot>

	<div class="max-w-none prose">
		<h2>Edit Business Info</h2>
		<div class="divider"></div>

		<x-navigations.business-pages-links :business="$business"></x-navigations.business-pages-links>

		<form action="{{ url()->current() }}" method="POST" class="mt-8">
			@csrf
			@method('PUT')

			@if($errors->any())
				<x-displays.alert class="alert-error">
					<b>There are errors in the form you submitted.</b>
				</x-displays.alert>
			@endif

			<div class="grid grid-cols-1 lg:grid-cols-3">
				<x-forms.text-field
					label="Business ID Number"
					placeholder="Business ID Number"
					name="business_id_number"
					:value="old('business_id_number') ? old('business_id_number') : $business->id_no"
					class="lg:col-start-2 mb-4"
					:error="$errors->first('business_id_number')"
				/>

				<x-forms.text-field
					label="Business Name"
					placeholder="Business Name"
					name="business_name"
					:value="old('business_name') ? old('business_name') : $business->name"
					class="lg:col-start-2 mb-4"
					:error="$errors->first('business_name')"
				/>

				<livewire:text-with-search-selection-field
					label="Owner Name"
					placeholder="Owner Name"
					name="owner_name"
					:value="old('owner_name') ? old('owner_name') : $business->owner->name"
					root-el-class="lg:col-start-2 mb-4"
					:hidden-id-value="old('owner_name_selection_id') ? old('owner_name_selection_id') : $business->owner->owner_id"
					:error="$errors->first('owner_name')"
					button-text="Change Selection"
					dropdown-label-id="search_results"
					:search="0"
				/>

				<x-forms.select-field
					label="Barangay"
					name="barangay"
					:options="$addresses"
					:selected="old('barangay') ? old('barangay') : $business->address_id"
					class="lg:col-start-2 mb-4"
					:error="$errors->first('barangay')"
				/>

				<x-forms.text-field
					label="Other Location Info"
					placeholder="Other Location Info"
					name="other_location_info"
					:value="old('other_location_info') ? old('other_location_info') : $business->location_specifics"
					class="lg:col-start-2 mb-4"
					:error="$errors->first('other_location_info')"
				/>

				<div class="lg:col-start-2 mt-4 mb-4">
					<x-actions.button
						text="Submit Form"
						class="btn-primary btn-outline btn-block"
					/>
				</div>
			</div>
		</form>
	</div>
</x-layout>