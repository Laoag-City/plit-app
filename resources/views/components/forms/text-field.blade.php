@props([
	'label' => '',
	'type' => 'text',
	'name',
	'value',
	'placeholder' => '',
	'error' => ''
])

<div {{ $attributes->class('form-control') }}>
	@if($label)
		<label class="label">
			<span class="label-text font-bold">{{ $label }}</span>
		</label>
	@endif
	
	<div class="{{ !$error ?: 'tooltip tooltip-error' }}" data-tip="{{ $error }}">
		<input 
			type="{{ $type }}" 
			name="{{ $name }}" 
			value="{{ $value }}" 
			placeholder="{{ $placeholder }}"
			class="input input-bordered w-full {{ !$error ?: 'input-error' }}"
		/>
	</div>

	{{ $slot }}
</div>