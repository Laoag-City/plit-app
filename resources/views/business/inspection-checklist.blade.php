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

				<form action="{{ url()->current() }}" method="POST" class="col-span-1 lg:col-span-3" enctype="multipart/form-data" x-data="checklist">
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
												if(old('requirement.' . $req_id . 'parameter'))
													$mandatory_req_for_js[$req_id]['requirement_field_val'] = old('requirement.' . $req_id . 'parameter');
											@endphp

											{{ Str::before($bus_req->requirement->requirement, $param['param']) }} 
											
											<input 
												type="number" 
												name="requirement[{{ $req_id }}][parameter]" 
												class="w-12 mx-1" 
												min="1"
												max="9999"
												{{ $editable ?: 'disabled' }}
												x-model="mandatory_requirements[{!! $req_id !!}]['requirement_field_val']"
											> 
											
											{{ Str::after($bus_req->requirement->requirement, $param['param']) }} 
										@else
											{{ $bus_req->requirement->requirement }} 
										@endif

										<span class="italic text-xs">(mandatory)</span>
									</td>

									<td class="align-middle">
										@php
											//check if there's old user input for the complied status value
											if(old('requirement.' . $req_id . 'complied'))
												$mandatory_req_for_js[$req_id]['is_checked'] = true;
										@endphp

										<input 
											type="checkbox" 
											name="requirement[{{ $req_id }}][complied]" 
											class="checkbox checkbox-lg" 
											{{ $editable ?: 'disabled' }}
											x-model="mandatory_requirements[{!! $req_id !!}]['is_checked']"
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
											x-model="other_office_other_requirements[{!! $bus_req->requirement_id !!}]['is_checked']"
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
										x-model="other_requirements['requirement_field_val']"
									>
								</td>

								<td class="align-middle">
									<input 
										type="checkbox" 
										name="other_requirement_complied" 
										class="checkbox checkbox-lg" 
										x-model="other_requirements['is_checked']"
									/>
								</td>
							</tr>
						</x-slot>
					</x-displays.table>

					<div class="grid grod-cols-1 lg:grid-cols-5 gap-4">
						@php
							$status = $business->getInspectionStatus();

							if(old('inspection_status'))
								$inspection_status_value = old('inspection_status');

							elseif($status == 1)
								$inspection_status_value = 'initial_inspection';

							elseif($status == 2)
								$inspection_status_value = 're-inspection';

							else
								$inspection_status_value = null;
						@endphp

						<x-forms.select-field
							label="Inspection Status"
							name="inspection_status"
							:options="[['value' => 'initial_inspection', 'name' => 'Initial Inspection'], ['value' => 're-inspection', 'name' => 'Re-Inspection']]"
							:selected="$inspection_status_value"
							:error="$errors->first('inspection_status')"
							class="lg:col-span-2"
							:disabled="!Gate::allows('pld-personnel-action-only')"
						/>

						<x-forms.text-field
							label="Initial Inspection Date"
							placeholder="Initial Inspection Date"
							name="initial_inspection_date"
							type="date"
							:value="old('initial_inspection_date') ? old('initial_inspection_date') : $business->inspection_date"
							:error="$errors->first('initial_inspection_date')"
							:readonly="!Gate::allows('pld-personnel-action-only')"
						/>

						<x-forms.text-field
							label="Re-inspection Date"
							placeholder="Re-inspection Date"
							name="reinspection_date"
							type="date"
							:value="old('reinspection_date') ? old('reinspection_date') : $business->re_inspection_date"
							:error="$errors->first('reinspection_date')"
							:readonly="!Gate::allows('pld-personnel-action-only')"
						/>

						@if($status == 2 || $status == 3)
							<x-forms.checkbox-field
								label="Tag business for closure"
								name="business_for_closure"
								:checked="$status == 3"
								:error="$errors->first('business_for_closure')"
								:disabled="!Gate::allows('pld-personnel-action-only')"
							/>
						@else
							<div class="min-[1px]:max-lg:hidden"></div>
						@endif

						{{-- next row --}}

						<x-forms.text-field
							label="Due Date"
							placeholder="Due Date"
							name="due_date"
							type="date"
							:value="old('due_date') ? old('due_date') : $business->due_date"
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

						@can('pld-personnel-action-only')
							<x-forms.file-input-field 
								:label="'Supporting Images (' . $user_office_remaining_image_uploads . ' / ' . App\Models\ImageUpload::MAX_UPLOADS . ')'"
								name="supporting_images[]"
								file-types="image/png, image/jpeg"
								camera="environment"
								class="lg:col-span-2"
								:error="collect([$errors->first('supporting_images'), $errors->first('supporting_images.*')])->first(fn($val, $key) => $val != '')"
								:multiple="true"
								:disabled="$uploads_disabled"
							/>
						@endcan
					</div>

					<div class="mt-12">
						<x-actions.button
							text="Save Checklist"
							class="btn-primary btn-outline btn-block"
						/>
					</div>
				</form>

				<div class="col-span-1 lg:col-span-3 mt-6 px-12 text-left">
					<h3 class="">Other Info:</h3>

					<x-displays.collapse>
						Remarks from other offices

						<x-slot:content>
							@if($remarks->isNotEmpty())
								@php
									$remarks_initial = $remarks->where('inspection_count', '<', 2);
									$remarks_reinspect = $remarks->where('inspection_count', '==', 2);
								@endphp

								@if($remarks_initial->isNotEmpty())
									<p>Initial Inspection Remarks</p>
									<ul>
										@foreach($remarks_initial as $remark)
											<li><b>{{ $remarks->office->name }}</b> - {{ $remarks->name }}</li>
										@endforeach
									</ul>
								@endif

								@if($remarks_reinspect->isNotEmpty())
									<p>Re-inspection Remarks</p>
									<ul>
										@foreach($remarks_initial as $remark)
											<li><b>{{ $remarks->office->name }}</b> - {{ $remarks->name }}</li>
										@endforeach
									</ul>
								@endif
							@else
								No remarks yet.
							@endif
						</x-slot>
					</x-displays.collapse>

					<x-displays.collapse>
						Uploaded Images

						<x-slot:content>
							@if($image_uploads->isNotEmpty())
								<x-displays.carousel :images="$images"/>
							@else
								No images yet.
							@endif
						</x-slot>
					</x-displays.collapse>
				</div>
			@elseif(request()->bin)
				<h3 class="col-span-1 lg:col-span-3">No results found.</h3>
			@endif
		</div>
	</div>

	@pushOnce('scripts')
		<script>
			document.addEventListener('alpine:init', () => {
				Alpine.data('checklist', () => ({
					mandatory_requirements: {!! collect($mandatory_req_for_js)->toJson() !!},
					other_office_other_requirements: {!! collect($other_offices_other_req_for_js)->toJson() !!},
					other_requirements: {!! collect($other_req_for_js)->toJson() !!},

					init(){
						console.log('mandatory', this.mandatory_requirements);
						console.log('other office', this.other_office_other_requirements);
						console.log('other', this.other_requirements);
					}
				}));
			});
		</script>
	@endPushOnce
</x-layout>