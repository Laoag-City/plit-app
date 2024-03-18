@props(['business'])

<div class="not-prose">
	<ul class="menu menu-horizontal max-[768px]:hidden rounded-box">
		<li>
			<a href="{{ route('business_info', ['business' => $business]) }}" 
				class="{{ $current_url != route('business_info', ['business' => $business]) ?: 'active' }}">
				Business Info
			</a>
		</li>
		<li>
			<a href="{{ route('checklist', ['bin' => $business->id_no]) }}" 
				class="{{ $current_url != route('checklist') ?: 'active' }}">
				Inspection Checklist
			</a>
		</li>
		@can('pld-personnel-action-only')
			<li>
				<a href="{{ route('edit_business', ['business' => $business]) }}" 
					class="{{ $current_url != route('edit_business', ['business' => $business]) ?: 'active' }}">
					Edit Business Info
				</a>
			</li>
			<li>
				<a href="{{ route('image_manager', ['business' => $business]) }}" 
					class="{{ $current_url != route('image_manager', ['business' => $business]) ?: 'active' }}">
					Manage Images
				</a>
			</li>
		@endcan
	</ul>

	<ul class="menu menu-vertical md:hidden rounded-box">
		<li>
			<a href="{{ route('business_info', ['business' => $business]) }}" 
				class="{{ $current_url != route('business_info', ['business' => $business]) ?: 'active' }}">
				Business Info
			</a>
		</li>
		<li>
			<a href="{{ route('checklist', ['bin' => $business->id_no]) }}" 
				class="{{ $current_url != route('checklist') ?: 'active' }}">
				Inspection Checklist
			</a>
		</li>
		@can('pld-personnel-action-only')
			<li>
				<a href="{{ route('edit_business', ['business' => $business]) }}" 
					class="{{ $current_url != route('edit_business', ['business' => $business]) ?: 'active' }}">
					Edit Business Info
				</a>
			</li>
			<li>
				<a href="{{ route('image_manager', ['business' => $business]) }}" 
					class="{{ $current_url != route('image_manager', ['business' => $business]) ?: 'active' }}">
					Manage Images
				</a>
			</li>
		@endcan
	</ul>
</div>