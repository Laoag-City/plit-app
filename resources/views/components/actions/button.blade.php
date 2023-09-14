@props([
	'type' => 'submit',
	'text'
	])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn']) }}>
	<b>{{ $text }}</b>
</button>