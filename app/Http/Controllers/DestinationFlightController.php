<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Flights;
use App\Models\Planning;

class DestinationFlightController extends Controller
{
    public function index()
    {
        $flights = collect(); // kosongkan hasil pencarian saat awal
        $origin = '';
        $destination = '';
        $departureDate = '';
        $userPlannings = Auth::check()
            ? Planning::where('user_id', Auth::id())->get()
            : collect();

        return view('destinationFlight', compact('flights', 'origin', 'destination', 'departureDate', 'userPlannings'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date',
        ]);

        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $departureDate = $request->input('departure_date');

        $flights = Flights::where('origin', 'like', '%' . $origin . '%')
            ->where('destination', 'like', '%' . $destination . '%')
            ->whereDate('departure_time', $departureDate)
            ->get();

        $userPlannings = Auth::check()
            ? Planning::where('user_id', Auth::id())->get()
            : collect();

        return view('destinationFlight', compact('flights', 'origin', 'destination', 'departureDate', 'userPlannings'));
    }
}
