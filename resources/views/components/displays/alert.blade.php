<div {{ $attributes->merge(['class' => 'alert prose']) }} x-data="{alertOpen : true}" x-show="alertOpen">
	<span>
		{{ $slot }}
	</span>

	<div>
		<button type="button" class="btn btn-xs" @click="alertOpen = false">Close</button>
	  </div>
  </div>