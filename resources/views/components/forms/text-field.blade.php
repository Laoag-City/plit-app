@props([
	'label',
	'type' => 'text',
	'name',
	'value',
	'placeholder' => '',
	'error' => ''
])

<div class="form-control">
	<label class="label">
		<span class="label-text font-bold">{{ $label }}</span>
	</label>
	
	<div {{ $attributes->class(['tooltip tooltip-error' => $error])->merge(['data-tip' => $error]) }}>
		<input 
			type="{{ $type }}" 
			name="{{ $name }}" 
			value="{{ $value }}" 
			placeholder="{{ $placeholder }}" 
			{{ $attributes->class(['input input-bordered w-full', 'input-error' => $error]) }}
		/>
	</div>
</div>