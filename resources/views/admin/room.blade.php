@extends('layouts.admin')

@section('content')
<script>
    let book_room_wrapper = document.querySelector('.book_room_wrapper'),
    from = document.querySelector('#from'),
    to = document.querySelector('#to'),
    book_close_button = document.querySelector('#book_close_button'),
    book_room_form = document.querySelector('#book_room_form'),
    price_tag = document.querySelector('#price_tag')
    let book_button = document.querySelectorAll('.bookbutton')
    var room_to_be_booked = null, __price = null;
    class useDate extends Date{
        today = null
        constructor (date_ = null) {
            super(date_)
            this.today = new Date()
        }
        getNoOfDays(){
            return Math.ceil((this.valueOf() - this.today.valueOf()) / (1000 * 60 * 60 * 24))  +1
        }


    }
</script>

{{-- //add room section --}}
<section title="create room"  class="w-full h-fit py-5">
    <div class="w-full h-full flex justify-center content-center">
        {!! Form::open([ "url"=> url("rooms"), 'method' => 'POST']) !!}
            <h3 class="text-white text-4">Add a new room</h3>
            <div class="overflow-hidden shadow sm:rounded-md">
                <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 sm:col-span-2">
                            {{ Form::label('number', 'Room Number', ['class' => 'block text-sm font-medium text-gray-700']) }}
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span
                                    class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">#</span>
                                {{ Form::number('number', '', ['class' => 'block w-full flex-1 rounded-none rounded-r-md border-gray-300
                                focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm', 'placeholder' => 'Room Number', "type" =>
                                "number"]) }}
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 sm:col-span-2">
                            {{ Form::label('price', 'Room Price per night', ['class' => 'block text-sm font-medium text-gray-700']) }}
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span
                                    class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">#</span>
                                {{ Form::number('price', '', ['class' => 'block w-full flex-1 rounded-none rounded-r-md border-gray-300
                                focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm', 'placeholder' => 'Room Price per Night', "type" => "number"]) }}
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 sm:col-span-2">
                            {{ Form::label('Room type', 'type', ['class' => 'block text-sm font-medium text-gray-700']) }}
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span
                                    class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">#</span>
                                {{ Form::select('type', ['suites' => 'suites', 'room' => 'room'], ['id' => "type", "min" => 1, "url" => "none", 'class' => 'input-date
                        block w-full flex-1 rounded-none rounded-r-md
                        border-gray-300
                        focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm', 'placeholder' => 'Payment']) }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                    {{ Form::submit('Submit', ['class' => 'inline-flex justify-center rounded-md border border-transparent bg-indigo-600
                    py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2
                    focus:ring-indigo-500 focus:ring-offset-2']) }}
                </div>
            </div>
            {{ Form::close( )}}
    </div>
</section>
{{-- //book room section --}}
<section title="book room"
    class="book_room_wrapper w-full h-fullmix-blend-overlay  bg-stone-600 fixed inset-0 py-[20%] hidden">
    <div class="w-full h-full flex justify-center content-center">
        {!! Form::open([ 'method' => 'POST', "id" => "book_room_form"]) !!}
        <div class="overflow-hidden shadow sm:rounded-md">
            <button id="book_close_button" class="bg-red-700 px-3 py-1 text-slate-100">Close</button>
            <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                <div class="grid grid-cols-3 gap-6">
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
    </div>
</section>

{{-- //all room section --}}

@include('admin.allrooms')

@endsection
