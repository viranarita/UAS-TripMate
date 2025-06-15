<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
use App\Models\Planning;

class DestinationHotelsController extends Controller
{
    public function index()
    {
        $userPlannings = Auth::check()
            ? Planning::where('user_id', Auth::id())->get()
            : collect();

        $hotels = collect();
        $city = '';

        return view('destinationHotel', compact('userPlannings', 'hotels', 'city'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255',
        ]);

        $city = $request->input('city');

        $hotels = Hotel::where('location', 'like', '%' . $city . '%')->get();

        $userPlannings = Auth::check()
            ? Planning::where('user_id', Auth::id())->get()
            : collect();

        return view('destinationHotel', compact('hotels', 'city', 'userPlannings'));
    }
}
