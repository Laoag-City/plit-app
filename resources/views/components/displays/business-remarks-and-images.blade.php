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
					@foreach($remarks as $remark)
						<li><b>{{ $remark->office->name }}</b> - {{ $remark->remarks }}</li>
					@endforeach
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