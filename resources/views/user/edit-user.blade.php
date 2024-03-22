<x-layout>
	<x-slot:title>Edit User</x-slot>

	<form method="POST" action="{{ url()->current() }}" class="grid grid-cols-1 lg:grid-cols-3 mt-8">
		@method('PUT')
		@csrf

		<div class="lg:col-start-2">
			<a class="btn btn-accent btn-outline btn-block btn-sm mb-8" href="{{ route('user_dashboard') }}">Back</a>

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
				:value="old('name') ? old('name') : $user->name"
				class="mb-4"
				:error="$errors->first('name')"
			/>

			<x-forms.select-field
				label="Office"
				name="office"
				:options="$offices"
				:selected="old('office') ? old('office') : $user->office_id"
				class="mb-4"
				:error="$errors->first('office')"
			/>

			<x-forms.text-field
				label="Username"
				placeholder="Username"
				name="username"
				:value="old('username') ? old('username') : $user->username"
				class="mb-4"
				:error="$errors->first('username')"
			/>

			<div class="divider"></div>

			<x-forms.text-field
				label="Change Password"
				placeholder="Change Password"
				name="change_password"
				value=""
				type="password"
				class="mb-4"
				:error="$errors->first('change_password')"
			/>

			<x-forms.text-field
				label="Change Password Confirmation"
				placeholder="Change Password Confirmation"
				name="change_password_confirmation"
				value=""
				type="password"
				class="mb-4"
				:error="$errors->first('change_password_confirmation')"
			/>

			<div class="divider"></div>

			<x-forms.select-field
				label="User Level"
				name="user_level"
				:options="[['value' => '1', 'name' => 'Administrator'], ['value' => '0', 'name' => 'Regular User']]"
				:selected="old('user_level') ? old('user_level') : $user->admin"
				class="mb-4"
				:error="$errors->first('user_level')"
			/>

			<div class="mt-4 mb-4">
				<x-actions.button
					text="Edit User"
					class="btn-primary btn-outline btn-block"
				/>
			</div>
		</div>
	</form>
</x-layout>