<!doctype html>
<html lang="{{ config('app.locale') }}" class='dark'>

<head>
    <meta charset="uft-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="http://localhost/wemall/css/bootstrap.min.css" />
    <script src="http://localhost/wemall/javascripts/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>{{ config('app.name', 'CLOG') }}</title>
</head>
<nav>
@include('includes.messages')
<nav>

<body >
    <main class="bg-slate-700 w-screen h-screen flex overflow-hidden">
        @if(Auth::guard('admins')->check())
        <aside class="block h-full  w-full bg-white md:w-1/4 shrink-0">
            @include('includes.adminpanel')
        </aside>
        @endif
        <div class="relative bg-slate-700 w-full h-full md:w-3/4 shrink-0 overflow-y-scroll will-change-scroll">
            @yield('content')
        </div>
    </main>

        {{-- //check if user is logged in --}}
        {{-- @if(Auth::check())
            @include('include.nav')
        <div class="row">
            <div class="col-md-4 col-lg-4">

                @yield('adminpanel')
                <hr>
            </div>
        </div>
        @endif --}}
</body>

</html>