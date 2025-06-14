<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attraction;

class DestinationAttractionController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255',
        ]);

        $city = $request->input('city');

        $attractions = Attraction::where('location', 'like', '%' . $city . '%')->get();

        return view('destinationAttraction', compact('attractions', 'city'));
    }

}
