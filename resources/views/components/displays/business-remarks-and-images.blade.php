@props([
	'remarks' => app('App\Models\Remark'),
	'imageUploads' => app('App\Models\ImageUpload')
])

<div {{ $attributes->class('grid grid-cols-subgrid') }}>
	<div class="col-span-full">
		<h3 class="">Other Info:</h3>

		<x-displays.collapse>
			Remarks from other offices

			<x-slot:content>
				@if($remarks->isNotEmpty())
					@php
						$remarks_initial = $remarks->where('inspection_count', '<', 2);
						$remarks_reinspect = $remarks->where('inspection_count', '==', 2);
					@endphp

					@if($remarks_initial->isNotEmpty())
						<p>Initial Inspection Remarks</p>
						<ul>
							@foreach($remarks_initial as $remark)
								<li><b>{{ $remarks->office->name }}</b> - {{ $remarks->name }}</li>
							@endforeach
						</ul>
					@endif

					@if($remarks_reinspect->isNotEmpty())
						<p>Re-inspection Remarks</p>
						<ul>
							@foreach($remarks_initial as $remark)
								<li><b>{{ $remarks->office->name }}</b> - {{ $remarks->name }}</li>
							@endforeach
						</ul>
					@endif
				@else
					No remarks yet.
				@endif
			</x-slot>
		</x-displays.collapse>

		<x-displays.collapse>
			Uploaded Images

			<x-slot:content>
				@if($imageUploads->isNotEmpty())
					<x-displays.carousel :images="$imageUploads"/>
				@else
					No images yet.
				@endif
			</x-slot>
		</x-displays.collapse>
	</div>
</div>