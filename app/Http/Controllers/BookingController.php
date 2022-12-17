<?php

namespace App\Http\Controllers;
use Error;
use Illuminate\Http\Request;
use App\Models\Bookings;


class BookingController extends Controller
{
    //booking date start from 12:00 am from the date to 11:59 the end date
    protected static function bookRoom(string $user, int $num, string $to, ?string $from = null, $check_in = false)
    {
        // $men = null;
        // var_dump('testing', date("Y-m-d H:i:s", strtotime("11:59pm $men")));
        
        if (strtotime("midnight") > strtotime("midnight $from") || strtotime("11:59pm") > strtotime("11:59pm $to"))
            throw new Error("Date select dates earlier than today");
        if (!$from)
            $from = date("Y-m-d", strtotime("midnight"));
        if(!RoomController::room_exist($num)) throw new Error("Room $num does not exist");
        // var_dump(self::is_booked($num, $from, $to));
        $number_of_days = self::number_of_days($from, $to);
        if (0 > $number_of_days)
            throw new error("Invalid Number of days $number_of_days");
        if (self::is_booked($num, $from, $to))
            throw new Error("Room $num is already booked");
        
        $booking = new Bookings;
        $booking->user = $user;
        $booking->room_number = $num;
        $booking->no_of_days = $number_of_days;
        $booking->from = date("Y-m-d", strtotime("midnight $from"));
        $booking->to = date("Y-m-d", strtotime("11:59pm $to"));
        $booking->payment_method = 'CASH';
        $booking->paid = true;
        echo $number_of_days;
        // var_dump(strtotime($from) < (time() + (1000 * 60 * 60 * 24)), date("Y-m-d H:i:s", strtotime($from)) , date("Y-m-d H:i:s", (time() + (1000 * 60 * 60 * 24))));
        if(strtotime("midnight") >= strtotime("midnight $from")){
            RoomController::turnBookSignal($num, $to);
            $booking->checked_in = true;
        }
        $booking->save();
        return true;

    }
    #TODO: fix this 
    public static function is_booked($num, $from = null, $to = null, $must_pay = false)
    {
        #NOTE: $last_booking is the booking with the $last_booking->to time greater than $from
        /**
         * Test Data set 
         * Booking 0 = 7 - 9 can book
         * Booking 1 = 13 - 18 // can book 
         * Booking 2 = 18 - 24 //can book 
         * Booking 3 = 11 - 15 // should say booked
         */
        $last_booking = Bookings::where('room_number', $num)
                            ->where('to', '>', $from)
                            ->orderBy("to", "ASC")->first();
        // if no booking exist for the room return false
        if(!$last_booking) return false;
        $m_from = date("Y-m-d", strtotime("midnight $from"));
        $l_from = date("Y-m-d", strtotime("midnight $last_booking->from"));
        $m_to = date("Y-m-d", strtotime("11:59pm $to"));
        $l_to = date("Y-m-d", strtotime("11:59pm $last_booking->to"));
        
        if ($m_from >= $l_from) return true; # if the from date is in between the last start(from) and end(to) date its booked 
        if ($m_to < $l_from) return false; #if the from and the to is lesser than the (last from and to )
        return true;
    }
    public static function number_of_days($from, $to)
    {
    return intval((strtotime("11:59pm $to") - strtotime("midnight $from"))  / (60 * 60 * 24)) + 1;
    }
    public static function bookByAdmin($num,  $to, $from = null)
    {
        $user = AdminController::whoIsLoggedIn();
        if (!$user)
            throw new Error('Please Login to perfrom this action');
        self::bookRoom($user->username, $num, $to, $from, true);
    }
    public static function getBookings($room = null)
    {
        return $room ? Bookings::where('room_number', $room) : Bookings::all();
    }
}
