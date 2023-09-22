<x-layout>
    <x-slot:title>Add New Business</x-slot>

    <form action="" method="POST" class="max-w-none prose">
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

            <x-forms.text-field
                label="Barangay"
                placeholder="Barangay"
                name="barangay"
                :value="old('barangay')"
                :error="$errors->first('barangay')"
            />
        </div>
    </form>
</x-layout>