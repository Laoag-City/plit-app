@props([
	'label',
	'name',
	'fileTypes',
	'camera' => '',
	'error' => ''
])

<div class="form-control">
	<label class="label">
		<span class="label-text font-bold">{{ $label }}</span>
	</label>
	
	<div {{ $attributes->class(['tooltip tooltip-error' => $error])->merge(['data-tip' => $error]) }}>
		<input 
			type="file" 
			name="{{ $name }}"
			value=""
			accept="{{ $fileTypes }}"
			capture="{{ $camera }}"
			class="file-input file-input-bordered w-full {{ !$error ?: 'file-input-error' }}"
		/>
	</div>
</div>