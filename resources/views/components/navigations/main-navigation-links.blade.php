<li>
	<details>
		<summary>Permits and Licenses</summary>

		<ul>
			@can('pld-personnel-action-only')
				<li><a href="{{ route('new_business') }}">Add New Business</a></li>
			@endcan
			<li><a href="{{ route('checklist') }}">Inspection Checklist</a></li>
			<li><a href="{{ route('businesses') }}">Businesses</a></li>
		</ul>
	</details>
</li>

<li>
	<a>My Account</a>
</li>