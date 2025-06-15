<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItineraryItemController extends Controller
{
    public function addHotel(Request $request)
    {
        DB::table('itinerary_hotels')->insert([
            'list_id' => $request->list_id,
            'hotel_id' => $request->hotel_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Hotel added to itinerary.');
    }

    public function addAttraction(Request $request)
    {
        DB::table('itinerary_attractions')->insert([
            'list_id' => $request->list_id,
            'attraction_id' => $request->attraction_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Attraction added to itinerary.');
    }

    public function addCulinary(Request $request)
    {
        DB::table('itinerary_culinary')->insert([
            'list_id' => $request->list_id,
            'culinary_id' => $request->culinary_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Culinary added to itinerary.');
    }

    public function addBus(Request $request)
    {
        DB::table('itinerary_buses')->insert([
            'list_id' => $request->list_id,
            'bus_id' => $request->bus_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Bus added to itinerary.');
    }

    public function addTrain(Request $request)
    {
        DB::table('itinerary_trains')->insert([
            'list_id' => $request->list_id,
            'train_id' => $request->train_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Train added to itinerary.');
    }

    public function addFlight(Request $request)
    {
        DB::table('itinerary_flights')->insert([
            'list_id' => $request->list_id,
            'flight_id' => $request->flight_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Flight added to itinerary.');
    }
}
