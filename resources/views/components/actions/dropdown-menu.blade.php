<div {{ $attributes->class('dropdown not-prose') }}>
	<label tabindex="0" class="btn btn-xs sm:btn-sm btn-neutral">{{ $label }}</label>
	<ul tabindex="0" class="dropdown-content z-[1] menu menu-xs sm:menu-sm p-2 shadow bg-base-100 rounded-box w-max">
		{{ $slot }}
	</ul>
</div>