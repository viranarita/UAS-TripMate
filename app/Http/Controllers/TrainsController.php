<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trains;

class TrainsController extends Controller
{
    public function index()
    {
        $trains = Trains::all();
        return view('trains', compact('trains'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'train_name' => 'required|string|max:255',
            'train_type' => 'required|in:Eksekutif,Bisnis,Ekonomi',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $lastTrain = Trains::orderBy('train_id', 'desc')->first();
        if ($lastTrain && preg_match('/TRN(\d+)/', $lastTrain->train_id, $matches)) {
            $nextIdNumber = (int)$matches[1] + 1;
        } else {
            $nextIdNumber = 1;
        }

        $newTrainId = 'TRN' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

        Trains::create([
            'train_id' => $newTrainId,
            'train_name' => $request->train_name,
            'train_type' => $request->train_type,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Kereta berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'train_name' => 'required|string|max:255',
            'train_type' => 'required|in:Eksekutif,Bisnis,Ekonomi',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $train = Trains::where('train_id', $id)->first();

        if (!$train) {
            return redirect()->back()->with('error', 'Kereta tidak ditemukan');
        }

        $train->train_name = $request->train_name;
        $train->train_type = $request->train_type;
        $train->departure_time = $request->departure_time;
        $train->arrival_time = $request->arrival_time;
        $train->origin = $request->origin;
        $train->destination = $request->destination;
        $train->price = $request->price;

        $train->save();

        return redirect()->back()->with('success', 'Kereta berhasil diupdate');
    }

    public function destroy($id)
    {
        $train = Trains::where('train_id', $id)->first();

        if ($train) {
            $train->delete();
            return redirect()->back()->with('success', 'Kereta berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Kereta tidak ditemukan');
    }
}
