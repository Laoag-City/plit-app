@props([
	'label',
	'name',
	'fileTypes',
	'camera' => '',
	'error' => '',
	'multiple' => false,
	'disabled' => false
])

<div {{ $attributes->class('form-control') }}>
	<label class="label">
		<span class="label-text font-bold">{{ $label }}</span>
	</label>
	
	<div class="{{ !$error ?: 'tooltip tooltip-error' }}" data-tip="{{ $error }}">
		<input 
			type="file" 
			name="{{ $name }}"
			value=""
			accept="{{ $fileTypes }}"
			capture="{{ $camera }}"
			{{ $multiple ? 'multiple' : '' }}
			{{ $disabled ? 'disabled' : '' }}
			class="file-input file-input-bordered w-full {{ !$error ?: 'file-input-error' }}"
		/>
	</div>
</div>