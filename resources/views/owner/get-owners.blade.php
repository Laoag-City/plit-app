<x-layout>
    <x-slot:title>Owners</x-slot>

	<x-displays.owners-table :owners="$owners" :paginate="true"></x-displays.owners-table>
</x-layout>