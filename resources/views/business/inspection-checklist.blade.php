<x-layout>
    <x-slot:title>Inspection Checklist</x-slot>

	<div class="max-w-none prose">
		<h2>Inspection Checklist</h2>
		<div class="divider"></div>

        @if($errors->any())
            <x-displays.alert class="alert-error">
                <b>There are errors in the form you submitted.</b>
            </x-displays.alert>
		@elseif(session('success'))
			<x-displays.alert class="alert-success">
				<b>Inspection Checklist successfully updated!</b>
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
				<x-displays.business-data-view
					:business="$business"
					class="col-span-1 lg:col-span-3"
				/>

				<form action="{{ route('save_checklist') }}" method="POST" class="col-span-1 lg:col-span-3" enctype="multipart/form-data" x-data="checklist">
					@csrf
					<input type="hidden" name="bin" value="{{ request()->bin }}" />

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

										//saved the id to a different variable to avoid long object property access syntax
										$req_id = $bus_req->requirement_id;
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

												//check if there's old user input for the requirement parameter value and store it in the variable for AlpineJS
												if(old('requirement.' . $req_id . '.parameter'))
													$mandatory_req_for_js[$req_id]['requirement_field_val'] = old('requirement.' . $req_id . '.parameter');

												//The complied checkbox of a requirement with parameter can only be enabled if its parameter has a value (with consideration if it is editable)
												//so check its value before enabling it.
												if($mandatory_req_for_js[$req_id]['requirement_field_val'] != null && $editable)
													$mandatory_req_for_js[$req_id]['cannot_comply'] = false;
											@endphp

											{{ Str::before($bus_req->requirement->requirement, $param['param']) }} 
											
											<input 
												type="number" 
												name="requirement[{{ $req_id }}][parameter]" 
												class="w-12 mx-1" 
												min="0"
												max="9999"
												{{ $editable ?: 'disabled' }}
												x-model="mandatory_requirements[{{ $req_id }}]['requirement_field_val']"
												@change="toggleComply($event.target.value, {{ $req_id }})"
											> 
											
											{{ Str::after($bus_req->requirement->requirement, $param['param']) }} 
										@else
											@php
												//if no params but still owns the requirement
												if($editable)
													$mandatory_req_for_js[$req_id]['cannot_comply'] = false;
											@endphp
											{{ $bus_req->requirement->requirement }} 
										@endif

										<span class="italic text-xs">(mandatory)</span>
									</td>

									<td class="align-middle">
										@php
											//check if there's old user input for the complied status value
											if(old('requirement.' . $req_id . '.complied'))
												$mandatory_req_for_js[$req_id]['is_checked'] = true;
										@endphp

										<input 
											type="checkbox" 
											name="requirement[{{ $req_id }}][complied]" 
											class="checkbox checkbox-lg" 
											x-model="mandatory_requirements[{{ $req_id }}]['is_checked']"
											x-bind:disabled="mandatory_requirements[{{ $req_id }}]['cannot_comply']"
											@change="checkIfAllComplied"
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
											disabled
											x-model="other_offices_other_requirements[{{ $bus_req->requirement_id }}]['is_checked']"
										/>
									</td>
								</tr>
							@endforeach
							
							{{-- other requirement of USER's office --}}
							<tr class="hover">
								@php
									//check if there's old user input for the other requirement value
									if(old('other_requirement'))
										$other_req_for_js['requirement_field_val'] = old('other_requirement');

									//check if there's old user input for the other requirement complied status value
									if(old('other_requirement_complied'))
										$other_req_for_js['is_checked'] = true;

									//The complied checkbox of an other requirement can only be enabled if it has a value
									//so check its value before enabling it.
									if($other_req_for_js['requirement_field_val'] != null)
										$other_req_for_js['cannot_comply'] = false;
								@endphp

								<td class="align-middle">
									<b>{{ Auth::user()->office->name }}</b>
								</td>

								<td class="align-middle text-justify">
									Others: 
									<input 
										type="text" 
										name="other_requirement" 
										class="w-1/2"
										x-model="other_requirement['requirement_field_val']"
										@change="toggleComply($event.target.value)"
									>
								</td>

								<td class="align-middle">
									<input 
										type="checkbox" 
										name="other_requirement_complied" 
										class="checkbox checkbox-lg" 
										x-model="other_requirement['is_checked']"
										x-bind:disabled="other_requirement['cannot_comply']"
										@change="checkIfAllComplied"
									/>
								</td>
							</tr>
						</x-slot>
					</x-displays.table>

					<div class="grid grod-cols-1 lg:grid-cols-5 gap-4">
						@can('pld-personnel-action-only')
							@php
								if(old('inspection_status'))
									$inspection_status_value = old('inspection_status');

								elseif($business->inspection_count == 1)
									$inspection_status_value = 1;

								elseif($business->inspection_count == 2)
									$inspection_status_value = 2;

								elseif($business->inspection_count == 3)
									$inspection_status_value = 3;

								else
									$inspection_status_value = '';
							@endphp

							<template x-if="all_complied == false">
								<x-forms.select-field
									label="Inspection Status"
									name="inspection_status"
									:options="[['value' => 1, 'name' => 'Initial Inspection'], ['value' => 2, 'name' => 'Re-Inspection'], ['value' => 3, 'name' => 'For Closure']]"
									:error="$errors->first('inspection_status')"
									class="lg:col-span-2"
									js-bind="inspection_status_bind"
								/>
							</template>

							<x-forms.file-input-field 
								:label="'Supporting Images (' . $user_office_remaining_image_uploads . ' / ' . App\Models\ImageUpload::MAX_UPLOADS . ')'"
								name="supporting_images[]"
								file-types="image/png, image/jpeg"
								camera="environment"
								class="lg:col-start-4 lg:col-span-2"
								:error="collect([$errors->first('supporting_images'), $errors->first('supporting_images.*')])->first(fn($val, $key) => $val != '')"
								:multiple="true"
								:disabled="$uploads_disabled"
							/>
						@endcan

						{{-- next row --}}
						@php
							$inspection_date = $business->inspection_date ? $business->inspection_date->toDateString() : null;
							$re_inspection_date = $business->re_inspection_date ? $business->re_inspection_date->toDateString() : null;
							$due_date = $business->due_date ? $business->due_date->toDateString() : null;
						@endphp


						<x-forms.text-field
							label="Initial Inspection Date"
							placeholder="Initial Inspection Date"
							name="initial_inspection_date"
							type="date"
							:value="old('initial_inspection_date') ? old('initial_inspection_date') : $inspection_date"
							:error="$errors->first('initial_inspection_date')"
							:readonly="!Gate::allows('pld-personnel-action-only')"
						/>

						<x-forms.text-field
							label="Re-inspection Date"
							placeholder="Re-inspection Date"
							name="reinspection_date"
							type="date"
							:value="old('reinspection_date') ? old('reinspection_date') : $re_inspection_date"
							:error="$errors->first('reinspection_date')"
							:readonly="!Gate::allows('pld-personnel-action-only')"
						/>

						<x-forms.text-field
							label="Due Date"
							placeholder="Due Date"
							name="due_date"
							type="date"
							:value="old('due_date') ? old('due_date') : $due_date"
							:error="$errors->first('due_date')"
							:readonly="!Gate::allows('pld-personnel-action-only')"
						/>
						
						<x-forms.text-field
							label="Remarks"
							placeholder="Remarks"
							name="remarks"
							class="lg:col-span-2"
							:value="old('remarks') ? old('remarks') : $user_office_remarks"
							:error="$errors->first('remarks')"
						/>
					</div>

					<div class="mt-12">
						<x-actions.button
							text="Save Checklist"
							class="btn-primary btn-outline btn-block"
						/>
					</div>
				</form>

				<x-displays.business-remarks-and-images
					:remarks="$remarks"
					:image-uploads="$image_uploads"
					class="col-span-1 lg:col-span-3 mt-6 lg:px-12 text-left"
				/>
			@elseif(request()->bin)
				<h3 class="col-span-1 lg:col-span-3">No results found.</h3>
			@endif
		</div>
	</div>

	@pushOnce('scripts')
		<script>
			document.addEventListener('alpine:init', () => {
				Alpine.data('checklist', () => ({
					mandatory_requirements: {{ Js::from(collect($mandatory_req_for_js)) }},

					other_offices_other_requirements: {{ Js::from(collect($other_offices_other_req_for_js)) }},

					other_requirement: {{ Js::from(collect($other_req_for_js)) }},

					has_pld_privileges: {{ Gate::allows('pld-personnel-action-only') ? Js::from(true) : Js::from(false) }},

					all_complied: false,

					inspection_status: {{ Js::from($inspection_status_value ?? '') }},

					inspection_status_bind: {
						['x-model']: 'inspection_status',
						['x-on:change'](){
							//console.log(this.inspection_status);
						}
					},

					checkIfAllComplied(){
						let mandatory_complied = _.every(this.mandatory_requirements, {'is_checked': true});

						let other_office_complied = this.other_offices_other_requirements.length == 0 
													? true 
													: _.every(this.other_offices_other_requirements, {'is_checked': true});
						
						let other_req_complied = true;

						if(this.other_requirement.requirement_field_val != '')
							if(!this.other_requirement.is_checked)
								other_req_complied = false;

						this.all_complied = (mandatory_complied && other_office_complied && other_req_complied);
					},

					toggleComply(value, index = null){
						if(index != null)
						{
							if(value != '')
								this.mandatory_requirements[index]['cannot_comply'] = false;
							else
							{
								this.mandatory_requirements[index]['cannot_comply'] = true;
								this.mandatory_requirements[index]['is_checked'] = false;
							}
						}

						else
						{
							if(value != '')
								this.other_requirement['cannot_comply'] = false;
							else
							{
								this.other_requirement['cannot_comply'] = true;
								this.other_requirement['is_checked'] = false;
							}

							this.checkIfAllComplied();
						}
					},

					init(){
						this.checkIfAllComplied();
						
						//console.log('mandatory', this.mandatory_requirements);
						//console.log('other office', this.other_offices_other_requirements);
						//console.log('other', this.other_requirement);
					}
				}));
			});
		</script>
	@endPushOnce
</x-layout>