<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trains;
use Illuminate\Support\Facades\Auth;
use App\Models\Planning;

class DestinationTrainsController extends Controller
{
    public function index()
    {
        $trains = collect(); // hasil pencarian kosong saat awal
        $origin = '';
        $destination = '';
        $departureDate = '';
        $trainType = '';

        $userPlannings = Auth::check()
            ? Planning::where('user_id', Auth::id())->get()
            : collect();

        return view('destinationTrains', compact('trains', 'origin', 'destination', 'departureDate', 'trainType', 'userPlannings'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'train_type' => 'nullable|string|in:Ekonomi,Bisnis,Eksekutif',
        ]);

        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $departureDate = $request->input('departure_date');
        $trainType = $request->input('train_type');

        $query = Trains::where('origin', 'like', '%' . $origin . '%')
            ->where('destination', 'like', '%' . $destination . '%')
            ->whereDate('departure_time', $departureDate);

        if (!empty($trainType)) {
            $query->where('train_type', $trainType);
        }

        $trains = $query->get();

        $userPlannings = Auth::check()
            ? Planning::where('user_id', Auth::id())->get()
            : collect();

        return view('destinationTrains', compact('trains', 'origin', 'destination', 'departureDate', 'trainType', 'userPlannings'));
    }
}
