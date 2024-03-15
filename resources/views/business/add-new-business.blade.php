<x-layout>
    <x-slot:title>Add New Business</x-slot>

    <form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data" x-data="form">
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

            <x-forms.text-field
                label="Other Location Info"
                placeholder="Other Location Info"
                name="other_location_info"
                :value="old('other_location_info')"
                :error="$errors->first('other_location_info')"
            />

            <x-forms.file-input-field 
                :label="'Supporting Images (maximum of ' . App\Models\ImageUpload::MAX_UPLOADS . ' images)'"
                name="supporting_images[]"
                file-types="image/png, image/jpeg"
                camera="environment"
                :error="collect([$errors->first('supporting_images'), $errors->first('supporting_images.*')])->first(fn($val, $key) => $val != '')"
                :multiple="true"
            />

            

            <div id="map-container" class="lg:col-span-2 hidden">
                <h3 class="text-left font-bold">Tag business location</h3>

                <div id="map" class="h-96"></div>

                <input type="hidden" name="coordinates" x-model="coordinates">
            </div>

            <div class="lg:col-span-2 mt-5">
                <x-actions.button
                    text="Submit Form"
                    class="btn-primary btn-outline btn-block"
                />
            </div>
        </div>
    </form>

    @pushOnce('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('form', () => ({
                    map: null,
                    marker: null,
                    coordinates: {{ Js::from(old('coordinates')) }},

                    init(){
                        navigator.geolocation.getCurrentPosition((position) => {
                            document.getElementById('map-container').classList.remove('hidden');

                            var initial_coordinates = [];

                            if(this.coordinates != null)
                            {
                                initial_coordinates[0] = _.split(this.coordinates, ' ')[0];
                                initial_coordinates[1] = _.split(this.coordinates, ' ')[1];
                            }

                            else
                            {
                                initial_coordinates[0] = position.coords.latitude;
                                initial_coordinates[1] = position.coords.longitude;

                                this.coordinates = position.coords.latitude + ' ' + position.coords.longitude;
                            }

                            this.map = L.map('map')
                                        .setView([initial_coordinates[0], initial_coordinates[1]], 15)
                                        .on('click', (e) => {
                                            this.map.removeLayer(this.marker);
                                            this.marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(this.map);
                                            this.coordinates = this.marker._latlng.lat + ' ' + this.marker._latlng.lng;
                                        });

                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                            }).addTo(this.map);

                            this.marker = L.marker([initial_coordinates[0], initial_coordinates[1]]).addTo(this.map);
                        }, () => {
                            window.alert('Location service is blocked. Please enable it in your browser\'s site settings.');
                        });
                    }
                }));
            });
        </script>
    @endPushOnce
</x-layout>