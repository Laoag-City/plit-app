@props([
	'currentCoordinates' => null,
	'error' => '',
	'label' => 'Business location',
	'viewOnly' => false
])

<div id="map-container" {{ $attributes->class(['hidden form-control', 'tooltip tooltip-error' => $error != '']) }} data-tip="{{ $error }}" x-data="map">
	<label class="label">
		<span class="label-text font-bold {{ $error == '' ?: 'text-red-800'}}">{{ $label }}</span>
	</label>

	<input type="hidden" name="coordinates" x-model="coordinates">

	<div id="map" class="h-96"></div>

	
</div>

@pushOnce('scripts')
	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('map', () => ({
				map: null,
				marker: null,
				coordinates: {{ Js::from(old('coordinates') ? old('coordinates') : $currentCoordinates) }},
				viewOnly: {{ Js::from($viewOnly) }},

				init(){
					navigator.geolocation.getCurrentPosition((position) => {
						document.getElementById('map-container').classList.remove('hidden');

						var initial_coordinates = [];

						if(this.coordinates != null)
						{
							initial_coordinates[0] = _.split(this.coordinates, ', ')[0];
							initial_coordinates[1] = _.split(this.coordinates, ', ')[1];
						}

						else
						{
							initial_coordinates[0] = position.coords.latitude;
							initial_coordinates[1] = position.coords.longitude;

							//this.coordinates = position.coords.latitude + ', ' + position.coords.longitude;
						}

						this.map = L.map('map').setView([initial_coordinates[0], initial_coordinates[1]], 15);

						if(this.viewOnly == false)
							this.map = this.map.on('click', (e) => {
											if(this.marker != null)
												this.map.removeLayer(this.marker);

											this.marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(this.map);
											this.coordinates = this.marker._latlng.lat + ', ' + this.marker._latlng.lng;
										});

						L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
							maxZoom: 19,
							attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
						}).addTo(this.map);

						if(this.coordinates != null)
							this.marker = L.marker([initial_coordinates[0], initial_coordinates[1]]).addTo(this.map);
					}, () => {
						window.alert('Location service is blocked. Please enable it in your browser\'s site settings.');
					});
				}
			}));
		});
	</script>
@endPushOnce