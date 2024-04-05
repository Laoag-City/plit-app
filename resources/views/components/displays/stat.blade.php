@props([
	'title',
	'value',
	'desc' => null,
	'valueIsLink' => false,
	'url' => null
])

<div class="stats shadow mx-2 my-3">
	<div class="stat">
		<div class="stat-title">{{ $title }}</div>
		@if($valueIsLink)
			<a class="stat-value" href="{{ $url }}">{{ $value }}</a>
		@else
			<div class="stat-value">{{ $value }}</div>
		@endif
		<div class="stat-desc">{{ $desc }}</div>
	</div>
  </div>