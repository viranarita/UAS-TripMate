<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Culinary;
use Illuminate\Support\Facades\Auth;
use App\Models\Planning;


class DestinationCulinaryController extends Controller
{
    public function index()
    {
        $culinary = collect(); // kosongkan hasil pencarian saat awal
        $city = '';
        $userPlannings = Auth::check() 
            ? Planning::where('user_id', Auth::id())->get()
            : collect();

        return view('destinationCulinary', compact('culinary', 'city', 'userPlannings'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255',
        ]);

        $city = $request->input('city');

        $culinary = Culinary::where('location', 'like', '%' . $city . '%')->get();

        $userPlannings = Auth::check()? Planning::where('user_id', Auth::id())->get(): collect();

        return view('destinationCulinary', compact('culinary', 'city', 'userPlannings'));

    }

}
