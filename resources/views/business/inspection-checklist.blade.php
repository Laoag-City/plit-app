<x-layout>
    <x-slot:title>Inspection Checklist</x-slot>

	<form action="{{ url()->current() }}" method="POST" class="max-w-none prose" enctype="multipart/form-data">
		<h2>Inspection Checklist</h2>
		<div class="divider"></div>

		@csrf

        @if($errors->any())
            <x-displays.alert class="alert-error">
                <b>There are errors in the form you submitted.</b>
            </x-displays.alert>
        @endif

		<div class="grid grid-cols-1 lg:grid-cols-3 mt-8">
			<x-forms.text-field
                label="Business ID Number"
                placeholder="Business ID Number"
                name="business_id_number"
                :value="old('business_id_number') ? old('business_id_number') : request()->bin"
				class="lg:col-start-2"
                :error="$errors->first('business_id_number')"
            />
		</div>

		@if($business)
			<x-displays.table class="table-xs sm:table-md">
				<x-slot:head>
					<tr>
						<th>Requirement</th>
						<th>Complied</th>
					</tr>
				</x-slot>

				<x-slot:body>
					@foreach($business->business_requirements as $bus_req)
						<tr>
							<td>{{ $bus_req->requirement->requirement }}</td>
							<td>
								<input type="checkbox" checked="checked" class="checkbox" />
							</td>
						</tr>
					@endforeach
				</x-slot>
			</x-displays.table>
		@endif
	</form>
</x-layout>