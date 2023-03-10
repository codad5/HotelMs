<!doctype html>
<html lang="{{ config('app.locale') }}" class='dark'>

<head>
    <meta charset="uft-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="http://localhost/wemall/css/bootstrap.min.css" />
    <script src="http://localhost/wemall/javascripts/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>{{ config('app.name', 'CLOG') }}</title>
    <style>
        *{
            padding:0;
            margin: 0;
            box-sizing: border-box;
        }
    </style>
</head>

@include('includes.messages')
<body class="relative w-full">
    <header class="sticky top-0 w-full z-40 shadow bg-slate-200 flex inset-0 flex-col">
        <div class="h-full text-gray-600 w-full text-center basis-1/3 flex-shrink-0  min-w-fit p-3">
            <h1>Hotel Name</h1>
        </div>
        <div class="w-full h-full text-center">
            <nav class="w-full h-full">
                <ul class="w-full h-full inline-block space-x-9">
                    @foreach ([
                        [
                            'name' => 'Home',
                            'link' => '/'
                        ],
                        [
                            'name' => 'Rooms',
                            'link' => '/rooms'
                        ]
                    ] as $item)
                    <li class="inline-grid place-items-center h-full py-2 w-fit">
                        <a class="underline text-gray-600" href="{{ $item['link'] }}">{{ $item['name'] }}</a>
                    </li>
                    @endforeach
                    @if(Auth::check())
                    <li class="inline-grid place-items-center h-full py-2 w-fit">
                        <a class="underline text-gray-600" href="{{ url('/logout') }}">Logout</a>
                    </li>
                    @else
                    <li class="inline-grid place-items-center h-full py-2 w-fit">
                        <a class="underline text-gray-600" href="{{ url('/login') }}">login</a>
                    </li>
                    <li class="inline-grid place-items-center h-full py-2 w-fit">
                        <a class="underline text-gray-600" href="{{ url('/signup') }}">signup</a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </header>
    <main class="w-full">
        {{-- @if(Auth::check())
        @endif --}}
            @yield('content')
    </main>
@include('includes.footer')
</body>
</html>
