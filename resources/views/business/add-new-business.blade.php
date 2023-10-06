<x-layout>
    <x-slot:title>Add New Business</x-slot>

    <form action="{{ url('/') }}" method="POST" class="max-w-none prose" enctype="multipart/form-data">
        <h2>Add New Business</h2>
        <div class="divider"></div>

        @csrf

        @if($errors->any())
            <x-displays.alert class="alert-error">
                <b>There are errors in the form you submitted.</b>
            </x-displays.alert>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-8">
            <x-forms.text-field
                label="Business ID Number"
                placeholder="Business ID Number"
                name="business_id_number"
                :value="old('business_id_number')"
                :error="$errors->first('business_id_number')"
            />

            <x-forms.text-field
                label="Business Name"
                placeholder="Business Name"
                name="business_name"
                :value="old('business_name')"
                :error="$errors->first('business_name')"
            />

            <livewire:text-with-search-selection-field
                label="Owner Name"
                placeholder="Owner Name"
                name="owner_name"
                :value="old('owner_name')"
                :hidden-id-value="old('owner_name_selection_id')"
                :error="$errors->first('owner_name')"
                button-text="Change Selection"
                dropdown-label-id="search_results"
                :search="0"
            />

            <x-forms.select-field
                label="Barangay"
                name="barangay"
                :options="$addresses"
                :selected="old('barangay')"
                :error="$errors->first('barangay')"
            />

            <div class="lg:flex lg:col-span-2 lg:justify-center">
                <x-forms.file-input-field 
                    label="Supporting Images"
                    name="supporting_images[]"
                    file-types="image/png, image/jpeg"
                    camera="environment"
                    :error="$errors->first('supporting_images[]')"
                    :multiple="true"
                />
            </div>

            <div class="lg:col-span-2 mt-14">
                <x-actions.button
                    text="Submit Form"
                    class="btn-primary btn-outline btn-block"
                />
            </div>
        </div>
    </form>
</x-layout>