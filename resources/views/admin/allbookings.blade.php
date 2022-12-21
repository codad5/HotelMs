@extends('layouts.admin')

@section('content')

{{-- //all room section --}}
<section title="All rooms" class="w-full h-fit" id="allrooms">
    <div class="w-full h-full">
        <h1 class="text-bold text-slate-100 p-4">All Bookings</h1>
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
                        <button class="checkinbtn inline-flex justify-center rounded-md border border-transparent
                                        py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2
                                        focus:ring-indigo-500 focus:ring-offset-2" data-book="{{$booking->id}}">CheckIn</button>
                                        @elseif(strtotime("11:59pm $booking->to") < time())
                                        Expired {{!$booking->checked_in ? '(Never Checked In)' : null }}
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

<div id="message_cnt" class="fixed hidden  overflow-hidden shadow sm:rounded-md w-screen h-screen flex justify-center items-center inset-0">
    @csrf
    <div>
        <button id="check_close_button" class="bg-red-700 px-3 py-1 text-slate-100">Close</button>
        <div id="message" class="message space-y-6 sm:rounded-md bg-white px-4 py-5 sm:p-6">
        </div>
    </div>
</div>



<script>
    const checkinbtn = document.querySelectorAll('.checkinbtn'),
    message_cnt = document.querySelector('#message_cnt'),
    check_close_button = document.querySelector('#check_close_button'),
    counts = {};
    check_close_button.onclick = () => {
        message_cnt.classList.add('hidden')
        for(item in counts){
            if(counts[item] > 1) navigation.reload()
        }
    }
    checkinbtn.forEach(element => {
        console.clear()
        let {book} = element.dataset
        counts[`${book}`] = 0;
        console.log(counts)
        element.addEventListener('click', (e) => {
            e.preventDefault();
            counts[`${book}`] = counts[`${book}`] + 1
            checkIn(book, counts[`${book}`] > 1 ? true : false)
        });
        
    });

    const checkIn = (booking_id, bypass = false) => {
        const _token = message_cnt.querySelector('input[name="_token"]')
        $('#message').load(`{{url('booking/checkin')}}`, {_token:_token.value, id: booking_id, bypass: bypass}, (e) => {
            console.log(e);
            message_cnt.classList.remove('hidden')
            setTimeout(() => {
                counts[`${booking_id}`] = 0
            }, 10000);
        })
    }
</script>

@endsection