<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buses;

class DestinationBusesController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'bus_class' => 'nullable|string|in:VIP,Eksekutif,Ekonomi',
        ]);

        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $departureDate = $request->input('departure_date');
        $busClass = $request->input('bus_class');

        $query = Buses::where('origin', 'like', '%' . $origin . '%')
            ->where('destination', 'like', '%' . $destination . '%')
            ->whereDate('departure_time', $departureDate);

        if (!empty($busClass)) {
            $query->where('bus_class', $busClass);
        }

        $buses = $query->get();

        return view('destinationBuses', compact('buses', 'origin', 'destination', 'departureDate', 'busClass'));
    }

}
