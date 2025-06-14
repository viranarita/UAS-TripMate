<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flights;

class DestinationFlightController extends Controller
{
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

        return view('destinationFlight', compact('flights', 'origin', 'destination', 'departureDate'));
    }
}
