@extends('layouts.client')
@section('content')
    {{-- Hero Section --}}
    <section title="Hero Section" class="w-full h-[63vh] sm:h-[80vh]">
        <div class="bg-gray-500 h-full relative bg-[url('https://images.pexels.com/photos/164595/pexels-photo-164595.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')] bg-cover bg-center">
{{--            <img class="w-full h-full" src="https://images.pexels.com/photos/164595/pexels-photo-164595.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"/>--}}
{{--            <h1 class="text-7xl text-white w-full text-center">Hotel Name</h1>--}}
{{--            <div class="p-9 text-white w-full text-center space-x-2">--}}
{{--                <a href="" class="p-6 bg-green-600 w-fit no-underline">--}}
{{--                    Book Now--}}
{{--                </a>--}}
{{--                <a href="" class="p-6 bg-slate-300 w-fit no-underline">--}}
{{--                    Contact us--}}
{{--                </a>--}}
{{--            </div>--}}
            <div class="absolute top-0 w-full h-full justify-center items-center
             bg-grey-600/30 backdrop-brightness-75">
                <span class="text-white h-40 text-5xl inline-block max-w-[250px] absolute top-1/3 left-[20px]">
                    This is a good place to be at and here is
                </span>
            </div>
        </div>
    </section>
    <section title="semi Hero Section" class="w-full p-[20px] relative">
        <div class="md:w-4/5 sm:w-full bg-white inline-block text-black h-[150px] absolute top-[-60px] p-3 md:left-[10%] sm:left-[0%] drop-shadow-lg">
            <h4 class="w-full">
                Find Your room
            </h4>
            {!! Form::open([ "url"=> url("rooms"), 'method' => 'GET', "id" => "", "class" => ""]) !!}
            <div class="p-3">
                <div class="w-[30%] inline-block h-full">
                    {!! Form::label('from', 'from', []) !!}
                    <div>
                        {!! Form::date('from', '', ['min' => 1]) !!}
                    </div>
                </div>
                <div class="w-[30%] inline-block h-full">
                    {!! Form::label('to', 'to', []) !!}
                    <div>
                        {!! Form::date('to', '', ['min' => 1]) !!}
                    </div>
                </div>
                <div class="w-[15%] inline-block h-full">
                    {!! Form::label('Room type', 'type', []) !!}
                    <div>
                        {{ Form::select('type', ['any' => 'all/any', 'suites' => 'suites', 'room' => 'room'], ['class' => '', 'placeholder' => 'Room Type']) }}
                    </div>
                </div>
                <div class="w-[15%] inline-block h-full">
                    <div>
                        {!! Form::submit('search', ['min' => 1, 'class' => 'inline-flex justify-center rounded-md border border-transparent
            bg-indigo-600
            py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2
            focus:ring-indigo-500 focus:ring-offset-2']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
    <section title="Goals" class="w-full p-4">
        <div class="w-full h-auto pt-12">
            <h4 class="w-full h-[30px]">
                Some of our rooms
            </h4>
            <div title="some rooms" class="grid md:grid-cols-3 sm:grid-cols-1 place-items-center p-9 gap-x-6">
                <div class="w-[250px] shrink-0 h-[300px] drop-shadow-md shadow-lg border-0 border-gray-500">
                    <div class="w-full h-2/3 bg-[url('https://images.pexels.com/photos/164595/pexels-photo-164595.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')] bg-cover bg-center">
                        <div class="w-full h-full text-white opacity-0 hover:opacity-75 bg-gray-700">
                            <div class="w-full h-full flex justify-center place-items-center">
                                <button class="test-white border-white border-4 px-2 py-1 grow-0 h-[40px] drop-shadow-lg">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <div title="room details" class="w-full  h-1/3 p-2">
                        <div class="w-full"><b>Room Di Me (No 30)</b> </div>
                        <div class="w-full pt-2">
                            <div class="w-1/2 inline-block"><b>Suites</b></div>
                            <div class="w-auto inline-block"><span>$2000</span> </div>
                        </div>
                    </div>
                </div>
                <div class="w-[250px] shrink-0 h-[300px] drop-shadow-md shadow-lg border-0 border-gray-500">
                    <div class="w-full h-2/3 bg-[url('https://images.pexels.com/photos/164595/pexels-photo-164595.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')] bg-cover bg-center">
                        <div class="w-full h-full text-white opacity-0 hover:opacity-75 bg-gray-700">
                            <div class="w-full h-full flex justify-center place-items-center">
                                <button class="test-white border-white border-4 px-2 py-1 grow-0 h-[40px] drop-shadow-lg">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <div title="room details" class="w-full  h-1/3 p-2">
                        <div class="w-full"><b>Room Di Me (No 30)</b> </div>
                        <div class="w-full pt-2">
                            <div class="w-1/2 inline-block"><b>Suites</b></div>
                            <div class="w-auto inline-block"><span>$2000</span> </div>
                        </div>
                    </div>
                </div>
                <div class="w-[250px] shrink-0 h-[300px] drop-shadow-md shadow-lg border-0 border-gray-500">
                    <div class="w-full h-2/3 bg-[url('https://images.pexels.com/photos/164595/pexels-photo-164595.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')] bg-cover bg-center">
                        <div class="w-full h-full text-white opacity-0 hover:opacity-75 bg-gray-700">
                            <div class="w-full h-full flex justify-center place-items-center">
                                <button class="test-white border-white border-4 px-2 py-1 grow-0 h-[40px] drop-shadow-lg">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <div title="room details" class="w-full  h-1/3 p-2">
                        <div class="w-full"><b>Room Di Me (No 30)</b> </div>
                        <div class="w-full pt-2">
                            <div class="w-1/2 inline-block"><b>Suites</b></div>
                            <div class="w-auto inline-block"><span>$2000</span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section title="what we offer" class="w-full ">
            <h3 class="p-3 w-full">What we offer</h3>
        <div class="w-full p-3">
            <div class="sm:w-full md:w-[33%] h-[300px] inline-flex flex-col relative">
{{--                <div class="absolute h-3/5 w-[2px] bg-gray-600 right-0 top-[20%]">--}}
{{--                </div>--}}
                <div class="w-full basis-2/5 text-center text-lg font-semibold font-serif text-yellow-300">
                    <div class="w-full h-full flex justify-center items-end pb-2">
                        Hello
                    </div>
                </div>
                <div class="text-center font-semibold basis-3/5 text-base px-5">
                    This is just something you will enjoy for sure i asure you
                </div>
            </div>
            <div class="sm:w-full md:w-[33%] h-[300px] inline-flex flex-col relative">
                <div class="absolute h-3/5 w-[2px] bg-gray-600 right-0 top-[20%]">
                </div>
                <div class="absolute h-3/5 w-[2px] bg-gray-600 left-0 top-[20%]">
                </div>
                <div class="w-full basis-2/5 text-center text-lg font-semibold font-serif text-yellow-300">
                    <div class="w-full h-full flex justify-center items-end pb-2">
                        Hello
                    </div>
                </div>
                <div class="text-center font-semibold basis-3/5 text-base px-5">
                    This is just something you will enjoy for sure i asure you
                </div>
            </div>
            <div class="sm:w-full md:w-[33%] h-[300px] inline-flex flex-col relative">
{{--                <div class="absolute h-3/5 w-[2px] bg-gray-600 right-0 top-[20%]">--}}
{{--                </div>--}}
                <div class="w-full basis-2/5 text-center text-lg font-semibold font-serif text-yellow-300">
                    <div class="w-full h-full flex justify-center items-end pb-2">
                        Hello
                    </div>
                </div>
                <div class="text-center font-semibold basis-3/5 text-base px-5">
                    This is just something you will enjoy for sure i asure you
                </div>
            </div>
        </div>
    </section>
    <br>
@include('includes.book_page')
@endsection
