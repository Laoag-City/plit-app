<li class="z-10">
	<details>
		<summary>Permits and Licenses</summary>

		<ul>
			@can('pld-personnel-action-only')
				<li>
					<a href="{{ route('new_business') }}" 
						class="{{ $current_url != route('new_business') ?: 'active' }}">
						Add New Business
					</a>
				</li>
			@endcan
			<li>
				<a href="{{ route('checklist') }}" 
					class="{{ $current_url != route('checklist') ?: 'active' }}">
					Inspection Checklist
				</a>
			</li>
			<li>
				<a href="{{ route('businesses') }}" 
					class="{{ $current_url != route('businesses') ?: 'active' }}">
					Businesses
				</a>
			</li>
			<li>
				<a href="{{ route('owners') }}" 
					class="{{ $current_url != route('owners') ?: 'active' }}">
					Owners
				</a>
			</li>
		</ul>
	</details>
</li>

<li>
	<a href="{{ route('my_account') }}">
		My Account
	</a>
</li>

<li>
	<form action="{{ route('search') }}" method="GET" class="join gap-0 p-0">
		<input type="text" placeholder="Search records" name="keyword" value="{{ request()->keyword }}" class="input join-item input-sm input-bordered w-auto hover:bg-white focus:bg-white" required minlength="3"/>
		<button type="submit" class="join-item btn btn-outline btn-sm btn-secondary">Search</button>
	</form>
</li>