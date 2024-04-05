<x-layout>
    <x-slot:title>Businesses: {{ $category }}</x-slot>

	<x-displays.businesses-table :businesses="$businesses" :paginate="false"></x-displays.businesses-table>
</x-layout>