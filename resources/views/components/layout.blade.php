<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="autumn">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- For development use, use code below and comment vite code below --}}
        {{--<link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.css" rel="stylesheet" type="text/css" />--}}
        {{--<script src="https://cdn.tailwindcss.com?plugins=typography"></script>--}}
        {{--<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>--}}

        {{-- For production use, use code below and comment link and script tags above --}}
        @vite('resources/css/app.css')

        <title>PLIT - APP | {{ $title ?? "" }}</title>
    </head>
    <body class="text-center antialiased">
        @auth
            <div class="drawer">
                <input id="main-drawer" type="checkbox" class="drawer-toggle" /> 
                <div class="drawer-content flex flex-col">
                    <!-- Navbar -->
                    <div class="w-full navbar bg-accent">
                        <div class="navbar-start">
                            <label for="main-drawer" class="btn btn-square btn-ghost lg:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </label>

                            <div class="px-2 mx-2 text-xl font-bold">
                                <a class="transition ease-in-out delay-75 hover:text-red-700 duration-500" href="{{ route('home') }}">PLIT - APP</a>
                            </div>
                        </div>

                        <div class="navbar-center hidden lg:flex">
                            <ul class="menu menu-horizontal">
                                <x-navigations.main-navigation-links></x-navigations.main-navigation-links>
                            </ul>
                        </div>

                        <div class="navbar-end hidden lg:flex">
                            <ul class="menu menu-horizontal">
                                <li>
                                    @can('is-admin')
                                        <li>
                                            <a href="{{ route('user_dashboard') }}">User Management</a>
                                        </li>
                                    @endcan
                                    <li>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">Log Out</a>
                                    </li>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> 
                
                <div class="drawer-side z-10">
                    <label for="main-drawer" class="drawer-overlay"></label> 
                    <ul class="menu p-4 w-80 min-h-full bg-base-200">
                        <x-navigations.main-navigation-links></x-navigations.main-navigation-links>
                        <li>
                            @can('is-admin')
                                <li>
                                    <a href="{{ route('user_dashboard') }}">User Management</a>
                                </li>
                            @endcan
                            <li>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">Log Out</a>
                            </li>
                        </li>
                    </ul>
                </div>

                <form id="logout_form" action="{{ url('/logout') }}" method="POST" class="hidden">
                    @csrf
    			</form>
            </div>
        @endauth
        
        <div class="container mx-auto">
            <div @class(['grid grid-cols-1 gap-3 p-6 my-2 bg-neutral-content rounded-lg shadow-lg' => auth()->check()])>
                @auth
                    @switch(url()->current())
                        @case(url(''))
                        @case(route('home'))
                            @break
                        @default
                            <div class="max-w-none prose">
                                <h2>{{ $title }}</h2>
                                <div class="divider"></div>
                            </div>
                    @endswitch

                    {{ $slot }}
                @endauth

                @guest
                    {{ $slot }}
                @endguest
            </div>
        </div>

        @auth
            <footer class="footer footer-center p-5 bg-neutral text-base-content">
                <aside>
                    <p>Copyright © 2023 - All right reserved</p>
                </aside>
            </footer>
        @endauth

        @vite('resources/js/app.js')
        <!---->
        @stack('scripts')
        <!---->
        @livewireScripts
    </body>
</html>
