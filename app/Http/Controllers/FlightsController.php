<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flights;

class FlightsController extends Controller
{
    public function index()
    {
        $flights = Flights::all();
        return view('flights', compact('flights'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'airline' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $lastFlight = Flights::orderBy('flight_id', 'desc')->first();

        if ($lastFlight && preg_match('/FLT(\d+)/', $lastFlight->flight_id, $matches)) {
            $nextIdNumber = (int)$matches[1] + 1;
        } else {
            $nextIdNumber = 1;
        }
        $newFlightId = 'FLT' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

        Flights::create([
            'flight_id' => $newFlightId,
            'airline' => $request->airline,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Flight berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'airline' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $flight = Flights::where('flight_id', $id)->first();

        if (!$flight) {
            return redirect()->back()->with('error', 'Flight tidak ditemukan');
        }

        $flight->airline = $request->airline;
        $flight->departure_time = $request->departure_time;
        $flight->arrival_time = $request->arrival_time;
        $flight->origin = $request->origin;
        $flight->destination = $request->destination;
        $flight->price = $request->price;

        $flight->save();

        return redirect()->back()->with('success', 'Flight berhasil diupdate');
    }

    public function destroy($id)
    {
        $flight = Flights::where('flight_id', $id)->first();

        if ($flight) {
            $flight->delete();
            return redirect()->back()->with('success', 'Flight berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Flight tidak ditemukan');
    }
}
