<x-layout>
	<x-slot:title>Business Info</x-slot>

	<x-navigations.business-pages-links :business="$business"></x-navigations.business-pages-links>

	<div class="grid grid-cols-1 lg:grid-cols-3 mt-8">
		<x-displays.business-data-view
			:business="$business"
			:show-dates="true"
			class="col-span-1 lg:col-span-3"
		/>

		<div class="divider col-span-1 lg:col-span-3"></div>

		<div class="col-span-1 lg:col-span-3">
			<x-displays.table class="table-xs sm:table-lg table-fixed text-center mt-0">
				<x-slot:head>
					<tr>
						<th class="text-base lg:text-lg">Office</th>
						<th class="text-base lg:text-lg">Requirement</th>
						<th class="text-base lg:text-lg">Complied</th>
					</tr>
				</x-slot>

				<x-slot:body>
					@foreach($business->businessRequirements as $bus_req)
						<tr class="hover">
							<td class="align-middle">
								{{ $bus_req->requirement->office->name }}
							</td>

							<td class="align-middle text-justify">
								@if($bus_req->requirement->has_dynamic_params)
									@php
										//get the requirement's parameter info
										$param = $bus_req->requirement->getParams();
									@endphp

									{{ Str::before($bus_req->requirement->requirement, $param['param']) }} 
									<b>{{ $bus_req->requirement_params_value }}</b> 
									{{ Str::after($bus_req->requirement->requirement, $param['param']) }} 
								@else
									{{ $bus_req->requirement->requirement }} 
								@endif

								<span class="italic text-xs">(mandatory)</span>
							</td>

							<td class="align-middle">
								<span class="text-2xl">{!! $bus_req->complied ? '&#x2714;' : '' !!}</span>
							</td>
						</tr>
					@endforeach
				</x-slot>
			</x-displays.table>
		</div>

		<x-displays.business-remarks-and-images
			:remarks="$business->remarks"
			:image-uploads="$business->imageUploads"
			class="col-span-1 lg:col-span-3 mt-6 lg:px-12 text-left"
		/>

		@if($business->coordinates)
			<x-forms.map
				class="lg:col-span-3 mt-4"
				:label="'Business location'"
				:current-coordinates="$business->coordinates"
				:view-only="true"
			/>
		@endif
	</div>
</x-layout>