@props(['text'])

<button {{ $attributes->merge(['class' => 'btn', 'type' => 'submit']) }}>
	<b>{{ $text }}</b>
</button>