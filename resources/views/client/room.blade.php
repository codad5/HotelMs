@extends('layouts.client')
@section('content')
{{-- Luxury Section --}}
<section title="Hero Section" class="w-screen h-fit p-8">
    <div class="w-full flex justify-start gap-6 flex-wrap max-w-screen-lg">
        @if(isset($rooms) && isset($actives))
        @foreach($rooms as $room)
        <div class="w-72 h-72 border-4 inline-block shrink-0 " title="{{$room->number}}">
            <div class="card h-2/4">
                Image for Room {{$room->number}}
            </div>
            <div class="card text-left p-3 h-1/4">
                <div class="w-full align-middle">
                    Price : {{$room->price}}
                </div>
                <div class="w-full align-middle">
                    Room Type : Suites
                </div>
            </div>
            <div class="card h-1/4">
                <button class="book-buttons w-1/2 bg-green-400 h-full text-white" data-room="{{$room->number}}">
                    Book
                </button>
            </div>
        </div>
        @endforeach
        @endif
        
    </div>
</section>
<section class="book-section w-screen h-screen hidden bg-slate-400 from-transparent fixed top-0 z-50 grid items-center place-content-center">
        {!! Form::open([ "url"=> url("booking"), 'method' => 'POST', "id" => "book_room_form", "class" => "max-w-md"]) !!}
        <div class="overflow-hidden shadow sm:rounded-md">
            <button id="book_close_button" type="button" class="bg-red-700 px-3 py-1 text-slate-100">Close</button>
            <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                <div class="grid grid-cols-3 gap-6">
                    {{ Form::hidden('room_number', '' , ['id' => 'room_number_input']) }}
                    <div class="col-span-3 sm:col-span-2">
                        {{ Form::label('from', 'from', ['class' => 'block text-sm font-medium text-gray-700'])
                        }}
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">#</span>
                            {{ Form::date('from', '', ['id' => "from", "min" => 1, "url" => "none", 'class' =>
                            'input-date block w-full flex-1 rounded-none rounded-r-md
                            border-gray-300
                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm', 'placeholder' => 'No of Night',
                            "type" =>
                            "number"]) }}
                        </div>
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        {{ Form::label('to', 'TO', ['class' => 'block text-sm font-medium text-gray-700'])
                        }}
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">#</span>
                            {{ Form::date('to', '', ['id' => "to", "min" => 1, "url" => "none", 'class' => 'input-date
                            block w-full flex-1 rounded-none rounded-r-md
                            border-gray-300
                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm', 'placeholder' => 'No of Night',
                            "type" =>
                            "number"]) }}
                        </div>
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        {{ Form::label('payment', 'Payment', ['class' => 'block text-sm font-medium text-gray-700'])
                        }}
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">#</span>
                            {{ Form::select('payment', ['paystack' => 'paystack', 'cash' => 'cash'], ['id' => "to", "min" => 1, "url" => "none", 'class' => 'input-date
                            block w-full flex-1 rounded-none rounded-r-md
                            border-gray-300
                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm', 'placeholder' => 'Payment']) }}
                        </div>
                    </div>
                </div>
                <div id="price_tag"></div>
                <div id="load_add_room"></div>
            </div>
            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                {{ Form::submit('Book', ['class' => 'inline-flex justify-center rounded-md border border-transparent
                bg-indigo-600
                py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2
                focus:ring-indigo-500 focus:ring-offset-2']) }}
            </div>
        </div>
        {{ Form::close( )}}
</section>
<script>
    const book_buttons = document.querySelectorAll('.book-buttons'),
    book_section = document.querySelector('.book-section'),
    room_number_input = document.querySelector('#room_number_input')
    book_buttons.forEach(item => {
        let {room}  = item.dataset
        item.addEventListener('click', (e) => {
            e.preventDefault()
            room_number_input.value = room
            book_section.classList.remove('hidden')
        })
    })
    document.querySelector('#book_close_button').addEventListener('click', () => {
        book_section.classList.add('hidden')
    })
    document.querySelectorAll('input[type="date"]').forEach(item => {
        console.log("{{ date('Y-m-d') }}")
        item.min = "{{ date('Y-m-d') }}"
    })
</script>
@endsection