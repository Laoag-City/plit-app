<div {{ $attributes->merge(['class' => 'alert prose mx-auto']) }} x-data="{alertOpen : true}" x-show="alertOpen">
	<span>
		{{ $slot }}
	</span>

	<div class="mx-auto">
		<button type="button" class="btn btn-xs" @click="alertOpen = false">Close</button>
	  </div>
  </div>