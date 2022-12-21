<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use App\Models\{Admins};
use \Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Throwable;

class AdminController extends Controller
{
    public function showAllRooms(){
        if (!Auth::guard('admins')->check())
            return redirect('/admin');
        return view('admin.allrooms', RoomController::getAllRooms());
    }
    public function checkIn(Request $req)
    {
        if (!Auth::guard('admins')->check())
            return redirect('/admin');
        ['id' => $id, 'bypass' => $bypass] = $req->only('id', 'bypass');
        try{
            // $bypass = (bool) $bypass;
            BookingController::checkIn($id, $bypass);
            echo "Successfully Checked in";
        }
        catch(\Error $e){
            echo $e->getMessage();
            return false;
        }
    }
    public function book(Request $req)
    {
        if (!Auth::guard('admins')->check())
            return redirect('/admin');
        [
            'from' => $from,
            'to' => $to,
            "room" => $room
        ] = $req->only('from', 'to', 'room');
        try {
            // var_dump($req->only('from', 'to', 'room'));
            BookingController::bookByAdmin($room, $to, $from);
            echo "Book successfully";
        }
        catch(Throwable $e){
            echo $e->getMessage();
            return false;
        }
        // echo "it ends $to and ".date('Y-m-d', strtotime($to));
        // return "Someone is logged in : ".Auth::guard('admins')->check();
    }
    public function showAllBookings()
    {
        if (!Auth::guard('admins')->check())
            return redirect('/admin');
        $bookings =  BookingController::getBookings();
        return view('admin.allbookings', ['bookings' => $bookings]);
    }
    public function login()
    {
        // Auth::
        if (Auth::guard('admins')->check())
            return redirect('/admin');
        return view('admin.login');
    }
    public function logout()
    {
        Auth::guard('admins')?->logout();
        return redirect('/admin/login');
    }
    public function postLogin(Request $req)
    {
        $req->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $req->only('username', 'password');
        if (Auth::guard('admins')->attempt($credentials)) {

            return redirect()->intended('/admin')->with('success', 'You are now logged in');;
        }
        return back()->withInput($credentials);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (!Auth::guard('admins')->check())
            return redirect('/admin/login');
        return view('admin.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $request->validate(
            []
        );
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
    public static function isLoggedIn()
    {
        return Auth::guard('admins')->check();
    }
    public static function whoIsLoggedIn()
    {
        return Auth::guard('admins')->user();
    }
}
