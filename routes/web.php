<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\{AdminController, RoomController, BookingController, UserController};



// clients route s
Route::get('/', fn() => view('client.index'));
Route::get('/login', [UserController::class, 'loginForm']);
Route::get('/signup', fn() => view('client.signup'));
Route::post('/login', [UserController::class, 'login']);
Route::post('/signup', [UserController::class, 'signup']);
Route::get('/logout', [UserController::class, 'logout']);
Route::post('/booking', [UserController::class, 'book']);

//admin routes
Route::get('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/login', [AdminController::class, 'postLogin']);
Route::get('/admin/allrooms', [AdminController::class, 'showAllRooms']);
Route::get('/admin/bookings', [AdminController::class, 'showAllBookings']);
Route::post('/booking/checkin', [AdminController::class, 'checkIn']);
Route::get('admin/logout', [AdminController::class, 'logout']);

Route::resource('/admin', AdminController::class);
Route::resource('/rooms', RoomController::class);
// Route::resource('/bookings', BookingController::class);
Route::post('/admin/booking', [AdminController::class, 'book']);