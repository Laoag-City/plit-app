@props([
	'images' => [],
	'carousel_content_prefix' => 'content'
])

<div class="carousel w-full">
	@foreach($images as $image)
		<div id="{{ $carousel_content_prefix . $loop->iteration }}" class="carousel-item relative w-full">
			<img src="{{--link to image--}}" class="w-full" />
			<div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
				@php
					if($loop->first)
						$previous = $carousel_content_prefix . count($images);
					else
						$previous = $carousel_content_prefix . ($loop->iteration - 1);

					if($loop->last)
						$next = $carousel_content_prefix . 1;
					else
						$next = $carousel_content_prefix . ($loop->iteration + 1);
				@endphp

				<a href="#{{ $previous }}" class="btn btn-circle">❮</a> 
				<a href="#{{ $next }}" class="btn btn-circle">❯</a>
			</div>
		</div> 
	@endforeach