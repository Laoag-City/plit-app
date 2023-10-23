<x-layout>
    <x-slot:title>Inspection Checklist</x-slot>

	<div class="max-w-none prose">
		<h2>Inspection Checklist</h2>
		<div class="divider"></div>

        @if($errors->any())
            <x-displays.alert class="alert-error">
                <b>There are errors in the form you submitted.</b>
            </x-displays.alert>
        @endif

		<div class="grid grid-cols-1 lg:grid-cols-3 mt-8">
			<form action="{{ url()->current() }}" method="GET" class="join justify-center col-span-1 lg:col-start-2 mb-5">
				
				<x-forms.text-field
					placeholder="Business ID Number"
					name="bin"
					:value="old('bin') ? old('bin') : request()->bin"
					class="join-item"
					:error="$errors->first('business_id_number')"
				/>

				<x-actions.button
                    text="Search BIN"
                    class="btn-secondary btn-outline join-item"
                />
			</form>
		

			@if($business)
				<div class="col-span-1 lg:col-span-2 text-justify">
					<h3>{{ $business->name }}</h3>
					<h4>{{ $business->owner->name }}</h4>
					<h4>{{ $business->address->brgy }}</h4>
					<h4>{{ $business->location_specifics }}</h4>
				</div>

				<div class="col-span-1 lg:col-span-1 text-justify lg:text-right">
					<h3>BIN: {{ $business->id_no }}</h3>
					<h4>Status: {{ $business->getInspectionStatus() }}</h4>
				</div>

				<form action="{{ url()->current() }}" method="POST" class="col-span-1 lg:col-span-3" enctype="multipart/form-data">
					@csrf

					<div class="divider"></div>

					<x-displays.table class="table-xs sm:table-lg table-fixed text-center mt-0">
						<x-slot:head>
							<tr>
								<th class="text-base lg:text-lg">Office</th>
								<th class="text-base lg:text-lg">Requirement</th>
								<th class="text-base lg:text-lg">Complied</th>
							</tr>
						</x-slot>

						<x-slot:body>
							@foreach($mandatory_business_requirements as $bus_req)
								<tr class="hover">
									@php
										//check if user has authority to edit the mandatory requirement
										if(Gate::allows('owns-requirement', $bus_req->requirement))
											$editable = true;
										else
											$editable = false;
									@endphp

									<td class="align-middle">
										@if($editable)
											<b>{{ $bus_req->requirement->office->name }}</b>
										@else
											{{ $bus_req->requirement->office->name }}
										@endif
									</td>

									<td class="align-middle text-justify">
										@if($bus_req->requirement->has_dynamic_params)
											@php
												//get the requirement's parameter info
												$param = $bus_req->requirement->getParams();

												//check where to get requirement parameter value
												if(old('requirement.' . $bus_req->requirement->requirement_id . 'parameter'))
													$param_value = old('requirement.' . $bus_req->requirement->requirement_id . 'parameter');
												else
													$param_value = $bus_req->requirement_params_value;
											@endphp

											{{ Str::before($bus_req->requirement->requirement, $param['param']) }} 
											
											<input 
												type="number" 
												name="requirement[{{ $bus_req->requirement->requirement_id }}][parameter]" 
												class="w-12 mx-1" 
												value="{{ $param_value }}"
												min="1"
												max="9999"
												{{ $editable ?: 'readonly' }}
											> 
											
											{{ Str::after($bus_req->requirement->requirement, $param['param']) }} 
										@else
											{{ $bus_req->requirement->requirement }} 
										@endif

										<span class="italic text-xs">(mandatory)</span>
									</td>

									<td class="align-middle">
										@php
											$checked = '';

											//check where to get the complied status value
											if(old('requirement.' . $bus_req->requirement->requirement_id . 'complied'))
												$checked = 'checked';
											elseif($bus_req->complied)
												$checked = 'checked';
										@endphp

										<input 
											type="checkbox" 
											name="requirement[{{ $bus_req->requirement->requirement_id }}][complied]" 
											class="checkbox checkbox-lg" 
											{{ $checked }}
											{{ $editable ?: 'disabled' }}
										/>
									</td>
								</tr>
							@endforeach

							{{-- other requirement of OTHER offices --}}
							@foreach($other_offices_other_requirements as $bus_req)
								<tr class="hover">
									<td class="align-middle">
										{{ $bus_req->requirement->office->name }}
									</td>

									<td class="align-middle text-justify">
										Others: 
										{{ $bus_req->requirement->requirement }}
									</td>

									<td class="align-middle">
										<input 
											type="checkbox" 
											class="checkbox checkbox-lg" 
											{{ !$bus_req->complied ?: 'checked' }}
											disabled
										/>
									</td>
								</tr>
							@endforeach
							
							{{-- other requirement of USER's office --}}
							<tr class="hover">
								@php
									$checked = '';
									$other_requirement_value = '';

									//check where to get the other requirement value
									if(old('other_requirement'))
										$other_requirement_value = old('other_requirement');
									elseif($other_requirement != null)
										$other_requirement_value = $other_requirement->requirement->requirement;

									//check where to get the other requirement complied status value
									if(old('other_requirement_complied'))
										$checked = 'checked';
									elseif($other_requirement != null && $other_requirement->complied)
										$checked = 'checked';
								@endphp

								<td class="align-middle">
									<b>{{ Auth::user()->office->name }}</b>
								</td>

								<td class="align-middle text-justify">
									Others: 
									<input 
										type="text" 
										name="other_requirement" 
										value="{{ $other_requirement_value }}" 
										class="w-1/2">
								</td>

								<td class="align-middle">
									<input 
										type="checkbox" 
										name="other_requirement_complied" 
										class="checkbox checkbox-lg" 
										{{ $checked }}
									/>
								</td>
							</tr>
						</x-slot>
					</x-displays.table>

					<div class="grid grod-cols-1 lg:grid-cols-5 gap-4">
						<x-forms.text-field
							label="Days To Comply"
							placeholder="Days To Comply"
							name="days_to_comply"
							type="number"
							:value="old('days_to_comply')"
							:error="$errors->first('days_to_comply')"
							:readonly="!Gate::allows('edits-days-to-comply')"
						/>
						
						<x-forms.text-field
							label="Remarks"
							placeholder="Remarks"
							name="remarks"
							class="lg:col-span-2"
							:value="old('remarks')"
							:error="$errors->first('remarks')"
						/>

						<x-forms.file-input-field 
							label="Supporting Images"
							name="supporting_images[]"
							file-types="image/png, image/jpeg"
							camera="environment"
							class="lg:col-span-2"
							:error="collect([$errors->first('supporting_images'), $errors->first('supporting_images.*')])->first(fn($val, $key) => $val != '')"
							:multiple="true"
						/>
					</div>

					<div class="mt-12">
						<x-actions.button
							text="Save Checklist"
							class="btn-primary btn-outline btn-block"
						/>
					</div>
				</form>
			@elseif(request()->bin)
				<h3 class="col-span-1 lg:col-span-3">No results found.</h3>
			@endif
		</div>
	</div>
</x-layout>