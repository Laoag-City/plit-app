<div class="form-control" x-data="textWithSearchSelectionField">
	<!--label-->
	<label class="label">
		<span class="label-text font-bold">
			{{ $label }} 
			<span class="loading loading-spinner loading-sm text-primary ml-1" x-show="loading" x-transition.duration.750ms></span>
		</span>
	</label>
	
	<!--inputs-->
	<div class="flex">
		<div class="flex-1 {{ !$error ?: 'tooltip tooltip-error' }}" data-tip="{{ $error }}">
			<input 
				type="{{ $type }}" 
				name="{{ $name }}" 
				wire:model="value"
				placeholder="{{ $placeholder }}"
				{{ $readOnly ? 'readonly' : '' }}
				autocomplete="off"
				class="input input-bordered w-full {{ !$error ?: 'input-error' }}"
                x-on:keyUp.debounce="($event.target.value.length >= {{ $minSearchChars }} && !$wire.readOnly) ? callSearch($wire, $event.target.value) : ''"
			/>
		</div>

		<input type="hidden" name="{{ $name . $hiddenIdSuffix }}" value="{{ $hiddenIdValue }}"/>

		<div class="flex-none basis-1/4" x-show="$wire.value != null && $wire.hiddenIdValue != null">
			<x-actions.button 
				type="button" 
				class="btn-outline btn-accent" 
				text="{{ $buttonText }}"
				x-on:click="callRemoveSelection($wire)"
			/>
		</div>
	</div>

	<!--search results-->
	<div class="dropdown not-prose">
		<label tabindex="0" id="{{ $dropdownLabelId }}"></label>
		<ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-full mt-1">
			@foreach ($results as $result)
				<li wire:key="{{ $loop->iteration }}">
					<button type="button" x-on:click="callSelection($wire, '{{ $result['id'] }}', '{{ $result['text'] }}')">
						{{ $result['text'] }}
					</button>
				</li>
			@endforeach
		</ul>
	</div>
</div>

@pushOnce('scripts')
	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('textWithSearchSelectionField', () => ({
				loading: false,

				callSearch(wire, search) {
					this.loading = true;
					wire.searchKeyword(search).then(() => {
						if(wire.results.length > 0)
							document.getElementById(wire.dropdownLabelId).focus();
						this.loading = false;
					});
				},

				callSelection(wire, id, text) {
					this.loading = true;
					wire.makeSelection(id, text).then(() => {
						this.loading = false;
					});
				},

				callRemoveSelection(wire) {
					this.loading = true;
					wire.removeSelection().then(() => {
						this.loading = false;
					});
				}
			}))
		})
	</script>
@endPushOnce