<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attraction;
use App\Models\Culinary;

class DestinationCulinaryController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255',
        ]);

        $city = $request->input('city');

        $culinary = Culinary::where('location', 'like', '%' . $city . '%')->get();

        return view('destinationCulinary', compact('culinary', 'city'));
    }

}
