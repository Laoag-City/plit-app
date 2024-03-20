<x-layout>
	<x-slot:title>Search Results</x-slot>

	<h3 class="text-left font-bold text-lg">Search results for <i>{{ request()->keyword }}</i></h3>

	<div role="tablist" class="tabs tabs-lifted">
		<input type="radio" name="my_tabs_2" role="tab" class="tab font-bold" aria-label="Owners" checked/>
		<div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
			@if($owners->count() != 0)
			<x-displays.owners-table :owners="$owners"></x-displays.owners-table>
			@else
				<p>No search results.</p>
			@endif
		</div>
	  
		<input type="radio" name="my_tabs_2" role="tab" class="tab font-bold" aria-label="Businesses"/>
		<div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
			@if($businesses->count() != 0)
				<x-displays.businesses-table :businesses="$businesses"></x-displays.businesses-table>
			@else
				<p>No search results.</p>
			@endif
		</div>
	  </div>
</x-layout>