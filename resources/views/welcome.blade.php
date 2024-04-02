<x-layout>
	<x-slot:title>Welcome</x-slot>

	<div class="hero min-h-screen">
		<div class="hero-content text-center">
			<div class="max-w-4xl">
				<h1 class="text-4xl font-bold">{{ $greetings }}, inspectorate!</h1>
				<p class="py-6">Start by checking license requirements of businesses or view list of businesses.</p>

				<x-displays.stat
					title="No inspection records"
					:value="$no_inspections"
				/>

				<x-displays.stat
					title="For Closure of Business"
					:value="$for_closures"
				/>

				<x-displays.stat
					title="Complied Businesses"
					:value="$complied"
				/>

				<x-displays.stat
					title="Expired Registration"
					:value="$expired"
				/>

				<x-displays.stat
					title="Inspections Today"
					:value="$inspection_today"
				/>

				<x-displays.stat
					title="Re-inspections Today"
					:value="$re_inspection_today"
				/>

				<x-displays.stat
					title="Inspections Past Due Date"
					:value="$due_from_today"
				/>
			</div>
		</div>
	</div>
</x-layout>