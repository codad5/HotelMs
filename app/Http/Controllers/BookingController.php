<?php

namespace App\Http\Controllers;
use App\Exceptions\PaymentHandler;
use App\Models\Rooms;
use Error;
use Illuminate\Http\Request;
use App\Models\Bookings;


class BookingController extends Controller
{
    const PAYMENT_METHODS = ['cash', 'paystack'];
    //booking date start from 12:00 am from the date to 11:59 the end date
    protected static function bookRoom(string $user, int $num, string $to, ?string $from = null, $payment = "CASH", $paid = false , $must_checkin = true)
    {
        // $men = null;
        // var_dump('testing', date("Y-m-d H:i:s", strtotime("11:59pm $men")));
        
        if (strtotime("midnight") > strtotime("midnight $from") || strtotime("11:59pm") > strtotime("11:59pm $to"))
            throw new Error("Select a date later than today");
        if (!$from)
            $from = date("Y-m-d", strtotime("midnight"));
        if(!RoomController::room_exist($num)) throw new Error("Room $num does not exist");
        // var_dump(self::is_booked($num, $from, $to));
        $number_of_days = self::number_of_days($from, $to);
        if (0 > $number_of_days)
            throw new error("Invalid Number of days $number_of_days");
        $booked = self::is_booked($num, $from, $to);
        if ($booked)
            throw new Error("Room $num is booked from ".$booked['from']." to ".$booked["to"]);
        
        $booking = new Bookings;
        $booking->user = $user;
        $booking->room_number = $num;
        $booking->no_of_days = $number_of_days;
        $booking->from = date("Y-m-d", strtotime("midnight $from"));
        $booking->to = date("Y-m-d", strtotime("11:59pm $to"));
        $booking->payment_method = strtoupper($payment);
        $booking->paid = $paid;
        echo $number_of_days;
        // var_dump(strtotime($from) < (time() + (1000 * 60 * 60 * 24)), date("Y-m-d H:i:s", strtotime($from)) , date("Y-m-d H:i:s", (time() + (1000 * 60 * 60 * 24))));
        if(strtotime("midnight") >= strtotime("midnight $from") && AdminController::whoIsLoggedIn()){
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
         * Booking 1 = 13 - 15 // can book 
         * Booking 2 = 17 - 20 //can book 
         * Booking 3 = 24 - 28 //can book 
         * Booking 4 = 16 - 19  // should say 'booked'
         */
        #POINTS:
        # 1. selecting booking that is not be expired yet and select the one with the shortest booking ending date , this is bescause this new booking will have a tendency of being between any booking period with expiring date (to) abd its starting date (to)  greater than this new booking date starting date (from)
        # 2. So if the current booking ending date (to) is greater than the starting date of the last booking (from)  then this booking is inbetween the lastbooking and cant be booked 

        #================= USING THE SAMPLES DATESABOVE=================
        #lets try the (4th) bokking thats our starting(from) is 3rd and ending(to) is 15
        #From step (1) the 2rd booking will be selected because its the Lowest to period of ending date greater than this currenct booking starting date 
        #From step(2) since the end date of the current bookinng period (19th) is greater than the starting date (13th) of the currenct booking period therefore the current booking period is enchrosing the last booking period therefore its 'booked'
        $last_booking = Bookings::where('room_number', $num)
                            ->where('to', '>', $from)
                            ->orderBy("to", "ASC")->first();
        // if no booking exist for the room return false
        if(!$last_booking) return false;
        $m_from = date("Y-m-d", strtotime("midnight $from"));
        $l_from = date("Y-m-d", strtotime("midnight $last_booking->from"));
        $m_to = date("Y-m-d", strtotime("11:59pm $to"));
        $l_to = date("Y-m-d", strtotime("11:59pm $last_booking->to"));
        
        if ($m_from >= $l_from) return ['from' => $l_from, 'to' => $l_to]; # if the from date is in between the last start(from) and end(to) date its booked 
        if ($m_to < $l_from) return false; #if the from and the to is lesser than the (last from and to )
        return ['from' => $l_from, 'to' => $l_to];
    }
    public static function checkIn($booking_id, $bypass = false)
    {
        $booking = Bookings::find($booking_id);
        if (!$booking)
            throw new Error('Booking Does not exist.. refresh your browser');
        $booking->paid = (bool) $booking->paid;
        $bypass = (bool) ($bypass == 'true' ? true : false);
        $room = Rooms::where('number', $booking->room_number)->first();
        if (time() > strtotime("11:59pm $booking->to"))
            throw new Error("Booking has Expired, (Checked IN : ".($booking->checked_in ? 'true' : 'false'));
        if (time() < strtotime("midnight $booking->from"))
            throw new Error("Booking date is still ".self::number_of_days(date("Y-m-d"), $booking->from)." days ahead");
        if ($booking->paid == false && $bypass == false){
            throw new Error('Customer to pay '.($room->price * $booking->no_of_days).', Click "check in" again to confirm payment');
        }
        $booking->checked_in = true;
        $booking->save();
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
        self::bookRoom($user->username, $num, $to, $from, "CASH", true, false);
    }
    public static function bookByUser($num, $payment_method,  $to, $from = null)
    {
        $user = UserController::whoIsLoggedIn();
        if (!$user)
            throw new Error('Please Login to perfrom this action');
        $payment_status = self::proccedPayement($num, $payment_method, self::number_of_days($from, $to));
        self::bookRoom($user->email, $num, $to, $from, $payment_method, $payment_status);
    }
    protected static function proccedPayement($num, $payment_method, $days)
    {
        $room = RoomController::room_exist($num);
        if (!$room)
            throw new Error("Room $num not found");
        $price = $room->price * $days;
        switch(strtolower($payment_method)){
            case 'cash':
                return false;
            case 'paystack':
                throw new PaymentHandler($payment_method, PaymentHandler::NOT_INTEGRATED, "Payment Through Paystack not integrated");
            default:
                throw new PaymentHandler($payment_method, PaymentHandler::INVALID_PAYMENT_METHOD, "Payment Method not integrated");
        }
    }
    public static function getBookings($room = null)
    {
        return $room ? Bookings::where('room_number', $room) : Bookings::all();
    }
}
