@props([
	'label',
	'name',
	'value' => 1,
	'checked' => false,
	'error' => '',
	'labelJustifyClass' => "justify-start"
])

<div class="form-control self-center">
	<div {{ $attributes->class(['tooltip tooltip-error' => $error])->merge(['data-tip' => $error]) }}>
		<label class="label cursor-pointer {{ $labelJustifyClass }}">
			<input
				type="checkbox"
				name="{{ $name }}"
				value="{{ $value }}"
				{{ $attributes->class(['checkbox lg:ml-5', 'checkbox-error' => $error]) }}
				{{ !$checked ?: 'checked' }}
			/>
			<span class="label-text ml-5 lg:mr-5">{{ $label }}</span> 
		</label>
	</div>
</div>