<li>
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
		</ul>
	</details>
</li>

<li>
	<a>My Account</a>
</li>