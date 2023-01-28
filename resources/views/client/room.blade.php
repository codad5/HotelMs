@extends('layouts.client')
@section('content')
{{-- Luxury Section --}}
<section title="Hero Section" class="w-full h-fit p-8">
    <h2 class="p-4">
        {{ $header }}
    </h2>
    <div class="w-full grid md:grid-cols-3 sm:grid-cols-1 lg:grid-cols-4 place-items-center gap-4 pt-4 gap-x-6 transition-all">
        @if(isset($rooms) && isset($actives))
        @foreach($rooms as $room)
            <div class="w-[250px] shrink-0 h-[300px] drop-shadow-md shadow-lg border-0 border-gray-500">
                <div class="w-full h-2/3 bg-[url('https://images.pexels.com/photos/164595/pexels-photo-164595.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')] bg-cover bg-center">
                    <div class="w-full h-full text-white opacity-0 hover:opacity-75 bg-gray-700">
                        <div class="w-full h-full flex justify-center place-items-center">
                            <button class="book-buttons test-white border-white border-4 px-2 py-1 grow-0 h-[40px] drop-shadow-lg" data-room="{{$room->number}}">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
                <div title="room details for room {{$room->number}}" class="w-full  h-1/3 p-2">
                    <div class="w-full"><b>Room Di Me (No {{$room->number}})</b> </div>
                    <div class="w-full pt-2">
                        <div class="w-1/2 inline-block"><b>{{$room->room_type}}</b></div>
                        <div class="w-auto inline-block"><span>${{$room->price}}</span> </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
    </div>
</section>
@include('includes.book_page')
@endsection
