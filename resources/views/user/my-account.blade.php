<x-layout>
	<x-slot:title>My Account</x-slot>

	<form action="{{ url()->current() }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 mt-8">
		@csrf
		@method('PUT')

		<div class="lg:col-start-2">
			@if($errors->any())
				<x-displays.alert class="alert-error mb-4">
					<b>There are errors in the form you submitted.</b>
				</x-displays.alert>
			@elseif(session('success'))
				<x-displays.alert class="alert-success mb-4">
					<b>{{ session('success') }}</b>
				</x-displays.alert>
			@endif

			<x-forms.text-field
				label="Name"
				placeholder="Name"
				name="name"
				:value="request()->user()->name"
				class="mb-4"
				:readonly="true"
			/>

			<x-forms.text-field
				label="Office"
				placeholder="Office"
				name="office"
				:value="request()->user()->office->name"
				class="mb-4"
				:readonly="true"
			/>

			<x-forms.text-field
				label="Username"
				placeholder="Username"
				name="username"
				:value="old('username') ? old('username') : request()->user()->username"
				class="mb-4"
				:error="$errors->first('username')"
			/>

			<div class="divider mb-4"></div>

			<x-forms.text-field
				label="Old Password"
				placeholder="Old Password"
				name="old_password"
				value=""
				type="password"
				class="mb-4"
				:error="$errors->first('old_password')"
			/>

			<x-forms.text-field
				label="New Password"
				placeholder="New Password"
				name="new_password"
				value=""
				type="password"
				class="mb-4"
				:error="$errors->first('new_password')"
			/>

			<x-forms.text-field
				label="New Password Confirmation"
				placeholder="New Password Confirmation"
				name="new_password_confirmation"
				value=""
				type="password"
				class="mb-4"
				:error="$errors->first('new_password_confirmation')"
			/>

			<div class="mt-4 mb-4">
				<x-actions.button
					text="Edit My Account"
					class="btn-primary btn-outline btn-block"
				/>
			</div>
		</div>
	</form>
</x-layout>