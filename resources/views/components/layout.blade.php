<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="autumn">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.4/dist/full.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com?plugins=typography"></script>

        @vite('resources/js/app.js')
        {{--@vite('resources/css/app.css')--}}

        <title>PLIT - APP | {{ $title ?? "" }}</title>
    </head>
    <body class="text-center antialiased">
        @auth
            <div class="drawer">
                <input id="main-drawer" type="checkbox" class="drawer-toggle" /> 
                <div class="drawer-content flex flex-col">
                    <!-- Navbar -->
                    <div class="w-full navbar bg-accent">
                        <div class="flex-none lg:hidden">
                            <label for="main-drawer" class="btn btn-square btn-ghost">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </label>
                        </div> 
                        
                        <div class="flex-1 px-2 mx-2 text-xl font-semibold">PLIT - APP</div>
            
                        <div class="flex-none hidden lg:block">
                            <ul class="menu menu-horizontal">
                                <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">Log Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div> 
                
                <div class="drawer-side">
                    <label for="main-drawer" class="drawer-overlay"></label> 
                    <ul class="menu p-4 w-80 min-h-full bg-base-200">
                        <!-- Sidebar content here -->
                        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">Log Out</a></li>
                    </ul>
                </div>

                <form id="logout_form" action="{{ url('/logout') }}" method="POST" class="hidden">
        			@method('POST')
                    @csrf
    			</form>
            </div>
        @endauth
        
        <div class="container mx-auto">
            {{ $slot }}
        </div>
    </body>
</html>
