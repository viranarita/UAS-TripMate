<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('index');
})->name('index');

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
Route::get('/planning/{id}', [PlanningController::class, 'show'])->name('planning.show');
Route::get('/planning', [PlanningController::class, 'index'])->name('planning');
Route::get('/planning/edit/{id}', [PlanningController::class, 'edit']);
Route::delete('/planning/{list_id}', [PlanningController::class, 'destroy'])->name('planning.destroy');
Route::middleware('auth')->group(function () {
    Route::post('/planning', [PlanningController::class, 'store']);
    Route::delete('/planning/{id}', [PlanningController::class, 'delete']);
});
Route::get('/cardplanning', [PlanningController::class, 'cardPlanning'])->name('cardplanning');
Route::get('/image/planning/{id}', [App\Http\Controllers\PlanningController::class, 'showImage']);
Route::post('/planning/{id}', [PlanningController::class, 'store'])->name('planning.store');


use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/chart-data', [DashboardController::class, 'getChartData']);

use App\Http\Controllers\LupaPasswordController;
Route::get('/lupa-password', [LupaPasswordController::class, 'showForm'])->name('password.request');
Route::post('/lupa-password', [LupaPasswordController::class, 'handleRequest'])->name('password.email');

use App\Http\Controllers\ResetPasswordController;
Route::get('/reset-password', [ResetPasswordController::class, 'showForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'handleReset'])->name('password.update');

use App\Http\Controllers\DestinationAttractionController;
Route::get('/destination-attraction', [DestinationAttractionController::class, 'index'])->name('destination-attraction.index');
Route::post('/destination-attraction', [DestinationAttractionController::class, 'search'])->name('destination-attraction.search');


use App\Http\Controllers\DestinationCulinaryController;
Route::post('/destination-culinary', [DestinationCulinaryController::class, 'search'])->name('destination-culinary.search');
Route::get('/destination-culinary', [DestinationCulinaryController::class, 'index'])->name('destination-culinary.index');

use App\Http\Controllers\DestinationHotelsController;
Route::post('/destination-hotel', [DestinationHotelsController::class, 'search'])->name('destination-hotel.search');
Route::get('/destination-hotel', function () {
    return view('destinationHotel');
});

use App\Http\Controllers\DestinationBusesController;
Route::post('/destination-buses', [DestinationBusesController::class, 'search'])->name('destination-buses.search');
Route::get('/destination-buses', function () {
    return view('destinationBuses');
});

use App\Http\Controllers\DestinationFlightController;
Route::post('/destination-flight', [DestinationFlightController::class, 'search'])->name('destination-flight.search');
Route::get('/destination-flight', function () {
    return view('destinationFlight');
});

use App\Http\Controllers\DestinationTrainsController;
Route::post('/destination-trains', [DestinationTrainsController::class, 'search'])->name('destination-trains.search');
Route::get('/destination-trains', function () {
    return view('destinationTrains');
});

use App\Http\Controllers\DestinationPackageController;
Route::post('/destination-package', [DestinationPackageController::class, 'search'])->name('destination-package.search');
Route::get('/destination-package', function () {
    return view('destinationPackage');
});

use App\Http\Controllers\ItineraryItemController;

Route::post('/itinerary/hotel/add', [ItineraryItemController::class, 'addHotel']);
Route::post('/itinerary/attraction/add', [ItineraryItemController::class, 'addAttraction']);
Route::post('/itinerary/culinary/add', [ItineraryItemController::class, 'addCulinary']);
Route::post('/itinerary/bus/add', [ItineraryItemController::class, 'addBus']);
Route::post('/itinerary/train/add', [ItineraryItemController::class, 'addTrain']);
Route::post('/itinerary/flight/add', [ItineraryItemController::class, 'addFlight']);

Route::get('/planning/select', [PlanningController::class, 'select'])->middleware('auth')->name('planning.select');
Route::post('/itinerary/attraction/add', [ItineraryItemController::class, 'addAttraction'])->name('itinerary.attraction.add');

use App\Http\Controllers\ItineraryAttractionController;
Route::post('/itinerary-attractions', [ItineraryAttractionController::class, 'store'])->name('itinerary.attraction');

use App\Http\Controllers\ItineraryCulinaryController;
Route::post('/itinerary-culinaries', [ItineraryCulinaryController::class, 'store'])->name(name: 'itinerary.culinary');

use App\Http\Controllers\ItineraryHotelController;
Route::post('/itinerary-hotels', [ItineraryHotelController::class, 'store'])->name('itinerary-hotels');

use App\Http\Controllers\ItineraryBusesController;
Route::post('/itinerary-buses', [ItineraryBusesController::class, 'store'])->name('itinerary-buses');

use App\Http\Controllers\ItineraryFlightsController;
Route::post('/itinerary-flights', [ItineraryFlightsController::class, 'store'])->name('itinerary-flights');

use App\Http\Controllers\ItineraryTrainsController;
Route::post('/itinerary-trains', [ItineraryTrainsController::class, 'store'])->name('itinerary-trains');

Route::post('/plan/toggle-save/{type}/{id}', [PlanningController::class, 'toggleSave'])->name('plan.toggleSave');

Route::match(['get', 'post'], '/payment', function (Request $request) {
    if ($request->isMethod('post')) {
        session(['payment_success' => true]);
        session(['total_price' => $request->total_price]);

        return redirect()->route('payment');
    }

    $totalPrice = session('total_price', 0);
    return view('payment', compact('totalPrice'));
})->name('payment');