@props([
	'business' => app('App\Models\Business'),
	'showDates' => false
])

<div {{ $attributes->class('grid grid-cols-subgrid') }}>
	<div class="col-span-1 lg:col-span-2 text-justify" >
		<h3>{{ $business->name }}</h3>
		<h4>{{ $business->owner->name }}</h4>
		<h4>{{ $business->address->brgy }}</h4>
		<h4>{{ $business->location_specifics }}</h4>
		@if($showDates)
			<h4>Inspection Date: {{ $business->inspection_date }}</h4>
			<h4>Reinspection Date: {{ $business->re_inspection_date }}</h4>
		@endif
	</div>

	<div class="col-span-1 lg:col-span-1 text-justify lg:text-right">
		<h3>BIN: {{ $business->id_no }}</h3>
		<h4>Status: {{ $business->getInspectionStatus() }}</h4>
		@if($showDates)
			<h4>Due Date: {{ $business->due_date }}</h4>
		@endif
	</div>
</div>