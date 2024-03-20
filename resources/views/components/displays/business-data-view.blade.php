@props([
	'business' => app('App\Models\Business'),
	'showDates' => false
])

<div {{ $attributes->class('grid grid-cols-subgrid prose') }}>
	<div class="col-span-1 lg:col-span-2 text-justify" >
		<h2 class="mt-2">{{ $business->name }}</h2>
		<h4><a href="{{ route('owner_info', ['owner' => $business->owner]) }}" class="link">{{ $business->owner->name }}</a></h4>
		<h4>{{ $business->address->brgy }}</h4>
		<h4>{{ $business->location_specifics }}</h4>
		@if($showDates)
			<h4>Inspection Date: {{ $business->inspection_date ? $business->inspection_date->toFormattedDateString() : null }}</h4>
			<h4>Reinspection Date: {{ $business->re_inspection_date ? $business->re_inspection_date->toFormattedDateString() : null }}</h4>
		@endif
	</div>

	<div class="col-span-1 lg:col-span-1 text-justify lg:text-right">
		<h3 class="mt-2">Status: {{ $business->getInspectionStatus() }}</h3>
		<h3>BIN: {{ $business->id_no }}</h3>
		@if($showDates)
			<h4 class="text-red-900">Due Date: {{ $business->due_date ? $business->due_date->toFormattedDateString() : null }}</h4>
		@endif
	</div>
</div>