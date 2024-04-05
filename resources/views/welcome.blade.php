<x-layout>
	<x-slot:title>Welcome</x-slot>

	<div class="hero min-h-screen">
		<div class="hero-content text-center">
			<div class="max-w-4xl">
				<h1 class="text-4xl font-bold">{{ $greetings }}, inspectorate!</h1>
				<p class="py-6">Start by checking license requirements of businesses or view list of businesses.</p>

				<x-displays.stat
					title="No inspection records"
					:value="$stats['no_inspections']"
					:value-is-link="true"
					:url="route('stats-view', ['view' => 'no_inspections'])"
				/>

				<x-displays.stat
					title="For Closure of Business"
					:value="$stats['for_closures']"
					:value-is-link="true"
					:url="route('stats-view', ['view' => 'for_closures'])"
				/>

				<x-displays.stat
					title="Complied Businesses"
					:value="$stats['complied']"
					:value-is-link="true"
					:url="route('stats-view', ['view' => 'complied'])"
				/>

				<x-displays.stat
					title="Expired Registration"
					:value="$stats['expired']"
					:value-is-link="true"
					:url="route('stats-view', ['view' => 'expired'])"
				/>

				<x-displays.stat
					title="Inspections Today"
					:value="$stats['inspection_today']"
					:value-is-link="true"
					:url="route('stats-view', ['view' => 'inspection_today'])"
				/>

				<x-displays.stat
					title="Re-inspections Today"
					:value="$stats['re_inspection_today']"
					:value-is-link="true"
					:url="route('stats-view', ['view' => 're_inspection_today'])"
				/>

				<x-displays.stat
					title="Inspections Past Due Date"
					:value="$stats['due_from_today']"
					:value-is-link="true"
					:url="route('stats-view', ['view' => 'due_from_today'])"
				/>
			</div>
		</div>
	</div>
</x-layout>