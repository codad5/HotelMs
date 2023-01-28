<?php

namespace App\Http\Controllers;

use App\Exceptions\PaymentHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Throwable;

class UserController extends Controller
{
    public function index()
    {
        $rooms = RoomController::getAllRooms()['rooms'];
        $actives = RoomController::getAllRooms()['actives'];

        return view('client.index', ["rooms" => $rooms, "actives" => $actives]);
    }
    //
    public function book(Request $req)
    {
        echo 'hello';
        if(!Auth::check()){
            return redirect()->intended('/login')->withErrors("LogIn to Continue");
        }
        $this->validate($req, [
            'room_number' => 'required|int',
            'to' => 'required|date',
            'payment' => 'required|string',
        ]);
        try {
            [
                'room_number' => $room,
                'from' => $from,
                'to' => $to,
                'payment' => $payment
            ] = $req->only('room_number', 'from', 'to', 'payment');
            BookingController::bookByUser($room, $payment, $to, $from);
            return back()->with('success', 'Successfully Booked');
        }
        catch(PaymentHandler $e)
        {
            return $e->resolve();
        }
        catch(Throwable $e){
            return back()->withError($e->getMessage());
        }

    }
    public function loginForm()
    {
        if(Auth::check()){

            return redirect()->intended('/');
        }
        return view('client.login');
    }
    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            // return redirect()->intended('dashboard')->with('success', 'You are now logged in');
            return back()->with('success', 'You are now logged in');
        }
        return redirect("login")->withError('Oppes! You have entered invalid credentials');
    }
    public static function whoIsLoggedIn()
    {
        return Auth::user();
    }
    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
