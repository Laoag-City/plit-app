@props([
	'images' => [],
	'carouselContentPrefix' => 'content'
])

<div class="carousel w-full">
	@foreach($images as $image)
		<div id="{{ $carouselContentPrefix . $loop->iteration }}" class="carousel-item relative w-full">
			<img src="{{--link to image--}}" class="w-full" />
			<div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
				@php
					if($loop->first)
						$previous = $carouselContentPrefix . count($images);
					else
						$previous = $carouselContentPrefix . ($loop->iteration - 1);

					if($loop->last)
						$next = $carouselContentPrefix . 1;
					else
						$next = $carouselContentPrefix . ($loop->iteration + 1);
				@endphp

				<a href="#{{ $previous }}" class="btn btn-circle">❮</a> 
				<a href="#{{ $next }}" class="btn btn-circle">❯</a>
			</div>
		</div> 
	@endforeach