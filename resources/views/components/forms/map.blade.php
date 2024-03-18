@props([
	'currentCoordinates' => null
])

<div id="map-container" {{ $attributes->class(['hidden']) }} x-data="map">
	<h3 class="text-left font-bold">Tag business location</h3>

	<div id="map" class="h-96"></div>

	<input type="hidden" name="coordinates" x-model="coordinates">
</div>

@pushOnce('scripts')
	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('map', () => ({
				map: null,
				marker: null,
				coordinates: {{ Js::from(old('coordinates') ? old('coordinates') : $currentCoordinates) }},

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