@props([
	'owners',
	'paginate' => false
])

<x-displays.table class="table-xs sm:table-md mb-32">
	<x-slot:head>
		<tr>
			<th>Owner Name</th>
			<th>Businesses</th>
			<th></th>
		</tr>
	</x-slot>

	<x-slot:body>
		@foreach ($owners as $owner)
			<tr class="hover">
				<td>{{ $owner->name }}</td>
				<td>{{ $owner->businesses->count() }}</td>
				<td>
					<x-actions.dropdown-menu class="dropdown-bottom dropdown-end">
						<x-slot:label>Options</x-slot>

						<li><a href="{{ route('owner_info', ['owner' => $owner]) }}">Owner Info</a></li>
						@can('pld-personnel-action-only')
							<li><a href="{{ route('edit_owner', ['owner' => $owner]) }}">Edit Owner</a></li>
						@endcan
					</x-actions.dropdown-menu>
				</td>
			</tr>
		@endforeach
	</x-slot:body>
</x-displays.table>

@if($paginate)
	{{ $owners->onEachSide(1)->links() }}
@endif