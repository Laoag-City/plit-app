<x-layout>
	<x-slot:title>Owner Info</x-slot>

	<x-navigations.owner-pages-links :owner="$owner"></x-navigations.owner-pages-links>

	<div class="text-justify">
		<h3 class="my-4 font-bold text-xl">{{ $owner->name }}</h3>
		
		@if($businesses->count() != 0)
			<h4 class="mt-8 mb-2 font-bold text-lg">Businesses owned</h4>

			<x-displays.businesses-table :businesses="$businesses"></x-displays.businesses-table>
		@else
			<p>Does not own any business.</p>
		@endif
	</div>
</x-layout>