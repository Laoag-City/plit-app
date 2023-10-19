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
			<form action="{{ url()->current() }}" method="GET" class="join justify-center lg:col-start-2">
				
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
				<form action="{{ url()->current() }}" method="POST" class="col-span-3" enctype="multipart/form-data">
					@csrf

					<x-displays.table class="table-xs sm:table-lg">
						<x-slot:head>
							<tr>
								<th>Requirement</th>
								<th>Complied</th>
							</tr>
						</x-slot>

						<x-slot:body>
							@foreach($mandatory_business_requirements as $bus_req)
								<tr>
									<td>
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
												max="9999"> 
											
											{{ Str::after($bus_req->requirement->requirement, $param['param']) }}
										@else
											{{ $bus_req->requirement->requirement }}
										@endif
									</td>

									<td>
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
											class="checkbox" 
											{{ $checked }}
										/>
									</td>
								</tr>
							@endforeach
							
							<tr>
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

								<td>
									Others: <input type="text" name="other_requirement" value="{{ $other_requirement_value }}" class="w-1/2">
								</td>

								<td>
									<input 
										type="checkbox" 
										name="other_requirement_complied" 
										class="checkbox" 
										{{ $checked }}
									/>
								</td>
							</tr>
						</x-slot>
					</x-displays.table>

					<div class="lg:col-span-3 mt-5">
						<x-actions.button
							text="Save Checklist"
							class="btn-primary btn-outline btn-block"
						/>
					</div>
				</form>
			@endif
		</div>
	</div>
</x-layout>