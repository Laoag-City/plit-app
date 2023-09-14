<x-layout>
	<x-slot:title>Log In</x-slot>

	<div class="flex h-screen">
		<form method="POST" action="{{ url()->current() }}" class="m-auto w-[21rem] lg:w-1/3 bg-accent rounded-xl shadow-lg p-6">
			<h1 class="font-bold text-5xl mb-5">Log In</h1>
			<span class="text-lg">Permits and Licenses Inspectorate Team App</span>
			
			<div class="divider"></div>

			@if($errors->any())
				<x-displays.alert class="alert-error">
					<b>Oops! Something went wrong...</b>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</x-displays.alert>
			@endif

			@method('POST')
			@csrf

			<x-forms.text-field
				label="Username"
				name="username"
				placeholder="Username"
				value="{{ old('username') }}"
			/>

			<x-forms.text-field
				label="Password"
				type="password"
				name="password"
				placeholder="Password"
				value="{{ old('password') }}"
			/>
			
			<x-actions.button 
				text="Log In"
				class="btn-primary btn-block btn-neutral mt-8"
			/>
		</form>
	</div>
</x-layout>