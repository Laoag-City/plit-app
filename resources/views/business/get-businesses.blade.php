<x-layout>
    <x-slot:title>Businesses</x-slot>

	<x-displays.table class="table-xs sm:table-md mb-32">
		<x-slot:head>
			<tr>
				<th>Business ID Number</th>
				<th>Business Name</th>
				<th>Owner Name</th>
				<th>Due Date</th>
				<th>Barangay</th>
				<th></th>
			</tr>
		</x-slot>

		<x-slot:body>
			@foreach ($businesses as $business)
				<tr class="hover">
					<td>{{ $business->id_no }}</td>
					<td>{{ $business->name }}</td>
					<td>{{ $business->owner->name }}</td>
					<td>{{ $business->due_date }}</td>
					<td>Brgy. {{ $business->address->brgy_no }}</td>
					<td>
						<x-actions.dropdown-menu class="dropdown-bottom dropdown-end">
							<x-slot:label>Options</x-slot>

							<li><a href="{{ route('business_info', ['business' => $business]) }}">Business Info</a></li>
							<li><a href="{{ route('checklist', ['bin' => $business->id_no]) }}">Inspection Checklist</a></li>
							<li><a href="{{ route('edit_business', ['business' => $business]) }}">Edit Business</a></li>
							<li><a href="{{ route('image_manager', ['business' => $business]) }}">Manage Images</a></li>
						</x-actions.dropdown-menu>
					</td>
				</tr>
			@endforeach
		</x-slot:body>
	</x-displays.table>

	{{ $businesses->onEachSide(1)->links() }}
</x-layout>