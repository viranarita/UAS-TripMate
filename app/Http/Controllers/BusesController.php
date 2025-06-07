<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buses;

class BusesController extends Controller
{
    public function index()
    {
        $buses = Buses::all();
        return view('buses', compact('buses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_name' => 'required|string|max:255',
            'bus_class' => 'required|in:VIP,Eksekutif,Ekonomi',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $lastBus = Buses::orderBy('bus_id', 'desc')->first();
        if ($lastBus && preg_match('/BUS(\d+)/', $lastBus->bus_id, $matches)) {
            $nextIdNumber = (int)$matches[1] + 1;
        } else {
            $nextIdNumber = 1;
        }
        $newBusId = 'BUS' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);


        Buses::create([
            'bus_id' => $newBusId,
            'bus_name' => $request->bus_name,
            'bus_class' => $request->bus_class,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'price' => $request->price,

        ]);

        return redirect()->back()->with('success', 'Bus berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bus_name' => 'required|string|max:255',
            'bus_class' => 'required|in:VIP,Eksekutif,Ekonomi',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'price' => 'required|numeric|min:0'
        ]);

        $bus = Buses::where('bus_id', $id)->first();

        if (!$bus) {
            return redirect()->back()->with('error', 'Bus tidak ditemukan');
        }

        // Update data
        $bus->bus_name = $request->bus_name;
        $bus->bus_class = $request->bus_class;
        $bus->departure_time = $request->departure_time;
        $bus->arrival_time = $request->arrival_time;
        $bus->origin = $request->origin;
        $bus->destination = $request->destination;
        $bus->price = $request->price;

        $bus->save();

        return redirect()->back()->with('success', 'Bus berhasil diupdate');
    }

    public function destroy($id)
    {
        $bus = Buses::where('bus_id', $id)->first();

        if ($bus) {
            $bus->delete();
            return redirect()->back()->with('success', 'Bus berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Bus tidak ditemukan');
    }
}
