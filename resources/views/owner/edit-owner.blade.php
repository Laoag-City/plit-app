<x-layout>
	<x-slot:title>Edit Owner Info</x-slot>

	<x-navigations.owner-pages-links :owner="$owner"></x-navigations.owner-pages-links>

	<form method="POST" action="{{ url()->current() }}" class="mt-8">
		@method('PUT')
		@csrf

		@if($errors->any())
			<x-displays.alert class="alert-error">
				<b>There are errors in the form you submitted.</b>
			</x-displays.alert>
		@elseif(session('success'))
			<x-displays.alert class="alert-success">
				<b>{{ session('success') }}</b>
			</x-displays.alert>
		@endif

		<div class="grid grid-cols-1 lg:grid-cols-3">
			<x-forms.text-field
				label="Owner Name"
				placeholder="Owner Name"
				name="owner_name"
				:value="old('owner_name') ? old('owner_name') : $owner->name"
				class="lg:col-start-2 mb-4"
				:error="$errors->first('owner_name')"
			/>
			
			<div class="lg:col-start-2 mt-4 mb-4">
				<x-actions.button
					text="Edit Owner Info"
					class="btn-primary btn-outline btn-block"
				/>
			</div>
		</div>
	</form>
</x-layout>