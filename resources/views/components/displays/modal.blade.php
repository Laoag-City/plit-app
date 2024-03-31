@props([
	'header',
	'content',
	'formButtonText'
])

<dialog id="my_modal_1" class="modal">
	<div class="modal-box">
		<h3 class="text-lg font-bold">{{ $header }}</h3>
		<p class="py-4">{{ $content }}</p>
		<div class="modal-action">
			<form method="POST">
				<button type="submit" class="btn btn-primary">{{ $formButtonText }}</button>
			</form>

			<form method="dialog">
				<!-- if there is a button in form, it will close the modal -->
				<button class="btn">Close</button>
			</form>
		</div>
	</div>
</dialog>
