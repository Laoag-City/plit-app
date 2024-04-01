@props([
	'modalId',
	'header',
	'content',
	'method',
	'formLinkSuffix',
	'formButtonText'
])

<dialog id="{{ $modalId }}" class="modal">
	<div class="modal-box">
		<h3 class="text-lg font-bold">{{ $header }}</h3>
		<p class="py-4">{{ $content }}</p>
		<div class="modal-action">
			<form id="{{ $modalId }}_modal_form" method="POST">
				@method($method)
				@csrf
				<button type="submit" class="btn btn-primary">{{ $formButtonText }}</button>
			</form>

			<form method="dialog">
				<button class="btn">Close</button>
			</form>
		</div>
	</div>
</dialog>

@push('scripts')
	<script>
		var {{ $modalId }}_link_id = null;
		var {{ $modalId }}_form_link_suffix = {{ Js::from($formLinkSuffix) }};

		function openModal{{ $modalId }}(button_link_id)
		{
			{{ $modalId }}_link_id = button_link_id;
			document.getElementById('{{ $modalId }}_modal_form').setAttribute('action', {{ $modalId }}_form_link_suffix + '/' + {{ $modalId }}_link_id);
			{{ $modalId }}.showModal();
		}
	</script>
@endPush