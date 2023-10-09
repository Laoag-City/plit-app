@props([
	'label',
	'name',
	'value' => 1,
	'checked' => false,
	'error' => '',
	'labelJustifyClass' => "justify-start"
])

<div {{ $attributes->class('form-control self-center') }}>
	<div class="{{ !$error ?: 'tooltip tooltip-error' }}" data-tip="{{ $error }}">
		<label class="label cursor-pointer {{ $labelJustifyClass }}">
			<input
				type="checkbox"
				name="{{ $name }}"
				value="{{ $value }}"
				class="checkbox lg:ml-5 {{ !$error ?: 'checkbox-error'}}"
				{{ !$checked ?: 'checked' }}
			/>
			<span class="label-text ml-5 lg:mr-5">{{ $label }}</span> 
		</label>
	</div>
</div>