<x-layout>
    <x-slot:title>Welcome</x-slot>

    <div class="hero">
        <div class="hero-content text-center">
          <div class="max-w-xl">
            <h1 class="text-4xl font-bold">{{ $greetings }}, inspectorate!</h1>
            <p class="py-6">Start by checking license requirements of businesses or view list of businesses.</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Get Started</a>
          </div>
        </div>
      </div>
</x-layout>