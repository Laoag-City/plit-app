<x-layout>
    <x-slot:title>Add New Business</x-slot>

	<div class="max-w-none prose">
		<h2>Businesses</h2>

    	<div class="divider"></div>

		<x-displays.table class="table-xs sm:table-md mb-24">
			<x-slot:head>
				<tr>
					<th>Business ID Number</th>
					<th>Business Name</th>
					<th>Owner Name</th>
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
						<td>{{ $business->address->brgy }}</td>
						<td>
							<x-actions.dropdown-menu class="dropdown-bottom dropdown-end">
								<x-slot:label>Options</x-slot>

								<li><a href="">Business Info</a></li>
								<li><a href="{{ route('checklist', ['bin' => $business->id_no]) }}">Inspection Checklist</a></li>
							</x-actions.dropdown-menu>
						</td>
					</tr>
				@endforeach
			</x-slot:body>
		</x-displays.table>

		{{ $businesses->onEachSide(1)->links() }}
	</div>
</x-layout>