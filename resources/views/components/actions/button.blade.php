@props(['text'])

<button {{ $attributes->merge(['class' => 'btn', 'type' => 'submit']) }}>
	{{ $text }}
</button>