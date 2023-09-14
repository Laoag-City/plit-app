@props([
	'label',
	'type' => 'text',
	'name',
	'value',
	'placeholder' => ''
])

<div class="form-control">
	<label class="label">
		<span class="label-text font-bold">{{ $label }}</span>
	</label>
	<input 
		type="{{ $type }}" 
		name="{{ $name }}" 
		value="{{ $value }}" 
		placeholder="{{ $placeholder }}" 
		class="input input-bordered w-full" 
	/>
</div>