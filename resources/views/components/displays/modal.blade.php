@props([
	'header',
	'content',
	'formLinkSuffix',
	'formButtonText'
])

<dialog id="modal_container" class="modal" x-data="modal">
	<div class="modal-box">
		<h3 class="text-lg font-bold">{{ $header }}</h3>
		<p class="py-4">{{ $content }}</p>
		<div class="modal-action">
			<form id="modal_form" method="POST" x-bind:action="full_form_link">
				<button type="submit" x-on:click="setFormLink" class="btn btn-primary">{{ $formButtonText }}</button>
			</form>

			<form method="dialog">
				<button class="btn">Close</button>
			</form>
		</div>
	</div>
</dialog>

@pushOnce('scripts')
	<script>
		var link_id = null;

		function openModal(button_link_id)
		{
			link_id = button_link_id;
			//open modal
		}

		document.addEventListener('alpine:init', () => {
			Alpine.data('modal', () => ({
				form_link_suffix = {{ Js::from($formLinkSuffix) }},

				full_form_link: null,

				setFormLink(){
					//prevent default
					this.full_form_link = form_link_suffix + '/' + link_id;
					//submit form
				}
			}));
		});
	</script>
@endPushOnce