<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use Illuminate\Http\Request;
use Exception;

class RoomController extends Controller
{
    public static function turnBookSignal($num, $till, $on = true)
    {
        $room = Rooms::where("number", $num)->first();
        if($room){
            $room->booked = $on;
            $room->booked_till = $till;
            $room->save();
        }
    }
    public static function room_exist($id)
    {
        // var_dump(Rooms::where('number', $id)->first());
        return Rooms::where('number', $id)->first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!AdminController::isLoggedIn())
            return redirect('/admin/login');
        $rooms = self::getAllRooms()['rooms'];
        $actives = self::getAllRooms()['actives'];
        
        return view('admin.room', ["rooms" => $rooms, "actives" => $actives]);
    }
    public static function getAllRooms()
    {
        $rooms = Rooms::all();
        $actives = [];
        foreach ($rooms as $room)
        {
            $room->booked = false;
            $anypresent = BookingController::getBookings($room?->number)->where('from', '<=', date("Y-m-d"))->where('to', '>=', date("Y-m-d"));

            if ($anypresent->first() && $anypresent->first()->checked_in)
            {
                // dd($anypresent->first());
                $room->booked = true;
            }
            $anypresent->first() ? $actives[$room?->number] = $anypresent->first()->from : null;
            $anypresent->first() ? $room->booked_till = $anypresent->first()->to : null;
            $room->save();
        }
        return ["rooms" => $rooms, "actives" => $actives];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (!AdminController::isLoggedIn())
            return redirect('/admin');
        $request->validate([
            'number' => 'required|int',
            'price' => 'required|int',
        ]);
        [
            "number" => $number,
            "price" => $price
        ] = $request->only('number', 'price');
        try{
        if($number < 0) throw new Exception('Invalid number');
        if($price < 0) throw new Exception('Invalid price');
        if (Rooms::where('number', $number)->first())
            throw new Exception("Room with Number $number already exist");
        $room = new Rooms;
        $room->number = $number;
        $room->room_type = '';
        $room->price = $price;
        // dd(date('d-m-Y'));
        $room->booked_by = '';
        $room->booked_till = date('Y-m-d');
        $room->created_by = AdminController::whoIsLoggedIn()->username;

            $room->save();
            return redirect()->intended('/rooms/create')->with('success', "Room Number: $number created");
        }catch(Exception $e)
        {
            return back()->withError($e->getMessage());

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
