<x-layout>
    <x-slot:title>Businesses</x-slot>

	<x-displays.businesses-table :businesses="$businesses" :paginate="true"></x-displays.businesses-table>
</x-layout>