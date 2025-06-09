<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/destination', function () {
    return view('destination');
});

use App\Http\Controllers\LoginController;
Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('register');
    });
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

// // Route::get('/users', function () {
// //     return view('users');
// // });

// Route::get('/attraction', function () {
//     return view('attraction');
// });

// Route::get('/culinary', function () {
//     return view('culinary');
// });

// Route::get('/hotel', function () {
//     return view('hotel');
// });

// Route::get('/buses', function () {
//     return view('buses');
// });

// Route::get('/flights', function () {
//     return view('flights');
// });

// Route::get('/trains', function () {
//     return view('trains');
// });

// Route::get('/packages', function () {
//     return view('packages');
// });

use App\Http\Controllers\AttractionController;
Route::get('/attraction', [AttractionController::class, 'index']);
Route::post('/attraction', [AttractionController::class, 'store']);
Route::delete('/attraction/{id}', [AttractionController::class, 'destroy']);
Route::put('/attraction/{id}', [AttractionController::class, 'update']);

use App\Http\Controllers\CulinaryController;
Route::get('/culinary', [CulinaryController::class, 'index']);
Route::post('/culinary', [CulinaryController::class, 'store']);
Route::delete('/culinary/{id}', [CulinaryController::class, 'destroy']);
Route::put('/culinary/{id}', [CulinaryController::class, 'update']);

use App\Http\Controllers\HotelController;
Route::get('/hotel', [HotelController::class, 'index']);
Route::post('/hotel', [HotelController::class, 'store']);
Route::put('/hotel/{id}', [HotelController::class, 'update']);
Route::delete('/hotel/{id}', [HotelController::class, 'destroy']);

use App\Http\Controllers\PackagesController;
Route::get('/packages', [PackagesController::class, 'index']);
Route::post('/packages', [PackagesController::class, 'store']);
Route::put('/packages/{id}', [PackagesController::class, 'update']);
Route::delete('/packages/{id}', [PackagesController::class, 'destroy']);

use App\Http\Controllers\BusesController;
Route::get('/buses', [BusesController::class, 'index']);
Route::post('/buses', [BusesController::class, 'store']);
Route::put('/buses/{id}', [BusesController::class, 'update']);
Route::delete('/buses/{id}', [BusesController::class, 'destroy']);

use App\Http\Controllers\FlightsController;

Route::get('/flights', [FlightsController::class, 'index'])->name('flights.index');
Route::post('/flights', [FlightsController::class, 'store'])->name('flights.store');
Route::put('/flights/{id}', [FlightsController::class, 'update'])->name('flights.update');
Route::delete('/flights/{id}', [FlightsController::class, 'destroy'])->name('flights.destroy');

use App\Http\Controllers\TrainsController;

Route::get('/trains', [TrainsController::class, 'index'])->name('trains.index');
Route::post('/trains', [TrainsController::class, 'store'])->name('trains.store');
Route::put('/trains/{id}', [TrainsController::class, 'update'])->name('trains.update');
Route::delete('/trains/{id}', [TrainsController::class, 'destroy'])->name('trains.destroy');

use App\Http\Controllers\UsersController;
Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::post('/users', [UsersController::class, 'store'])->name('users.store');
Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');

use App\Http\Controllers\LogoutController;
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

use App\Http\Controllers\PlanningController;
Route::get('/planning', [PlanningController::class, 'index'])->name('planning');
Route::middleware('auth')->group(function () {
    Route::post('/planning', [PlanningController::class, 'store']);
    Route::delete('/planning/{id}', [PlanningController::class, 'delete']);
});

use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/chart-data', [DashboardController::class, 'getChartData']);

use App\Http\Controllers\LupaPasswordController;
Route::get('/lupa-password', [LupaPasswordController::class, 'showForm'])->name('password.request');
Route::post('/lupa-password', [LupaPasswordController::class, 'handleRequest'])->name('password.email');

use App\Http\Controllers\ResetPasswordController;
Route::get('/reset-password', [ResetPasswordController::class, 'showForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'handleReset'])->name('password.update');
