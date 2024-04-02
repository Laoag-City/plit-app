@props([
	'title',
	'value',
	'desc' => null
])

<div class="stats shadow mx-2 my-3">
	<div class="stat">
		<div class="stat-title">{{ $title }}</div>
		<div class="stat-value">{{ $value }}</div>
		<div class="stat-desc">{{ $desc }}</div>
	</div>
  </div>