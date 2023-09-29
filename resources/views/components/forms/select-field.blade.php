@props([
	'label',
	'name',
	'options' => [],
	'selected' => null,
	'error' => ''
])

<div class="form-control">
	<label class="label">
		<span class="label-text font-bold">{{ $label }}</span>
	</label>

	<div {{ $attributes->class(['tooltip tooltip-error' => $error])->merge(['data-tip' => $error]) }}>
		<select name="{{ $name }}" class="select select-bordered w-full {{ !$error ?: 'select-error' }}">
			<option disabled selected>Choose a {{ Str::title($name) }}</option>
			@foreach ($options as $option)
				<option value="{{ $option['value'] }}" {{ $option['value'] != $selected ?: 'selected'}}>
					{{ $option['name'] }}
				</option>
			@endforeach
		</select>
	</div>
</div>