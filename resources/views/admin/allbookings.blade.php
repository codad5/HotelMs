@extends('layouts.admin')

@section('content')


{{-- //all room section --}}
<section title="All rooms" class="w-full h-fit" id="allrooms">
    <div class="w-full h-full">
        <h1 class="text-bold text-slate-100 p-4">All Rooms</h1>
        <table class="border-collapse table-fixed w-full text-sm">
            <thead>
                <tr>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-100 dark:text-slate-200 text-left">
                        No</th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-100 dark:text-slate-200 text-left">
                        No of days</th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-100 dark:text-slate-200 text-left">
                        Paid</th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-100 dark:text-slate-200 text-left">
                        Starts</th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-100 dark:text-slate-200 text-left">
                        Ends</th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-100 dark:text-slate-200 text-left">
                        Checked in</th>
                </tr>
            </thead>
            <tbody class="bg-slate-800">
                @if(isset($bookings) && count($bookings) > 0)
                @foreach($bookings as $booking)
                <tr>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-100">
                        {{$booking->room_number}} </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-100"> 
                        {{$booking->no_of_days}}
                            @if($booking->checked_in || time() > strtotime("midnight $booking->from"))
                                (Left: {{intval((strtotime("11:59pm $booking->to") - time()) / (60 * 60 * 24))}})
                            @endif
                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-100">{{$booking->payment_method}}</td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-100">
                        {{$booking->from}}
                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-100">
                        {{$booking->to}}
                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-100">
                        @if(($booking->paid || $booking->payment_method == "CASH") && !$booking->checked_in && strtotime("11:59pm $booking->to") > time())
                        <button class="bookbutton inline-flex justify-center rounded-md border border-transparent
                                        py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2
                                        focus:ring-indigo-500 focus:ring-offset-2" data-room="{{$booking->room_number}}">CheckIn</button>
                        @elseif(strtotime("11:59pm $booking->to") < time())
                            Expired
                        @else
                        Checked In 
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</section>



<script>
    const book_room_wrapper = document.querySelector('.book_room_wrapper'),
    from = document.querySelector('#from'),
    to = document.querySelector('#to'),
    book_close_button = document.querySelector('#book_close_button'),
    book_room_form = document.querySelector('#book_room_form'),
    price_tag = document.querySelector('#price_tag')
    let book_button = document.querySelectorAll('.bookbutton')
    var room_to_be_booked = null, __price = null;
    book_button.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            let {room, price} = button.dataset
            room_to_be_booked = room
            __price = price
            console.log(`booking room ${room}`);
            from.value=null;
            to.value=null;
            price_tag.innerHTML=null;
            book_room_wrapper.classList.remove('hidden')
        })
    })
    book_close_button.onclick = () => {
        book_room_wrapper.classList.add('hidden')
    }
    to.addEventListener('input', (e) => {
        price_tag.innerHTML = ``
        // console.log(from.value.length)
        let from_date = new useDate(from.value.length > 0 ? from.value : null),
        to_date = new useDate(to.value)
        console.log( from_date.getNoOfDays(), to_date.getNoOfDays())
        if(from_date.getNoOfDays() < 0) return price_tag.innerHTML = `From day can't be yesterday or earlier`
        if(to_date.getNoOfDays() < 0) return price_tag.innerHTML = `To day can't be yesterday or earlier`
        if(from_date.getNoOfDays() > to_date.getNoOfDays()) return price_tag.innerHTML = `From day can't be greater than to Days`
        // console.log(from_date, to_date)
        const no_of_days = to_date.getNoOfDays() - from_date.getNoOfDays()
        price_tag.innerHTML = `Total Payment of ${__price * no_of_days} for ${no_of_days} day(s)`
    })
    $(document).ready(() => {
        book_room_form.addEventListener('submit', e => {
            e.preventDefault();
            console.log(to.value);
            if(to.value.length <= 0) return price_tag.innerHTML = `Place select an ending date`;
            if(!room_to_be_booked || !__price) return book_room_wrapper.classList.add('hidden')
            let from_date = new useDate(from.value.length > 0 ? from.value : null),
            to_date = new useDate(to.value)
            const no_of_days = to_date.getNoOfDays() - from_date.getNoOfDays(),
            _token = book_room_form.querySelector('input[name="_token"]')
            console.log(_token.value)
            console.log(room_to_be_booked)
        $('#load_add_room').load(`{{url('admin/booking')}}`, {_token:_token.value, room:room_to_be_booked, no_of_days:no_of_days, from:from.value, to:to.value})
        $('#allrooms').load(`{{url('admin/allrooms')}}`)
    })
    })
    class useDate extends Date{
        today = null
        constructor (date_ = null) {
            super(date_)
            this.today = new Date()
        }
        getNoOfDays(){
            return Math.ceil((this.valueOf() - this.today.valueOf()) / (1000 * 60 * 60 * 24))
        }
        
        
    }
</script>
@endsection