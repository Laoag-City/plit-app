<x-layout>
	<x-slot:title>Manage Images</x-slot>

	<x-navigations.business-pages-links :business="$business"></x-navigations.business-pages-links>

	<div class="grid grid-cols-1 mt-8 not-prose">
		@foreach($images as $image)
			
		@endforeach
	</div>
</x-layout>