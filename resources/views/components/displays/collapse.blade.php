@props(['bgColor' => 'bg-base-300'])

<div {{ $attributes->merge(['class' => 'collapse my-3 '. $bgColor]) }}>
	<input type="checkbox" /> 
	<div class="collapse-title text-lg font-medium">
		{{ $slot }}
	</div>
	<div class="collapse-content"> 
		{{ $content }}
	</div>
</div>