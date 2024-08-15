@props([
	'businesses',
	'paginate' => false
])

<x-displays.table class="table-xs sm:table-md mb-36">
	<x-slot:head>
		<tr>
			<th>Business ID No.</th>
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
				<td>{{ $business->due_date ? $business->due_date->toFormattedDateString() : null }}</td>
				<td>{{ $business->address->brgy_no }}</td>
				<td>
					<x-actions.dropdown-menu class="dropdown-bottom dropdown-end">
						<x-slot:label>Options</x-slot>

						<li><a href="{{ route('business_info', ['business' => $business]) }}">Business Info</a></li>
						<li><a href="{{ route('checklist', ['bin_search' => $business->id_no]) }}">Inspection Checklist</a></li>
						@can('pld-personnel-action-only')
							<!--<li><a href="{{ route('edit_business', ['business' => $business]) }}">Edit Business</a></li>-->
							<li><a href="{{ route('image_manager', ['business' => $business]) }}">Manage Images</a></li>
						@endcan
						@can('is_admin')
							<li><button onclick="openModalRemoveBusiness({{ $business->business_id }})">Remove</button></li>
						@endcan
					</x-actions.dropdown-menu>
				</td>
			</tr>
		@endforeach
	</x-slot:body>
</x-displays.table>

<x-displays.modal
	modal-id="RemoveBusiness"
	header="Remove Business"
	content="Are you sure you want to remove the business?"
	method="DELETE"
	:form-link-suffix="url('businesses')"
	form-button-text="Remove"
/>

@if($paginate)
	{{ $businesses->onEachSide(1)->links() }}
@endif
