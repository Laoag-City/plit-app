<x-layout>
    <x-slot:title>Add New Business</x-slot>

	<div class="max-w-none prose">
		<h2>Businesses</h2>

    	<div class="divider"></div>

		<x-displays.table class="table-xs sm:table-md">
			<x-slot:head>
				<tr>
					<th>Business ID Number</th>
					<th>Business Name</th>
					<th>Owner Name</th>
					<th>Barangay</th>
				</tr>
			</x-slot>

			<x-slot:body>
				@foreach ($businesses as $business)
					<tr class="hover">
						<td>{{ $business->business_id_number }}</td>
						<td>{{ $business->business_name }}</td>
						<td>{{ $business->owner->owner_name }}</td>
						<td>{{ $business->address->brgy }}</td>
					</tr>
				@endforeach
			</x-slot:body>
		</x-displays.table>

		{{ $businesses->onEachSide(1)->links() }}
	</div>
</x-layout>