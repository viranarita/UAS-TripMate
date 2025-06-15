<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attraction;
use Illuminate\Support\Facades\Auth;
use App\Models\Planning;

class DestinationAttractionController extends Controller
{
    public function index()
    {
        $userPlannings = Auth::check()
            ? Planning::where('user_id', Auth::id())->get()
            : collect();

            $attractions = collect();
            $city = '';
        
        return view('destinationAttraction', compact('userPlannings', 'attractions', 'city'));
    }
    public function search(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255',
        ]);

        $city = $request->input('city');

        $attractions = Attraction::where('location', 'like', '%' . $city . '%')->get();

        $userPlannings = Auth::check()
            ? Planning::where('user_id', Auth::id())->get()
            : collect();

        return view('destinationAttraction', compact('attractions', 'city', 'userPlannings'));

    }

}
