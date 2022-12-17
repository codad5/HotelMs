<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\{AdminController, RoomController, BookingController};



Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/login', [AdminController::class, 'postLogin']);
Route::get('/admin/allrooms', [AdminController::class, 'showAllRooms']);
Route::get('/admin/bookings', [AdminController::class, 'showAllBookings']);
Route::get('logout', [AdminController::class, 'logout']);

Route::resource('/admin', AdminController::class);
Route::resource('/rooms', RoomController::class);
// Route::resource('/bookings', BookingController::class);
Route::post('/admin/booking', [AdminController::class, 'book']);