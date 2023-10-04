<div class="form-control">
	<!--label-->
	<label class="label">
		<span class="label-text font-bold">{{ $label }}</span>
	</label>
	
	<!--inputs-->
	<div class="flex">
		<div class="flex-1 {{ !$error ?: 'tooltip tooltip-error' }}" data-tip="{{ $error }}">
			<input 
				type="{{ $type }}" 
				name="{{ $name }}" 
				value="{{ $value }}" 
				placeholder="{{ $placeholder }}"
				class="input input-bordered w-full {{ !$error ?: 'input-error' }}"
			/>
		</div>

		<div class="flex-none basis-1/4">
			<x-actions.button 
				type="button" 
				class="btn-outline btn-accent" 
				text="{{ $buttonText }}"
			/>
		</div>
	</div>

	<!--search results-->
	<div class="dropdown not-prose">
		<label tabindex="0" id="{{ $dropdownLabelId }}"></label>
		<ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-full mt-1">
			@foreach ($results as $result)
				<li wire:key="{{ $loop->iteration }}">
					<a href="#">{{ $result['text'] }}</a>
				</li>
			@endforeach
		</ul>
	</div>
</div>