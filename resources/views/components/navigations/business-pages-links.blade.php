@props(['business'])

<div class="not-prose">
	<ul class="menu menu-horizontal max-[768px]:hidden rounded-box">
		<li><a href="{{ route('business_info', ['business' => $business]) }}">Business Info</a></li>
		<li><a href="{{ route('checklist', ['bin' => $business->id_no]) }}">Inspection Checklist</a></li>
		<li><a href="{{ route('edit_business', ['business' => $business]) }}">Edit Business</a></li>
		<li><a href="{{ route('image_manager', ['business' => $business]) }}">Manage Images</a></li>
	</ul>

	<ul class="menu menu-vertical md:hidden rounded-box">
		<li><a href="{{ route('business_info', ['business' => $business]) }}">Business Info</a></li>
		<li><a href="{{ route('checklist', ['bin' => $business->id_no]) }}">Inspection Checklist</a></li>
		<li><a href="{{ route('edit_business', ['business' => $business]) }}">Edit Business</a></li>
		<li><a href="{{ route('image_manager', ['business' => $business]) }}">Manage Images</a></li>
	</ul>
</div>