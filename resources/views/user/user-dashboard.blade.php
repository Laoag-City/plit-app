<x-layout>
	<x-slot:title>User Dashboard</x-slot>

	<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
		<div class="lg:col-span-1 p-4 border rounded-lg border-gray-300 bg-base-200 shadow-lg shadow-gray-400">
			<h3 class="text-xl font-bold">Add User</h3>

			<form method="POST" action="{{ route('new_user') }}">
				@csrf

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
					:value="old('name')"
					class="mb-4"
					:error="$errors->first('name')"
				/>

				<x-forms.select-field
					label="Office"
					name="office"
					:options="$offices"
					:selected="old('office')"
					class="mb-4"
					:error="$errors->first('office')"
				/>

				<x-forms.text-field
					label="Username"
					placeholder="Username"
					name="username"
					:value="old('username')"
					class="mb-4"
					:error="$errors->first('username')"
				/>

				<x-forms.text-field
					label="Password"
					placeholder="Password"
					name="password"
					value=""
					type="password"
					class="mb-4"
					:error="$errors->first('password')"
				/>

				<x-forms.text-field
					label="Password Confirmation"
					placeholder="Password Confirmation"
					name="password_confirmation"
					value=""
					type="password"
					class="mb-4"
					:error="$errors->first('password_confirmation')"
				/>

				<x-forms.select-field
					label="User Level"
					name="user_level"
					:options="[['value' => '1', 'name' => 'Administrator'], ['value' => '0', 'name' => 'Regular User']]"
					:selected="old('user_level')"
					class="mb-4"
					:error="$errors->first('user_level')"
				/>

				<div class="mt-4 mb-4">
					<x-actions.button
						text="Add User"
						class="btn-primary btn-outline btn-block"
					/>
				</div>
			</form>
		</div>

		<div class="lg:col-span-2 p-4 border rounded-lg border-gray-300 bg-base-200 shadow-lg shadow-gray-400">
			<h3 class="text-xl font-bold">User List</h3>

			<x-displays.table class="table-xs sm:table-md mb-20">
				<x-slot:head>
					<tr class="border-gray-400">
						<th>Name</th>
						<th>Office</th>
						<th>Username</th>
						<th>Admin</th>
						<th></th>
					</tr>
				</x-slot>

				<x-slot:body>
					@foreach($users as $user)
						<tr class="hover border-gray-400">
							<td>{{ $user->name }}</td>
							<td>{{ $user->office->name }}</td>
							<td>{{ $user->username }}</td>
							<td>{{ (bool)$user->admin ? 'Yes' : 'No' }}</td>
							<td>
								<x-actions.dropdown-menu class="dropdown-bottom dropdown-end">
									<x-slot:label>Options</x-slot>
			
									<li><a href="{{ route('edit_user', ['user' => $user]) }}">Edit</a></li>
									<li><a href="">Remove</a></li>
								</x-actions.dropdown-menu>
							</td>
						</tr>
					@endforeach
				</x-slot>
			</x-displays.table>
		</div>
	</div>
</x-layout>