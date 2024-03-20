@props(['owner'])

<div class="not-prose">
	<ul class="menu menu-horizontal max-[768px]:hidden rounded-box">
		<li>
			<a href="{{ route('owner_info', ['owner' => $owner]) }}" 
				class="{{ $current_url != route('owner_info', ['owner' => $owner]) ?: 'active' }}">
				Owner Info
			</a>
		</li>
		@can('pld-personnel-action-only')
			<li>
				<a href="{{ route('edit_owner', ['owner' => $owner]) }}" 
					class="{{ $current_url != route('edit_owner', ['owner' => $owner]) ?: 'active' }}">
					Edit Owner Info
				</a>
			</li>
		@endcan
	</ul>

	<ul class="menu menu-vertical md:hidden rounded-box">
		<li>
			<a href="{{ route('owner_info', ['owner' => $owner]) }}" 
				class="{{ $current_url != route('owner_info', ['owner' => $owner]) ?: 'active' }}">
				Owner Info
			</a>
		</li>
		@can('pld-personnel-action-only')
			<li>
				<a href="{{ route('edit_owner', ['owner' => $owner]) }}" 
					class="{{ $current_url != route('edit_owner', ['owner' => $owner]) ?: 'active' }}">
					Edit Owner Info
				</a>
			</li>
		@endcan
	</ul>
</div>