<x-layout>
    <x-slot:title>Add New Business</x-slot>

    <form action="{{ url('/') }}" method="POST" class="max-w-none prose">
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

            <x-forms.text-field
                label="Owner Name"
                placeholder="Owner Name"
                name="owner_name"
                :value="old('owner_name')"
                :error="$errors->first('owner_name')"
            />

            <x-forms.select-field
                label="Barangay"
                name="barangay"
                :options="$addresses"
                :selected="old('barangay')"
                :error="$errors->first('barangay')"
            />
            
            <x-forms.text-field
                label="Line of Business"
                placeholder="Line of Business"
                name="line_of_business"
                :value="old('line_of_business')"
                :error="$errors->first('line_of_business')"
            />

            <x-forms.checkbox-field
                label="Specify another kind of Line of Business"
                name="another_line_of_business"
                :checked="(bool)old('another_line_of_business') ? true : false"
                :error="$errors->first('another_line_of_business')"
            />

            <div class="lg:flex lg:col-span-2 lg:justify-center">
                <x-forms.file-input-field 
                    label="Supporting Image"
                    name="supporting_image"
                    file-types="image/png, image/jpeg"
                    camera="environment"
                    :error="$errors->first('supporting_image')"
                />
            </div>

            <div class="lg:flex lg:col-span-2 lg:justify-center">
                <x-actions.button
                    type="button"
                    text="Add another supporting image"
                    class="btn-outline btn-accent"
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