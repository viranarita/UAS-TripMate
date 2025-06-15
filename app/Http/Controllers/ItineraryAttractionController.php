<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItineraryAttractionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'attraction_id' => 'required|exists:tb_Attractions,id',
            'list_id' => 'required|exists:plannings,id',
        ]);

        DB::table('itinerary_attractions')->insert([
            'planning_id' => $request->input('list_id'),
            'attraction_id' => $request->input('attraction_id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
