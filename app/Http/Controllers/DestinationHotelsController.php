<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class DestinationHotelsController extends Controller
{
    public function search(Request $request)
    {
        $city = $request->input('city');

        $hotels = Hotel::where('location', 'like', '%' . $city . '%')->get();

        return view('destinationHotel', compact('hotels', 'city'));
    }

}